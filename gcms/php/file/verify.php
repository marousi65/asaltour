<?php
declare(strict_types=1);

// بارگذاری NuSOAP (مطمئن شوید nusoap.php در همین فولدر باشد)
require_once __DIR__ . '/nusoap.php';

$wsdl   = 'https://modern.enbank.net/ref-payment/ws/ReferencePayment?WSDL';
$client = new soapclient($wsdl, 'wsdl');

if ($err = $client->getError()) {
    echo "Constructor Error: {$err}";
    exit;
}

$proxy = $client->getProxy();
$result = $proxy->VerifyTransaction('T8qrtY6bK81mcAe2y0tH', '00015001-28');

if ($client->fault) {
    echo "Fault:<br>";
    print_r($result);
}
elseif ($err = $client->getError()) {
    echo "Error: {$err}";
}
else {
    if ($result <= 0) {
        echo 'Verification failed';
    } else {
        echo "Verified: {$result}";
    }
}
