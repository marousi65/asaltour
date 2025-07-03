<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?php
// تابه لیست یوزر برای صفحه اصلی و لیست کردن کاربران
function  listpage($errmes){
// فراخوانی کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

if ( $_REQUEST[submitbtt] AND $_REQUEST[childpagenum] ){

	$querysettup = "UPDATE gcms_setting SET
`setting_value` = '$_REQUEST[childpagenum]'
 WHERE `setting_id` ='$_REQUEST[childid]'";
	
		//در صورتی که تغییرات درست انجام بگیرد
		if (mysql_query($querysettup,$link))
		{	
			$errmes = "تغییرات ،با موفقیت انجام شد";
		}
		// مشکل در تغییرات کاربر
		else{
		$errmes = "مشکل در انجام تغییرات لطفا دوباره سعی کنید. ";
		}



}


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
	// تعریف کوئری برای پیدا کردن  
	$query_all = "SELECT COUNT(*) FROM `gcms_pages` WHERE page_type='page' ";
	$query_publish = "SELECT COUNT(*) FROM `gcms_pages` WHERE page_status='publish' AND page_type='page' ";
	$query_pending = "SELECT COUNT(*) FROM `gcms_pages` WHERE page_status='pending' AND page_type='page' ";
	// نتایج کوئری
	$result_all = mysql_query($query_all,$link);
	$result_publish = mysql_query($query_publish,$link);
	$result_pending = mysql_query($query_pending,$link);
	// دریافت نتایج در سطر	
	$row_all = mysql_fetch_array($result_all);
	$row_publish = mysql_fetch_array($result_publish);
	$row_pending = mysql_fetch_array($result_pending);
	

echo "<div id='mytb' >
<h2>
نمایش  صفحات
</h2>
<div id='uptable' >
<a href='?part=pages' >همه صفحه ها ( $row_all[0] )</a> | <a href='?part=pages&status=publish' >صفحه های منتشر شده ( $row_publish[0] )</a> | <a href='?part=pages&status=pending' >صفحه های درحال بررسی ( $row_pending[0] ) </a>
</div>
<table cellpadding='0' cellspacing='0' >
<thead>
<tr>
<th scope='col' width=250px >عنوان</th><th scope='col' width=50px>نظرات</th><th scope='col' width=50px>وضعیت</th><th scope='col' width=50px>حذف</th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col' width=250px >عنوان</th><th scope='col' width=50px>نظرات</th><th scope='col' width=50px>وضعیت</th><th scope='col' width=50px>حذف</th>
</tr>
</tfoot>
";

// تعریف کوئری برای لیست کاربران
	if ($_REQUEST[status] == "publish" OR $_REQUEST[status] == "pending"){
		$query = " FROM `gcms_pages` WHERE page_type='page' AND page_status='$_REQUEST[status]' ORDER BY `gcms_pages`.`id` DESC ";
	}else{
		$query = " FROM `gcms_pages` WHERE page_type='page' ORDER BY `gcms_pages`.`id` DESC ";
		$_REQUEST[status] = "all";
	}
	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = 15; 
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num $query "),0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=pages&status=$_REQUEST[status]";
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
		
	//
	if ( $row[page_parent] != 0){	
	// تعریف کوئری برای پیدا کردن  
	$query2 = "SELECT page_title,id,page_excerpt FROM `gcms_pages` where id='$row[page_parent]'   ";
	// نتایج کوئری
	$result2 = mysql_query($query2,$link);
	// دریافت نتایج در سطر	
	$row2 = mysql_fetch_array($result2);
	$parent = "<a href='?part=pages&action=edit&id=$row2[id]&editor=full' title='$row2[page_excerpt]' > $row2[0] &raquo;</a> ";
	
	}
	//
	if ( $row[comment_status] == 'open'){	
	// تعریف کوئری برای پیدا کردن  
	$query3 = "SELECT COUNT(*) FROM `gcms_comment` WHERE page_id ='$row[id]'    ";
	// نتایج کوئری
	$result3 = mysql_query($query3,$link);
	// دریافت نتایج در سطر	
	$row3 = mysql_fetch_array($result3);
	$comment = " <a href='?part=comment&status=commentpage&id=$row[id]' >$row3[0] </a> ";
	}else{
	$comment = "بسته";
	}
// نمایش جدول لیست 
echo "
<tr class='$clsoe'>
<td >$parent <img src='$row[page_pic]' border='0' width='30' height='30'  /><a href='?part=pages&action=edit&id=$row[id]&editor=full' title='$row[page_excerpt]'  >$row[3]</a> </td><td>$comment</td><td><a href='?part=pages&action=status&id=$row[id]&statuspage=$row[page_status]' ><img src='/gcms/admin-gcms/images/$row[page_status].png'  height=30px width=30px title='$row[page_status]' border=0 ></a></td><td><a href='?part=pages&action=delete&id=$row[id]' title='حذف' onclick=\"return confirm('آیا می خواهید صفحه $row[3] را حذف کنید؟');\"  ><img src='/gcms/admin-gcms/images/delete.png'  height=25px width=25px title='حذف' border='0' ></a></td>
</tr>
";
$parent = "";
		}
		
