<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?php
// تابه لیست یوزر برای صفحه اصلی و لیست کردن کاربران
function  listplugin($errmes){
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
افزونه ها
</h2>
<table cellpadding='0' cellspacing='0' >
<thead>
<tr>
<th scope='col' width=100px >نام افزونه فارسی</th><th scope='col' width=100px>نام افزونه لاتین</th><th scope='col' width=50px>لینک مدیریت</th><th scope='col' width=50px>وضعیت</th><th scope='col' width=50px>حذف</th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col' width=100px >نام افزونه فارسی</th><th scope='col' width=100px>نام افزونه لاتین</th><th scope='col' width=50px>لینک مدیریت</th><th scope='col' width=50px>وضعیت</th><th scope='col' width=50px>حذف</th>
</tr>
</tfoot>
";

// تعریف کوئری برای لیست 

		$query = " FROM `gcms_plugin`  ";
		
	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = 20; 
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num $query "),0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=plugin";
	//////////////////////////////////////////////////////////////////////////////////////
// درست کردن لیست
$query = "SELECT * ".$query." LIMIT $from, $max_results";
	
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
		

// نمایش جدول لیست 
echo "
<tr class='$clsoe'>
<td >
$row[f_name]
</td>
<td>
$row[e_name]
</td>
<td>
<a href='?part=$row[e_name]' title='لینک به مدیریت افزونه'  ><img src='/gcms/admin-gcms/images/link.png'  height=30px width=30px title='لینک به مدیریت افزونه' border='0' ></a>
</td>
<td>
<a href='?part=plugin&action=status&id=$row[id]&statusplugin=$row[status]' title='$row[status]'   ><img src='/gcms/admin-gcms/images/$row[status]plugin.png'  height=30px width=30px title='$row[status]' border='0' ></a>
</td>
<td>
<a href='?part=plugin&action=delete&id=$row[id]' title='حذف' onclick=\"return confirm('آیا می خواهید افزونه  $row[f_name] را حذف کنید؟');\"  ><img src='/gcms/admin-gcms/images/delete.png'  height=25px width=25px title='حذف' border='0' ></a>
</td>
</tr>
";
		}
		
echo "
</table><div id='pagediv' >";
			////////////////////////////////////////////////////////////////////////////////////
//صفحه قبلی
if($page > 1){ 
    $prev = ($page - 1); 
    echo "<a href='$pagelink&page=$prev'><div id='ppagnolink' title='صفحه قبلی' >&laquo;</div></a>"; 
} 
//صفحه حاضر
for($i = 1; $i <= $total_pages; $i++){ 
    if(($page) == $i){echo "<div id='ppagnolink' >$i</div>";} else { 
            echo "<a href='$pagelink&page=$i'><div id='ppag' title='صفحه $i' >$i</div></a>"; 
    } 
}
	//صفحه بعدی
if($page < $total_pages){ 
    $next = ($page + 1); 
    echo "<a href='$pagelink&page=$next'><div id='ppag' title='صفحه بعدی' >&raquo;</div></a>"; 
} 
			////////////////////////////////////////////////////////////////////////////////////
echo "
</div>

</div>
<div id='leftsidb' >
<div id='leftsidup' >
<div id='leftsiduptxt' >
افزودن افزونه جدید
</div>
</div>
<div id='leftsidmid' >
<div id='leftsidmidtxt'>

<form enctype='multipart/form-data' method='post'  action='?part=plugin&action=add&add=true' >

نام افزونه به فارسی  <br>

<input type='text' id='input'  name='f_name'  /><br />

نام افزونه به لاتین <br>

  <select name='e_name' id='input'>
    <option>select</option>
    <option>gallery</option>
    <option>news</option>
    <option>newsletter</option>
    <option>poll</option>
    <option>map</option>
    <option>product</option>
  </select>
<br>
آپلود فایل اصلی<br>

<input type='file' name='main_file'  id='input' size='7' >

آپلود فایل توابع <br>

<input type='file' name='func_file'  id='input' size='7' >

حداقل عدد سطح دسترسی به این افزونه ( 10,8,6 ) 

<input type='text' id='input'  name='level'  value='8'   size='1' /><br />

کوئری اس کیو ال مربوطه <br>

	<textarea name='sqlquery' cols='17' rows='4' id='input' width='40'></textarea>

<input type='submit' id='submitinput'  name='submitbtt'  value='افزودن افزونه'  />
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


// تابع نهایی اضافه کردن 

