<?php
function sendmail($email,$from,$text,$subject,$messmail)
{


// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Additional headers
$headers .= 'To: ' .$email. "\r\n";
$headers .= 'From: '.$from . "\r\n";
$headers .= 'Cc: ' . "\r\n";
$headers .= 'Bcc: ' . "\r\n";
// Mail it
if (mail($to, $subject, $text , $headers))
{
return  $messmail = true ;
}else{		
return  $messmail = false ;
;

}
}
?>
