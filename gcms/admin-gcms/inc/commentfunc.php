<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?php
// تابه لیست  برای صفحه اصلی  
function  listcomment($errmes){
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
	// تعریف کوئری برای پیدا کردن  
	$query_all = "SELECT COUNT(*) FROM `gcms_comment` ";
	$query_confirm = "SELECT COUNT(*) FROM `gcms_comment` WHERE comment_approved='confirm' ";
	$query_rejcet = "SELECT COUNT(*) FROM `gcms_comment` WHERE comment_approved='rejcet'";
	// نتایج کوئری
	$result_all = mysql_query($query_all,$link);
	$result_confirm = mysql_query($query_confirm,$link);
	$result_rejcet = mysql_query($query_rejcet,$link);
	// دریافت نتایج در سطر	
	$row_all = mysql_fetch_array($result_all);
	$row_confirm = mysql_fetch_array($result_confirm);
	$row_rejcet = mysql_fetch_array($result_rejcet);
	

echo "<div id='mytb' >
<h2>
نمایش  نظرات
</h2>
<div id='uptable' >
<a href='?part=comment' >همه نظرات  ( $row_all[0] )</a> | <a href='?part=comment&status=confirm' >نظرات منتشر شده ( $row_confirm[0] )</a> | <a href='?part=comment&status=rejcet' >نظرات  درحال بررسی ( $row_rejcet[0] ) </a>
</div>
<table cellpadding='0' cellspacing='0' >
<thead>
<tr>
<th scope='col' width=100px >نویسنده</th><th scope='col' width=180px>نظر</th><th scope='col' width=70px>صفحه</th><th scope='col' width=50px>وضعیت</th><th scope='col' width=50px>حذف</th>
</tr>
</thead>
<tfoot>
<tr>
<th scope='col' width=100px >نویسنده</th><th scope='col' width=180px>نظر</th><th scope='col' width=70px>صفحه</th><th scope='col' width=50px>وضعیت</th><th scope='col' width=50px>حذف</th>
</tr>
</tfoot>
";

// تعریف کوئری برای لیست 
	if ($_REQUEST[status] == "confirm" OR $_REQUEST[status] == "rejcet"){
		$query = " FROM `gcms_comment` WHERE  comment_approved='$_REQUEST[status]' ORDER BY `gcms_comment`.`comment_id` DESC ";
	}else{
		  if ( $_REQUEST[status] == "commentpage" ){
		$query = " FROM `gcms_comment` WHERE page_id ='$_REQUEST[id]'  ORDER BY `gcms_comment`.`comment_id` DESC ";
		  }else{
		$query = " FROM `gcms_comment`  ORDER BY `gcms_comment`.`comment_id` DESC ";
		$_REQUEST[status] = "all";
	}
	}
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
	$total_comment = ceil($total_results / $max_results); 
	$pagelink = "?part=comment&status=$_REQUEST[status]";
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
		
	
	// تعریف کوئری برای پیدا کردن  
	$query2 = "SELECT page_title,id,page_excerpt FROM `gcms_pages` where id='$row[page_id]'   ";
	// نتایج کوئری
	$result2 = mysql_query($query2,$link);
	// دریافت نتایج در سطر	
	$row2 = mysql_fetch_array($result2);

		//
		$row2[0] = substr(strip_tags($row2[0]), 0, 30); 
		$row2[0] = substr($row2[0],0,strrpos($row2[0]," "));

	$pageid = "<a href='?part=comment&status=commentpage&id=$row[page_id]' title='$row2[page_excerpt]' ><small> $row2[0] </small></a> ";

		//
	$row[comment_content] = substr(strip_tags($row[comment_content]), 0, 50); 
	$row[comment_content] = substr($row[comment_content],0,strrpos($row[comment_content]," "));

		
		
// نمایش جدول لیست 
echo "
<tr class='$clsoe'>
<td ><center><a href='$row[comment_author_url]' target='_blank' >$row[comment_author]</a></center><center>$row[comment_author_email]</center><center>$row[comment_author_ip]</center></td><td><a href = '?part=comment&action=edit&id=$row[comment_id]&editor=small' ><small>$row[comment_content]...<small></a></td><td>$pageid</td><td><a href='?part=comment&action=status&id=$row[comment_id]&approvedcomment=$row[comment_approved]' ><img src='/gcms/admin-gcms/images/$row[comment_approved].png'  height=30px width=30px title='$row[comment_approved]' border=0 ></a></td><td><a href='?part=comment&action=delete&id=$row[comment_id]' title='حذف' onclick=\"return confirm('آیا می خواهید نظر $row[comment_author] را حذف کنید؟');\"  ><img src='/gcms/admin-gcms/images/delete.png'  height=25px width=25px title='حذف' border='0' ></a></td>
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
for($i = 1; $i <= $total_comment; $i++){ 
    if(($page) == $i){echo "<div id='ppagnolink' >$i</div>";} else { 
            echo "<a href='$pagelink&page=$i'><div id='ppag' title='صفحه $i' >$i</div></a>"; 
    } 
}
	//صفحه بعدی
if($page < $total_comment){ 
    $next = ($page + 1); 
    echo "<a href='$pagelink&page=$next'><div id='ppag' title='صفحه بعدی' >&raquo;</div></a>"; 
} 
			////////////////////////////////////////////////////////////////////////////////////

// تعریف کوئری
	$query_cpi = "SELECT * FROM `gcms_setting`  WHERE `setting_name` ='comment_publish_immd' ";
	$query_ce = "SELECT * FROM `gcms_setting`  WHERE `setting_name` ='comment_email' ";
// نتایج کوئری
	$result_cpi = mysql_query($query_cpi,$link);
	$result_ce = mysql_query($query_ce,$link);
// دریافت نتایج در سطر	
	$row_cpi = mysql_fetch_array($result_cpi);
	$row_ce = mysql_fetch_array($result_ce);

echo "
</div>

</div>
<div id='leftsidb' >
<div id='leftsidup' >
<div id='leftsiduptxt' >
تنظیمات نظرات
</div>
</div>
<div id='leftsidmid' >
<div id='leftsidmidtxt'>
<form method='post' action='?part=comment&action=setting' >
آیا نظرات قبل از بررسی انتشار یابند؟<br />
<input type='radio' name='comment_publish_immd' value='yes' ";
if ( $row_cpi[setting_value] == "yes" ){
echo " checked ";
}else{
$nochecked = " checked ";}
echo" />
بله    &nbsp;&nbsp;&nbsp;&nbsp; 
<input type='radio' name='comment_publish_immd' value='no' $nochecked />
خیر
<br />

تمام نظرات بعد از ثبت به آدرس ایمیل زیر می رسند . 
<input type='text' id='input' name='comment_email' value='$row_ce[setting_value]'  /><br />
( در صورتی که آدرس ایمیل خالی باشد نظرات به ایمیل ارسال نمی شود ) 
<br />

<input type='submit' name='submitbtt'  id='submitinput' value='اعمال تغییرات'  />
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

//تابع ویرایش  

function  editcomment($errmes){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

// تعریف کوئری
	$query = "SELECT * FROM `gcms_comment` WHERE comment_id='$_REQUEST[id]' ";
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


// تعریف کوئری برای لیست کاربران
	$query1 = "SELECT page_title FROM `gcms_pages` WHERE id='$row[page_id]' ";
// نتایج کوئری
	$result1 = mysql_query($query1,$link);
// دریافت نتایج در سطر	
	$row1 = mysql_fetch_array($result1);
	
	//
	$showregisterd = jdate(" j  M  y ",$row[comment_date]);
	
echo "<div id='mytb' >
<h2>
ویرایش نظر مرتبط با صفحه ی $row1[page_title]
</h2>
<div id='bhdshb' >
<form   action='?part=comment&action=edit&edit=true' method='post' >
<br>
&nbsp;
<textarea id='textarea' name='comment_content' style='width:508px;height:300px;'  >
$row[comment_content]
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
<b>نام </b>
<input type='text' size='15' name='comment_author' id='input' value='$row[comment_author]'  />
<br />
<b>ایمیل </b>&nbsp;&nbsp;&nbsp;&nbsp; <small><a href='' >ارسال ایمیل </a></small><br>
<input type='text' size='20' name='comment_author_email' id='input' value='$row[comment_author_email]'  />
<br />
<b>آدرس وب </b><br>
<input type='text' size='20' name='comment_author_url' id='input' value='$row[comment_author_url]'  />
<br />
<b>آی پی : </b>$row[comment_author_ip] <br />
<small><a href='http://www.geoiptool.com/?IP=$row[comment_author_ip]' target='_blank' >شناسایی آی پی</a></small><br>

<b>وضعیت نظر</b>
<br />
 <input type='radio' name='comment_approved'  value='confirm' ";
if ($row[comment_approved] == "confirm"){
echo " checked='checked' ";
}
 echo " /> نمایش نظر
 <br />
 <input type='radio' name='comment_approved'  value='rejcet'  ";
if ($row[comment_approved] == "rejcet"){
echo " checked='checked' ";
}
 echo "  /> در دست بررسی
<br />
<br />
<b>تاریخ ایجاد : $showregisterd</b>
$day
<br />
<center><input type='submit' id='submitinput' name='submitbtt' value='ویرایش نظر'  /></center>
<input type='hidden' name='id'  value='$row[comment_id]'  />
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


//تابع نهایی ویرایش 

function  finaleditcomment($errmes){



// تعریف کوئری
	$query = "UPDATE gcms_comment SET
`comment_author` = '$_REQUEST[comment_author]',
`comment_author_email` = '$_REQUEST[comment_author_email]',
`comment_author_url` = '$_REQUEST[comment_author_url]',
`comment_approved` = '$_REQUEST[comment_approved]',
`comment_content` = '$_REQUEST[comment_content]'
 WHERE `comment_id` ='$_REQUEST[id]'";
// در صورت ارسال اطلاعات
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	
		//در صورتی که تغییرات درست انجام بگیرد
		if (mysql_query($query,$link))
		{	
			$errmes = "تغییرات در نظر   ، $_REQUEST[comment_author] ،با موفقیت انجام شد";
		}
		// مشکل در تغییرات کاربر
		else{
		$errmes = "مشکل در انجام تغییرات لطفا دوباره سعی کنید. ";
		}

listcomment($errmes);
}

// تابع تغییر وضعیت 

function  statusc($errmes){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	if ($_REQUEST[approvedcomment] == "confirm" ){
	$approvedcomment = "rejcet"; }else{
	$approvedcomment = "confirm"; }
	
	if ($_REQUEST[id]){
	//  کوئری
	$query_status = "UPDATE gcms_comment SET comment_approved='$approvedcomment'  WHERE `comment_id` ='$_REQUEST[id]'";
	
		if (mysql_query($query_status,$link)){
		$errmes = "وضعیت انتشار نظر  مورد نظر با موفقیت به روز شد";
		}else{
			  $errmes = "مشکل در به روزآوری وضعیت نظر .. لطفا دوباره تلاش کنید.";
			  }
	}
listcomment($errmes);
}
// تابع حذف
function  deletecomment($errmes){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
if ($_REQUEST[id]){
	$query_del = "DELETE FROM `gcms_comment` WHERE `gcms_comment`.`comment_id` = $_REQUEST[id] LIMIT 1";
	
		if (mysql_query($query_del,$link)){
		$errmes = "نظر  با شماره سطر $_REQUEST[id] با موفقیت حذف شد";
		}else{
			  $errmes = "مشکل در به حذف نظر .. لطفا دوباره تلاش کنید.";
			  }

}

listcomment($errmes);
}
//تابع تغییر تنظیمات
function  settingcomment($errmes){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	if ($_REQUEST[submitbtt]){
	//  کوئری
	$query1 = "UPDATE gcms_setting SET setting_value='$_REQUEST[comment_publish_immd]'  WHERE `setting_name` ='comment_publish_immd' ";
	//  کوئری
	$query2 = "UPDATE gcms_setting SET setting_value='$_REQUEST[comment_email]'  WHERE `setting_name` ='comment_email' ";
		if (mysql_query($query1,$link) AND mysql_query($query2,$link)){
		$errmes = "تنظیمات نظرات  با موفقیت به روز شد";
		}else{
			  $errmes = "مشکل در به روزآوری تنظیمات نظرات .. لطفا دوباره تلاش کنید.";
			  }
	}
listcomment($errmes);
}








?>