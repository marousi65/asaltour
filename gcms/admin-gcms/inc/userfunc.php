<?php
// تابه لیست یوزر برای صفحه اصلی و لیست کردن کاربران
function  listuser($errmes){
// فراخوانی کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
echo "
<div id='head' >
<div id='mainbody' >
<div class='leftbody' >";
// در صورتی که پیغام خطایی داشته باشیم نشان می دهد
if ($errmes){
echo"
<div id='err-mess' >
$errmes
</div>
";
}
echo "<div id='mytb' >
<h2>
نمایش لیست تمام کاربران
</h2>
<table cellpadding='0' cellspacing='0' >
<thead>
<tr>
<th scope='col'>نام کاربری</th><th scope='col'>نام و نام خانوادگی</th><th scope='col'>ایمیل</th><th scope='col'>وظیفه</th><th scope='col'>وضعیت</th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col'>نام کاربری</th><th scope='col'>نام و نام خانوادگی</th><th scope='col'>ایمیل</th><th scope='col'>وظیفه</th><th scope='col'>وضعیت</th>
</tr>
</tfoot>
";

// تعریف کوئری برای لیست کاربران
	$query = "SELECT * FROM `gcms_user` WHERE id!=1 ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
		while($row = mysql_fetch_array($result)){
		$i++;
		// تعریف زوج و فرد بودن سطور
		if ( $i % 2 == 0){
		$clsoe = "even";
		}else{
		$clsoe = "odd";
		}
		// تعریف وظیفه برای کاربر
	switch ($row[level]){
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
		
	// تعریف کوئری برای پیدا کردن نام 
	$query2 = "SELECT metauser_value FROM `gcms_metauser` where user_id='$row[id]' AND metauser_key='first_name'  ";
	// تعریف کوئری برای پیدا کردن فامیل
	$query3 = "SELECT metauser_value FROM `gcms_metauser` where user_id='$row[id]' AND metauser_key='last_name'  ";
	// نتایج کوئری
	$result2 = mysql_query($query2,$link);
	$result3 = mysql_query($query3,$link);
	// دریافت نتایج در سطر	
	$row2 = mysql_fetch_array($result2);
	$row3 = mysql_fetch_array($result3);
// نمایش جدول لیست کاربران
	
echo "
<tr class='$clsoe'>
<td ><a href='?part=users&action=edit&id=$row[id]' >$row[login]</a></td><td>$row2[0] $row3[0]</td><td>$row[email]</td><td>$level</td><td><img src='/gcms/admin-gcms/images/$row[status].png' title='$row[status]' ></td>
</tr>
";
		}
		
echo "
</table>
<div id='dwbckdsh'></div>
</div>
<div id='leftsidb' >
<div id='leftsidup' >
<div id='leftsiduptxt' >
امکانات
</div>
</div>
<div id='leftsidmid' >
<div id='leftsidmidtxt'>
شما می توانید کاربر جدیدی را برای مدیریت سایت ایجاد کنید:
<br />
<form method='post' action='?part=users&action=add' >
<input type='submit' id='submitinput' value='ایجاد کاربر'  />
</form>
<br />

شما می توانید اطلاعات خود را ویرایش کنید:
<br />
<form method='post' action='?part=users&action=edit&id=$_SESSION[initiated]' >
<input type='submit' id='submitinput' value='تغییر اطلاعات خودم '  />
</form>
<br />

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
// تابع اضافه کردن کاربر - حالت اولیه

function  adduser($errmes){
echo "
<div id='head' >
<div id='mainbody' >
<div class='leftbody' >";
// نمایش پیغام
if ($errmes){
echo"
<div id='err-mess' >
$errmes
</div>
";
}
echo "<div id='mytb' >
<h2>
اضافه کردن کاربر جدید
</h2>
<form  action='?part=users&action=add&add=true' method='post' >
<table cellpadding='0' cellspacing='0' >
<thead>
<tr>
<th scope='col' width=110px ></th><th scope='col'></th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col'></th><th scope='col'><input type='submit' id='submitinput' value='ثبت نام'  onMouseDown='initForms()' /></th>
</tr>
</tfoot>

<tr class='odd'>
<td >نام کاربری</td><td><input type='text' id='input' name='login' class='reqd'  /></td>
</tr>

<tr class='even'>
<td >نام</td><td><input type='text' id='input' name='firstname'  /></td>
</tr>

<tr class='odd'>
<td >نام خانوادگی</td><td><input type='text' id='input' name='lastname'  /></td>
</tr>

<tr class='even'>
<td >ایمیل</td><td><input type='text' id='input' name='email' class='email'  /></td>
</tr>

<tr class='odd'>
<td >کلمه عبور</td><td><input type='password' id='input' name='password' class='reqd'  /></td>
</tr>

<tr class='even'>
<td >تکرار کلمه عبور</td><td><input type='password' id='input' name='repassword' class='reqd'  /></td>
</tr>

<tr class='odd'>
<td >وظیفه</td>
<td>
  <select name='level' id='input'>
    <option value='8'  selected='selected' >مدیر سایت</option>
	<option value='6' >ویراستار</option>
  </select>
</td>
</tr>
<tr class='even'>
<td >وضعیت</td><td><input type='radio' name='status' value='active' checked /> فعال  	&nbsp;&nbsp;&nbsp;&nbsp;	<input type='radio' name='status' value='nonactive' /> غیرفعال </td>
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

شما می توانید کاربر جدیدی را برای مدیریت سایت ایجاد کنید:
<br />
<form method='post' action='?part=users&action=add' >
<input type='submit' id='submitinput' value='ایجاد کاربر'  />
</form>
<br />

شما می توانید اطلاعات خود را ویرایش کنید:
<br />
<form method='post' action='?part=users&action=edit&id=$_SESSION[initiated]' >
<input type='submit' id='submitinput' value='تغییر اطلاعات خودم '   />
</form>
<br />

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

// تابع نهایی اضافه کردن کاربر

function  finaladduser($errmes){
// فراخوانی فایل کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	// تعیین وظیفه کاربر
	switch ($_REQUEST[level]){
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
		// برای گرفتن داده های ارسال شده
	if ($_REQUEST[email]){
		//چک کردن این که آیا با همین ایمیل در دیتا بیس موجود هست یا نه ؟
		$que_chkuser = "SELECT id FROM `gcms_user` WHERE  login='$_REQUEST[login]'  ";
		$res_chkuser = mysql_query($que_chkuser,$link);
		$row_chkuser = mysql_fetch_array($res_chkuser);
	//اگر یوزری با همین ایمیل وجود نداشت
		if( !$row_chkuser[id] ){
			if( $_REQUEST[password] == $_REQUEST[repassword] ){
			//رمز کردن پسورد
			$password = crypt($_REQUEST[password]);
			// بدست آوردن تاریخ کنونی
			$registerd = time();
			//تبدیل تاریخ کنونی به حالت اصلی
			$showregisterd = jdate("l j  F  y ",$registerd);
			//کوئری اضافه کردن به جدول یوزر
			$que_addtouser = "INSERT INTO `gcms_user` ( `login` ,`password` ,`email` ,`status` ,`registerd` ,`level` ) VALUES ('$_REQUEST[login]' ,'$password' ,'$_REQUEST[email]' ,'$_REQUEST[status]' ,'$registerd' ,'$_REQUEST[level]')";
			//انجام کوئری
			$res_addtouser= mysql_query($que_addtouser,$link);
			//پیدا کردن آی دی همین کوئری	
			$query1 = "SELECT id FROM `gcms_user` where registerd=$registerd ";
			// نتایج کوئری
			$result1 = mysql_query($query1,$link);
			// دریافت نتایج در سطر	
			$row1 = mysql_fetch_array($result1);
			// کوئری اضافه کردن نام به جدول متا دیتا
			$que_addtometauser1 = "INSERT INTO `gcms_metauser` (  `user_id` ,`metauser_key` ,`metauser_value`  ) VALUES ('$row1[0]','first_name','$_REQUEST[firstname]'  )";
			//کوئری اضافه کردن فامیل به جدول متا دیتا
			$que_addtometauser2 = "INSERT INTO `gcms_metauser` (  `user_id` ,`metauser_key` ,`metauser_value`  ) VALUES ('$row1[0]','last_name','$_REQUEST[lastname]'  )";
			//نتایج کوئری
			$res_addtometauser1= mysql_query($que_addtometauser1,$link);
			//نتایج کوئری
			$res_addtometauser2= mysql_query($que_addtometauser2,$link);
			// اگر به درستی کاربر به جدول یوزر اضافه شد
				if ( $que_addtouser AND $res_addtometauser1 ){
				$errmes = "کاربر با نام کاربری  $_REQUEST[login] : 
				نام :  $_REQUEST[firstname]
				نام خانوادگی : $_REQUEST[lastname]
				ایمیل : $_REQUEST[email]
				کلمه عبور : $_REQUEST[password]
				وظیفه : $level
				تاریخ عضویت : $showregisterd
				";
				}else{
				// در صورت برخورد با مشکل
				$errmes = " مشکل در ارسال اطلاعات لطفا دوباره تلاش کنید. ";
				}
			}else{
			//کلمه های عبور هماهنگ نباشند
			$errmes = "کلمه عبور شما هماهنگ نبوده لطفا دوباره سعی کنید";
			}
			
		}else{
		// از همین نام کاربری استفاده شده باشد
		$errmes = " کاربری با این نام کاربری وجود دارد لطفا دوباره سعی کنید. ";
		}

	}
	// فرستادن پیام خطلا با لیست کردن کاربران
listuser($errmes);
}

//تابع ویرایش یوزر ها

function  edituser($errmes){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	//error in id 1
	if ($_REQUEST[id] == 1 ){
	echo "
		<script>
		window.location='/gcms/admin-gcms/gcms/?part=dashboard';
		</script>
	";
	}else{

// تعریف کوئری
	$query = "SELECT * FROM `gcms_user` WHERE id='$_REQUEST[id]' ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
	$row = mysql_fetch_array($result);

// تعریف کوئری
	$query2 = "SELECT metauser_value FROM `gcms_metauser` where user_id='$row[id]' AND metauser_key='first_name'  ";
// تعرف کوئری برای نام خانوادگی
	$query3 = "SELECT metauser_value FROM `gcms_metauser` where user_id='$row[id]' AND metauser_key='last_name'  ";
// نتایج کوئری
	$result2 = mysql_query($query2,$link);
	$result3 = mysql_query($query3,$link);
// دریافت نتایج در سطر	
		$row2 = mysql_fetch_array($result2);
		$row3 = mysql_fetch_array($result3);

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
ویرایش کاربر
</h2>
<form  action='?part=users&action=edit&edit=true' method='post' >
<table cellpadding='0' cellspacing='0' >
<thead>
<tr>
<th scope='col' width=110px >$row[1]</th><th scope='col'></th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col'></th><th scope='col'><input type='submit' id='submitinput' value='ویرایش'  onMouseDown='initForms()' /></th>
</tr>
</tfoot>

<tr class='even'>
<td >نام</td><td><input type='text' id='input' name='firstname' value='$row2[0]'   /></td>
</tr>

<tr class='odd'>
<td >نام خانوادگی</td><td><input type='text' id='input' name='lastname' value='$row3[0]'  /></td>
</tr>

<tr class='even'>
<td >ایمیل</td><td><input type='text' id='input' name='email' class='email' value='$row[3]'  /></td>
</tr>

<tr class='odd'>
<td >کلمه عبور</td><td><input type='password' id='input' name='password'   /></td>
</tr>

<tr class='even'>
<td >تکرار کلمه عبور</td><td><input type='password' id='input' name='repassword'   /></td>
</tr>

<tr class='odd'>
<td >وظیفه</td>
<td>
  <select name='level' id='input'>
    <option value='8' ";
	if ($row[level] == 8){
	echo " selected='selected' ";
	}
	echo"  >مدیر سایت</option>
	<option value='6' ";
	if ($row[level] == 6){
	echo " selected='selected' ";
	}
	echo"  >ویراستار</option>
  </select>
</td>
</tr>
<tr class='even'>
<td >وضعیت</td><td><input type='radio' name='status' value='active' ";
	// مشخص کردن وضعیت کاربر
	if ($row[status] == "active" ){
	echo " checked ";
	}
	echo" /> فعال  	&nbsp;&nbsp;&nbsp;&nbsp;	<input type='radio' name='status' value='nonactive' ";
	if ($row[status] == "nonactive" ){
	echo " checked ";
	}
	echo"  /> غیرفعال </td>
</tr>

</table>
<div id='dwbckdsh'></div>

<input type='hidden'  name='login'  value='$row[login]'  />
<input type='hidden'  name='id'  value='$row[id]'  />
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

شما می توانید کاربر جدیدی را برای مدیریت سایت ایجاد کنید:
<br />
<form method='post' action='?part=users&action=add' >
<input type='submit' id='submitinput' value='ایجاد کاربر'  />
</form>
<br />

شما می توانید اطلاعات خود را ویرایش کنید:
<br />
<form method='post' action='?part=users&action=edit&id=$_SESSION[initiated]' >
<input type='submit' id='submitinput' value='تغییر اطلاعات خودم'  />
</form>
<br />

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
	//end error in id 1
	}

//تابع نهایی ویرایش کاربر

function  finaledituser($errmes){

if ( $_REQUEST[repassword] == $_REQUEST[password] ){
// تعریف کوئری
	$query = "UPDATE gcms_user SET email='$_REQUEST[email]',level='$_REQUEST[level]',status='$_REQUEST[status]' WHERE `id` ='$_REQUEST[id]'";
// در صورت ارسال اطلاعات
if ($_REQUEST[password]){
// رمز کردن پسورد
$password = crypt($_REQUEST[password]);
// تعریف کوئری آپ دیت
	$query = "UPDATE gcms_user SET email='$_REQUEST[email]',level='$_REQUEST[level]', password='$password'  WHERE `id` ='$_REQUEST[id]'";
}
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
		// تعریف کوئری آپ دیت نام
		$query2 = "UPDATE gcms_metauser SET metauser_value='$_REQUEST[firstname]'  WHERE `user_id` ='$_REQUEST[id]' AND metauser_key='first_name' ";
		//تعریف کوئری آپ دیت فامیل
		$query3 = "UPDATE gcms_metauser SET metauser_value='$_REQUEST[lastname]'  WHERE `user_id` ='$_REQUEST[id]' AND metauser_key='last_name' ";
	
		//در صورتی که تغییرات درست انجام بگیرد
		if (mysql_query($query,$link) AND mysql_query($query2,$link) AND mysql_query($query3,$link))
		{	
			$errmes = "تغییرات در اطلاعات کاربر ، $_REQUEST[login] ،با موفقیت انجام شد";
		}
		// مشکل در تغییرات کاربر
		else{
		$errmes = "مشکل در انجام تغییرات لطفا دوباره سعی کنید.";
		}

}else {
		$errmes = "کلمه عبور شما هماهنگ نبوده لطفا دوباره سعی کنید";
	   }
listuser($errmes);
}

//













?>