function  finaladdplugin($errmes){


if ($_FILES['main_file']['name'] AND $_FILES['func_file']['name']){
	// آپلود عکس
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/';
	// نام فایل
	$filename_main = $_FILES['main_file']['name'];
	$filename_func = $_FILES['func_file']['name'];
	//مسیر کامل فایل
	$uploadfile_main = $uploaddir . basename($filename_main);
	$uploadfile_func = $uploaddir . basename($filename_func);

	//انجام آپلود فایل  
	$mufm = move_uploaded_file($_FILES['main_file']['tmp_name'], $uploadfile_main);
	$muff = move_uploaded_file($_FILES['func_file']['tmp_name'], $uploadfile_func);
				if ( $mufm AND $muff ){
				$errmes = "
				فایل ها با موفقیت اضافه شد.
				";
				}else{
				// در صورت برخورد با مشکل
				$errmes = " مشکل در ارسال فایل ها لطفا دوباره تلاش کنید. ";
				}
	}
// فراخوانی فایل کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	$ddate = time();

		// برای گرفتن داده های ارسال شده
	if ($_REQUEST[submitbtt]){
			//کوئری اضافه کردن به جدول یوزر
			$que_add = "INSERT INTO `gcms_plugin` ( `f_name` ,`e_name` ,`status` ,`date` ,`level`) VALUES ('$_REQUEST[f_name]' ,'$_REQUEST[e_name]' ,'active', '$ddate', '$_REQUEST[level]')";
			//انجام کوئری
			
				if ( mysql_query($que_add,$link) ){
				$errmes = $errmes."
				افزونه  جدید با موفقیت اضافه شد.
				";
				}else{
				// در صورت برخورد با مشکل
				$errmes =  $errmes. " مشکل در ارسال اطلاعات لطفا دوباره تلاش کنید. ";
				}

	}
	
		// برای انجام کوئری
	if ($_REQUEST[sqlquery]){
			//کوئری اضافه کردن به جدول یوزر
			$query = $_REQUEST[sqlquery];
			//انجام کوئری

			$query  = explode(";", $query);
			$cont = count($query)-1;
		for ($i++ ; $i <= $cont ; $i++) {

		if ( mysql_query($query[$i-1],$link) ){
				$errmes = $errmes."
			کوئری".$i." با موفقیت انجام شد.
				";
				}else{
				// در صورت برخورد با مشکل
				$errmes =  $errmes. " مشکل در ارسال اطلاعات کوئری لطفا دوباره تلاش کنید.";
				}


		}
	}
	
	
	// فرستادن پیام خطا با لیست کردن کاربران
listplugin($errmes);
}

//تابع ویرایش  

