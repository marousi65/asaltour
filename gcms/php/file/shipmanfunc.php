<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';


//
function f_shipman_edit_profile(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
	
	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST[profile] == "chng"){
		$up_sql = "
		UPDATE `gcms_login` SET
		`fname` =  '$_REQUEST[fname]',
		`lname` = '$_REQUEST[lname]' ,
		`address` = '$_REQUEST[address]' ,
		`tell` = '$_REQUEST[tell]' ,	
		`cell` = '$_REQUEST[cell]' 
		WHERE `gcms_login`.`id` =$_SESSION[g_id_login] LIMIT 1 
		";
		if ( mysql_query($up_sql,$link) ){
		$_SESSION['g_name_login'] = $_REQUEST[fname] . " " . $_REQUEST[lname];
		$success_message = "تغییرات با موفقیت انجام شد <br>
		نام :  $_REQUEST[fname] <br>
		نام خانوادگی : $_REQUEST[lname] <br>
		آدرس : $_REQUEST[address] <br>
		تلفن : $_REQUEST[tell] 	<br>
		موبایل : $_REQUEST[cell] <br>
		<center>
		<img src='/gcms/images/load.gif' width='120' height='160' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=shipman&shipman=edit&edit=profile'\",5000);</script>
		";
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
	}
	$shipman_content = "$form_shipman_edit_profile";
	
}


//
function f_shipman_edit_pass(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
	
	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST['passw'] == "chng" and $_REQUEST['pass'] and $_REQUEST['repass']){
		if ($_REQUEST['pass'] == $_REQUEST['repass']){
			$newpass = crypt($_REQUEST[pass]);
			$up_sql = "
			UPDATE `gcms_login` SET
			`pass` = '$newpass' 
			WHERE `gcms_login`.`id` =$_SESSION[g_id_login] LIMIT 1 
			";
			if ( mysql_query($up_sql,$link) ){
			$success_message = "اطلاعات زیر با موفقیت اضافه شد <br>
			کلمه عبور جدید : $_REQUEST[pass]
			<center>
			<img src='/gcms/images/load.gif' width='120' height='160' >
			</center>
			<script language=\"JavaScript\">setTimeout(\"?part=shipman&shipman=edit&edit=pass'\",5000);</script>
			 ";
			}else{
			$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
			}
		}else{
			$error_message = "کلمات عبور هماهنگ نبود لطفا دوباره تلاش کنید. ";
		}
	}
	$shipman_content = "$form_shipman_edit_pass";
	
}

//
function f_admin_new_psngrtrade(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';

	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST['psngrtrade'] == "true" and $_REQUEST['capacity'] and $_REQUEST['fee'] and $_REQUEST['charter_fee'] and $_REQUEST['ship_name'] and $_REQUEST['mess1']){
		
		$t_date = "$_REQUEST[sal]-$_REQUEST[mah]-$_REQUEST[roz]";
		$t_hour = "$_REQUEST[hour]:$_REQUEST[min]";
		if ($_REQUEST[type] == "active"){
		$typeshow = "درحال فروش بلیط";
		}else{
		$typeshow = "غیرفعال";
		}
		$add_sql = "
		INSERT INTO `gcms_psngrtrade` (
		`id_mabd`,
		`id_magh`,
		`id_sailing`,
		`id_login`,
		`date`,
		`hour`,
		`capacity`,
		`free_capacity`,
		`time`,
		`speed`,
		`fee`,
		`charter_fee`,
		`ship_name`,
		`ship_info`,
		`type`,
		`mess1`,
		`mess2`,
		`mess3`,
        `darsad_cancel`
		)
		VALUES (
		'$_REQUEST[mabd]',
		'$_REQUEST[magh]',
		'$_REQUEST[sailing]',
		'$_SESSION[g_id_login]',
		'$t_date',
		'$t_hour',
		'$_REQUEST[capacity]',
		'$_REQUEST[capacity]',
		'$_REQUEST[time]',
		'$_REQUEST[speed]',
		'$_REQUEST[fee]',
		'$_REQUEST[charter_fee]',
		'$_REQUEST[ship_name]',
		'$_REQUEST[ship_info]',
		'$_REQUEST[type]',
		'$_REQUEST[mess1]',
		'$_REQUEST[mess2]',
		'$_REQUEST[mess3]',
        '$_REQUEST[darsad_cancel]'
		)
		";


		if ( mysql_query($add_sql,$link) ){

		$success_message = "اطلاعات زیر با موفقیت اضافه شد <br>
		تاریخ حرکت : $t_date<br>
		ساعت حرکت : $t_hour<br>
		ظرفیت مسافر : $_REQUEST[capacity]<br>
		تعداد جای خالی : $_REQUEST[capacity]<br>
		مدت زمان سفر : $_REQUEST[time]<br>
		سرعت حرکت کشتی : $_REQUEST[speed]<br>
		قیمت بلیط : $_REQUEST[fee]<br>
		قیمت چارتر : $_REQUEST[charter_fee]<br>
		نام کشتی : $_REQUEST[ship_name]<br>
		اطلاعات کشتی : $_REQUEST[ship_info]<br>
		وضعیت سفر : $typeshow<br>
		پیغام 1 : $_REQUEST[mess1]<br>
		پیغام 2 : $_REQUEST[mess2]<br>
		پیغام 3 : $_REQUEST[mess3]<br>
		<center>
		<img src='/gcms/images/load.gif' width='120' height='160' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=shipman&shipman=list&list=psngrtrade'\",20000);</script>
		 ";
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
		
		}

	$shipman_content = "$form_shipman_new_psngrtrade";
	
}

