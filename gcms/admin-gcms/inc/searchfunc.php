<?php
function search_result($search,$text){
		$text = strip_tags($text);
		$temp = explode($search,$text,2);
		$templen = strlen($temp[0]);
		if ($templen > 150) {$templen = $templen - 50;}
		$temp[0] = substr($temp[0],$templen);
		////
		$temp[0] = substr($temp[0],strpos($temp[0]," "));
		////
		$temp[0] = " ... " . $temp[0];
		$temp[1] = substr($temp[1],0,250);
		////
		$temp[1] = substr($temp[1],0,strrpos($temp[1]," "));
		////
		$temp[1] = $temp[1] . " ... ";
		$final = $temp[0] . "<span style='color:red;background-color:yellow' class='search_result'>" . $search . "</span>" . $temp[1];
	return $final;	
	
	}
//تابع 

function  search(){
// فراخوانی کانفیگ
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

$redsearch = $_REQUEST['txt'];
$search = ereg_replace(" ","%",$_REQUEST['txt']);

if ( $_REQUEST[option] == 'page_title' ) {
$sqlstr = " page_title LIKE  '%$search%' ";
}
if ( $_REQUEST[option] == 'page_content' ) {
$sqlstr = " page_content LIKE  '%$search%' ";
}

	
// تعریف کوئری   
	$querysp = "SELECT * FROM `gcms_pages` WHERE page_type = 'page' AND $sqlstr ";
// نتایج کوئری
	$resultsp = mysql_query($querysp,$link);
// دریافت نتایج در سطر	

			while($rowsp = mysql_fetch_array($resultsp)){
			
			$set = search_result($redsearch,$rset);
			if ( $_REQUEST[option] == 'page_title' ) {
			$rowsp[page_title] =search_result($redsearch,$rowsp[page_title]);
			}
			if ( $_REQUEST[option] == 'page_content' ) {
			$rowsp[page_content] =search_result($redsearch,$rowsp[page_content]);
			}else{
			$rowsp[page_content] = substr(strip_tags($rowsp[page_content]), 0, 250); 
			$rowsp[page_content] = substr($rowsp[page_content],0,strrpos($rowsp[page_content]," "));
			}

			$i++;
			$result = $result ."$i -  <b>$rowsp[page_title] </b>&nbsp;&nbsp;&nbsp;  <small><a href='?part=pages&action=edit&id=$rowsp[id]&editor=full' >ویرایش صفحه </a> </small> &nbsp;&nbsp;&nbsp; <small><a href='/gcms/?part=page&id=$rowsp[id]' >نمایش صفحه در سایت </a></small>  <br> 
			$rowsp[page_content] <br> 
			";
			}
			
			if (!$result){
				$result = "هیچ نتیجه ای برای جستجوی <b>$redsearch</b> در میان صفحات پیدا نشد. ";
			}
	
echo "
<div id='head' >
<div id='mainbody' >
<div class='leftbody' >
<div id='mytb' >
<h2>
نتایج جستجو
</h2>
<div id='bckfile' >
$result
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
جستجو در میان صفحات <br>
	<form method='post' action='?part=search&serach=page' >
	 <input type='text' id='input' name='txt'   /> <br>
	<input type='radio' name='option' value='page_title' id='input' / >  در میان عناوین صفحه
	   <br>
	<input type='radio' name='option' id='input' value='page_content' checked='checked' / >  در میان متن صفحه
	   <br>
	<input type='submit' name='submitbtt' id='submitinput' value='جستجو'  />
	</form>


<br>
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