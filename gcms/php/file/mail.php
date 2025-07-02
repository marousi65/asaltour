<?php
function sendmail($email,$from,$text,$subject,$messmail)
{

// multiple recipients
$to  = $email;
// subject
//$subject = $subject;

// message
$message = "
<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//EN http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
<html xmlns=http://www.w3.org/1999/xhtml>
<head>
<meta http-equiv=Content-Type content=text/html; charset=utf-8 />
<title>ایمیل</title>
</head>
<style type='text/css'>
body{
font-size:11px;
direction:rtl;
}
table {
	border-width: 1px;
	border-spacing: 5px;
	border-style: solid;
	border-color: black;
	border-collapse: collapse;
	background-color: white;
	font-size:12px;
}
table th {
	border-width: 1px;
	padding: 5px;
	border-style: inset;
	border-color: black;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
table td {
	border-width: 1px;
	padding: 5px;
	border-style: inset;
	border-color: black;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
</style>
<body>
<table width=600 border=0 cellpadding=0 cellspacing=0>
<tr><td>
<div align=right dir=rtl >
<font color=#000066 face=tahoma size=2>

".$text."
</font>
</div>
</td></tr>
</table>
</body>
</html>
";

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

// Additional headers
$headers .= 'To: ' .$to. "\r\n";
$headers .= 'From: '.$from . "\r\n";
$headers .= 'Cc: ' . "\r\n";
$headers .= 'Bcc: ' . "\r\n";
// Mail it
if (mail($to, $subject, $message, $headers))
{
return  $messmail = true ;
}else{		
return  $messmail = false ;
;

}
}
?>