//
function f_admin_list_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST[chngact] and $_REQUEST[id]){
		if ($_REQUEST[chngact] == "active" or $_REQUEST[chngact] == "pending" ){
		mysql_query(" UPDATE `gcms_psngrtrade` SET `type` =  'close' WHERE `id` =$_REQUEST[id] LIMIT 1 ",$link);
		}else{
		mysql_query(" UPDATE `gcms_psngrtrade` SET `type` =  'active' WHERE `id` =$_REQUEST[id] LIMIT 1 ",$link);
		}
	$success_message = "تغییرات با موفقیت انجام شد";
	}

	$q_page_l = "
	FROM `gcms_psngrtrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	WHERE `id_login` = '$_SESSION[g_id_login]' 
	ORDER BY `gcms_psngrtrade`.`id` DESC	
	";

	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = "15"; 
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num $q_page_l "),0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=shipman&shipman=list&list=psngrtrade";
	//////////////////////////////////////////////////////////////////////////////////////

			////////////////////////////////////////////////////////////////////////////////////
			//صفحه قبلی
			if($page > 1){ 
				$prev = ($page - 1); 
				$sendpage =  $sendpage."<a href='$pagelink&page=$prev'><div id='page' title='صفحه قبلی' >&laquo;</div></a>"; 
			} 
			//صفحه حاضر
			for($ipage = 1; $ipage <= $total_pages; $ipage++){ 
				if(($page) == $ipage){$sendpage =  $sendpage. "<div id='pagenolink' >$ipage</div>";} else { 
						$sendpage =  $sendpage. "<a href='$pagelink&page=$ipage'><div id='page' title='صفحه $ipage' >$ipage</div></a>"; 
				} 
			}
				//صفحه بعدی
			if($page < $total_pages){ 
				$next = ($page + 1); 
				$sendpage =  $sendpage. "<a href='$pagelink&page=$next'><div id='page' title='صفحه بعدی' >&raquo;</div></a>"; 
			} 
			////////////////////////////////////////////////////////////////////////////////////


//کوئری
	$q_page_l = "SELECT * ".$q_page_l." LIMIT $from, $max_results";
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
		<b>عملیات</b>
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
		<a href='?part=shipman&shipman=edit&edit=psngrtrade&id=$row_1[0]' >ویرایش</a><br>
	";
	}else{
		if ($row_1[type] == "close") {
		$edsh = "
			<a href='?part=shipman&shipman=list&list=psngrtrade&chngact=$row_1[type]&id=$row_1[0]' >فروش آزاد</a><br>
		";
		}else{
		$edsh = "
			<a href='?part=shipman&shipman=list&list=psngrtrade&chngact=$row_1[type]&id=$row_1[0]' >توقف فروش</a><br>
		";
		}
	}
	
	$shipman_content = $shipman_content . "
	<tr>
		<td>
		<center>
		$row_1[23]
		</center>
		</td>
		<td>
		<center>
		$row_1[25]
		</center>
		</td>
		<td>
		<center>
		$row_1[21]
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
		$edsh
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
	<a href='?part=shipman&shipman=list&list=psngrtrade&excel=true' target='_blank' >خروجی اکسل</a>
	<div class='clear'></div>
	<div >$sendpage</div>
	<div class='clear'></div>
	";
	
}

//
function f_shipman_edit_psngrtrade(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
	
	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST[psngrtrade] == "chng"){
		$up_sql = "
		UPDATE `gcms_psngrtrade` SET 
		`id_mabd` = '$_REQUEST[mabd]', 
		`id_magh` = '$_REQUEST[magh]', 
		`id_sailing` = '$_REQUEST[sailing]', 
		`date` = '$_REQUEST[sal]-$_REQUEST[mah]-$_REQUEST[roz]', 
		`hour` = '$_REQUEST[hour]:$_REQUEST[min]', 
		`capacity` = '$_REQUEST[capacity]', 
		`free_capacity` = '$_REQUEST[capacity]', 
		`time` = '$_REQUEST[time]', 
		`speed` = '$_REQUEST[speed]', 
		`fee` = '$_REQUEST[fee]', 
		`charter_fee` = '$_REQUEST[charter_fee]', 
		`ship_name` = '$_REQUEST[ship_name]', 
		`ship_info` = '$_REQUEST[ship_info]', 
		`type` = '$_REQUEST[type]', 
		`mess1` = '$_REQUEST[mess1]', 
		`mess2` = '$_REQUEST[mess2]', 
		`mess3` = '$_REQUEST[mess3]' ,
		`darsad_cancel` = '$_REQUEST[darsad_cancel]' 
		WHERE `gcms_psngrtrade`.`id` = $_GET[id] LIMIT 1; 
		";
		if ( mysql_query($up_sql,$link) ){
		$_SESSION['g_name_login'] = $_REQUEST[fname] . " " . $_REQUEST[lname];
		$success_message = "تغییرات با موفقیت انجام شد <br>
		<center>
		<img src='/gcms/images/load.gif' width='120' height='160' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=shipman&shipman=edit&edit=psngrtrade&id=$_GET[id]'\",5000);</script>
		";
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
	}
	$shipman_content = "$form_shipman_edit_psngrtrade";
	
}

//
function f_admin_new_cartrade(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';

	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST['cartrade'] == "true" and $_REQUEST['capacity'] and $_REQUEST['charter_fee'] and $_REQUEST['ship_name'] and $_REQUEST['mess1']){
	
		$carcard = $_REQUEST[carcard];
		
		for ($i = 0; $i <= count($carcard); $i++) {
			if ($carcard[$i]){
			$list_carcard =  $list_carcard . $carcard[$i] . ",";
			}
		}

		
		$t_date = "$_REQUEST[sal]-$_REQUEST[mah]-$_REQUEST[roz]";
		$t_hour = "$_REQUEST[hour]:$_REQUEST[min]";
		if ($_REQUEST[type] == "active"){
		$typeshow = "درحال فروش بلیط";
		}else{
		$typeshow = "غیرفعال";
		}
		$add_sql = "
		INSERT INTO `gcms_cartrade` (
		`id_mabd`,
		`id_magh`,
		`id_sailing`,
		`id_login`,
		`date`,
		`hour`,
		`capacity`,
		`free_capacity`,
		`time`,
		`speed`,
		`charter_fee`,
		`ship_name`,
		`ship_info`,
		`type`,
		`mess1`,
		`mess2`,
		`mess3`,
		`carcart`,
        `darsad_cancel` 
		)
		VALUES (
		'$_REQUEST[mabd]',
		'$_REQUEST[magh]',
		'$_REQUEST[sailing]',
		'$_SESSION[g_id_login]',
		'$t_date',
		'$t_hour',
		'$_REQUEST[capacity]',
		'$_REQUEST[capacity]',
		'$_REQUEST[time]',
		'$_REQUEST[speed]',
		'$_REQUEST[charter_fee]',
		'$_REQUEST[ship_name]',
		'$_REQUEST[ship_info]',
		'$_REQUEST[type]',
		'$_REQUEST[mess1]',
		'$_REQUEST[mess2]',
		'$_REQUEST[mess3]',
		'$list_carcard',
        '$_REQUEST[darsad_cancel]'
		)
		";
		
		if ( mysql_query($add_sql,$link) ){

		$success_message = "اطلاعات زیر با موفقیت اضافه شد <br>
		تاریخ حرکت : $t_date<br>
		ساعت حرکت : $t_hour<br>
		ظرفیت حمل خودرو : $_REQUEST[capacity]<br>
		تعداد جای خالی : $_REQUEST[capacity]<br>
		مدت زمان سفر : $_REQUEST[time]<br>
		سرعت حرکت کشتی : $_REQUEST[speed]<br>
		قیمت چارتر : $_REQUEST[charter_fee]<br>
		نام کشتی : $_REQUEST[ship_name]<br>
		اطلاعات کشتی : $_REQUEST[ship_info]<br>
		وضعیت سفر : $typeshow<br>
		پیغام 1 : $_REQUEST[mess1]<br>
		پیغام 2 : $_REQUEST[mess2]<br>
		پیغام 3 : $_REQUEST[mess3]<br>
		<center>
		<img src='/gcms/images/load.gif' width='120' height='160' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=shipman&shipman=list&list=cartrade'\",20000);</script>
		 ";
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
		
		}

	$shipman_content = "$form_shipman_new_cartrade";
	
}

//
function f_admin_new_car(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';

	global $error_message,$success_message,$shipman_content;

	if ($_REQUEST['car'] == "true" and $_REQUEST['name'] and $_REQUEST['fee']  and $_REQUEST['fee_cap']){

		$add_sql = "
		INSERT INTO `gcms_car` (
		`id_login`,
		`name`,
		`unit`,
		`fee`,
		`cargo_fee`,
		`max_cap`,
		`fee_cap`,
		`type`
		)
		VALUES (
		'$_SESSION[g_id_login]',
		'$_REQUEST[name]',
		'$_REQUEST[unit]',
		'$_REQUEST[fee]',
		'$_REQUEST[cargo_fee]',
		'$_REQUEST[max_cap]',
		'$_REQUEST[fee_cap]',
		'active'
		)
		";
		
		if ( mysql_query($add_sql,$link) ){

		$success_message = "اطلاعات با موفقیت اضافه شد<br>

		<center>
		<img src='/gcms/images/load.gif' width='120' height='160' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=shipman&shipman=list&list=car'\",20000);</script>
		 ";
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
		
		}

	$shipman_content = "$form_shipman_new_car";
	
}


//
function f_admin_list_car(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST[chngact] and $_REQUEST[id]){
		if ($_REQUEST[chngact] == "active"  ){
		mysql_query(" UPDATE `gcms_car` SET `type` =  'pending' WHERE `id` =$_REQUEST[id] LIMIT 1 ",$link);
		}else{
		mysql_query(" UPDATE `gcms_car` SET `type` =  'active' WHERE `id` =$_REQUEST[id] LIMIT 1 ",$link);
		}
	$success_message = "تغییرات با موفقیت انجام شد";
	}


//کوئری
	$q_page_l = "SELECT * FROM `gcms_car` WHERE `id_login` = '$_SESSION[g_id_login]' ";
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
		<td>
		<center>
		<b>وضعیت</b>
		</center>
		</td>
		<td>
		<center>
		<b>عملیات</b>
		</center>
		</td>
	</tr>
	</thead>
	<tbody>
	";
	while ($row_1 = mysql_fetch_array($res_1)){
	
	if ($row_1[type] == "active" ){
	$edsh = "
		<a href='?part=shipman&shipman=list&list=car&id=$row_1[0]&chngact=$row_1[type]' >غیرفعال</a><br>
	";
	$ttyp = "فعال";
	}else{
	$edsh = "
		<a href='?part=shipman&shipman=list&list=car&id=$row_1[0]&chngact=$row_1[type]' >فعال</a><br>
	";
	$ttyp = "غیرفعال";
	}
	
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
		<td>
		<center>
		$ttyp
		</center>
		</td>
		<td>
		<center>
		$edsh
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
	<a href='?part=shipman&shipman=list&list=car&excel=true&id=$_SESSION[g_id_login]' target='_blank' >خروجی اکسل</a>
	<div class='clear'></div>
	<div >$sendpage</div>
	<div class='clear'></div>
	";
	
}


//
function f_admin_list_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST[chngact] and $_REQUEST[id]){
		if ($_REQUEST[chngact] == "active" or $_REQUEST[chngact] == "pending" ){
		mysql_query(" UPDATE `gcms_psngrtrade` SET `type` =  'close' WHERE `id` =$_REQUEST[id] LIMIT 1 ",$link);
		}else{
		mysql_query(" UPDATE `gcms_psngrtrade` SET `type` =  'active' WHERE `id` =$_REQUEST[id] LIMIT 1 ",$link);
		}
	$success_message = "تغییرات با موفقیت انجام شد";
	}

	$q_page_l = "
	FROM `gcms_cartrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
	WHERE `id_login` = '$_SESSION[g_id_login]' 
	ORDER BY `gcms_cartrade`.`id` DESC	
	";

	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = "15"; 
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num $q_page_l "),0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=shipman&shipman=list&list=cartrade";
	//////////////////////////////////////////////////////////////////////////////////////

			////////////////////////////////////////////////////////////////////////////////////
			//صفحه قبلی
			if($page > 1){ 
				$prev = ($page - 1); 
				$sendpage =  $sendpage."<a href='$pagelink&page=$prev'><div id='page' title='صفحه قبلی' >&laquo;</div></a>"; 
			} 
			//صفحه حاضر
			for($ipage = 1; $ipage <= $total_pages; $ipage++){ 
				if(($page) == $ipage){$sendpage =  $sendpage. "<div id='pagenolink' >$ipage</div>";} else { 
						$sendpage =  $sendpage. "<a href='$pagelink&page=$ipage'><div id='page' title='صفحه $ipage' >$ipage</div></a>"; 
				} 
			}
				//صفحه بعدی
			if($page < $total_pages){ 
				$next = ($page + 1); 
				$sendpage =  $sendpage. "<a href='$pagelink&page=$next'><div id='page' title='صفحه بعدی' >&raquo;</div></a>"; 
			} 
			////////////////////////////////////////////////////////////////////////////////////


