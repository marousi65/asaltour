<?php
declare(strict_types=1);

namespace GCMS\NuSoap;

use GCMS\NuSoap\Base\NusoapBase;
use RuntimeException;

/**
 * Class Wsdl
 * 
 * Parses a WSDL document, handles imports/schemas and provides
 * operations/portType/binding data.
 */
class Wsdl extends NusoapBase
{
    /** @var string URL یا مسیر WSDL */
    private string $wsdl;

    /** @var int Timeout برحسب ثانیه */
    private int $timeout;

    /** @var int Response timeout برحسب ثانیه */
    private int $responseTimeout;

    /** @var string|null namespace پیش‌فرض */
    private ?string $defaultNamespace = null;

    /** @var array<string,string> تمامی namespace های تعریف‌شده */
    private array $namespaces = [];

    /** @var resource|null XML parser */
    private $parser = null;

    /** @var string حالت فعلی parser: '', 'message','portType','binding','service','schema' */
    private string $status = '';

    /** @var array<string,mixed> اطلاعات پیام‌ها (messages) */
    private array $messages = [];

    /** @var array<string,array> portTypes و عملیات‌های آن */
    private array $portTypes = [];

    /** @var array<string,mixed> bindings و جزئیات آن */
    private array $bindings = [];

    /** @var array<string,mixed> ports و endpointها */
    private array $ports = [];

    /** @var array<string,array> importها */
    private array $import = [];

    /** @var string|null نام سرویس */
    private ?string $serviceName = null;

    /** @var array<string,mixed> schemas بارگذاری‌شده */
    private array $schemas = [];

    // … می‌توانید سایر propertyها را مشابه بالا اضافه کنید …

    /**
     * Wsdl constructor.
     *
     * @param string      $wsdlUrl            URL یا مسیر فایل WSDL
     * @param int         $timeout            اتصال timeout
     * @param int         $responseTimeout    پاسخ timeout
     */
    public function __construct(
        string $wsdlUrl,
        int $timeout = 5,
        int $responseTimeout = 30
    ) {
        parent::__construct();
        $this->wsdl            = $wsdlUrl;
        $this->timeout         = $timeout;
        $this->responseTimeout = $responseTimeout;

        $this->debug("Initializing WSDL parser for {$this->wsdl}");
        if (! $this->loadAndParseWSDL()) {
            throw new RuntimeException('Failed to parse WSDL: ' . $this->getError());
        }
        // پس از parse، importها/schemas را resolve کنید
        $this->resolveImports();
    }

    /**
     * بارگیری متن WSDL (HTTP یا فایل) و فراخوانی parse
     *
     * @return bool
     */
    private function loadAndParseWSDL(): bool
    {
        $this->debug("Fetching WSDL content");
        $content = $this->fetchWSDL($this->wsdl);
        if ($content === null) {
            $this->setError("Cannot fetch WSDL from {$this->wsdl}");
            return false;
        }
        return $this->parseWSDLString($content);
    }

    /**
     * دریافت متن WSDL از HTTP(S) یا فایل محلی
     *
     * @param string $url
     * @return string|null
     */
    private function fetchWSDL(string $url): ?string
    {
        $parts = parse_url($url);
        // HTTP/HTTPS
        if (isset($parts['scheme']) && in_array($parts['scheme'], ['http','https'], true)) {
            $this->debug("Fetching via HTTP: $url");
            $client = new SoapTransportHttp($url);
            $client->request_method = 'GET';
            $client->useSOAPAction  = false;
            $client->setEncoding('gzip, deflate');
            $data = $client->send('', $this->timeout, $this->responseTimeout);
            if ($err = $client->getError()) {
                $this->setError("HTTP ERROR: $err");
                return null;
            }
            return $data;
        }
        // فایل محلی
        $path = $parts['scheme']==='file' && isset($parts['path'])
            ? ($parts['host'] . ':' . $parts['path'])
            : $url;
        $this->debug("Reading WSDL file: $path");
        if (! is_readable($path)) {
            $this->setError("Cannot open WSDL file: $path");
            return null;
        }
        return file_get_contents($path) ?: null;
    }

