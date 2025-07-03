<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<body style=" font-family:tahoma; direction:rtl" >
<?php // تست
error_reporting(E_ALL ^ E_NOTICE);
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/adminfunc.php';

switch ($_GET['list']){

	case "psngrtrade":

//کوئری
	$q_page_l = "SELECT * FROM `gcms_psngrtrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	ORDER BY `gcms_psngrtrade`.`id` DESC	";
//نتایج
	$res_1 = mysql_query($q_page_l,$link);

	$i = 0;
	$shipman_content =
	"
	<table id='hor-minimalist-a' >
	<thead>
	<tr>
		<td>
		<center>
		<b>مبدا</b>
		</center>
		</td>
		<td>
		<center>
		<b>مقصد</b>
		</center>
		</td>
		<td>
		<center>
		<b>نام کشتیرانی</b>
		</center>
		</td>
		<td>
		<center>
		<b>تاریخ</b>
		</center>
		</td>
		<td>
		<center>
		<b>ساعت حرکت</b>
		</center>
		</td>
		<td>
		<center>
		<b>ظرفیت</b>
		</center>
		</td>
		<td>
		<center>
		<b>ظرفیت خالی</b>
		</center>
		</td>
		<td>
		<center>
		<b>وضعیت</b>
		</center>
		</td>
		<td>
		<center>
		<b>قیمت بلیط</b>
		</center>
		</td>
		<td>
		<center>
		<b>قیمت چارتر</b>
		</center>
		</td>
		<td>
		<center>
		<b>نام کشتی</b>
		</center>
		</td>
		<td>
		<center>
		<b>اطلاعات کشتی</b>
		</center>
		</td>
		<td>
		<center>
		<b>مدت زمان سفر</b>
		</center>
		</td>
		<td>
		<center>
		<b>سرعت کشتی</b>
		</center>
		</td>
		<td>
		<center>
		<b>پیغام -1 </b>
		</center>
		</td>
		<td>
		<center>
		<b>پیغام -2</b>
		</center>
		</td>
		<td>
		<center>
		<b>پیغام -3</b>
		</center>
		</td>
	</tr>
	</thead>
	<tbody>
	";
	while ($row_1 = mysql_fetch_array($res_1)){
	if ($row_1[type] == "active"){
	$ac_li = "درحال فروش بلیط";
	}else{
		if ($row_1[type] == "close"){
		$ac_li = "بسته";
		}else{
		$ac_li = "غیر فعال";
		}
	}

	$shipman_content = $shipman_content . "
	<tr>
		<td>
		<center>
		$row_1[22]
		</center>
		</td>
		<td>
		<center>
		$row_1[24]
		</center>
		</td>
		<td>
		<center>
		$row_1[20]
		</center>
		</td>
		<td>
		<center>
		$row_1[5]
		</center>
		</td>
		<td>
		<center>
		$row_1[6]
		</center>
		</td>
		<td>
		<center>
		$row_1[7]
		</center>
		</td>
		<td>
		<center>
		$row_1[8]
		</center>
		</td>
		<td>
		<center>
		$ac_li
		</center>
		</td>
		<td>
		<center>
		$row_1[11]
		</center>
		</td>
		<td>
		<center>
		$row_1[12]
		</center>
		</td>
		<td>
		<center>
		$row_1[13]
		</center>
		</td>
		<td>
		<center>
		$row_1[14]
		</center>
		</td>
		<td>
		<center>
		$row_1[9]
		</center>
		</td>
		<td>
		<center>
		$row_1[10]
		</center>
		</td>
		<td>
		<center>
		$row_1[16]
		</center>
		</td>
		<td>
		<center>
		$row_1[17]
		</center>
		</td>
		<td>
		<center>
		$row_1[18]
		</center>
		</td>
	</tr>
	
	";
	$i++;
	}
	$shipman_content = $shipman_content .
	"
	</tbody>
	</table>
	";
	
	echo $shipman_content;
	$filename ="report".$_GET['list'].".xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	break;
	
	
	case "car":

//کوئری
	$q_page_l = "SELECT * FROM `gcms_car` WHERE `id_login` = '$_REQUEST[id]' ";
//نتایج
	$res_1 = mysql_query($q_page_l,$link);

	$i = 0;
	$shipman_content =
	"
	<table id='hor-minimalist-a' >
	<thead>
	<tr>
		<td>
		<center>
		<b>نام</b>
		</center>
		</td>
		<td>
		<center>
		<b>تعداد واحد</b>
		</center>
		</td>
		<td>
		<center>
		<b>قیمت بلیط</b>
		</center>
		</td>
		<td>
		<center>
		<b>قیمت بار اضافه</b>
		</center>
		</td>
		<td>
		<center>
		<b>حداکثر تعداد همراه</b>
		</center>
		</td>
		<td>
		<center>
		<b>قیمت بلیط همراه</b>
		</center>
		</td>
	</tr>
	</thead>
	<tbody>
	";
	while ($row_1 = mysql_fetch_array($res_1)){
	
	
	$shipman_content = $shipman_content . "
	<tr>
		<td>
		<center>
		$row_1[name]
		</center>
		</td>
		<td>
		<center>
		$row_1[unit]
		</center>
		</td>
		<td>
		<center>
		$row_1[fee]
		</center>
		</td>
		<td>
		<center>
		$row_1[cargo_fee]
		</center>
		</td>
		<td>
		<center>
		$row_1[max_cap] نفر
		</center>
		</td>
		<td>
		<center>
		$row_1[fee_cap]
		</center>
		</td>
	</tr>
	
	";
	$i++;
	}
	$shipman_content = $shipman_content .
	"
	</tbody>
	</table>
	";
	
	echo $shipman_content;
	$filename ="report".$_GET['list'].".xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	break;
	
	
	
	case "cartrade":
	if ($_REQUEST[id]){
//کوئری
	$q_page_l = "SELECT * FROM `gcms_cartrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
	WHERE `id_login` = '$_REQUEST[id]' 
	ORDER BY `gcms_cartrade`.`id` DESC";
//نتایج
	$res_1 = mysql_query($q_page_l,$link);

	$i = 0;
	$shipman_content =
	"
	<table id='hor-minimalist-a' >
	<thead>
	<tr>
		<td>
		<center>
		<b>مبدا</b>
		</center>
		</td>
		<td>
		<center>
		<b>مقصد</b>
		</center>
		</td>
		<td>
		<center>
		<b>نام کشتیرانی</b>
		</center>
		</td>
		<td>
		<center>
		<b>تاریخ</b>
		</center>
		</td>
		<td>
		<center>
		<b>ساعت حرکت</b>
		</center>
		</td>
		<td>
		<center>
		<b>ظرفیت</b>
		</center>
		</td>
		<td>
		<center>
		<b>ظرفیت خالی</b>
		</center>
		</td>
		<td>
		<center>
		<b>وضعیت</b>
		</center>
		</td>
		<td>
		<center>
		<b>قیمت چارتر</b>
		</center>
		</td>
		<td>
		<center>
		<b>نام کشتی</b>
		</center>
		</td>
		<td>
		<center>
		<b>اطلاعات کشتی</b>
		</center>
		</td>
		<td>
		<center>
		<b>مدت زمان سفر</b>
		</center>
		</td>
		<td>
		<center>
		<b>سرعت کشتی</b>
		</center>
		</td>
		<td>
		<center>
		<b>پیغام -1 </b>
		</center>
		</td>
		<td>
		<center>
		<b>پیغام -2</b>
		</center>
		</td>
		<td>
		<center>
		<b>پیغام -3</b>
		</center>
		</td>
	</tr>
	</thead>
	<tbody>
	";
	while ($row_1 = mysql_fetch_array($res_1)){
	if ($row_1[type] == "active"){
	$ac_li = "درحال فروش بلیط";
	}else{
		if ($row_1[type] == "close"){
		$ac_li = "بسته شده ";
		}else{
		$ac_li = "غیر فعال";
		}
	}
	
	if ($row_1[7] == $row_1[8]){
	$edsh = "
		<a href='?part=shipman&shipman=edit&edit=cartrade&id=$row_1[0]' >ویرایش</a><br>
	";
	}else{
		if ($row_1[type] == "close") {
		$edsh = "
			<a href='?part=shipman&shipman=list&list=cartrade&chngact=$row_1[type]&id=$row_1[0]' >فروش آزاد</a><br>
		";
		}else{
		$edsh = "
			<a href='?part=shipman&shipman=list&list=cartrade&chngact=$row_1[type]&id=$row_1[0]' >توقف فروش</a><br>
		";
		}
	}
	
	$shipman_content = $shipman_content . "
	<tr>
		<td>
		<center>
		$row_1[22]
		</center>
		</td>
		<td>
		<center>
		$row_1[24]
		</center>
		</td>
		<td>
		<center>
		$row_1[20]
		</center>
		</td>
		<td>
		<center>
		$row_1[5]
		</center>
		</td>
		<td>
		<center>
		$row_1[6]
		</center>
		</td>
		<td>
		<center>
		$row_1[7]
		</center>
		</td>
		<td>
		<center>
		$row_1[8]
		</center>
		</td>
		<td>
		<center>
		$ac_li
		</center>
		</td>
		<td>
		<center>
		$row_1[11]
		</center>
		</td>
		<td>
		<center>
		$row_1[12]
		</center>
		</td>
		<td>
		<center>
		$row_1[13]
		</center>
		</td>
		<td>
		<center>
		$row_1[9]
		</center>
		</td>
		<td>
		<center>
		$row_1[10]
		</center>
		</td>
		<td>
		<center>
		$row_1[15]
		</center>
		</td>
		<td>
		<center>
		$row_1[16]
		</center>
		</td>
		<td>
		<center>
		$row_1[17]
		</center>
		</td>
	</tr>
	
	";
	$i++;
	}
	$shipman_content = $shipman_content .
	"
	</tbody>
	</table>
	";
	
	echo $shipman_content;
	$filename ="report".$_GET['list'].".xls";
	header('Content-type: application/ms-excel');
	header('Content-Disposition: attachment; filename='.$filename);
	}
	break;
	
	

	default:
	//
}


?>


</body>