//کوئری
	$q_page_l = "SELECT * ".$q_page_l." LIMIT $from, $max_results";
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
		<b>عملیات</b>
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
		$row_1[23]
		</center>
		</td>
		<td>
		<center>
		$row_1[25]
		</center>
		</td>
		<td>
		<center>
		$row_1[21]
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
		$edsh
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
	<a href='?part=shipman&shipman=list&list=cartrade&excel=true&id=$_SESSION[g_id_login]' target='_blank' >خروجی اکسل</a>
	<div class='clear'></div>
	<div >$sendpage</div>
	<div class='clear'></div>
	";
	
}

//
function f_shipman_edit_cartrade(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
	
	global $error_message,$success_message,$shipman_content;
	
	if ($_REQUEST[cartrade] == "chng"){

		$carcard = $_REQUEST[carcard];
		
		for ($i = 0; $i <= count($carcard); $i++) {
			if ($carcard[$i]){
			$list_carcard =  $list_carcard . $carcard[$i] . ",";
			}
		}
	
		$up_sql = "
		UPDATE `gcms_cartrade` SET 
		`id_mabd` = '$_REQUEST[mabd]', 
		`id_magh` = '$_REQUEST[magh]', 
		`id_sailing` = '$_REQUEST[sailing]', 
		`date` = '$_REQUEST[sal]-$_REQUEST[mah]-$_REQUEST[roz]', 
		`hour` = '$_REQUEST[hour]:$_REQUEST[min]', 
		`capacity` = '$_REQUEST[capacity]', 
		`free_capacity` = '$_REQUEST[capacity]', 
		`time` = '$_REQUEST[time]', 
		`speed` = '$_REQUEST[speed]', 
		`charter_fee` = '$_REQUEST[charter_fee]', 
		`ship_name` = '$_REQUEST[ship_name]', 
		`ship_info` = '$_REQUEST[ship_info]', 
		`type` = '$_REQUEST[type]', 
		`mess1` = '$_REQUEST[mess1]', 
		`mess2` = '$_REQUEST[mess2]', 
		`mess3` = '$_REQUEST[mess3]' ,
		`carcart` = '$list_carcard' ,
        `darsad_cancel` = '$_REQUEST[darsad_cancel]' 
		WHERE `gcms_cartrade`.`id` = $_GET[id] LIMIT 1; 
		";
		if ( mysql_query($up_sql,$link) ){

		$success_message = "تغییرات با موفقیت انجام شد <br>
		<center>
		<img src='/gcms/images/load.gif' width='120' height='160' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=shipman&shipman=edit&edit=cartrade&id=$_GET[id]'\",5000);</script>
		";
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
	}
	$shipman_content = "$form_shipman_edit_cartrade";
	
}

//
function f_admin_repzlist(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	global $error_message,$success_message,$admin_content;
for ($i = 1; $i <= 31; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	$dy_roz = $dy_roz. "
	<option >$rpir$i</option>
	";
}
for ($i = 1; $i <= 12; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	$dy_mah = $dy_mah. "
	<option >$rpir$i</option>
	";
}
for ($i = 1386; $i <= jdate('Y'); $i++) {
    $dy_sal = $dy_sal. "
	<option>$i</option>
	";
}

	//
	$sai_name = mysql_query("SELECT *  FROM `gcms_sailing` ",$link);
	$i = 0;
	while ($row_sai_name = mysql_fetch_array($sai_name)){
	$sel_sai_name = $sel_sai_name ."<option value='$row_sai_name[id]'>$row_sai_name[name]</option>";
	$i++;
	}
	
	
	$admin_content = "

	<form target='_blank' action='/gcms/report.php?report=zlist' method='post' >
		<img src='/gcms/images/blank.gif' width='38' height='1'> 
		<select name='shiptype' >
			<option value='psngrtrade' >کشتی مسافربری</option>
			<option value='cartrade' >کشتی لندیگرافت</option>
		</select>
		<img src='/gcms/images/blank.gif' width='70' height='1'> 
		<select name='sail_name' >
			<option value='0' >همه کشتیرانیها</option>
			$sel_sai_name
		</select>
		<div class='clear'></div>
		از تاریخ : 
		
		<select name='az_roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='az_mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='az_sal' id='selectroz' >
			$dy_sal
		</select>
		
		<img src='/gcms/images/blank.gif' width='30' height='1'> تا تاریخ : 
		
		<select name='ta_roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='ta_mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='ta_sal' id='selectroz' >
			$dy_sal
		</select>
		<div class='clear'></div>
		<img src='/gcms/images/blank.gif' width='370' height='1'> 
		<input type='submit' value='گزارش'  >
	</form>

	";
	
}


//
function f_admin_repnlist(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	global $error_message,$success_message,$admin_content;
for ($i = 1; $i <= 31; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	if ($_REQUEST[roz] == "$i" ){$sel_roz = " selected='selected' "; }else{$sel_roz = " "; }
	$dy_roz = $dy_roz. "
	<option $sel_roz >$rpir$i</option>
	";
}
for ($i = 1; $i <= 12; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	if ($_REQUEST[mah] == "$i" ){$sel_mah = " selected='selected' "; }else{$sel_mah = " "; }
	$dy_mah = $dy_mah. "
	<option $sel_mah >$rpir$i</option>
	";
}
for ($i = 1386; $i <= jdate('Y'); $i++) {
	if ($_REQUEST[sal] == "$i" ){$sel_sal = " selected='selected' "; }else{$sel_sal = " "; }
    $dy_sal = $dy_sal. "
	<option $sel_sal>$i</option>
	";
}

	//
$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_SESSION[g_id_login]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$sel_sai_name = "";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
$sel_sai_name =  $sel_sai_name ."<option value='$arrsailiglist[$i]' >$r_taksailiglist[0]</option>";
}
}


	//

	//
	$mabd = mysql_query("SELECT *  FROM `gcms_des` ",$link);
	while ($row_mabd = mysql_fetch_array($mabd)){
	if ($_REQUEST[mabd] == "$row_mabd[id]" ){$sel_mabd = " selected='selected' "; }else{$sel_mabd = " "; }
	if ($_REQUEST[magh] == "$row_mabd[id]" ){$sel_magh = " selected='selected' "; }else{$sel_magh = " "; }
	$sel_row_mabd = $sel_row_mabd ."<option value='$row_mabd[id]' $sel_mabd >$row_mabd[name]</option>";
	$sel_row_magh = $sel_row_magh ."<option value='$row_mabd[id]' $sel_magh >$row_mabd[name]</option>";
	}
	
	switch($_REQUEST['min']){
	case "15" :
	 $sel_15 = " selected='selected' ";
	break;
	
	case "30" :
	 $sel_30 = " selected='selected' ";
	break;
	
	case "45" :
	 $sel_45 = " selected='selected' ";
	break;
	
	}

