<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
?>
<div id="bnnmenu" ></div>
<div class="rightbody" >
<?php
if ($_REQUEST[part] == "dashboard"){
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
?>
<div id="midmentxt" >
<a href="?part=dashboard" >
<img src="../images/dashboard.png" width="25" height="24" border="0" align="absmiddle"  />
میز کار شما
</a>
</div>
</div>

<?php
	//level check
	if (leveluser(8) == "true"){
	//normal view
	
if ($_REQUEST[part] == "users"){	
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
echo "
<div id='midmentxt'>
<a href='?part=users' >
<img src=../images/user.png width=25 height=24 border=0 align=absmiddle  />
 کاربران
</a>
</div>
</div>";

	}
	//end level check	

if ($_REQUEST[part] == "pages"){
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
?>
<div id="midmentxt">
<a href="?part=pages" >
<img src="../images/pages.png" width="25" height="24" border="0" align="absmiddle"  />
 صفحات
</a>
</div>
</div>


<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
// add plugin

		$querypluginmenu = "SELECT * FROM `gcms_plugin` WHERE status='active' AND $_SESSION[user_level] >=  level";
// نتایج کوئری
	$resultpluginmenu = mysql_query($querypluginmenu,$link);
// دریافت نتایج در سطر	
		while($rowpluginmenu = mysql_fetch_array($resultpluginmenu)){

			if ($_REQUEST[part] == "$rowpluginmenu[e_name]"){	
			echo "<div id='menumidhover'>";
			}else{
			echo "<div id='menumid'>";
			}
			echo "
			<div id='midmentxt'>
			<a href='?part=$rowpluginmenu[e_name]' >
			<img src=../images/$rowpluginmenu[e_name].png width=25 height=24 border=0 align=absmiddle  />
			 $rowpluginmenu[f_name]
			</a>
			</div>
			</div>";

}

if ($_REQUEST[part] == "comment"){
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
?>
<div id="midmentxt">
<a href="?part=comment" >
<img src="../images/comment.png" width="25" height="24" border="0" align="absmiddle"  />
 نظرات
</a>
</div>
</div>


<?php
if ($_REQUEST[part] == "file"){
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
?>
<div id="midmentxt">
<a href="?part=file" >
<img src="../images/file.png" width="25" height="24" border="0" align="absmiddle"  />
 فایل ها
</a>
</div>
</div>
<?php
	//level check
	if (leveluser(10) == "true"){
	//normal view
	
if ($_REQUEST[part] == "form"){	
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
echo "
<div id='midmentxt'>
<a href='?part=form' >
<img src=../images/dashboard.png width=25 height=24 border=0 align=absmiddle  />
 فرم ها
</a>
</div>
</div>";

	}
	//end level check	


if ($_REQUEST[part] == "rss2"){
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
?>
<div id="midmentxt">
<a href="?part=rss2" >
<img src="../images/rss2.png" width="25" height="24" border="0" align="absmiddle"  />
RSS - فید
</a>
</div>
</div>

<?php
	//level check
	if (leveluser(10) == "true"){
	//normal view
	
if ($_REQUEST[part] == "plugin"){	
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
echo "
<div id='midmentxt'>
<a href='?part=plugin' >
<img src=../images/dashboard.png width=25 height=24 border=0 align=absmiddle  />
 افزونه
</a>
</div>
</div>";

	}
	//end level check	

	//level check
	if (leveluser(8) == "true"){
	//normal view

if ($_REQUEST[part] == "setting"){
echo "<div id='menumidhover'>";
}else{
echo "<div id='menumid'>";
}
echo "
<div id='midmentxt' >
<a href='?part=setting' >
<img src=../images/setting.png width=25 height=24 border=0 align=absmiddle  />
تنظیمات سایت
</a>
</div>
</div>
"; }else {
echo "<div id='menumid'>
<div id='midmentxt' >
<a href='/gcms/' >
<img src=../images/dashboard.png width=25 height=24 border=0 align=absmiddle  />
نمایش سایت
</a>
</div>
</div>

";

} ?>
<div id="dwnmenu" ></div>
</div>
</div>
</div> 
