<?php
include('/usr/share/pear/nusoap.php');
require_once('nusoap.php');
$soapclient = new soapclient('https://modern.enbank.net/ref-payment/ws/ReferencePayment?WSDL','wsdl');
#$soapclient->debug_flag=true;
$soapProxy = $soapclient->getProxy() ;
#if( $err = $soapclient->getError() )
#	echo $err ;
#echo $soapclient->debug_str;
$res=  $soapProxy->VerifyTransaction('T8qrtY6bK81mcAe2y0tH','00015001-28');#reference number and sellerid
if( $res <= 0 )
	echo 'verification failed' ;
else
{
	echo 'it verified';
	echo $res ;
}
?>
