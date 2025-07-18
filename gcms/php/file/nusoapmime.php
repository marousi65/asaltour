<?php
declare(strict_types=1);

//******************************************************************************
//* soapclientmime – Extension for NuSOAP client with MIME attachments
//* منطبق با W3C SOAP-attachments specification
//******************************************************************************
require_once __DIR__ . '/mail/mimeDecode.php';
require_once __DIR__ . '/mail/mimePart.php';
require_once __DIR__ . '/nusoap.php';

class soapclientmime extends soapclient
{
    protected array $requestAttachments  = [];
    protected array $responseAttachments = [];
    protected string $mimeContentType    = '';

    public function addAttachment(
        string $data, string $filename,
        string $contenttype='', string $cid=''
    ): void {
        if (empty($cid)) {
            $cid = uniqid('cid', true) . '@nusoap.local';
        }
        if ($data === '') {
            $data = file_get_contents($filename);
        }
        $this->requestAttachments[] = [
            'data'        => $data,
            'filename'    => $filename,
            'contenttype' => $contenttype,
            'cid'         => $cid
        ];
    }

    public function clearAttachments(): void
    {
        $this->requestAttachments  = [];
        $this->responseAttachments = [];
        $this->mimeContentType     = '';
    }

    public function getAttachments(): array
    {
        return $this->responseAttachments;
    }

    // سایر متدها (getHTTPBody، getHTTPContentType، parseResponse و …)
    // بدون تغییر یا با مسیرهای به‌روز شده
}
