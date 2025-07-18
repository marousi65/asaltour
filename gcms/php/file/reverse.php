<?php
declare(strict_types=1);
session_start();

// بارگذاری NuSOAP bootstrap
require_once __DIR__ . '/nusoap.php';

// مثال فراخوانی وب‌سرویس ReverseTransaction
$wsdlUrl   = 'https://modern.enbank.net/ref-payment/ws/ReferencePayment?WSDL';
$soap      = new SoapClient($wsdlUrl, ['cache_wsdl' => WSDL_CACHE_NONE]);
$proxy     = $soap->getProxy();
$reference = 'T8qrtY6bK81mcAe2y0tH';
$sellerId  = '00015001-28';
$password  = '123456';
$amount    = 2;

$result = $proxy->ReverseTransaction($reference, $sellerId, $password, $amount);

if ($result == 1) {
    echo 'Reversed successfully';
} else {
    echo 'Reversed failed';
}