    /**
     * parse کردن XML WSDL
     *
     * @param string $xmlData
     * @return bool
     */
    private function parseWSDLString(string $xmlData): bool
    {
        $this->parser = xml_parser_create_ns('UTF-8', ':');
        xml_parser_set_option($this->parser, XML_OPTION_CASE_FOLDING, false);
        xml_set_object($this->parser, $this);
        xml_set_element_handler($this->parser, 'startElement', 'endElement');
        xml_set_character_data_handler($this->parser, 'characterData');

        if (! xml_parse($this->parser, $xmlData, true)) {
            $errCode = xml_get_error_code($this->parser);
            $errMsg  = xml_error_string($errCode);
            $line    = xml_get_current_line_number($this->parser);
            xml_parser_free($this->parser);
            $this->setError("XML parse error: $errMsg at line $line");
            return false;
        }
        xml_parser_free($this->parser);
        return true;
    }

    /**
     * Element start handler
     *
     * @param resource $parser
     * @param string   $name
     * @param array    $attrs
     */
    private function startElement($parser, string $name, array $attrs): void
    {
        // فراخوانی schema parser در صورت نیاز
        if ($this->status === 'schema') {
            $this->currentSchema->schemaStartElement($parser, $name, $attrs);
            $this->appendDebug($this->currentSchema->getDebug());
            $this->currentSchema->clearDebug();
            return;
        }

        // تشخیص تگ schema
        if (preg_match('/schema$/i', $name)) {
            $this->debug("Entering <schema>");
            $this->status        = 'schema';
            $this->currentSchema = new XmlSchema('', '', $this->namespaces);
            $this->currentSchema->schemaStartElement($parser, $name, $attrs);
            $this->appendDebug($this->currentSchema->getDebug());
            $this->currentSchema->clearDebug();
            return;
        }

        // هر عنصر دیگر
        // ثبت namespaceها از xmlns*
        foreach ($attrs as $k => $v) {
            if (strpos($k, 'xmlns') === 0) {
                $parts = explode(':', $k, 2);
                $prefix = $parts[1] ?? '';
                $this->namespaces[$prefix] = $v;
                // ذخیره XSD instance
                if (in_array($v, [
                    'http://www.w3.org/2001/XMLSchema',
                    'http://www.w3.org/1999/XMLSchema',
                    'http://www.w3.org/2000/10/XMLSchema'
                ], true)) {
                    $this->namespaces['xsi'] = $v . '-instance';
                }
            }
        }

        // پاکسازی cdata، depth و position
        $pos = $this->position++;
        $depth = $this->depth++;
        $this->depthArray[$depth] = $pos;
        $this->message[$pos] = ['cdata'=>''];

        // تفکیک prefix از نام المان
        $prefix = '';
        $local  = $name;
        if (strpos($name, ':') !== false) {
            [$prefix, $local] = explode(':', $name, 2);
        }

        // بر اساس وضعیت فعلی، اطلاعات را ذخیره کنید
        switch ($this->status) {
            case 'message':
                if ($local==='part' && isset($attrs['name'])) {
                    $key = $attrs['name'];
                    $this->messages[$this->currentMessage][$key]
                        = $attrs['type'] ?? ($attrs['element'] ?? '');
                }
                break;

            case 'portType':
                if ($local==='operation') {
                    $this->currentPortOperation = $attrs['name'] ?? '';
                    $this->portTypes[$this->currentPortType][$this->currentPortOperation] = [];
                } elseif (in_array($local, ['input','output'], true)) {
                    $this->portTypes[$this->currentPortType][$this->currentPortOperation][$local] = [
                        'message' => $this->getLocalPart($attrs['message'] ?? '')
                    ];
                }
                break;

            case 'binding':
                // … مشابه کد اولیه برای binding …
                break;

            case 'service':
                if ($local==='port') {
                    $this->currentPort = $attrs['name'] ?? '';
                    $this->ports[$this->currentPort] = [
                        'binding' => $this->getLocalPart($attrs['binding'] ?? '')
                    ];
                } elseif ($local==='address') {
                    $this->ports[$this->currentPort]['location'] = $attrs['location'] ?? '';
                    $this->ports[$this->currentPort]['bindingType'] = $attrs['location'] ?? '';
                }
                break;

            case '':
                if ($local==='definitions') {
                    $this->defaultNamespace = $attrs['targetNamespace'] ?? null;
                } elseif ($local==='message') {
                    $this->status = 'message';
                    $this->currentMessage = $attrs['name'] ?? '';
                    $this->messages[$this->currentMessage] = [];
                } elseif ($local==='portType') {
                    $this->status = 'portType';
                    $this->currentPortType = $attrs['name'] ?? '';
                    $this->portTypes[$this->currentPortType] = [];
                } elseif ($local==='binding') {
                    $this->status = 'binding';
                    $this->currentBinding = $this->getLocalPart($attrs['name'] ?? '');
                    $this->bindings[$this->currentBinding] = [
                        'portType' => $this->getLocalPart($attrs['type'] ?? '')
                    ];
                } elseif ($local==='service') {
                    $this->status = 'service';
                    $this->serviceName = $attrs['name'] ?? '';
                } elseif ($local==='import') {
                    $ns = $attrs['namespace'] ?? '';
                    $loc = $attrs['location'] ?? '';
                    $this->import[$ns][] = ['location'=>$loc,'loaded'=>false];
                }
                break;
        }
    }