for ($i = 1; $i <= 24; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	if ($_REQUEST[hour] == "$i" ){$sel_hour = " selected='selected' "; }else{$sel_hour = " "; }
	$hour = $hour. "
	<option $sel_hour >$rpir$i</option>
	";
}

	if ($_REQUEST[shiptype] == "psngrtrade" ){$sel_psngrtrade = " selected='selected' "; }else{$sel_cartrade = " selected='selected' "; }

	$admin_content = "

	<form  action='?part=shipman&shipman=report&report=nlist&nlist=true' method='post' name='report' >
		<img src='/gcms/images/blank.gif' width='38' height='1'> 
		<select name='shiptype' >
			<option value='psngrtrade' $sel_psngrtrade >کشتی مسافربری</option>
			<option value='cartrade' $sel_cartrade >کشتی لندیگرافت</option>
		</select>
		<img src='/gcms/images/blank.gif' width='70' height='1'> 
		<select name='sail_name' >
			<option value='0' >انتخاب کشتی رانی ... </option>
			$sel_sai_name
		</select>
		<div class='clear'></div>
		&nbsp;&nbsp; تاریخ : 
		
		<select name='roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='sal' id='selectroz' >
			$dy_sal
		</select>
		
		<img src='/gcms/images/blank.gif' width='30' height='1'> ساعت : 
		
		<select name='min' id='selectroz' >
			<option >00</option>
			<option $sel_15 >15</option>
			<option $sel_30 >30</option>
			<option $sel_45 >45</option>
		</select>
		 : 
		<select name='hour' id='selectroz' >
			$hour
		</select>
		<div class='clear'></div>
		
		<img src='/gcms/images/blank.gif' width='38' height='1'> 
		<select name='mabd' >
			<option value='0' >انتخاب مبدا ...</option>
			$sel_row_mabd
		</select>
		<img src='/gcms/images/blank.gif' width='70' height='1'> 
		<select name='magh' >
			<option value='0' >انتخاب مقصد ...</option>
			$sel_row_magh
		</select>
		<div class='clear'></div>

		<label><input type='radio' name='ttyp' value='1' checked='checked' class='DEPENDS ON shiptype BEING psngrtrade'  /> لیست اسامی مسافرین </label>
		<div class='clear'></div>
		<label><input type='radio' name='ttyp' value='2' class='DEPENDS ON shiptype BEING psngrtrade'  /> لیست مشخصات مسافرین </label>
		<div class='clear'></div>
		<label><input type='radio' name='ttyp' value='3'  class='DEPENDS ON shiptype BEING cartrade' /> لیست مشخصات ضروری خودرو </label>
		<div class='clear'></div>
		<label><input type='radio' name='ttyp' value='4' class='DEPENDS ON shiptype BEING cartrade' /> لیست خودرو</label>
		<div class='clear'></div>
		<img src='/gcms/images/blank.gif' width='370' height='1'> 
		<input type='submit' value='گزارش'  >
	</form>

	";
	if ($_REQUEST[nlist]){
	
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id , ship_name
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE 
	`date` = '$_REQUEST[sal]-$_REQUEST[mah]-$_REQUEST[roz]' 
	AND 
	`hour` = '$_REQUEST[hour]:$_REQUEST[min]' 	 
	AND 
	`id_mabd` = '$_REQUEST[mabd]' 
	AND 
	`id_magh` = '$_REQUEST[magh]' 
	AND 
	`id_sailing` = '$_REQUEST[sail_name]' 
	 ";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; 
			$ntj = "
			بدون نتیجه
			";
		}else{$result = true ;
			while ($rep_row = mysql_fetch_array($rep_res)){
			$ntj = $ntj . "
			<a href='/gcms/report.php?report=nlist&shiptype=$_REQUEST[shiptype]&$_REQUEST[shiptype]=$rep_row[0]&list=$_REQUEST[ttyp]'  target='_blank' >$rep_row[1]</a> <br>
			";
			}
		}	
	$admin_content = $admin_content."
	نام کشتی های مسیر فوق : <br>
	$ntj
	";
	}
	
}


