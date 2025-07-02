<?php

//تابع ویرایش

function  dashboardlist($errmes){
// فراخوانی کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	$query_rejcet = "SELECT * FROM `gcms_comment` WHERE comment_approved='rejcet'";
	// نتایج کوئری
	$result_rejcet = mysql_query($query_rejcet,$link);
	// دریافت نتایج در سطر	
	while ($row_rejcet = mysql_fetch_array($result_rejcet)){
	$row_rejcet[comment_content] = substr(strip_tags($row_rejcet[comment_content]), 0, 50); 
	$row_rejcet[comment_content] = substr($row_rejcet[comment_content],0,strrpos($row_rejcet[comment_content]," "));
	$i++;
	$rejcetcomm = $rejcetcomm . "$i - <a href='?part=comment&action=edit&id=$row_rejcet[0]&editor=small' > $row_rejcet[comment_content]  <small>توسط : $row_rejcet[comment_author] </small> </a><br> ";
	
	}
	
	// تعریف کوئری
		$queryset = "SELECT setting_value FROM `gcms_setting` WHERE  setting_name = 'first_page'  ";
	// نتایج کوئری
		$resultset = mysql_query($queryset,$link);
	// دریافت نتایج در سطر	
		$rowset = mysql_fetch_array($resultset);


	//$RR = gregorian_to_jalali(2009, 1, 17);
	//tamame bazdid :: page
	$query_statistics = "SELECT COUNT(*) FROM `gcms_statistics` ";
	// uniq bazdid :: visitor
	$query_distincstatistics = "SELECT COUNT(DISTINCT ip)  FROM `gcms_statistics` ";
	// firs page :: page
	$query_fpstatistics = $query_statistics . " WHERE page_id = '$rowset[0]'  ";
	// firs page :: visitor
	$query_disfpstatistics = $query_distincstatistics . " WHERE page_id = '$rowset[0]'  ";
	// pre day :: page
	$diroz = time() - (1 * 24 * 60 * 60);
	$predate = date('Y,m,d', $diroz);
	$query_prestatistics = $query_statistics . " WHERE date = '$predate'  ";
	// pre day :: visitor
	$query_disprestatistics = $query_distincstatistics . " WHERE date = '$predate' ";
	// now day :: page
	$nowdate = date('Y,m,d');
	$query_nowstatistics = $query_statistics . " WHERE date = '$nowdate'  ";
	// now day :: visitor
	$query_disnowstatistics = $query_distincstatistics . " WHERE date = '$nowdate' ";

	
	// دریافت نتایج در سطر	
	$row_statistics = mysql_fetch_array(mysql_query($query_statistics,$link));
	$row_distincstatistics = mysql_fetch_array(mysql_query($query_distincstatistics,$link));
	$row_fpstatistics = mysql_fetch_array(mysql_query($query_fpstatistics,$link));
	$row_disfpstatistics = mysql_fetch_array(mysql_query($query_disfpstatistics,$link));
	$row_prestatistics = mysql_fetch_array(mysql_query($query_prestatistics,$link));
	$row_disprestatistics = mysql_fetch_array(mysql_query($query_disprestatistics,$link));
	$row_nowstatistics = mysql_fetch_array(mysql_query($query_nowstatistics,$link));
	$row_disnowstatistics = mysql_fetch_array(mysql_query($query_disnowstatistics,$link));
	
	
	
	$statistics = $statistics . "کل بازدید صفحات : $row_statistics[0]	بار <br>
	کل بازدید کننده گان سایت : $row_distincstatistics[0]	نفر <br>
	بازدید از صفحه اول : $row_fpstatistics[0]	بار <br>
	 بازدید کننده گان از صفحه اول : $row_disfpstatistics[0]	نفر <br>
	 <b>آمار دیروز</b><br> 
	  بازدید صفحات : $row_prestatistics[0]	بار <br>
	   بازدید کننده گان  : $row_disprestatistics[0]	نفر <br>
	    <b>آمار امروز</b><br> 
		 بازدید صفحات : $row_nowstatistics[0]	بار <br>
		  بازدید کننده گان  : $row_disnowstatistics[0]	نفر <br>";	

	
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
میز کار شما
</h2>
<div id='bhdshb' style='height:100%;' >
<div id='shortcut' >
<b>دسترسی سریع به امکانات</b><br>

<a href='?part=pages&action=add&attrib=main&editor=full' ><img src='/gcms/admin-gcms/images/addmainpage.png' border=0 title='افزودن صفحه اصلی جدید' >افزودن صفحه اصلی جدید </a> <br>

<a href='?part=pages&action=add&attrib=child&editor=full' ><img src='/gcms/admin-gcms/images/addchildpage.png' border=0 title='افزودن صفحه فرعی جدید ' >افزودن صفحه فرعی جدید </a> <br><br>

<b>نظرات در دست بررسی </b> <br>
$rejcetcomm
</div>
<div id='shortcut' >
<b>آمار سایت</b><br>

$statistics
</div>
</div>
<div id='dwbckdsh'></div>
</div>
<div id='leftsidb' >
	<div id='leftsidup' >
		<div id='leftsiduptxt' >
جستجو
		</div>
	</div>
<div id='leftsidmid' >
	<div id='leftsidmidtxt'>
جستجو در میان صفحات 
	<form method='post' action='?part=search&serach=page' >
	 <input type='text' id='input' name='txt'   class='reqd' /> <br>
	<input type='radio' name='option' value='page_title'  / >  در میان عناوین صفحه
	   <br>
	<input type='radio' name='option'  value='page_content' checked='checked' / >  در میان متن صفحه
	   <br>
	<input type='submit' name='submitbtt' id='submitinput' value='جستجو' onMouseDown='initForms()'  />
	</form>";

	
	echo"

";
////////////////////////////////////////
////////////////////////////////////////


echo"<br>
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








?>