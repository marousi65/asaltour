<?php
declare(strict_types=1);

namespace GCMS\NuSoap;

use GCMS\NuSoap\Base\NusoapBase;
use GCMS\NuSoap\Transport\Http as SoapTransportHttp;
use GCMS\NuSoap\Parser\SoapParser;

class SoapClient extends NusoapBase
{
    private string $username = '';
    private string $password = '';
    private string $authType = '';
    private array  $certRequest = [];
    private $requestHeaders = null;
    private string $responseHeaders = '';
    private string $document = '';
    private string $endpoint;
    private string $forceEndpoint = '';
    // … بقیهٔ propertyها با اعلان نوع …

    public function __construct(
        string $endpoint,
        bool $wsdl = false,
        ?string $proxyHost = null,
        ?int    $proxyPort = null,
        ?string $proxyUsername = null,
        ?string $proxyPassword = null,
        int     $timeout = 0,
        int     $responseTimeout = 30
    ) {
        parent::__construct();
        $this->endpoint        = $endpoint;
        $this->proxyHost       = $proxyHost ?? '';
        $this->proxyPort       = $proxyPort ?? 0;
        $this->proxyUsername   = $proxyUsername ?? '';
        $this->proxyPassword   = $proxyPassword ?? '';
        $this->timeout         = $timeout;
        $this->responseTimeout = $responseTimeout;

        if ($wsdl) {
            // WSDL initialization (همان منطق قدیمی با نام‌گذاری به‌روز)
            $this->initWsdl($endpoint);
        } else {
            $this->endpointType = 'soap';
            $this->debug("instantiate SOAP with endpoint at $endpoint");
        }
    }

    public function call(
        string $operation,
        $params = [],
        string $namespace = 'http://tempuri.org',
        string $soapAction = '',
        $headers = null,
        ?string $style = 'rpc',
        ?string $use = 'encoded'
    ) {
        // … منطق قبلی serialize و envelope …
    }

    // مثال اصلاح ereg → preg_match در متد send()
    private function send(string $msg, string $soapAction = '', int $timeout = 0, int $responseTimeout = 30)
    {
        $this->checkCookies();
        if (preg_match('~^https?~i', $this->endpoint)) {
            $this->debug('transporting via HTTP(S)');
            $http = new SoapTransportHttp($this->endpoint);
            // … تنظیمات HTTP …
            if (stripos($this->endpoint, 'https://') === 0) {
                $this->responseData = $http->sendHTTPS(
                    $msg, $timeout, $responseTimeout, $this->cookies
                );
            } else {
                $this->responseData = $http->send(
                    $msg, $timeout, $responseTimeout, $this->cookies
                );
            }
            // …
        } else {
            $this->setError('no http/s in endpoint url');
        }
        // …
    }

    // … بقیهٔ متدها با اصلاح نام‌گذاری، type hint و preg_match …
}