//
function f_admin_repcncl(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	global $error_message,$success_message,$admin_content;
for ($i = 1; $i <= 31; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	$dy_roz = $dy_roz. "
	<option >$rpir$i</option>
	";
}
for ($i = 1; $i <= 12; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	$dy_mah = $dy_mah. "
	<option >$rpir$i</option>
	";
}
for ($i = 1386; $i <= jdate('Y'); $i++) {
    $dy_sal = $dy_sal. "
	<option>$i</option>
	";
}

	
	
	$admin_content = "

	<form target='_blank' action='/gcms/report.php?report=cncl' method='post' >
	<select name='shiptype' >
			<option value='psngrtrade' $sel_psngrtrade >کشتی مسافربری</option>
			<option value='cartrade' $sel_cartrade >کشتی لندیگرافت</option>
		</select>
		از تاریخ : 
		
		<select name='az_roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='az_mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='az_sal' id='selectroz' >
			$dy_sal
		</select>
		
		<img src='/gcms/images/blank.gif' width='30' height='1'> تا تاریخ : 
		
		<select name='ta_roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='ta_mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='ta_sal' id='selectroz' >
			$dy_sal
		</select>
		<div class='clear'></div>
		<img src='/gcms/images/blank.gif' width='370' height='1'> 
		<input type='submit' value='گزارش'  >
	</form>

	";
	
}

