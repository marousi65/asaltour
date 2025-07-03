<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
?>
<html>
<head>
<title>کنترل پنل کاربری</title>
<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<link href="/gcms/admin-gcms/cssjava/gcms.css" rel="stylesheet" type="text/css">
<script language='Javascript' type='text/javascript' src='/gcms/admin-gcms/cssjava/validform.js'>
</script>
<?php 
if ($_REQUEST[part] == 'newsletter' AND  $_REQUEST[action] == 'edit' ){
echo "
<script type='text/javascript' src='/gcms/admin-gcms/cssjava/nwsltr.js'></script>
<style>
.toggler {
	direction: rtl;
	color: #336699;
	margin: 0;
	padding: 2px 20px;
	border-bottom: 0px solid #ddd;
	font-size: 11px;
	font-weight: normal;
	font-family: tahoma, arial, sans-serif;
	cursor: pointer;
}

.element {
	padding: 30px 20px 30px 20px;
	background: #fafafa;
}

.sty {
	margin: 10px;
}

.element p {
	margin: 0;
	padding: 4px;
}

.float-right {
	padding: 10px 20px;
	float: right;
}

blockquote {
	text-style: italic;
	padding: 5px 0 5px 30px;
}
</style>

";

}
if ($_REQUEST[part] == 'comment' ){ $fcketxt = "comment_content"; }else{$fcketxt = "page_content"; }
?>
<?php 
if ($_REQUEST[editor] ){
if ($_REQUEST[part] == 'comment' ){ $fcketxt = "comment_content"; }else{$fcketxt = "page_content"; }
?>
	<script type="text/javascript" src="fckeditor.js"></script>
	<script type="text/javascript">

window.onload = function()
{
	var sBasePath = document.location.href.substring(0,document.location.href.lastIndexOf('_samples')) ;

	var oFCKeditor = new FCKeditor( '<?php echo $fcketxt ; ?>' ) ;
	oFCKeditor.BasePath	= "" ;
	oFCKeditor.ReplaceTextarea() ;
}

	</script>
<?php 
		if ( $_REQUEST[editor] == "full" ){
		echo "
	
		";
		}else{
		echo "
		
		";
		}
}else{
echo "<link href='/gcms/admin-gcms/cssjava/table.css' rel='stylesheet' type='text/css' />";
}
?>


</head>
<body>
	<center>
      <?php 
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/gcms/top.php';
	?>
    <div id="head" >
	<?php
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/gcms/center.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/gcms/menu.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/gcms/down.php';
	?>
</div>
<div id="downhead"></div>
	</center>
</body>
</html>