    /**
     * Element end handler
     *
     * @param resource $parser
     * @param string   $name
     */
    private function endElement($parser, string $name): void
    {
        // خروج از schema
        if ($this->status==='schema' && preg_match('/schema$/i',$name)) {
            $this->status = '';
            $this->schemas[$this->currentSchema->schemaTargetNamespace][] = $this->currentSchema;
            $this->appendDebug($this->currentSchema->getDebug());
            $this->currentSchema->clearDebug();
            return;
        }

        // کاهش عمق و swich وضعیت
        $this->depth--;
        if (in_array($name, ['message','portType','binding','service'], true)) {
            $this->status = '';
        }
    }

    /**
     * Character data handler
     *
     * @param resource $parser
     * @param string   $data
     */
    private function characterData($parser, string $data): void
    {
        $pos = $this->depthArray[$this->depth] ?? 0;
        $this->message[$pos]['cdata'] .= $data;
    }

    /**
     * پس از parse اصلی، importها را resolve می‌کند
     */
    private function resolveImports(): void
    {
        foreach ($this->import as $ns => $list) {
            foreach ($list as $i => $im) {
                if (! $im['loaded'] && $im['location'] !== '') {
                    $this->debug("Resolving import $ns -> {$im['location']}");
                    $this->import[$ns][$i]['loaded'] = true;
                    $content = $this->fetchWSDL($im['location']);
                    if ($content !== null) {
                        $this->parseWSDLString($content);
                    }
                }
            }
        }
    }

    /**
     * لیست عملیات‌های SOAP را برمی‌گرداند
     *
     * @param string $bindingType
     * @return array<string,array>
     */
    public function getOperations(string $bindingType = 'soap'): array
    {
        if ($bindingType === 'soap') {
            $bindingType = 'http://schemas.xmlsoap.org/wsdl/soap/';
        }
        $ops = [];
        foreach ($this->ports as $port => $pd) {
            if (($pd['bindingType'] ?? '') === $bindingType) {
                $ops = array_merge($ops, $this->bindings[$pd['binding']]['operations'] ?? []);
            }
        }
        return $ops;
    }

    /**
     * اطلاعات یک عملیات مشخص را برمی‌گرداند
     *
     * @param string $operation
     * @param string $bindingType
     * @return array<string,mixed>|null
     */
    public function getOperationData(string $operation, string $bindingType = 'soap'): ?array
    {
        foreach ($this->ports as $pd) {
            if (($pd['bindingType'] ?? '') === ($bindingType==='soap'
                    ? 'http://schemas.xmlsoap.org/wsdl/soap/'
                    : $bindingType
                )) {
                foreach ($this->bindings[$pd['binding']]['operations'] ?? [] as $name => $d) {
                    if ($name === $operation) {
                        return $d;
                    }
                }
            }
        }
        return null;
    }

    /**
     * اطلاعات یک نوع را از schema دریافت می‌کند
     *
     * @param string      $type
     * @param string|null $ns
     * @return array<string,mixed>|false
     */
    public function getTypeDef(string $type, ?string $ns = null)
    {
        $ns = $ns ?: ($this->namespaces['tns'] ?? '');
        if (! isset($this->schemas[$ns])) {
            return false;
        }
        foreach ($this->schemas[$ns] as $schema) {
            $def = $schema->getTypeDef($type);
            $this->appendDebug($schema->getDebug());
            $schema->clearDebug();
            if ($def !== false) {
                return $def;
            }
        }
        return false;
    }
}
