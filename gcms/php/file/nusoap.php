<?php
declare(strict_types=1);

// ??? constant ???? ?????? src/nusoap ?? ???? ??????
define('GCMS_NUSOAP_PATH', __DIR__ . '/../../src/nusoap/');

// ???????? ??????? ?? ??? ????
require_once GCMS_NUSOAP_PATH . 'NusoapBase.php';
require_once GCMS_NUSOAP_PATH . 'SoapParser.php';
require_once GCMS_NUSOAP_PATH . 'SoapTransportHttp.php'; // ??? ?????
require_once GCMS_NUSOAP_PATH . 'SoapServer.php';
require_once GCMS_NUSOAP_PATH . 'SoapClient.php';
require_once GCMS_NUSOAP_PATH . 'SoapVal.php';
require_once GCMS_NUSOAP_PATH . 'WsdlCache.php';
require_once GCMS_NUSOAP_PATH . 'Wsdl.php';
require_once GCMS_NUSOAP_PATH . 'xmlschema.php';
