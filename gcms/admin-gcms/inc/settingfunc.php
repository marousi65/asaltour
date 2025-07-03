<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?php

//تابع ویرایش

function  editsetting($errmes){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
// تعریف کوئری
	$query = "SELECT * FROM `gcms_setting`   ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
	while($row = mysql_fetch_array($result)){
	
		$config[$row['setting_name']]=$row['setting_value'];
	}
echo "
<div id='head' >
<div id='mainbody' >
<div class='leftbody' >";
if ($errmes){
echo"
<div id='err-mess' >
$errmes
</div>
";
}
echo "<div id='mytb' >
<h2>
تنظیمات سایت
</h2>
<form  action='?part=setting&action=edit&edit=true' method='post' >
<table cellpadding='0' cellspacing='0'>
<thead>
<tr>
<th scope='col' width=150px ></th><th scope='col'>تنظیمات عمومی</th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col'></th><th scope='col'><input type='submit' id='submitinput' value='به روزرسانی تنظیمات'  onMouseDown='initForms()' name='submitbtt' /></th>
</tr>
</tfoot>

<tr class='even'>
<td >عنوان سایت</td><td><input type='text' id='input'  name='config[title]' value='$config[title]'  size='40' /></td>
</tr>

<tr class='odd'>
<td >کلمات کلیدی سایت</td><td><input type='text' id='input' name='config[keyword]' value='$config[keyword]' size='40' /></td>
</tr>

<tr class='even'>
<td >شرح سایت</td><td><textarea name='config[description]' cols='40' rows='3' id='input' width='40'>$config[description]</textarea>
</td>
</tr>

<tr class='odd'>
<td >زبان سایت</td><td>
<input type='radio' name='config[language]' value='fa' ";
	// مشخص کردن   
	if ($config[language] == "fa" ){
	echo " checked ";
	}
	echo" /> فارسی &nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='config[language]' value='en' ";
	// مشخص کردن   
	if ($config[language] == "en" ){
	echo " checked ";
	}
	echo" /> English
</td>
</tr>";

	//level check
	if (leveluser(10) == "true"){
		echo"
		<tr class='even'>
		<td >کپی رایت سایت</td><td>
		<textarea name='config[copyright]' cols='40' rows='3' id='input' width='40'>$config[copyright]</textarea>
		</td>
		</tr>";
	}

echo"
<tr class='odd'>
<td >آدرس سایت</td><td><input type='text' id='input' name='config[site_address]' value='$config[site_address]'  size='40' /></td>
</tr>
<tr class='even'>
<td >ایمیل</td><td><input type='text' id='input'  size='40' name='config[email]' value='$config[email]'  /></td>
</tr>
<tr >
<td ></td><td><b>تنظیمات ورودی</b></td>
</tr>

<tr class='odd'>
<td >صفحه ورودی سایت</td><td>
<input type='radio' name='config[intro]' value='yes' ";
	// مشخص کردن  صفحه اینترو
	if ($config[intro] == "yes" ){
	echo " checked ";
	}
	echo" /> بله ؛ دارد  	&nbsp;&nbsp;&nbsp;&nbsp;    <input type='radio' name='config[intro]' value='no' ";
	// مشخص کردن  صفحه اینترو
	if ($config[intro] == "no" ){
	echo " checked ";
	}
	echo" /> خیر ؛ ندارد
</td>
</tr>


<tr class='even'>
<td >اولین صفحه سایت</td><td>";

// تعریف کوئری برای لیست 
	$query1 = "SELECT * FROM `gcms_pages` WHERE page_parent='0' AND page_type='page' ";
// نتایج کوئری
	$result1 = mysql_query($query1,$link);
// دریافت نتایج در سطر	
echo  "
<select  name='config[first_page]' id='input' >

";
		while($row1 = mysql_fetch_array($result1)){

echo "
<option value='$row1[id]' ";
if ($row1[id] == $config[first_page]){
echo  " selected ";
}
echo  ">$row1[page_title]</option>

";
}
echo "</select>

</td>
</tr>

<tr >
<td ></td><td><b>تنظیم تاریخ و ساعت</b></td>
</tr>

<tr class='odd'>
<td >پیش فرض تاریخ سایت</td><td>
<input type='radio' name='config[defult_date]' value='shamsi' ";
	// مشخص کردن   
	if ($config[defult_date] == "shamsi" ){
	echo " checked ";
	}
	$tarikh = jdate("l j  F  y ");
	$ddate  = date("l j  F  y ");
	echo" /> تاریخ شمسی ($tarikh) 	<br>    <input type='radio' name='config[defult_date]' value='miladi' ";
	// مشخص کردن   
	if ($config[defult_date] == "miladi" ){
	echo " checked ";
	}
	echo" /> تاریخ میلادی ($ddate)
	</td>
</tr>

<tr class='even'>
<td >تنظیم ساعت محلی</td><td>
<input type='radio' name='config[locale_time]' value='tehran' ";
	// مشخص کردن   
	if ($config[locale_time] == "tehran" ){
	echo " checked ";
	}
	echo" />  تهران (3:30+ ) &nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='config[locale_time]' value='greenwich' ";
	// مشخص کردن   
	if ($config[locale_time] == "greenwich" ){
	echo " checked ";
	}
	echo" /> Greenwich
</td>
</tr>

</table>
<div id='dwbckdsh'></div>
</form>

</div>
<div id='leftsidb' >
<div id='leftsidup' >
<div id='leftsiduptxt' >
امکانات
</div>
</div>
<div id='leftsidmid' >
<div id='leftsidmidtxt'>

شما می توانید تنظیمات جدیدی را به بخش تنظیمات اضافه کنید:
<br />
<form method='post' action='?part=setting&action=add' >
<input type='submit' id='submitinput' value='ایجاد تنظیم جدید' disabled=disabled  />
</form>
<br />
این قسمت هنوز فعال نشده و در آینده فعال می شود.
</div>
</div>
<div id='leftsiddown' >
<div id='leftsiddowntxt'>

</div>
</div>
</div>

</div>

";
}


//تابع نهایی ویرایش کاربر

function  finaleditsetting($errmes){

if ( $_REQUEST[submitbtt]  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$config = $_REQUEST[config];

	
	while(list($setting_name,$setting_value)=each($config))
    	{ 
		// تعریف کوئری
		$query="UPDATE gcms_setting SET setting_value='".$setting_value."' where setting_name='".$setting_name."'";
		//در صورتی که تغییرات درست انجام بگیرد
		
		mysql_query($query,$link);

		}       
	$errmes = $errmes." تنظیمات با موفقیت انجام شد ";

}
editsetting($errmes);
}










?>