function  editpage($errmes){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

// تعریف کوئری
	$query = "SELECT * FROM `gcms_pages` WHERE id='$_REQUEST[id]' ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
	$row = mysql_fetch_array($result);

			// بدست آوردن تاریخ 
			$registerd = $row[page_date];
			//تبدیل تاریخ کنونی به حالت اصلی
			$showregisterd = jdate("l j  F  y ",$registerd);

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

//فقط یک ریشه به جلو می رویم و صفحه هایی را می توانیم به عنوان صفحه اصلی معرفی کنیم که خودشان هیچ بالاتری نداشته باشند ... در صورتی که بخواهیم ساختار را درختی کنیم کوئری این قسمت را عوض می کنیم

// تعریف کوئری برای لیست کاربران
	$query1 = "SELECT * FROM `gcms_pages` WHERE page_parent='0' ";
// نتایج کوئری
	$result1 = mysql_query($query1,$link);
// دریافت نتایج در سطر	
$f_child = "<b>صفحه اصلی مرتبط </b>
<br />
<select  name='page_parent' id='input' >
<option value='0'>بدون صفحه اصلی</option>

";
		while($row1 = mysql_fetch_array($result1)){

$f_child = $f_child ."
<option value='$row1[id]' ";
if ($row1[id] == $row[page_parent]){
$f_child = $f_child . " selected ";
}
$f_child = $f_child . ">$row1[page_title]</option>

";
}
$f_child = $f_child ."</select>";

echo "<div id='mytb' >
<h2>
ویرایش صفحه $row[page_title]
</h2>
<form enctype='multipart/form-data'  action='?part=pages&action=edit&edit=true' method='post' >
<input type='text' id='input' name='page_title' class='reqd' size='45' value='$row[page_title]' />
<br><br>
<textarea id='textarea' name='page_content' style='width:450px;height:300px;'  >
$row[page_content]
</textarea>
</div>
<div id='leftsidb' >
<div id='leftsidup' >
<div id='leftsiduptxt' >
امکانات
</div>
</div>
<div id='leftsidmid' >
<div id='leftsidmidtxt'>

$f_child

<br />
<b>عکس مربوط به این صفحه</b><br />
<img src='$row[page_pic]' border='0' width='160' height='160'  /><input type='hidden' name='no_page_pic' value='$row[page_pic]' /><br />
<input type='file' size='7' name='page_pic' id='input' />
<br />
<b>وضعیت صفحه</b>
<br />
 <input type='radio' name='page_status'  value='publish' ";
if ($row[page_status] == "publish"){
echo " checked='checked' ";
}
 echo " /> نمایش صفحه
 <br />
 <input type='radio' name='page_status'  value='pending'  ";
if ($row[page_status] == "pending"){
echo " checked='checked' ";
}
 echo "  /> در دست بررسی
<br />
<b>وضعیت نظرات</b>
<br />
 <input type='radio' name='comment_status'  value='open'   ";
if ($row[comment_status] == "open"){
echo " checked='checked' ";
}
 echo "    /> فعال
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type='radio' name='comment_status' value='close'  ";
if ($row[comment_status] == "close"){
echo " checked='checked' ";
}
 echo "  /> غیر فعال
<br /><br />
<b>رتبه صفحه در منوها</b>

<input type='text' size='1' name='menu_order' id='input' value='$row[menu_order]'  />
<br /><br />
<b>تاریخ ایجاد : $showregisterd</b>
$day
<br />
<center><input type='submit' id='submitinput' name='submitbtt' value='ویرایش صفحه'  onMouseDown='initForms()' /></center>
<input type='hidden' name='id'  value='$row[id]'  />
</form>

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

function  finaleditpage($errmes){

$page_excerpt = substr($_REQUEST[page_content], 0, 250);  


if ($_FILES['page_pic']['name']){
	// آپلود عکس
	$uploaddir = $_SERVER['DOCUMENT_ROOT'].'/gcms/upload/title-images/';
	// نام فایل
	$filename = time().$_FILES['page_pic']['name'];
	//مسیر کامل فایل
	$uploadfile = $uploaddir . basename($filename);
	//سیر اینترنتی فایل را درست می کند
	$source = $filename;
	//انجام آپلود فایل  
	move_uploaded_file($_FILES['page_pic']['tmp_name'], $uploadfile);
	//تعریف مسیر فایل
	$src = "/gcms/upload/title-images/".$filename;
	}else{
	$src = $_REQUEST[no_page_pic];
	}

// تعریف کوئری
	$query = "UPDATE gcms_pages SET
`page_title` = '$_REQUEST[page_title]',
`page_content` = '$_REQUEST[page_content]',
`page_excerpt` = '$page_excerpt',
`page_status` = '$_REQUEST[page_status]',
`comment_status` = '$_REQUEST[comment_status]',
`page_parent` = '$_REQUEST[page_parent]',
`menu_order` = '$_REQUEST[menu_order]',
`page_pic` = '$src' 
 WHERE `id` ='$_REQUEST[id]'";
// در صورت ارسال اطلاعات
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	
		//در صورتی که تغییرات درست انجام بگیرد
		if (mysql_query($query,$link))
		{	
			$errmes = "تغییرات در  ، $_REQUEST[page_title] ،با موفقیت انجام شد";
		}
		// مشکل در تغییرات کاربر
		else{
		$errmes = "مشکل در انجام تغییرات لطفا دوباره سعی کنید.";
		}

listpage($errmes);
}

// تابع تغییر وضعیت 

function  statusp($errmes){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	if ($_REQUEST[statusplugin] == "active" ){
	$statuspage = "rejcet"; }else{
	$statuspage = "active"; }
	
	if ($_REQUEST[id]){
	//  کوئری
	$query_status = "UPDATE gcms_plugin SET status='$statuspage'  WHERE `id` ='$_REQUEST[id]'";
	
		if (mysql_query($query_status,$link)){
		$errmes = "وضعیت انتشار افزونه مورد نظر با موفقیت به روز شد";
		}else{
			  $errmes = "مشکل در به روزآوری وضعیت افزونه .. لطفا دوباره تلاش کنید.";
			  }
	}
listplugin($errmes);
}
// تابع حذف
function  deleteplugin($errmes){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
if ($_REQUEST[id]){
	$query_del = "DELETE FROM `gcms_plugin` WHERE `gcms_plugin`.`id` = $_REQUEST[id] LIMIT 1";
	
		if (mysql_query($query_del,$link)){
		$errmes = "افزونه ای با شماره سطر $_REQUEST[id] با موفقیت حذف شد";
		}else{
			  $errmes = "مشکل در به حذف افزونه .. لطفا دوباره تلاش کنید.";
			  }

}

listplugin($errmes);
}









?>