<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?PHP
error_reporting(E_ALL ^ E_NOTICE);
if ($_REQUEST[prnt] == "address" ){
echo "
<div dir='rtl' style='font-family:Verdana;'>
$_REQUEST[printa]
</div>
";
}else{
echo "
<div dir='rtl' style='font-family:Verdana;'>
$_REQUEST[printp]
</div>
";
}
?>
