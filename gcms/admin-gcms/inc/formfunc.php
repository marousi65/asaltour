<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?php
// تابه لیست یوزر برای صفحه اصلی و لیست کردن کاربران
function  listform($errmes){
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
فرم ها
</h2>
<table cellpadding='0' cellspacing='0' >
<thead>
<tr>
<th scope='col' width=100px >نام فرم</th><th scope='col' width=200px>صفحه مرتبط</th><th scope='col' width=50px>حذف</th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col' width=100px >نام فرم</th><th scope='col' width=200px>صفحه مرتبط</th><th scope='col' width=50px>حذف</th>
</tr>
</tfoot>
";


// تعریف کوئری برای لیست 

		$query = " FROM `gcms_form`  ";
		
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
	$pagelink = "?part=form";
	//////////////////////////////////////////////////////////////////////////////////////
// درست کردن لیست
$query = "SELECT * ".$query." LIMIT $from, $max_results";
	
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
		while($row = mysql_fetch_array($result)){
		
		$query2 = "SELECT id,page_title FROM gcms_pages WHERE form_id = '$row[form_id]' ";
		$row2 = mysql_fetch_array(mysql_query($query2,$link));
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
<a href='?part=form&action=edit&id=$row[form_id]' >$row[form_name]</a>
</td>
<td>
$row2[1]
</td>
<td>
<a href='?part=form&action=delete&id=$row[form_id]&pageid=$row2[0]' title='حذف' onclick=\"return confirm('آیا می خواهید فرم  $row[form_name] را حذف کنید؟');\"  ><img src='/gcms/admin-gcms/images/delete.png'  height=25px width=25px title='حذف' border='0' ></a>
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
افزودن فرم جدید
</div>
</div>
<div id='leftsidmid' >
<div id='leftsidmidtxt'>

<form  method='post'  action='?part=form&action=add&add=true' >

نام فرم  <br>

<input type='text' id='input'  name='form_name'  /><br />

کد HTML <br>

	<textarea name='form_html' cols='17' rows='4' id='input' width='40'></textarea>

<input type='submit' id='submitinput'  name='submitbtt'  value='افزودن فرم'  />
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

function  finaladdform($errmes){


// فراخوانی فایل کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
		// برای گرفتن داده های ارسال شده
	if ($_REQUEST[submitbtt]){
			//کوئری اضافه کردن به جدول یوزر
			$que_add = "INSERT INTO `gcms_form` ( `form_name` ,`form_html` ) VALUES ('$_REQUEST[form_name]' ,'$_REQUEST[form_html]' )";
			//انجام کوئری
			
				if ( mysql_query($que_add,$link) ){
				$errmes = $errmes."
				فرم  جدید با موفقیت اضافه شد. لطفا برای مرتبط کردن فرم مربوطه به صفحه به قسمت ویرایش فرم بروید
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
listform($errmes);
}

//تابع ویرایش  

function  editform($errmes){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

// تعریف کوئری
	$query = "SELECT * FROM `gcms_form` WHERE form_id='$_REQUEST[id]' ";
// نتایج کوئری
	$result = mysql_query($query,$link);
// دریافت نتایج در سطر	
	$row = mysql_fetch_array($result);


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


// تعریف کوئری برای لیست 
	$query1 = "SELECT id,page_title,form_id FROM `gcms_pages` WHERE page_type='page' ";
// نتایج کوئری
	$result1 = mysql_query($query1,$link);
// دریافت نتایج در سطر	
$f_child = "<b>صفحه مرتبط </b>
<br />
<select  name='page_form' id='input' >
<option value='0'>بدون صفحه</option>

";
		while($row1 = mysql_fetch_array($result1)){

$f_child = $f_child ."
<option value='$row1[id]' ";
if ($row1[form_id] == $_REQUEST[id]){
$id_page_form = $row1[id];
$f_child = $f_child . " selected ";
}
$f_child = $f_child . ">$row1[page_title]</option>

";
}
$f_child = $f_child ."</select>";

echo "<div id='mytb' >
<h2>
ویرایش فرم $row[form_name]
</h2>
<form  action='?part=form&action=edit&edit=true' method='post' >
<input type='text' id='input' name='form_name'  size='45' value='$row[form_name]' />
<br><br>

<br>
<textarea id='textarea' name='form_html' style='width:450px;height:300px;'  ></textarea>
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

<center><input type='submit' id='submitinput' name='submitbtt' value='ویرایش فرم'   /></center>
<input type='hidden' name='id'  value='$row[form_id]'  />
<input type='hidden' name='id_page_form'  value='$id_page_form'  />
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

function  finaleditform($errmes){

if ($_REQUEST[form_html]){
$reqformhtml = " ,`form_html` = '$_REQUEST[form_html]' ";
}

// تعریف کوئری
	$query = "UPDATE `gcms_form` SET `form_name` = '$_REQUEST[form_name]' ". $reqformhtml ." WHERE `gcms_form`.`form_id` =$_REQUEST[id]";
// در صورت ارسال اطلاعات
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	if ( $_REQUEST[id_page_form] != $_REQUEST[page_form] )
	{
			$query1 = "UPDATE `gcms_pages` SET `form_id` = '0' WHERE `gcms_pages`.`id` =$_REQUEST[id_page_form]";
			$query2 = "UPDATE `gcms_pages` SET `form_id` = '$_REQUEST[id]' WHERE `gcms_pages`.`id` =$_REQUEST[page_form]";
		if (mysql_query($query2,$link) AND mysql_query($query1,$link))
		{	
			$errmes = "تغییرات صفحه با موفقیت انجام شد  ";
		}
			
	
	}
	
		//در صورتی که تغییرات درست انجام بگیرد
		if (mysql_query($query,$link))
		{	
			$errmes = $errmes."تغییرات در  ، $_REQUEST[form_name] ،با موفقیت انجام شد";
		}
		// مشکل در تغییرات کاربر
		else{
		$errmes = "مشکل در انجام تغییرات لطفا دوباره سعی کنید.";
		}

listform($errmes);
}

// تابع حذف
function  deleteform($errmes){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
if ($_REQUEST[id]){
	$query_del = "DELETE FROM `gcms_form` WHERE `gcms_form`.`form_id` = $_REQUEST[id] LIMIT 1";

	$query_up = "UPDATE `gcms_pages` SET `form_id` = '0' WHERE `gcms_pages`.`id` =$_REQUEST[pageid]";
	

		if (mysql_query($query_del,$link) AND mysql_query($query_up,$link)){
		$errmes = "فرمی با شماره سطر $_REQUEST[id] با موفقیت حذف شد ";
		}else{
			  $errmes = "مشکل در به حذف فرم  .. لطفا دوباره تلاش کنید.";
			  }

}

listform($errmes);
}









?>