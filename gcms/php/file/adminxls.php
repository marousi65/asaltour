<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body style=" font-family:tahoma; direction:rtl" >
<?php // تست
error_reporting(E_ALL ^ E_NOTICE);
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/adminfunc.php';

switch ($_GET['list']){

	case "shipman":
	$res_1 = mysql_query(" select * FROM `gcms_login` WHERE type='shipman' ",$link);
	$i = 0;
	$admin_content =
	"
	<table id='hor-minimalist-a' >
	<thead>
	<tr>
		<td>
		<center>
		<b>نام و نام خانوادگی</b>
		</center>
		</td>
		<td>
		<center>
		<b>ایمیل</b>
		</center>
		</td>
		<td>
		<center>
		<b>موبایل</b>
		</center>
		</td>
		<td>
		<center>
		<b>کشتیرانی</b>
		</center>
		</td>
		<td>
		<center>
		<b>وضعیت</b>
		</center>
		</td>
	</tr>
	</thead>
	<tbody>
	";
	while ($row_1 = mysql_fetch_array($res_1)){
	if ($row_1[active] == "true"){
	$ac_li = "فعال";
	}else{
	$ac_li = "غیر فعال";
	}
	$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$row_1[id]'  ",$link));
	$arrsailiglist = explode(",", $sailiglist[value] );
	$taksailiglist = "";
	for ($i = 0; $i <= count($arrsailiglist); $i++) {
		if ($arrsailiglist[$i]){
		$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
		$taksailiglist =  $taksailiglist . $r_taksailiglist[0] . "<br>";
		}
	}
	$admin_content = $admin_content . "
	<tr>
		<td>
		<center>
		$row_1[fname] $row_1[lname]
		</center>
		</td>
		<td>
		<center>
		$row_1[email]
		</center>
		</td>
		<td>
		<center>
		$row_1[cell]
		</center>
		</td>
		<td>
		<center>
		$taksailiglist
		</center>
		</td>
		<td>
		<center>
		$ac_li
		</center>
		</td>
	</tr>
	
	";
	$i++;
	}
	$admin_content = $admin_content .
	"
	</tbody>
	</table>
	";
	echo $admin_content;
	$filename ="report".$_GET['list'].".xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	break;
	
	case "agency":
	
	//
	$res_1 = mysql_query(" select * FROM `gcms_login` WHERE type='agency' ",$link);
	$i = 0;
	$admin_content =
	"
	<table id='hor-minimalist-a' >
	<thead>
	<tr>
		<td>
		<center>
		<b>نام آژانس</b>
		</center>
		</td>
		<td>
		<center>
		<b>نام و نام خانوادگی</b>
		</center>
		</td>
		<td>
		<center>
		<b>ایمیل</b>
		</center>
		</td>
		<td>
		<center>
		<b>موبایل</b>
		</center>
		</td>
		<td>
		<center>
		<b>اعتبار</b>
		</center>
		</td>
		<td>
		<center>
		<b>مصرف</b>
		</center>
		</td>
		<td>
		<center>
		<b>وضعیت</b>
		</center>
		</td>
	</tr>
	</thead>
	<tbody>
	";
	while ($row_1 = mysql_fetch_array($res_1)){
	if ($row_1[active] == "true"){
	$ac_li = "فعال";
	}else{
	$ac_li = "غیر فعال";
	}
	$rslt_agency = mysql_query(" SELECT * FROM `gcms_metalogin` WHERE `login_id` = '$row_1[id]'  ",$link);

	while ( $row_agency_list =  mysql_fetch_array($rslt_agency) ){
		switch ($row_agency_list[key]){
	
			case "agency_name":
			$agency_name = "$row_agency_list[value]";
			break;
	
			case "agency_credit":
			$agency_credit = "$row_agency_list[value]";
			break;
	
			case "agency_use":
			$agency_use = "$row_agency_list[value]";
			break;
	
		}
	}

	$admin_content = $admin_content . "
	<tr>
		<td>
		<center>
		$agency_name
		</center>
		</td>
		<td>
		<center>
		$row_1[fname] $row_1[lname]
		</center>
		</td>
		<td>
		<center>
		$row_1[email]
		</center>
		</td>
		<td>
		<center>
		$row_1[cell]
		</center>
		</td>
		<td>
		<center>
		$agency_credit
		</center>
		</td>
		<td>
		<center>
		$agency_use
		</center>
		</td>
		<td>
		<center>
		$ac_li
		</center>
		</td>
	</tr>
	
	";
	$i++;
	}
	$admin_content = $admin_content .
	"
	</tbody>
	</table>

	";
	//
	echo $admin_content;
	$filename ="report".$_GET['list'].".xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	break;
	
	case "free":
	
	//
	$res_1 = mysql_query(" select * FROM `gcms_login` WHERE type='free' ",$link);
	$i = 0;
	$admin_content =
	"
	<table id='hor-minimalist-a' >
	<thead>
	<tr>
		<td>
		<center>
		<b>نام و نام خانوادگی</b>
		</center>
		</td>
		<td>
		<center>
		<b>ایمیل</b>
		</center>
		</td>
		<td>
		<center>
		<b>موبایل</b>
		</center>
		</td>
		<td>
		<center>
		<b>وضعیت</b>
		</center>
		</td>
	</tr>
	</thead>
	<tbody>
	";
	while ($row_1 = mysql_fetch_array($res_1)){
	if ($row_1[active] == "true"){
	$ac_li = "فعال";
	}else{
	$ac_li = "غیر فعال";
	}

	$admin_content = $admin_content . "
	<tr>
		<td>
		<center>
		$row_1[fname] $row_1[lname]
		</center>
		</td>
		<td>
		<center>
		$row_1[email]
		</center>
		</td>
		<td>
		<center>
		$row_1[cell]
		</center>
		</td>
		<td>
		<center>
		$ac_li
		</center>
		</td>
	</tr>
	
	";
	$i++;
	}
	$admin_content = $admin_content .
	"
	</tbody>
	</table>

	";
	//
	echo $admin_content;
	$filename ="report".$_GET['list'].".xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	break;
	

	default:
	//
}


?>


</body>