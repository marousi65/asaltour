<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
if ( $_SESSION['g_t_login'] == "admin" or  $_SESSION['g_t_login'] == "shipman" or $_SESSION['g_t_login'] == "portman" or $_SESSION['g_t_login'] == "agency"  ){
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/jdf.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

////
	if ($_REQUEST['report'] == 'zlist' ){
		if ($_REQUEST[shiptype] == "psngrtrade" ){
		$txt_shiptype = "مسافربری";
		}else{
		$txt_shiptype = "لندیگرافت";
		}
	
	if ($_REQUEST[sail_name] != "0" ){ 
	$shart1 = " AND  `id_sailing` = '$_REQUEST[sail_name]'";
	$find_sil = mysql_fetch_array(mysql_query("SELECT name  FROM `gcms_sailing` WHERE `id` = '$_REQUEST[sail_name]'  ",$link));
	}else{
	$find_sil[0] = "همه کشتیرانی ها";
	}
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id,hour,date,id_mabd,id_magh,ship_name, mabd.name , magh.name , capacity , free_capacity , sailing.name
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE 
	`date` >= '$_REQUEST[az_sal]-$_REQUEST[az_mah]-$_REQUEST[az_roz]' 
	AND 
	`date` <= '$_REQUEST[ta_sal]-$_REQUEST[ta_mah]-$_REQUEST[ta_roz]' 
	$shart1 
	ORDER BY `date`,`hour` ASC 
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$title = "گزارش لیست ظرفیت - کشتی $txt_shiptype ، کشتیرانی $find_sil[0] از تاریخ $_REQUEST[az_roz]-$_REQUEST[az_mah]-$_REQUEST[az_sal] تا تاریخ $_REQUEST[ta_roz]-$_REQUEST[ta_mah]-$_REQUEST[ta_sal] ";
			while ($rep_row = mysql_fetch_array($rep_res)){

			$tbody = $tbody . "
				<tr>
				  <td align='center' >$rep_row[1]</td>
				  <td align='center' >$rep_row[2]</td>
				  <td align='center' >$rep_row[8]</td>
				  <td align='center' >$rep_row[9]</td>
				  <td align='center' >$rep_row[6] به $rep_row[7]</td>
				  <td align='center' >$rep_row[5]</td>
				  <td align='center' >$rep_row[10]</td>
				</tr>
			";
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th>ساعت حرکت</th>
			  <th>تاریخ حرکت</th>
			  <th>ظرفیت کل</th>
			  <th>ظرفیت مانده</th>
			  <th>مسیر حرکت</th>
			  <th>نام کشتی</th>
			  <th>نام کشتیرانی</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}
	
	///
	if ($_REQUEST['report'] == 'nlist' and $_REQUEST['list'] == '1'){
	$tt = $_REQUEST[shiptype];
	if ( $_SESSION['g_t_login'] == "shipman"  ){
	$add_txt_sh_1 = " AND  `gcms_$_REQUEST[shiptype]`.`id_login` = '$_SESSION[g_id_login]' ";
	}
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id , ship_name , sailing.name , mabd.name , magh.name  , date , hour  	
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE  gcms_$_REQUEST[shiptype].`id` = '$_REQUEST[$tt]' $add_txt_sh_1
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$rep_row = mysql_fetch_array($rep_res);
		$dt_rep_row = explode("-", $rep_row[5] );
		$title = " 
		گزارش لیست اسامی مسافرین کشتی $rep_row[1] کشتیرانی $rep_row[2] مسیر $rep_row[3] به $rep_row[4] تاریخ $dt_rep_row[2]-$dt_rep_row[1]-$dt_rep_row[0] ساعت حرکت $rep_row[6]
		";
	$rep_sql_2 = "
	SELECT id,fname,lname,mcode,num
	FROM `gcms_buypsngrtrade` 

	WHERE  `id_psngrtrade` = '$rep_row[0]' AND `type` = 'active' 
	";
	$rep_res_2 = mysql_query($rep_sql_2,$link);
			
			while ($rep_row_2 = mysql_fetch_array($rep_res_2)){
			++$i;
			$mcode = $rep_row_2[0]+111111;
			$tbody = $tbody . "
				<tr>
				  <td align='center' >$i</td>
				  <td align='center' >$rep_row_2[1] $rep_row_2[2]</td>
				  <td align='center' >$rep_row_2[4]</td>
				  <td align='center' >$rep_row_2[3]</td>
				  <td align='center' >$mcode</td>
				  <td align='center' ></td>
				</tr>
			";
			if ( $rep_row_2[4] != 0){
				$rep_sql_3 = "
				SELECT *
				FROM `gcms_metabuy`  
				WHERE  `id_buy` = '$rep_row_2[0]' AND `type` = 'psngrtrade' 
				";
				$rep_res_3 = mysql_query($rep_sql_3,$link);
						$j = 0 ;
						while ($rep_row_3 = mysql_fetch_array($rep_res_3)){
						++$i;
						++$j;
						$tbody = $tbody . "
							<tr>
							  <td align='center' >$i</td>
							  <td align='center' >$rep_row_3[3] $rep_row_3[4]</td>
							  <td align='center' >*</td>
							  <td align='center' >$rep_row_3[5]</td>
							  <td align='center' >$mcode/$j</td>
							  <td align='center' ></td>
							</tr>
						";
						}
				}
			
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th  align='center'  >ردیف</th>
			  <th  align='center'  >نام</th>
			  <th  align='center'  >تعداد همراه</th>
			  <th  align='center'  >شماره ملی</th>
			  <th  align='center'  >شماره بلیط</th>
			  <th  align='center'  >تایید</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}
	
	
	///
	if ($_REQUEST['report'] == 'nlist' and $_REQUEST['list'] == '2'){
	$tt = $_REQUEST[shiptype];
	if ( $_SESSION['g_t_login'] == "shipman"  ){
	$add_txt_sh_1 = " AND  `gcms_$_REQUEST[shiptype]`.`id_login` = '$_SESSION[g_id_login]' ";
	}
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id , ship_name , sailing.name , mabd.name , magh.name  , date , hour
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE  gcms_$_REQUEST[shiptype].`id` = '$_REQUEST[$tt]' $add_txt_sh_1
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$rep_row = mysql_fetch_array($rep_res);
		$dt_rep_row = explode("-", $rep_row[5] );
		$title = " 
		گزارش لیست مشخصات مسافرین کشتی $rep_row[1] کشتیرانی $rep_row[2] مسیر $rep_row[3] به $rep_row[4] تاریخ $dt_rep_row[2]-$dt_rep_row[1]-$dt_rep_row[0] ساعت حرکت $rep_row[6]
		";
	$rep_sql_2 = "
	SELECT id,fname,lname,mcode,num,cell,tell,city,address,	id_login 	
	FROM `gcms_buypsngrtrade` 
	WHERE  `id_psngrtrade` = '$rep_row[0]'  AND `type` = 'active' 
	";
	$rep_res_2 = mysql_query($rep_sql_2,$link);
			
			while ($rep_row_2 = mysql_fetch_array($rep_res_2)){
			++$i;
			$mcode = $rep_row_2[0]+111111;
			$rep_row_22 = mysql_fetch_array(mysql_query("SELECT * FROM `gcms_metalogin` WHERE `login_id` = '$rep_row_2[id_login]' ",$link));

			if ($rep_row_22[0]){
			$sedorc = "$rep_row_2[id_login]";
			}else{
			$sedorc = "0";
			}
			$tbody = $tbody . "
				<tr>
				  <td align='center' >$rep_row_2[1] $rep_row_2[2]</td>
				  <td align='center' >$rep_row_2[3]</td>
				  <td align='center' >$rep_row_2[5]</td>
				  <td align='center' >$rep_row_2[6]</td>
				  <td align='center' >$rep_row_2[7]</td>
				  <td align='center' >$rep_row_2[8]</td>
				  <td align='center' >$mcode</td>
				  <td align='center' >$sedorc</td>
				</tr>
			";
			if ( $rep_row_2[4] != 0){
				$rep_sql_3 = "
				SELECT *
				FROM `gcms_metabuy`  
				WHERE  `id_buy` = '$rep_row_2[0]' AND `type` = 'psngrtrade' 
				";
				$rep_res_3 = mysql_query($rep_sql_3,$link);
						$j = 0 ;
						while ($rep_row_3 = mysql_fetch_array($rep_res_3)){
						++$i;
						++$j;
						$tbody = $tbody . "
							<tr>
							
							  <td align='center' >$rep_row_3[3] $rep_row_3[4]</td>
							  <td align='center' >$rep_row_3[5]</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >$mcode/$j</td>
							  <td align='center' >*</td>
							</tr>
						";
						}
				}
			
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th  align='center'  >نام و نام خانوادگی</th>
			  <th  align='center'  >شماره ملی</th>
			  <th  align='center'  >موبایل</th>
			  <th  align='center'  >تلفن</th>
			  <th  align='center'  >شهرستان</th>
			  <th  align='center'  >آدرس</th>
			  <th  align='center'  >سریال بلیط</th>
			  <th  align='center'  >کد صدور</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}
	
	
	///
	if ($_REQUEST['report'] == 'nlist' and $_REQUEST['list'] == '3'){
	$tt = $_REQUEST[shiptype];
	if ( $_SESSION['g_t_login'] == "shipman"  ){
	$add_txt_sh_1 = " AND  `gcms_$_REQUEST[shiptype]`.`id_login` = '$_SESSION[g_id_login]' ";
	}
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id , ship_name , sailing.name , mabd.name , magh.name  , date , hour
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE  gcms_$_REQUEST[shiptype].`id` = '$_REQUEST[$tt]' $add_txt_sh_1
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$rep_row = mysql_fetch_array($rep_res);
		$dt_rep_row = explode("-", $rep_row[5] );
		$title = " 
		گزارش لیست مشخصات ضروری خودرو کشتی $rep_row[1] کشتیرانی $rep_row[2] مسیر $rep_row[3] به $rep_row[4] تاریخ $dt_rep_row[2]-$dt_rep_row[1]-$dt_rep_row[0] ساعت حرکت $rep_row[6]
		";
	$rep_sql_2 = "
	SELECT gcms_buycartrade.id,fname,lname,mcode,num,cell,tell,city,address, gcms_buycartrade.id_login , model , gcms_car.name , certificate , plate , bdne , motor , shasi
	FROM `gcms_buycartrade` 
	INNER JOIN `gcms_car` ON `gcms_buycartrade`.`id_car` = `gcms_car`.`id`
	WHERE  `gcms_buycartrade`.`id_cartrade` = '$rep_row[0]'  AND `gcms_buycartrade`.`type` = 'active' 
	";

	$rep_res_2 = mysql_query($rep_sql_2,$link);
			
			while ($rep_row_2 = mysql_fetch_array($rep_res_2)){
			++$i;
			$mcode = $rep_row_2[0]+111111;
			$rep_row_22 = mysql_fetch_array(mysql_query("SELECT * FROM `gcms_metalogin` WHERE `login_id` = '$rep_row_2[id_login]' ",$link));

			if ($rep_row_22[0]){
			$sedorc = "$rep_row_2[id_login]";
			}else{
			$sedorc = "0";
			}
			$tbody = $tbody . "
				<tr>
				  <td align='center' >$i</td>
				  <td align='center' >$rep_row_2[1] $rep_row_2[2]</td>
				  <td align='center' >$rep_row_2[3]</td>
				  <td align='center' >$rep_row_2[4]</td>
				  <td align='center' >$rep_row_2[11]</td>
				  <td align='center' >$rep_row_2[10]</td>
				  <td align='center' >$rep_row_2[12]</td>
				  <td align='center' >$rep_row_2[13]</td>
				  <td align='center' >$rep_row_2[14]</td>
				  <td align='center' >$rep_row_2[15]</td>
				  <td align='center' >$rep_row_2[16]</td>
				  <td align='center' >$mcode</td>
				  <td align='center' ></td>
				</tr>
			";
			if ( $rep_row_2[4] != 0){
				$rep_sql_3 = "
				SELECT *
				FROM `gcms_metabuy`  
				WHERE  `id_buy` = '$rep_row_2[0]' AND `type` = 'cartrade' 
				";
				$rep_res_3 = mysql_query($rep_sql_3,$link);
						$j = 0 ;
						while ($rep_row_3 = mysql_fetch_array($rep_res_3)){
						++$j;
						$tbody = $tbody . "
							<tr>
							  <td align='center' >$i-$j</td>
							  <td align='center' >$rep_row_3[3] $rep_row_3[4]</td>
							  <td align='center' >$rep_row_3[5]</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >$mcode/$j</td>
							  <td align='center' ></td>
							</tr>
						";
						}
				}
			
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th  align='center'  >ردیف</th>
			  <th  align='center'  >نام و نام خانوادگی</th>
			  <th  align='center'  >شماره ملی</th>
			  <th  align='center'  >تعداد همراه</th>
			  <th  align='center'  >نوع خودرو</th>
			  <th  align='center'  >مدل</th>
			  <th  align='center'  >شماره گواهینامه</th>
			  <th  align='center'  >شماره پلاک</th>
			  <th  align='center'  >شماره بدنه</th>
			  <th  align='center'  >شماره موتور</th>
			  <th  align='center'  >شماره شاسی</th>
			  <th  align='center'  >سریال بلیط</th>
			  <th  align='center'  >تایید</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}
	
	///
	if ($_REQUEST['report'] == 'nlist' and $_REQUEST['list'] == '4'){
	$tt = $_REQUEST[shiptype];
	if ( $_SESSION['g_t_login'] == "shipman"  ){
	$add_txt_sh_1 = " AND  `gcms_$_REQUEST[shiptype]`.`id_login` = '$_SESSION[g_id_login]' ";
	}
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id , ship_name , sailing.name , mabd.name , magh.name  , date , hour
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE  gcms_$_REQUEST[shiptype].`id` = '$_REQUEST[$tt]' $add_txt_sh_1
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$rep_row = mysql_fetch_array($rep_res);
		$dt_rep_row = explode("-", $rep_row[5] );
		$title = " 
		گزارش لیست  خودرو کشتی $rep_row[1] کشتیرانی $rep_row[2] مسیر $rep_row[3] به $rep_row[4] تاریخ $dt_rep_row[2]-$dt_rep_row[1]-$dt_rep_row[0] ساعت حرکت $rep_row[6]
		";
	$rep_sql_2 = "
	SELECT gcms_buycartrade.id,fname,lname,mcode,num,cell,tell,city,address, gcms_buycartrade.id_login , model , gcms_car.name , certificate , plate , bdne , motor , shasi
	FROM `gcms_buycartrade` 
	INNER JOIN `gcms_car` ON `gcms_buycartrade`.`id_car` = `gcms_car`.`id`
	WHERE  `gcms_buycartrade`.`id_cartrade` = '$rep_row[0]'  AND `gcms_buycartrade`.`type` = 'active' 
	";

	$rep_res_2 = mysql_query($rep_sql_2,$link);
			
			while ($rep_row_2 = mysql_fetch_array($rep_res_2)){
			++$i;
			$mcode = $rep_row_2[0]+111111;
			$rep_row_22 = mysql_fetch_array(mysql_query("SELECT * FROM `gcms_metalogin` WHERE `login_id` = '$rep_row_2[id_login]' ",$link));

			if ($rep_row_22[0]){
			$sedorc = "$rep_row_2[id_login]";
			}else{
			$sedorc = "0";
			}
			$tbody = $tbody . "
				<tr>
				  <td align='center' >$i</td>
				  <td align='center' >$rep_row_2[1] $rep_row_2[2]</td>
				  <td align='center' >$rep_row_2[3]</td>
				  <td  align='center'  >$rep_row_2[cell]</th>
				  <td  align='center'  >$rep_row_2[tell]</th>
				  <td  align='center'  >$rep_row_2[city]</th>
				  <td  align='center'  >$rep_row_2[address]</th>
				  <td align='center' >$rep_row_2[4]</td>
				  <td align='center' >راننده</td>
				  <td align='center' >$rep_row_2[11]</td>
				  <td align='center' >$rep_row_2[10]</td>
				  <td align='center' >$rep_row_2[12]</td>
				  <td align='center' >$rep_row_2[13]</td>
				  <td align='center' >$rep_row_2[14]</td>
				  <td align='center' >$rep_row_2[15]</td>
				  <td align='center' >$rep_row_2[16]</td>
				  <td align='center' >$sedorc</td>
				  <td align='center' >$mcode</td>
				</tr>
			";
			if ( $rep_row_2[4] != 0){
				$rep_sql_3 = "
				SELECT *
				FROM `gcms_metabuy`  
				WHERE  `id_buy` = '$rep_row_2[0]' AND `type` = 'cartrade' 
				";
				$rep_res_3 = mysql_query($rep_sql_3,$link);
						$j = 0 ;
						while ($rep_row_3 = mysql_fetch_array($rep_res_3)){
						++$j;
						$tbody = $tbody . "
							<tr>
							  <td align='center' >$i-$j</td>
							  <td align='center' >$rep_row_3[3] $rep_row_3[4]</td>
							  <td align='center' >$rep_row_3[5]</td>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td align='center' >*</td>
							  <td align='center' >همراه</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >$mcode/$j</td>
							</tr>
						";
						}
				}
			
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th  align='center'  >ردیف</th>
			  <th  align='center'  >نام و نام خانوادگی</th>
			  <th  align='center'  >شماره ملی</th>
			  <th  align='center'  >موبایل</th>
			  <th  align='center'  >تلفن</th>
			  <th  align='center'  >شهرستان</th>
			  <th  align='center'  >آدرس</th>
			  <th  align='center'  >تعداد همراه</th>
			  <th  align='center'  >سمت</th>
			  <th  align='center'  >نوع خودرو</th>
			  <th  align='center'  >مدل</th>
			  <th  align='center'  >شماره گواهینامه</th>
			  <th  align='center'  >شماره پلاک</th>
			  <th  align='center'  >شماره بدنه</th>
			  <th  align='center'  >شماره موتور</th>
			  <th  align='center'  >شماره شاسی</th>
			  <th  align='center'  >کد صدور</th>
			  <th  align='center'  >سریال بلیط</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}
	
	///
	if ($_REQUEST['report'] == 'cncl' ){
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
	$as_g_d = jalali_to_gregorian2( "13".$_REQUEST[az_sal] , $_REQUEST[az_mah] , $_REQUEST[az_roz] );
	$ta_g_d = jalali_to_gregorian2( "13".$_REQUEST[ta_sal] , $_REQUEST[ta_mah] , $_REQUEST[ta_roz] );
	$rep_sql = "
	SELECT gcms_buy$_REQUEST[shiptype].cancel_fee , gcms_buy$_REQUEST[shiptype].fee , gcms_login.fname , gcms_login.lname , mabd.name as mabd , magh.name as magh , gcms_$_REQUEST[shiptype].date , gcms_$_REQUEST[shiptype].hour , gcms_$_REQUEST[shiptype].ship_name 
	FROM `gcms_buy$_REQUEST[shiptype]` 
    INNER JOIN `gcms_login` ON `gcms_login`.`id` = `gcms_buy$_REQUEST[shiptype]`.`id_login` 
    INNER JOIN `gcms_$_REQUEST[shiptype]` ON `gcms_$_REQUEST[shiptype]`.`id` = `gcms_buy$_REQUEST[shiptype]`.`id_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`    
	WHERE
    gcms_buy$_REQUEST[shiptype].`type` ='cancel'
    AND  
	gcms_buy$_REQUEST[shiptype].`buy_time` >= '$as_g_d[0]-$as_g_d[1]-$as_g_d[2]' 
	AND 
	gcms_buy$_REQUEST[shiptype].`buy_time` <= '$ta_g_d[0]-$ta_g_d[1]-$ta_g_d[2]'  
	ORDER BY gcms_buy$_REQUEST[shiptype].`buy_time` DESC 
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$title = "لیست گزارش کنسلی از تاریخ $_REQUEST[az_roz]-$_REQUEST[az_mah]-$_REQUEST[az_sal] تا تاریخ $_REQUEST[ta_roz]-$_REQUEST[ta_mah]-$_REQUEST[ta_sal]   ";
			while ($rep_row = mysql_fetch_array($rep_res)){
			
            $tbody = $tbody . "
							<tr>
							 
                                <td align='center' >$rep_row[mabd]</td>
                                <td align='center' >$rep_row[magh]</td>
                                <td align='center' >$rep_row[date]</td>
                                <td align='center' >$rep_row[hour]</td>
                                <td align='center' >$rep_row[ship_name]</td>
                              <td align='center' >$rep_row[fname] $rep_row[lname]</td>
                              <td align='center' >";
                              if ($rep_row['cancel_fee']!="")
                                $tbody .= number_format($rep_row['cancel_fee']);
                              $tbody .= "</td>
                              <td align='center' >".number_format($rep_row['fee'])."</td>
							 
							</tr>
						";
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  
			   <th>از</th>
               <th>به</th>
               <th>تاریخ</th>
               <th>ساعت</th>
               <th>نام کشتی</th>
              <th>نام و نام خانوادگی</th>
              <th>مبلغ کسر شده (ريال)</th>
              <th>مبلغ کل  (ريال)</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
	$rep_sql
		";
		}
	}
	
	///
	if ($_REQUEST['report'] == 'mcncl' ){
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
	$tt = $_REQUEST[shiptype];
	if ( $_SESSION['g_t_login'] == "shipman" or $_SESSION['g_t_login'] == "agency"  ){
	$add_txt_sh_1 = "  AND  `gcms_$_REQUEST[shiptype]`.`id_login` = '$_SESSION[g_id_login]' ";
	}
	$rep_sql = "
	SELECT gcms_$_REQUEST[shiptype].id , ship_name , sailing.name , mabd.name , magh.name  , date , hour
	FROM `gcms_$_REQUEST[shiptype]` 
	INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
	WHERE  gcms_$_REQUEST[shiptype].`id` = '$_REQUEST[$tt]' $add_txt_sh_1
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$rep_row = mysql_fetch_array($rep_res);
		$dt_rep_row = explode("-", $rep_row[5] );
		$title = " 
		گزارش کنسلی مسیر  کشتیرانی  $rep_row[1] کشتیرانی $rep_row[2] مسیر $rep_row[3] به $rep_row[4] تاریخ $dt_rep_row[2]-$dt_rep_row[1]-$dt_rep_row[0] ساعت حرکت $rep_row[6]
		";
	$rep_sql_2 = "
	SELECT id ,fname,lname,num,buy_time ,id_login ,cell,fee
	FROM `gcms_buy$_REQUEST[shiptype]` 
	WHERE  gcms_buy$_REQUEST[shiptype].`id_$_REQUEST[shiptype]` = ' $rep_row[0]' AND `type` = 'cancel'
	";

	$rep_res_2 = mysql_query($rep_sql_2,$link);
			while ($rep_row = mysql_fetch_array($rep_res_2)){
			
		$sho_d= explode("-", $rep_row[4]);
		$s_d_2 = gregorian_to_jalali2 ( $sho_d[0] , $sho_d[1] , $sho_d[2] );
		$s_d_2[0] = Convertnumber2farsi($s_d_2[0]);
		$s_d_2[1] = Convertnumber2farsi($s_d_2[1]);
		$s_d_2[2] = Convertnumber2farsi($s_d_2[2]);
						
			$rep_sql_2 = "
			SELECT fname , lname , num , buy_time , cell , `gcms_buy$_REQUEST[shiptype]`.fee , id_$_REQUEST[shiptype] , `gcms_buy$_REQUEST[shiptype]`.id_login
			FROM `gcms_buy$_REQUEST[shiptype]` 
			INNER JOIN `gcms_$_REQUEST[shiptype]` ON `gcms_$_REQUEST[shiptype]`.`id` = `gcms_buy$_REQUEST[shiptype]`.`id_$_REQUEST[shiptype]`		 
			WHERE `gcms_buy$_REQUEST[shiptype]`.`id` = '$rep_row[0]' 
			";
			$rep_res_2 = mysql_query($rep_sql_2,$link);
			$rep_row_2 = mysql_fetch_array($rep_res_2);

			$seryl = $rep_row[0]+111111 ; 
			$rep_row_22 = mysql_fetch_array(mysql_query("SELECT * FROM `gcms_metalogin` WHERE `login_id` = '$rep_row_2[7]' ",$link));
			
			$sho_d_2= explode("-", $rep_row_2[3]);
			$s_d_2_2 = gregorian_to_jalali2 ( $sho_d_2[0] , $sho_d_2[1] , $sho_d_2[2] );

			if ($rep_row_22[0]){
			$sedorc = "$rep_row_2[id_login]";
			}else{
			$sedorc = "0";
			}
				
			$rep_sql_3 = "
			SELECT *
			FROM `gcms_cancel` 
			WHERE `id_buy` = '$rep_row[0]' 
			";
			$rep_res_3 = mysql_query($rep_sql_3,$link);
			$rep_row_3 = mysql_fetch_array($rep_res_3);
		
			$sho_d_2_3= explode("-", $rep_row_3[4]);
			$s_d_2_2_3 = gregorian_to_jalali2 ( $sho_d_2_3[0] , $sho_d_2_3[1] , $sho_d_2_3[2] );

			if ($rep_row_3[5] == "agency" ){
			$bnk = "آژانس";
			}else{
			$bnk = "$rep_row_3[7] <br>$rep_row_3[6] <br>$rep_row_3[5]";
			}

			$tbody = $tbody . "
				<tr>
				  <td align='center' >$rep_row_2[0] $rep_row_2[1]</td>
				  <td align='center' >$rep_row_2[2]</td>
				  <td align='center' >$s_d_2_2[0]-$s_d_2_2[1]-$s_d_2_2[2]</td>
				  <td align='center' > $s_d_2_2_3[0]-$s_d_2_2_3[1]-$s_d_2_2_3[2]<br>$rep_row_3[3]</td>
				  <td align='center' >$sedorc</td>
				  <td align='center' >$seryl</td>
				  <td align='center' > $bnk </td>
				  <td align='center' >$rep_row_2[4]</td>
				  <td align='center' >$rep_row_2[5]</td>
				</tr>
			";
			/*
			if ( $rep_row_2[2] != 0){
				$rep_sql_3 = "
				SELECT *
				FROM `gcms_metabuy`  
				WHERE  `id_buy` = '$rep_row[0]' AND `type` = '$_REQUEST[shiptype]' 
				";
				$rep_res_3 = mysql_query($rep_sql_3,$link);
						$j = 0 ;
						while ($rep_row_3 = mysql_fetch_array($rep_res_3)){
						++$j;
						$tbody = $tbody . "
							<tr>
							  <td align='center' >$rep_row_2[0] $rep_row_2[1]</td>
							  <td align='center' >$rep_row_2[2]</td>
							  <td align='center' >$s_d_2_2[0]-$s_d_2_2[1]-$s_d_2_2[2]</td>
							  <td align='center' > $s_d_2_2_3[0]-$s_d_2_2_3[1]-$s_d_2_2_3[2]<br>$rep_row_3[3]</td>
							  <td align='center' >$sedorc</td>
							  <td align='center' >$seryl</td>
							  <td align='center' >$rep_row_3[7] <br>$rep_row_3[6] <br>$rep_row_3[5]  </td>
							  <td align='center' >$rep_row_2[4]</td>
							  <td align='center' >$rep_row_2[5]</td>
							
							
							  <td align='center' >$i-$j</td>
							  <td align='center' >$rep_row_3[3] $rep_row_3[4]</td>
							  <td align='center' >$rep_row_3[5]</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >*</td>
							  <td align='center' >$mcode/$j</td>
							</tr>
						";
						}
				}
				*/
			
			
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th>نام مسافر</th>
			  <th>تعداد همراه</th>
			  <th>تاریخ صدور</th>
			  <th>تاریخ کنسلی</th>
			  <th>کد صدور</th>
			  <th>سریال بلیط</th>
			  <th>شماره حساب</th>
			  <th>همراه</th>
			  <th>مبلغ کل</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}
	
	///
	if ($_REQUEST['report'] == 'agncy' ){

	$rep_sql = "
	SELECT login_id , value
	FROM `gcms_metalogin` 
	WHERE  `key` = 'agency_name' 
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		
		$title = " 
		گزارش عملکرد آژانس ها
		";
			
			while ($rep_row = mysql_fetch_array($rep_res)){
			//
			$rep_sql_2 = "
			SELECT COUNT(*)
			FROM `gcms_buypsngrtrade`
			WHERE `id_login` = '$rep_row[0]' 
			";
			$rep_row_2 = mysql_fetch_array(mysql_query($rep_sql_2,$link)) ;
			
			//
			$rep_sql_3 = "
			SELECT COUNT(*)
			FROM `gcms_buycartrade`
			WHERE `id_login` = '$rep_row[0]' 
			";
			$rep_row_3 = mysql_fetch_array(mysql_query($rep_sql_3,$link)) ;

			//
			$rep_sql_4 = "
			SELECT value
			FROM `gcms_metalogin`
			WHERE `key` = 'agency_use'  AND `login_id` = '$rep_row[0]' 
			";
			$rep_row_4 = mysql_fetch_array(mysql_query($rep_sql_4,$link)) ;
			
			//
			$rep_sql_5 = "
			SELECT value
			FROM `gcms_metalogin`
			WHERE `key` = 'agency_credit'  AND `login_id` = '$rep_row[0]' 
			";
			$rep_row_5 = mysql_fetch_array(mysql_query($rep_sql_5,$link)) ;
			//
			$mande = $rep_row_5[0] - $rep_row_4[0] ; 
			
			//
			$rep_sql_6 = "
			SELECT SUM(fee)
			FROM `gcms_prdxt`
			WHERE `id_login` = '$rep_row[0]' 
			";
			$rep_row_6 = mysql_fetch_array(mysql_query($rep_sql_6,$link)) ;
			
			//
			$rep_sql_7 = "
			SELECT SUM(fee)
			FROM `gcms_buycartrade`
			WHERE `id_login` = '$rep_row[0]'  AND `charter` = 'true'  
			";
			$rep_row_7 = mysql_fetch_array(mysql_query($rep_sql_7,$link)) ;
			$rep_sql_8 = "
			SELECT SUM(fee)
			FROM `gcms_buypsngrtrade`
			WHERE `id_login` = '$rep_row[0]'  AND `charter` = 'true'  
			";
			$rep_row_8 = mysql_fetch_array(mysql_query($rep_sql_8,$link)) ;
			$chr_add = $rep_row_7[0] + $rep_row_8[0] ;
			++$i;

			$tbody = $tbody . "
				<tr>
			  <td  align='center'  >$i</th>
			  <td  align='center'  >$rep_row[1]</th>
			  <td  align='center'  >$rep_row_2[0]</th>
			  <td  align='center'  >$rep_row_3[0]</th>
			  <td  align='center'  >$chr_add</th>
			  <td  align='center'  >$rep_row_4[0]</th>
			  <td  align='center'  >$rep_row_6[0]</th>
			  <td  align='center'  >$rep_row[0]</th>
			  <td  align='center'  >$mande</th>
				</tr>
			";
			
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th  align='center'  >ردیف</th>
			  <th  align='center'  >نام آژانس</th>
			  <th  align='center'  >تعداد خرید بلیط مسافربری</th>
			  <th  align='center'  >تعداد خرید بلیط لندیگرافت</th>
			  <th  align='center'  >جمع فروش چارتر</th>
			  <th  align='center'  >جمع کل فروش</th>
			  <th  align='center'  >جمع کل واریز</th>
			  <th  align='center'  >کد آژانس</th>
			  <th  align='center'  >اعتبار مانده</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}

	///
	if ($_REQUEST['report'] == 'alist' ){

	$rep_sql = "
	SELECT login_id , value
	FROM `gcms_metalogin` 
	WHERE  `key` = 'agency_name' AND `login_id` = '$_REQUEST[sail_name]' 
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$rep_row = mysql_fetch_array($rep_res);
		
		if ($_REQUEST[shiptype] == "psngrtrade" ){
		$txt_shiptype = "مسافربری";
		}else{
		$txt_shiptype = "لندیگرافت";
		}
		
		$title = " 
		گزارش عملکرد آژانس $rep_row[1] از تاریخ $_REQUEST[az_roz]-$_REQUEST[az_mah]-$_REQUEST[az_sal] تا تاریخ $_REQUEST[ta_roz]-$_REQUEST[ta_mah]-$_REQUEST[ta_sal] در کشتیهای $txt_shiptype 
		";

			if ($_REQUEST[shiptype] == "cartrade" ){
			$add_car_2 = "
			, gcms_car.name
			";
			$add_car_3 = "
			INNER JOIN `gcms_car` ON `gcms_buycartrade`.`id_car` = `gcms_car`.`id`
			";

			}

		
			//
			$rep_sql_2 = "
			SELECT fname , lname , mcode , cell , num , gcms_buy$_REQUEST[shiptype].fee , id_$_REQUEST[shiptype] , gcms_buy$_REQUEST[shiptype].id $add_car_2
			FROM `gcms_buy$_REQUEST[shiptype]`
			$add_car_3 
			WHERE `gcms_buy$_REQUEST[shiptype]`.`id_login` = '$rep_row[0]' 
			";

			$rep_res_2 = mysql_query($rep_sql_2,$link) ;

			while ($rep_row_2 = mysql_fetch_array($rep_res_2)){
			//
			$rep_sql_3 = "
			SELECT gcms_$_REQUEST[shiptype].id , sailing.name , ship_name , mabd.name , magh.name , date , hour 
			FROM `gcms_$_REQUEST[shiptype]`
			INNER JOIN `gcms_des` AS mabd ON `gcms_$_REQUEST[shiptype]`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_$_REQUEST[shiptype]`.`id_magh` = `magh`.`id`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_$_REQUEST[shiptype]`.`id_sailing` = `sailing`.`id`
			
			WHERE `gcms_$_REQUEST[shiptype]`.`id` = '$rep_row_2[6]'
			AND 
			`date` >= '$_REQUEST[az_sal]-$_REQUEST[az_mah]-$_REQUEST[az_roz]' 
			AND 
			`date` <= '$_REQUEST[ta_sal]-$_REQUEST[ta_mah]-$_REQUEST[ta_roz]' 
			";
			
			
			$rep_res_3 = mysql_query($rep_sql_3,$link) ;
			$rep_row_3 = mysql_fetch_array($rep_res_3);
			if ($rep_row_3[0]){
			++$i;
			
			if ($_REQUEST[shiptype] == "cartrade" ){
			$add_car_4 = "
			  <td  align='center'  >$rep_row_2[8]</th>
			  <td  align='center'  >راننده</th>
			"; 

			}


			$tbody = $tbody . "
				<tr>
			  <td  align='center'  >$rep_row_2[0] $rep_row_2[1]</th>
			  <td  align='center'  >$rep_row_2[2]</th>
			  $add_car_4 
			  <td  align='center'  >$rep_row_2[3]</th>
			  <td  align='center'  >$rep_row_3[1]</th>
			  <td  align='center'  >$rep_row_3[2]</th>
			  <td  align='center'  >$rep_row_3[3] به $rep_row_3[4]</th>
			  <td  align='center'  >$rep_row_3[5]</th>
			  <td  align='center'  >$rep_row_3[6]</th>
			  <td  align='center'  >$rep_row_2[4]</th>
			  <td  align='center'  >$rep_row_2[5]</th>
				</tr>
			";

			if ( $rep_row_2[4] != 0){
			
				$rep_sql_4 = "
				SELECT *
				FROM `gcms_metabuy`  
				WHERE  `id_buy` = '$rep_row_2[7]' AND `type` = '$_REQUEST[shiptype]' 
				";
				$rep_res_4 = mysql_query($rep_sql_4,$link);
						$j = 0 ;
						while ($rep_row_4 = mysql_fetch_array($rep_res_4)){
						++$i;
			if ($_REQUEST[shiptype] == "cartrade" ){
			$add_car_5 = "
			  <td  align='center'  >*</th>
			  <td  align='center'  >همراه</th>
			"; 

			}
						$tbody = $tbody . "
							<tr>
							
							  <td  align='center'  >$rep_row_4[3] $rep_row_4[4]</th>
							  <td  align='center'  >$rep_row_4[5]</th>
							  $add_car_5 
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							  <td  align='center'  >*</th>
							
							</tr>
						";
						}
				}
			
			
			}
			}
		}
		if ( $result ){
		
		if ($_REQUEST[shiptype] == "cartrade" ){
		$add_car_1 = "
			  <th  align='center'  >نوع خودرو</th>
			  <th  align='center'  >سمت</th>
		"; 
		}
		
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th  align='center'  >نام و نام خانوادگی</th>
			  <th  align='center'  >شماره ملی</th>
			  $add_car_1
			  <th  align='center'  >موبایل</th>
			  <th  align='center'  >نام کشتیرانی</th>
			  <th  align='center'  >نام کشتی</th>
			  <th  align='center'  >مسیر حرکت</th>
			  <th  align='center'  >تاریخ</th>
			  <th  align='center'  >ساعت</th>
			  <th  align='center'  >تعداد همراه</th>
			  <th  align='center'  >جمع کل خرید</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}

////
	if ($_REQUEST['report'] == 'user' ){
		if ($_REQUEST[shiptype] == "psngrtrade" ){
		$txt_shiptype = "مسافربری";
		}else{
		$txt_shiptype = "لندیگرافت";
		}
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
	$as_g_d = jalali_to_gregorian2( "13".$_REQUEST[az_sal] , $_REQUEST[az_mah] , $_REQUEST[az_roz] );
	$ta_g_d = jalali_to_gregorian2( "13".$_REQUEST[ta_sal] , $_REQUEST[ta_mah] , $_REQUEST[ta_roz] );
	
	if ($_REQUEST[shiptype] == "cartrade" ){
	$add_txt_1 = "
	, plate , gcms_car.name 
	";
	$add_txt_2 = "
	INNER JOIN `gcms_car` ON `gcms_car`.`id` = `gcms_buy$_REQUEST[shiptype]`.`id_car`
	";
	}
	
	$rep_sql = "
	SELECT gcms_buy$_REQUEST[shiptype].id , fname , lname , mcode , cell , tell , state , city , address $add_txt_1
	FROM `gcms_buy$_REQUEST[shiptype]` 
	$add_txt_2
	WHERE 
	`buy_time` >= '$as_g_d[0]-$as_g_d[1]-$as_g_d[2]' 
	AND 
	`buy_time` <= '$ta_g_d[0]-$ta_g_d[1]-$ta_g_d[2]' 
	AND 
	gcms_buy$_REQUEST[shiptype].id_login NOT IN ( SELECT login_id FROM gcms_metalogin WHERE `key` = 'agency_name' ) 
	";
	$rep_res = mysql_query($rep_sql,$link);
		if (!$rep_res){$result = false ; }else{$result = true ;
		$title = "گزارش لیست کاربرانی که خرید بلیط  $txt_shiptype ، داشته اند  از تاریخ $_REQUEST[az_roz]-$_REQUEST[az_mah]-$_REQUEST[az_sal] تا تاریخ $_REQUEST[ta_roz]-$_REQUEST[ta_mah]-$_REQUEST[ta_sal] ";
			while ($rep_row = mysql_fetch_array($rep_res)){
			++$i ;
			
	if ($_REQUEST[shiptype] == "cartrade" ){
	$add_txt_3 = "
				  <td align='center' >$rep_row[10]</td>
				  <td align='center' >$rep_row[9]</td>
	";
	}else{
	$add_txt_3 = "
				  <td align='center' >*</td>
				  <td align='center' >*</td>
	";
	}
			
			$tbody = $tbody . "
				<tr>
				  <td align='center' >$i</td>
				  <td align='center' >$rep_row[1] $rep_row[2]</td>
				  <td align='center' >$rep_row[3]</td>
					$add_txt_3
				  <td align='center' >$rep_row[4]</td>
				  <td align='center' >$rep_row[5]</td>
				  <td align='center' >$rep_row[6] , $rep_row[7] <br> $rep_row[8]</td>
				</tr>
			";
			}
		}
		if ( $result ){
		$content = "
		<table border=1 bordercolor='#000000' bordercolordark='#000000' bordercolorlight='#000000' >
		  <thead>
			<tr>
			  <th>ردیف</th>
			  <th>نام نام خانوادگی</th>
			  <th>شماره ملی</th>
			  <th>نوع خودرو</th>
			  <th>پلاک خودرو</th>
			  <th>شماره همراه</th>
			  <th>تلفن</th>
			  <th>آدرس</th>
			</tr>
		  </thead>
		  <tbody>
			$tbody
		  </tbody>
		</table>
	
		";
		}else{
		$content = "
		<center><font color=red > هیچ نتیجه ای پیدا نشد </font></center>
		";
		}
	}

	
	
	
}else{
$content = "<center><font color=red >شما اجازه دسترسی به این بخش را ندارید</font></center>";
}






?>
<style type="text/css">
body{
font-size:11px;
direction:rtl;
}
table {
	border-width: 1px;
	border-spacing: 5px;
	border-style: solid;
	border-color: black;
	border-collapse: collapse;
	background-color: white;
	font-size:12px;
}
table th {
	border-width: 1px;
	padding: 5px;
	border-style: inset;
	border-color: black;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
table td {
	border-width: 1px;
	padding: 5px;
	border-style: inset;
	border-color: black;
	background-color: white;
	-moz-border-radius: 0px 0px 0px 0px;
}
</style>
<head>
<title>گزارش</title>
<link rel="stylesheet" type="text/css" href="/gcms/css/blpr.css" />
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
</head>
<body style="font-family:tahoma;" >
<div style=" direction:rtl; margin-right:10px" >
<h3 style="direction:rtl"><?php echo $title; ?></h1>
</div>
<div style="direction:rtl; text-align:right ; margin:50px;" >
<?php echo $content; ?>		
</div>
</body>