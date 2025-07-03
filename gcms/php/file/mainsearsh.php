<?php
	//تست
	$res_des = mysql_query("SELECT *  FROM `gcms_des` ",$link);
	$i = 0;
	$slct_des = "<option value='ch'>انتخاب کنید ...</option>";
	while ($row_des = mysql_fetch_array($res_des)){
	$slct_des = $slct_des ."<option value='$row_des[id]'>$row_des[name]</option>";
	$i++;
	}
	$gcms->assign('slct_des',$slct_des); 
	
	//
	$res_sailing = mysql_query("SELECT *  FROM `gcms_sailing` ",$link);
	$i = 0;
	$slct_sailing = "<option value='all'>تمام کشتیرانیها</option>";
	while ($row_des = mysql_fetch_array($res_sailing)){
	$slct_sailing = $slct_sailing ."<option value='$row_des[id]'>$row_des[name]</option>";
	$i++;
	}
	$gcms->assign('slct_sailing',$slct_sailing); 
	//
	$sel_sal = array(1 => 'فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند');
	if (!$_SESSION['g_s_m']){
	switch (jdate("m")){

		case "&#1776;&#1777;":
		$s_m = 1;
		break;
		
		case "&#1776;&#1778;":
		$s_m = 2;
		break;
		
		case "&#1776;&#1779;":
		$s_m = 3;
		break;
		
		case "&#1776;&#1780;":
		$s_m = 4;
		break;
		
		case "&#1776;&#1781;":
		$s_m = 5;
		break;
		
		case "&#1776;&#1782;":
		$s_m = 6;
		break;
		
		case "&#1776;&#1783;":
		$s_m = 7;
		break;
		
		case "&#1776;&#1784;":
		$s_m = 8;
		break;
		
		case "&#1776;&#1785;":
		$s_m = 9;
		break;
		
		case "&#1777;&#1776;":
		$s_m = 10;
		break;
		
		case "&#1777;&#1777;":
		$s_m = 11;
		break;
		
		case "&#1777;&#1778;":
		$s_m = 12;
		break;
		
	}
	$_SESSION['g_s_m'] = $s_m;
	}else{
	$s_m = $_SESSION['g_s_m'] ;
	}
	
	for ($i = $s_m ; $i <= 6; $i++) {
    $s_trx = $s_trx . "<option value='$i'>&#1777;&#1779;&#1785;&#1780; - $sel_sal[$i]</option>" ;
	}

	for ($i = 1 ; $i <= $s_m-1; $i++) {
    $s_trx = $s_trx . "<option value='$i'>&#1777;&#1779;&#1785;&#1780; - $sel_sal[$i]</option>" ;
	}
	//////////////////////////////////////////////////////////////////
	///////////////// بین کامنت ها در آخر سال گذاشته می شود و بعد از خرداد کامنت می شود
	$s_trx = "
	<option value='1'".(jdate('n') == 1 ? " selected":"").">".jdate('Y')." - فروردین</option>
	<option value='2'".(jdate('n') == 2 ? " selected":"").">".jdate('Y')." - اردیبهشت</option>
	<option value='3'".(jdate('n') == 3 ? " selected":"").">".jdate('Y')." - خرداد</option>
	<option value='4'".(jdate('n') == 4 ? " selected":"").">".jdate('Y')." - تیر</option>
	<option value='5'".(jdate('n') == 5 ? " selected":"").">".jdate('Y')." - مرداد</option>
	<option value='6'".(jdate('n') == 6 ? " selected":"").">".jdate('Y')." - شهریور</option>
	<option value='7'".(jdate('n') == 7 ? " selected":"").">".jdate('Y')." - مهر</option>
	<option value='8'".(jdate('n') == 8 ? " selected":"").">".jdate('Y')." - آبان</option>
	<option value='9'".(jdate('n') == 9 ? " selected":"").">".jdate('Y')." - آذر</option>
	<option value='10'".(jdate('n') == 10 ? " selected":"").">".jdate('Y')." - دی</option>
	<option value='11'".(jdate('n') == 11 ? " selected":"").">".jdate('Y')." - بهمن</option>
	<option value='12'".(jdate('n') == 12 ? " selected":"").">".jdate('Y')." - اسفند</option>
	
	";
///////////////////////////////////////////////////////////////////////
	$gcms->assign('s_trx',$s_trx); 

?>	

