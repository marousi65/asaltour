<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
//ps
$p_hour = date("Y-m-d-H-i-s", strtotime("-1 hours"));
$sql = "
SELECT id,id_psngrtrade,num,type,buy_time FROM gcms_buypsngrtrade WHERE `type` = 'pending'     
";
$result = mysql_query($sql,$link);
while ($row = mysql_fetch_array($result))
{
	if(analysdate($row[4]))
	{
		$get_cap_sql = "SELECT free_capacity FROM `gcms_psngrtrade` WHERE `id` = $row[1] ";
		$get_cap = mysql_fetch_array(mysql_query($get_cap_sql,$link));
		$new_free_capacity =  $row[2]+1+$get_cap[0];
		$upd_sql = " UPDATE `gcms_psngrtrade` SET `free_capacity` = '$new_free_capacity' WHERE `gcms_psngrtrade`.`id` =$row[1] ";
		mysql_query($upd_sql,$link);
		$del_sql = " UPDATE `gcms_buypsngrtrade` SET `type` = 'cancel' WHERE `gcms_buypsngrtrade`.`id` = $row[0] ";
		mysql_query($del_sql,$link);		
	}
}
//car 
$sql_car = "
SELECT id,id_cartrade,id_car,type,buy_time FROM gcms_buycartrade WHERE `type` = 'pending'     
";
$result_car = mysql_query($sql_car,$link);
while ($row = mysql_fetch_array($result_car))
{
	if(analysdate($row[4]))
	{
		$get_cap_sql = "SELECT free_capacity FROM `gcms_cartrade` WHERE `id` = $row[1] ";
		$get_cap = mysql_fetch_array(mysql_query($get_cap_sql,$link));
		//find car value
		$car_cap_sql = " SELECT unit FROM `gcms_car` WHERE `id` = $row[2]";
		$get_car_cap = mysql_fetch_array(mysql_query($car_cap_sql,$link));
		$new_free_capacity =  $get_car_cap[0]+$get_cap[0];
		$upd_sql = " UPDATE `gcms_cartrade` SET `free_capacity` = '$new_free_capacity' WHERE `gcms_cartrade`.`id` =$row[1] ";
		mysql_query($upd_sql,$link);
		$del_sql = " UPDATE `gcms_buycartrade` SET `type` = 'cancel' WHERE `gcms_buycartrade`.`id` = $row[0] ";
		mysql_query($del_sql,$link);	
	}
}


function analysdate($db_date)
{
	$p_hour = strtotime("-1 hours");
	$new_date = explode("-" ,$db_date);
	$n_date = $new_date[0]."-".$new_date[1]."-".$new_date[2]." ".$new_date[3].":".$new_date[4].":".$new_date[5] ;
	$expiration_date = strtotime($n_date);
	if ($expiration_date < $p_hour)
	{
		return true;
	}else{
		return false;
	}	
}