<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
// برای گرفتن یوزر و پسورد
if ($_POST['username'] != '' && $_POST['password'] != ''){
	$_REQUEST[username] = addslashes($_REQUEST[username]);

//فراخوانی فایل کانفیگ
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
// تعریف کوئری
	$query = "select * from gcms_user where login='$_REQUEST[username]' AND status='active'";
	
// نتایج کوئری
	$result=mysql_query($query,$link);
// دریافت نتایج در سطر	
	$row=mysql_fetch_array($result);
// اگر نتیجه داشته باشیم
	if ($row){
	// چک کردن پسورد
		if( crypt($_REQUEST[password], $row[password]) == $row[password] ){
		//اگر پسور درست باشد به سشن ها مقدار دهی می کنیم
		$_SESSION['initiated'] = $row[id];
		$_SESSION['ip'] =$_SERVER['REMOTE_ADDR'] ;
		$_SESSION['user_level'] = $row[level];
		$_SESSION['login'] = $row[login];
		//مقدار دهی به کوکی
		if ( $_REQUEST[cookie] ){
		// echo " NOT ACTIVE ";		
		}
		//فرستادن کاربر به سمت داشبورد
		header("Location: /gcms/admin-gcms/gcms/?part=dashboard");
	}
// اگر پسورد اشتباه باشد
	else{
	//مقدار سشن را صفر می کنیم
		$_SESSION['initiated'] = '0';
		$error = "کلمه عبور اشتباه است.";
	}
// اگر هیچ نتیجه ای نداشته باشیم
	}else{
		$_SESSION['initiated'] = '0';
		$error = "نام کاربری اشتباه است.";
	}
// بستن ارتباط با جدول
	mysql_close($link);
// end login

}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script language='Javascript' type='text/javascript' src='/gcms/admin-gcms/cssjava/validform.js'>
</script>
<link href="/gcms/admin-gcms/cssjava/login.css" rel="stylesheet" type="text/css" />
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Gcms - کنترل پنل ورود کاربر</title>
<body>
<div id="main">
<?php 
//بخش فراموش کردن پسورد
if ( $_GET[forget] == "pass" ){
?>
<!-- start forget pass -->
<div id="error-message" >این قسمت هنوز راه اندازی نشده است</div>
<div class="txt"><div style="color:#FFFFFF">
کلمه عبور خود را فراموش کرده ام !
</div>
<br /><br />
ایمیل
<form name="forgetpass" action="" method="post" >
<input type="text" id="input" title="ایمیل خود را وارد کنید" name="email" class="reqd"   />

<input type="submit" id="submitinput" value="ارسال"  onMouseDown="initForms()" />
</form>
<br />
<a href="/gcms/admin-gcms/" >برگشت</a>
<br />
</div>
<!-- end forget pass -->
<?php 
}else {
//بخش صفحه اصلی
?>

<!-- start login -->
<div id="error-message" ><?php echo $error  ?></div>
<div class="txt"><div style="color:#FFFFFF">
ورود به سیستم مدیریت محتوای تحت وب گاتریا
</div>
<form name="login" action="" method="post" >
نام کاربری : <br />
<input type="text" id="input" title="نام کاربری خود را وارد کنید" name="username"  class="reqd"  /><br />
کلمه عبور : <br />
<input type="password"  id="input" title="کلمه عبور خود را وارد کنید" name="password" class="reqd" /><br />
<input type="checkbox" title="با انتخاب این گزینه می توانید بر روی این کامپیوتر بدون وارد کردن کلمه عبور و نام کاربری وارد شوید. " name="cookie" value="true"  disabled="disabled" /> مرا به یاد داشته باش! 
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="submit" id="submitinput" value="ورود" onMouseDown="initForms()" />
<br />
<a href="file:///C|/Users/Rses/AppData/Local/Temp/?forget=pass" >فراموش کردن کلمه عبور! </a>
</form>
</div>
<!-- end login -->
<?php 
}
?>

<div class="copyright" title="سیستم مدیریت محتوای گاتریا" >
Powered by Gcms <big><big>V</big></big>1.1 &copy; <a href="http://www.lengehdesign.com/" target="_blank" title="lengehdesign" >lengehdesign.com</a>
</div>
</div>
</body>
</html>