//
function f_admin_repmcncl(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	global $error_message,$success_message,$admin_content;
for ($i = 1; $i <= 31; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	if ($_REQUEST[roz] == "$i" ){$sel_roz = " selected='selected' "; }else{$sel_roz = " "; }
	$dy_roz = $dy_roz. "
	<option $sel_roz >$rpir$i</option>
	";
}
for ($i = 1; $i <= 12; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	if ($_REQUEST[mah] == "$i" ){$sel_mah = " selected='selected' "; }else{$sel_mah = " "; }
	$dy_mah = $dy_mah. "
	<option $sel_mah >$rpir$i</option>
	";
}
for ($i = 1386; $i <= jdate('Y'); $i++) {
	if ($_REQUEST[sal] == "$i" ){$sel_sal = " selected='selected' "; }else{$sel_sal = " "; }
    $dy_sal = $dy_sal. "
	<option $sel_sal>$i</option>
	";
}

	//
	//
$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_SESSION[g_id_login]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$sel_sai_name = "";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
$sel_sai_name =  $sel_sai_name ."<option value='$arrsailiglist[$i]' >$r_taksailiglist[0]</option>";
}
}

	//
	$mabd = mysql_query("SELECT *  FROM `gcms_des` ",$link);
	while ($row_mabd = mysql_fetch_array($mabd)){
	if ($_REQUEST[mabd] == "$row_mabd[id]" ){$sel_mabd = " selected='selected' "; }else{$sel_mabd = " "; }
	if ($_REQUEST[magh] == "$row_mabd[id]" ){$sel_magh = " selected='selected' "; }else{$sel_magh = " "; }
	$sel_row_mabd = $sel_row_mabd ."<option value='$row_mabd[id]' $sel_mabd >$row_mabd[name]</option>";
	$sel_row_magh = $sel_row_magh ."<option value='$row_mabd[id]' $sel_magh >$row_mabd[name]</option>";
	}
	
	switch($_REQUEST['min']){
	case "15" :
	 $sel_15 = " selected='selected' ";
	break;
	
	case "30" :
	 $sel_30 = " selected='selected' ";
	break;
	
	case "45" :
	 $sel_45 = " selected='selected' ";
	break;
	
	}

