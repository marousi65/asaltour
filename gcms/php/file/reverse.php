<?php
include('/usr/share/pear/nusoap.php');
require_once('nusoap.php');
$soapclient = new soapclient('https://modern.enbank.net/ref-payment/ws/ReferencePayment?WSDL','wsdl');
$soapProxy = $soapclient->getProxy() ;
$res=  $soapProxy->ReverseTransaction('T8qrtY6bK81mcAe2y0tH','00015001-28','123456',2);#reference number,sellerid,password,reverse amount
if( $res == 1 )
	echo 'reversed successfully' ;
else
	echo 'reversed failed' ;
?>