echo "
</table><div id='pagediv' >";
			////////////////////////////////////////////////////////////////////////////////////
//صفحه قبلی
if($page > 1){ 
    $prev = ($page - 1); 
    echo "<a href='$pagelink&page=$prev'><div id='ppag' title='صفحه قبلی' >&laquo;</div></a>"; 
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
// تعریف کوئری برای تنظمات 
	$querysett = "SELECT * FROM `gcms_setting` WHERE setting_name='childpagenum'   ";
// نتایج کوئری
	$resultsett = mysql_query($querysett,$link);
// دریافت نتایج در سطر	
$childpagenum = "
<select  name='childpagenum' id='input' >

";
		$rowsett = mysql_fetch_array($resultsett);
		
		for ($inum = 1; $inum <= 50; $inum++) {

$childpagenum = $childpagenum ."
<option value='$inum' ";
if ($inum == $rowsett[setting_value]){
$childpagenum = $childpagenum . " selected ";
}
$childpagenum = $childpagenum . ">$inum</option>

";
}
$childpagenum = $childpagenum ."</select>";

echo "
</div>

</div>
<div id='leftsidb' >
<div id='leftsidup' >
<div id='leftsiduptxt' >
امکانات
</div>
</div>
<div id='leftsidmid' >
<div id='leftsidmidtxt'>
جستجو در میان صفحات <br>
	<form method='post' action='?part=search&serach=page' >
	 <input type='text' id='input' name='txt'  class='reqd' /> <br>
	<input type='radio' name='option' value='page_title' / >  در میان عناوین صفحه
	   <br>
	<input type='radio' name='option'  value='page_content' checked='checked' / >  در میان متن صفحه
	   <br>
	<input type='submit' name='submitbtt' id='submitinput' value='جستجو' onMouseDown='initForms()'  />
	</form>

<form method='post' action='?part=pages' >
تعداد نمایش صفحات فرعی<br />
$childpagenum
<br />
<input type='hidden' value='$rowsett[setting_id]'  name='childid' />
<input type='submit' id='submitinput' value='تنظیم'  name='submitbtt'  />
</form>
شما می توانید صفحه جدید اصلی اضافه کنید:
<br />
<form method='post' action='?part=pages&action=add&attrib=main&editor=full' >
<input type='submit' id='submitinput' value='ایجاد صفحه اصلی'  />
</form>
شما می توانید صفحه جدید فرعی ( زیر شاخه صفحه اصلی ) اضافه کنید:
<form method='post' action='?part=pages&action=add&attrib=child&editor=full' >
<input type='submit' id='submitinput' value='ایجاد صفحه فرعی'  />
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
// تابع اضافه کردن  - حالت اولیه

function  addpage($errmes){

			// بدست آوردن تاریخ کنونی
			$registerd = time();
			//تبدیل تاریخ کنونی به حالت اصلی
			$day = jdate(" j  M  y ",$registerd);
			$hour = date("G:i ");
			$hour = Convertnumber2farsi("$hour");
			
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
// پیدا کردن صفحه اصلی یا فرعی ؟
if ($_REQUEST[attrib] == "main"){

$attribpage = "صفحه اصلی";
$f_child = "<input type='hidden' name='page_parent'  value='0'  />";

}else{
$attribpage = "صفحه فرعی";
//فقط یک ریشه به جلو می رویم و صفحه هایی را می توانیم به عنوان صفحه اصلی معرفی کنیم که خودشان هیچ بالاتری نداشته باشند ... در صورتی که بخواهیم ساختار را درختی کنیم کوئری این قسمت را عوض می کنیم
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
// تعریف کوئری برای لیست کاربران
	$query = "SELECT * FROM `gcms_pages` WHERE page_parent='0' AND page_type = 'page' ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
$f_child = "<b>صفحه اصلی مرتبط </b>
<br />
<select  name='page_parent' id='input' >
";
		while($row = mysql_fetch_array($result)){

$f_child = $f_child ."
<option value='$row[id]'>$row[page_title]</option>

";
}
$f_child = $f_child ."</select>";
}
echo "<div id='mytb' >
<h2>
اضافه کردن $attribpage جدید
</h2>
<div id='bhdshb' >
<form enctype='multipart/form-data'  action='?part=pages&action=add&add=true' method='post' >
<input type='text' id='input' name='page_title' class='reqd' size='45' />
<br><br>
&nbsp;
<textarea id='textarea' name='page_content'   >

</textarea>
<div id='dwbckdsh'></div>
</div>
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
<b>عکس مربوط به این صفحه</b>
<br />
<input type='file' size='7' name='page_pic' id='input' />
<br />
<b>وضعیت صفحه</b>
<br />
 <input type='radio' name='page_status'  value='publish' checked='checked'/> نمایش صفحه
 <br />
 <input type='radio' name='page_status'  value='pending'  /> در دست بررسی
<br />
<b>وضعیت نظرات</b>
<br />
 <input type='radio' name='comment_status'  value='open' checked='checked' /> فعال
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 <input type='radio' name='comment_status' value='close'  /> غیر فعال
<br /><br />
<b>رتبه صفحه در منوها</b>

<input type='text' size='1' name='menu_order' id='input' value='0'  />
<br /><br />
<b>تاریخ : </b>
$day
<br />
<b>ساعت : </b>
$hour
<center><input type='submit' id='submitinput' name='submitbtt' value='ایجاد صفحه'  onMouseDown='initForms()' /></center>
<input type='hidden' name='page_date'  value='$registerd'  />
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

// تابع نهایی اضافه کردن 

function  finaladdpage($errmes){

$_REQUEST[page_content] = stripslashes( $_REQUEST[page_content] );


	$page_excerpt = substr(strip_tags($_REQUEST[page_content]), 0, 250); 
	$page_excerpt = substr($page_excerpt,0,strrpos($page_excerpt," "));


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
	$src = "/gcms/upload/title-images/defultpagepic.jpg";
	}
// فراخوانی فایل کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

		// برای گرفتن داده های ارسال شده
	if ($_REQUEST[submitbtt]){
			//کوئری اضافه کردن به جدول 
			$que_add = "INSERT INTO `gcms_pages` ( `page_author` ,`page_date` ,`page_title` ,`page_content` ,`page_excerpt` ,`page_status` ,`comment_status` ,`page_parent`, `page_type` ,`menu_order`, `page_pic`, `form_id` ) VALUES ('$_SESSION[initiated]' ,'$_REQUEST[page_date]' ,'$_REQUEST[page_title]' ,'$_REQUEST[page_content]' ,'$page_excerpt' ,'$_REQUEST[page_status]', '$_REQUEST[comment_status]', '$_REQUEST[page_parent]' ,'page' ,'$_REQUEST[menu_order]' ,'$src' ,'0' )";
			//انجام کوئری
			
				if ( mysql_query($que_add,$link) ){
				$errmes = "
				صفحه جدید با موفقیت اضافه شد.
				";
				}else{
				// در صورت برخورد با مشکل
				$errmes = " مشکل در ارسال اطلاعات لطفا دوباره تلاش کنید. ";
				}

	}
	// فرستادن پیام خطا با لیست کردن کاربران
listpage($errmes);
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

// تعریف کوئری برای لیست 
	$query1 = "SELECT * FROM `gcms_pages` WHERE page_parent='0' AND page_type = 'page'  ";
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
<div id='bhdshb' >
<form enctype='multipart/form-data'  action='?part=pages&action=edit&edit=true' method='post' >
<input type='text' id='input' name='page_title' class='reqd' size='45' value='$row[page_title]' />
<br><br>
&nbsp;
<textarea id='textarea' name='page_content' style='width:508px;height:440px;'  >
$row[page_content]
</textarea>
<div id='dwbckdsh'></div>
</div>
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

$_REQUEST[page_content] = stripslashes( $_REQUEST[page_content] );

	$page_excerpt = substr(strip_tags($_REQUEST[page_content]), 0, 250); 
	$page_excerpt = substr($page_excerpt,0,strrpos($page_excerpt," "));


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

// تابع تغییر وضعیت صفحه

function  statusp($errmes){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	if ($_REQUEST[statuspage] == "publish" ){
	$statuspage = "pending"; }else{
	$statuspage = "publish"; }
	
	if ($_REQUEST[id]){
	//  کوئری
	$query_status = "UPDATE gcms_pages SET page_status='$statuspage'  WHERE `id` ='$_REQUEST[id]'";
	
		if (mysql_query($query_status,$link)){
		$errmes = "وضعیت انتشار صفحه مورد نظر با موفقیت به روز شد";
		}else{
			  $errmes = "مشکل در به روزآوری وضعیت صفحه .. لطفا دوباره تلاش کنید.";
			  }
	}
listpage($errmes);
}

function  deletepage($errmes){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
if ($_REQUEST[id]){
	$query_del = "DELETE FROM `gcms_pages` WHERE `gcms_pages`.`id` = $_REQUEST[id] LIMIT 1";
	
		if (mysql_query($query_del,$link)){
		$errmes = "صفحه ای با شماره سطر $_REQUEST[id] با موفقیت حذف شد";
		}else{
			  $errmes = "مشکل در به حذف صفحه .. لطفا دوباره تلاش کنید.";
			  }

}

listpage($errmes);
}









?>