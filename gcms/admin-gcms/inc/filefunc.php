<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?php

//تابع ویرایش

function  filelist($errmes){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
		switch ($_REQUEST[chngfile]){
			//	
			case "type":
			//
			$query="UPDATE gcms_file  SET file_type ='$_REQUEST[elect]' WHERE id='$_REQUEST[id]' ";
			if (mysql_query($query,$link)){
			$errmes = "نوع فایل مورد نظر با موفقیت تغییر کرد";
			}else{
			$errmes = "مشکل در تغییر نوع فایل ... لطفا دوباره تلاش کنید.";
			}
			break;
			
			case "del":
			//
			$query="DELETE FROM `gcms_file` WHERE `gcms_file`.`id` ='$_REQUEST[id]' LIMIT 1  ";
			if (mysql_query($query,$link)){
			$errmes = " فایل مورد نظر با موفقیت حذف کرد";
			}else{
			$errmes = "مشکل در حذف  فایل ... لطفا دوباره تلاش کنید.";
			}
			break;
			
			
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
مدیریت فایل ها
</h2>
<div id='bckfile' >

";
if ( !$_REQUEST[folder] ){

echo "
لیست تمامی پوشه ها <br><br>
";
// تعریف کوئری
	$query = "SELECT DISTINCT  folder FROM `gcms_file`   ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
	while($row = mysql_fetch_array($result)){
echo "
<a href='?part=file&folder=$row[0]' >
<div id='foldershow' >
<br>
$row[0]  </div></a>
";		
	}
}else{
echo "
<a href='?part=file' >&lt;&lt; بازگشت به پوشه اصلی </a><br>
لیست تمامی فایل های داخل پوشه <b> $_REQUEST[folder] </b><br><br>
";

// تعریف کوئری
	$query_setting = "SELECT setting_value FROM `gcms_setting` WHERE  setting_name = 'site_address'  ";
// نتایج کوئری
	$result_setting = mysql_query($query_setting,$link);
// دریافت نتایج در سطر	
	$row_setting = mysql_fetch_array($result_setting);

// تعریف کوئری
	$query = "SELECT *  FROM `gcms_file` WHERE folder = '$_REQUEST[folder]'  ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
	while($row = mysql_fetch_array($result)){
echo "<div class='fileshow' >

<img src='/gcms/admin-gcms/images/fileimag/$row[file_type]' align='right' border='0' width='128' height='128'  />
<b>حجم فایل </b> $row[file_size] KB
<br>
<b>نام فایل  </b>
<br>
$row[file_name]
<br><a href='/gcms/upload/filetype/$row[file_name]' >
دانلود فایل
 </a>
<textarea class='input' dir='ltr' rows='3' readonly='readonly' onfocus='javascript: this.select()'>
$row_setting[0]/gcms/upload/filetype/$row[file_name]
</textarea> 
تغییر نوع فایل
<form method='post' action='?part=file&folder=$row[folder]&chngfile=type&id=$row[id]' >
  <select name='elect' id='input'>
    <option value='elect.png'>انتخاب کنید</option>
 
    <option value='Data.png'>فایل دیتا</option>
 
    <option value='Text.png'>فایل متنی</option>
 
    <option value='Image.png'>عکس</option>
 
    <option value='Audio.png'>فایل صوتی</option>
 
    <option value='Vdeo.png'>فایل تصویری</option>
 
    <option value='Web.png'>فایل وب</option>
 
    <option value='Font.png'>فونت</option>
 
    <option value='Binary.png'>فایل سیستمی</option>
 
    <option value='exe.png'>فایل اجرایی</option>
 
    <option value='Winrar.png'>فایل فشرده</option>
 
    <option value='Backup.png'>فایل پشتیبان</option>
 
    <option value='PDF.png'>پی دی اف</option>
 
    <option value='Word.png'>ورد</option>
 
  </select>
  <input type='submit' id='submitinput' value='تغییر'  />
  </form>
  <div id='delbtt' >
  <a href='?part=file&folder=$row[folder]&chngfile=del&id=$row[id]' onclick=\"return confirm('آیا می خواهید فایل $row[file_name] را حذف کنید؟');\" >
  حذف فایل
  </a>
  </div>
  </div>
";		
	}

}

// تعریف کوئری
	$query = "SELECT DISTINCT  folder FROM `gcms_file`   ";
// نتایج کوئری
	$result = mysql_query($query,$link);
	
	$folderselect = "  <select name='folderselect' id='input'>";
// دریافت نتایج در سطر	
	while($row = mysql_fetch_array($result)){
$folderselect = $folderselect." <option value='$row[0]'>$row[0]</option> ";		
	}
	$folderselect = $folderselect."  </select>";

echo "
</div>
<div id='dwbckdsh'></div>
</div>
<div id='leftsidb' >
	<div id='leftsidup' >
		<div id='leftsiduptxt' >
اضافه کردن فایل
		</div>
	</div>
<div id='leftsidmid' >
	<div id='leftsidmidtxt'>

<form enctype='multipart/form-data' method='post' action='?part=file&action=addfile' >
<input type='file' name='filetype'  id='input' size='7' >
<br> نوع فایل : <br>
  <select name='elect' id='input'>
    <option value='elect.png'>انتخاب کنید</option>
 
    <option value='Data.png'>فایل دیتا</option>
 
    <option value='Text.png'>فایل متنی</option>
 
    <option value='Image.png'>عکس</option>
 
    <option value='Audio.png'>فایل صوتی</option>
 
    <option value='Vdeo.png'>فایل تصویری</option>
 
    <option value='Web.png'>فایل وب</option>
 
    <option value='Font.png'>فونت</option>
 
    <option value='Binary.png'>فایل سیستمی</option>
 
    <option value='exe.png'>فایل اجرایی</option>
 
    <option value='Winrar.png'>فایل فشرده</option>
 
    <option value='Backup.png'>فایل پشتیبان</option>
 
    <option value='PDF.png'>پی دی اف</option>
 
    <option value='Word.png'>ورد</option>
 
  </select>

 <br>
یکی از پوشه های زیر را انتخاب کنید 
$folderselect
<br>
و یا نام پوشه جدیدی را وارد کنید
 <br>
 <input type='text' id='input' name='newfoldername'   />
<br />
<input type='submit' name='submitbtt'  id='submitinput' value='آپلود فایل'  />
</form>
	<br />
	</div>
</div>
	<div id='leftsiddown' >
		<div id='leftsiddowntxt'>
		</div>
	</div>
<div id='leftsidup' >
	<div id='leftsiduptxt' >
مدیریت پوشه ها
	</div>
</div>
		<div id='leftsidmid' >
			<div id='leftsidmidtxt'>
<form method='post' action='?part=file&action=editfolder' >
<b>ویرایش پوشه </b><br />
نام فعلی <br />
$folderselect <br />
نام جدید <br />
 <input type='text' id='input' name='newfoldername'   />
<input type='submit' name='submitbtt' id='submitinput' value='تایید'  />
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


// تابع نهایی آپلود فایل  

function  finaladdfile($errmes){


if ($_FILES['filetype']['name']){
	
	if ($_REQUEST[newfoldername]){
	$foldername = $_REQUEST[newfoldername] ;
	}else{
	$foldername = $_REQUEST[folderselect] ;
	}
	
	// آپلود فایل
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/gcms/upload/filetype/';
	// نام فایل
	$filename = time().$_FILES['filetype']['name'];
	//مسیر کامل فایل
	$uploadfile = $uploaddir . basename($filename);
	//سیر اینترنتی فایل را درست می کند
	$source = $filename;
	//انجام آپلود فایل  
	move_uploaded_file($_FILES['filetype']['tmp_name'], $uploadfile);
	//تعریف مسیر فایل
	$src = "/gcms/upload/filetype/".$filename;
	$filetypesize = $_FILES['filetype']['size'];
}
// فراخوانی فایل کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

		// برای گرفتن داده های ارسال شده
	if ($_REQUEST[submitbtt] and $_FILES['filetype']['name']){
			//کوئری اضافه کردن به جدول 
			$ttime = time();
			$que_add = "INSERT INTO `gcms_file` ( `file_name` ,`file_type` ,`file_size` ,`folder` ,`date` ,`user` ) VALUES ('$filename' ,'$_REQUEST[elect]' ,'$filetypesize' ,'$foldername' ,'$ttime' ,'$_SESSION[initiated]')";
			//انجام کوئری
			
				if ( mysql_query($que_add,$link) ){
				$errmes = "
				فایل با موفقیت اضافه شد.
				";
				}else{
				// در صورت برخورد با مشکل
				$errmes = " مشکل در ارسال اطلاعات لطفا دوباره تلاش کنید. ";
				}

	}else{
				$errmes = " شما هیچ فایلی را ارسال نکرده اید .. دوباره تلاش کنید. ";
	}
	// فرستادن پیام خطا با لیست کردن کاربران
filelist($errmes);
}


// تابع نهایی ویرایش پوشه  

function  finaleditfolder($errmes){

/*
// فراخوانی فایل کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

		// برای گرفتن داده های ارسال شده
	if ($_REQUEST[submitbtt]){
			//کوئری اضافه کردن به جدول یوزر
			$ = "INSERT INTO `gcms_file` ( `file_name` ,`file_type` ,`file_size` ,`folder` ,`date` ,`user` ) VALUES ('$filename' ,'$_REQUEST[elect]' ,'$filetypesize' ,'$foldername' ,'time()' ,'1')";
			//انجام کوئری
			
				if ( mysql_query($que_add,$link) ){
				$errmes = "
				فایل با موفقیت اضافه شد.
				";
				}else{
				// در صورت برخورد با مشکل
				$errmes = " مشکل در ارسال اطلاعات لطفا دوباره تلاش کنید. ";
				}

	}
	// فرستادن پیام خطا با لیست کردن کاربران
	*/
	$errmes = "این قسمت هنوز تکمیل نشده است";
filelist($errmes);
}






?>