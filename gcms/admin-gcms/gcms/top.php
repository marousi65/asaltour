<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
function  leveluser($numlevel){
	if ($_SESSION['user_level'] >= $numlevel){
	return  "true"; 
	}else{
	return  "false"; 
	}
}
?>
<div id="top" >
<div class="wellcom" >
<b>به سیستم مدیریت محتوای تحت وب گاتریا خوش آمدید.  </b><br />
<img src="../images/space.gif" width="10" height="4"  />با سیستم مدیریت محتوای وب سایت گاتریا ،<br />
<img src="../images/space.gif" width="10" height="4"  />به آسانی وب سایت خود را مدیریت کنید.
</div>
<a href="/gcms/admin-gcms/help/<?php echo "$_REQUEST[part].php"; ?>" target="_blank" >
<div id="helpbtt" ></div>
</a>
<a href="/gcms/" >
<div id="displaybtt" ></div>
</a>
<div class="clear" ></div>
<div class="txt" >
<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/jdf.php';
	//putenv("TZ=Asia/Tehran");
	//putenv("TZ=Etc/Greenwich");
	$tarikh = jdate("l j  F  y ");
	$hour = date("G:i ");
	$hour = Convertnumber2farsi("$hour");
	switch ($_SESSION[user_level]){
		case "10":
		$level="مدیر کل";
		break;
		case "8":
		$level="مدیر سایت";
		break;
		case "6":
		$level="ویراستار";
		break;
		}
	
echo "امروز $tarikh ساعت $hour -  <a href='?part=users&action=edit&id=$_SESSION[initiated]' >$_SESSION[login]</a>   - [$level]";
?>
<img src="../images/space.gif" width="490" height="4"  />
<a href="/gcms/admin-gcms/inc/logout.php" >خروج</a>  
</div>
</div>