for ($i = 1; $i <= 24; $i++) {
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
	if ($_REQUEST[hour] == "$i" ){$sel_hour = " selected='selected' "; }else{$sel_hour = " "; }
	$hour = $hour. "
	<option $sel_hour >$rpir$i</option>
	";
}

	if ($_REQUEST[shiptype] == "psngrtrade" ){$sel_psngrtrade = " selected='selected' "; }else{$sel_cartrade = " selected='selected' "; }

	$admin_content = "

	<form  action='?part=admin&admin=report&report=mcncl&mcncl=true' method='post' name='report' >
		<img src='/gcms/images/blank.gif' width='38' height='1'> 
		<select name='shiptype' >
			<option value='psngrtrade'  >کشتی مسافربری</option>
			<option value='cartrade' >کشتی لندیگرافت</option>
		</select>
		<img src='/gcms/images/blank.gif' width='70' height='1'> 
		<select name='sail_name' >
			<option value='0' >انتخاب کشتی رانی ... </option>
			$sel_sai_name
		</select>
		<div class='clear'></div>
		&nbsp;&nbsp; تاریخ : 
		
		<select name='roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='sal' id='selectroz' >
			$dy_sal
		</select>
		
		<img src='/gcms/images/blank.gif' width='30' height='1'> ساعت : 
		
		<select name='min' id='selectroz' >
			<option >00</option>
			<option $sel_15 >15</option>
			<option $sel_30 >30</option>
			<option $sel_45 >45</option>
		</select>
		 : 
		<select name='hour' id='selectroz' >
			$hour
		</select>
		<div class='clear'></div>
		
		<img src='/gcms/images/blank.gif' width='38' height='1'> 
		<select name='mabd' >
			<option value='0' >انتخاب مبدا ...</option>
			$sel_row_mabd
		</select>
		<img src='/gcms/images/blank.gif' width='70' height='1'> 
		<select name='magh' >
			<option value='0' >انتخاب مقصد ...</option>
			$sel_row_magh
		</select>
		<div class='clear'></div>
		<div class='clear'></div>
		<img src='/gcms/images/blank.gif' width='370' height='1'> 
		<input type='submit' value='گزارش'  >
	</form>

	";
	if ($_REQUEST[mcncl]){
	
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id , ship_name
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE 
	`date` = '$_REQUEST[sal]-$_REQUEST[mah]-$_REQUEST[roz]' 
	AND 
	`hour` = '$_REQUEST[hour]:$_REQUEST[min]' 	 
	AND 
	`id_mabd` = '$_REQUEST[mabd]' 
	AND 
	`id_magh` = '$_REQUEST[magh]' 
	AND 
	`id_sailing` = '$_REQUEST[sail_name]' 
	 ";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; 
			$ntj = "
			بدون نتیجه
			";
		}else{$result = true ;
			while ($rep_row = mysql_fetch_array($rep_res)){
			$ntj = $ntj . "
			<a href='/gcms/report.php?report=mcncl&shiptype=$_REQUEST[shiptype]&$_REQUEST[shiptype]=$rep_row[0]'  target='_blank' >$rep_row[1]</a> <br>
			";
			}
		}	
	$admin_content = $admin_content."
	نام کشتی های مسیر فوق : <br>
	$ntj
	";
	}
	
}




?>
