<?php
declare(strict_types=1);
namespace GCMS\NuSoap;

use Exception;

class SoapFault extends NusoapBase
{
    private string $faultcode;
    private string $faultactor;
    private string $faultstring;
    private $faultdetail;

    public function __construct(
        string $faultcode,
        string $faultactor = '',
        string $faultstring = '',
        $faultdetail = ''
    ) {
        parent::__construct();
        $this->faultcode   = $faultcode;
        $this->faultactor  = $faultactor;
        $this->faultstring = $faultstring;
        $this->faultdetail = $faultdetail;
    }

    public function serialize(): string
    {
        $ns = '';
        foreach ($this->namespaces as $k => $v) {
            $ns .= sprintf("\n  xmlns:%s=\"%s\"", $k, $v);
        }
        $xml  = '<?xml version="1.0" encoding="'. $this->soap_defencoding .'"?>'.
                '<SOAP-ENV:Envelope SOAP-ENV:encodingStyle="http://schemas.xmlsoap.org/soap/encoding/"'. $ns .">".
                '<SOAP-ENV:Body>'.
                  '<SOAP-ENV:Fault>'.
                    $this->serializeVal($this->faultcode,   'faultcode').
                    $this->serializeVal($this->faultactor,  'faultactor').
                    $this->serializeVal($this->faultstring, 'faultstring').
                    $this->serializeVal($this->faultdetail, 'detail').
                  '</SOAP-ENV:Fault>'.
                '</SOAP-ENV:Body>'.
                '</SOAP-ENV:Envelope>';
        return $xml;
    }
}
