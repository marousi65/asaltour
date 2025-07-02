<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
//
if ( $_REQUEST[mbd] and  $_REQUEST[mgh] and $_REQUEST[sai] ){
	if ( $_REQUEST[mbd] ==  $_REQUEST[mgh] ){
	$error_message = "مبدا و مقصد یکسان است";
	}else{
	$chk_all = true;
	}

}else{
	$error_message = "اطلاعاتی ارسال نشده";
}
//
if ( $_REQUEST[trade] == "psngr" and $chk_all  ){
	
	$mbd = addslashes($_REQUEST[mbd]);
	$mgh = addslashes($_REQUEST[mgh]);
	$sai = addslashes($_REQUEST[sai]);
	$mah = addslashes($_REQUEST[mah]);
	
	//
	if ( $sai == "all" ){
		$sql_sai = "";
	}else{
		$sql_sai = "and `id_sailing` = '$sai' ";
	}
	//
	if ( $mbd == "ch" ){
		$sql_mbd = "";
	}else{
		$sql_mbd = " `id_mabd` = '$mbd'  ";
	}
	//
	if ( $mgh == "ch" ){
		$sql_mgh = "";
	}else{
		if ($mbd == "ch"){$sql_mgh = " `id_magh` = '$mgh'  ";}else{$sql_mgh = " and `id_magh` = '$mgh'  ";}
	}

	include $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
	
   $t_roz = jdate2('y-m-d', strtotime(' -1 day'));
   $t_hor = jdate2('H', strtotime('-3 hour -50 minutes'));
	//
	$cyear = jdate('Y')-1;
	$q_s = "
	SELECT mabd.name , magh.name ,  sailing.name , gcms_psngrtrade.id , gcms_psngrtrade.date , gcms_psngrtrade.hour , gcms_psngrtrade.free_capacity , gcms_psngrtrade.fee, gcms_psngrtrade.ship_name, SUBSTRING_INDEX(gcms_psngrtrade.date,'-',1) yeardate
	FROM `gcms_psngrtrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	WHERE $sql_mbd $sql_mgh $sql_sai and `type` = 'active' AND `gcms_psngrtrade`.`date` >  '$t_roz'  
	Having yeardate > $cyear
	ORDER BY `gcms_psngrtrade`.`date` ASC , `gcms_psngrtrade`.`hour` ASC
	 ";
    // echo $q_s ;
	$r_s = mysql_query($q_s,$link);
	$i = 0 ;	
	$searchtrade_content = "
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
			<b>نام کشتی</b>
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
			<b>ظرفیت خالی</b>(نفر)
			</center>
			</td>
			<td>
			<center>
			<b>قیمت </b>
			
			ریال
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
	while($row_s = mysql_fetch_array($r_s)){
		$trkh_chk = explode("-", $row_s[date]);
		
		if( $trkh_chk[1] == $_REQUEST[mah]   ){
		
		$codelenght = 50;
		while($newcode_length < $codelenght) {
		$x=1;
		$y=3;
		$part = rand($x,$y);
		if($part==1){$a=48;$b=57;}  // Numbers
		if($part==2){$a=65;$b=90;}  // UpperCase
		if($part==3){$a=97;$b=122;} // LowerCase
		$code_part=chr(rand($a,$b));
		$newcode_length = $newcode_length + 1;
		$newcode = $newcode.$code_part;
		}
		$r_rand = $newcode;
		$chk_cont = true ;
		if ( $row_s[free_capacity] == "0"){
		$khl = "ظرفیت تکمیل";
		}else{
		$khl = "<a href='?part=buy&buy=psngrtrade&psngrtrade=$r_rand$row_s[3]&num=0&stage=1' >خرید</a>";
		}
		$thishor = explode ( ":" , $row_s[hour] );
		$thisroz = explode ( "-" , $row_s[date] );
		$t_rozem = jdate2('d');
		$t_month = jdate2('m');
		if ( ( $t_hor < $thishor[0] or $t_rozem < $thisroz[2] ) and $_REQUEST[mah] == $t_month  )
			{
			
			$searchtrade_content = $searchtrade_content . "
		<tr>
			<td>
			<center>
			$row_s[0]
			</center>
			</td>
			<td>
			<center>
			$row_s[1]
			</center>
			</td>
			<td>
			<center>
			$row_s[ship_name]
			</center>
			</td>
			<td>
			<center>
			$row_s[2]
			</center>
			</td>
			<td>
			<center>
			$row_s[date]
			</center>
			</td>
			<td>
			<center>
			$row_s[hour]
			</center>
			</td>
			<td>
			<center>
			$row_s[free_capacity]
			</center>
			</td>
			<td>
			<center>
			".number_format($row_s[fee])."
			</center>
			</td>
			<td>
			<center>
			$khl
			</center>
			</td>
		</tr>
		";
			}
		elseif (  $_REQUEST[mah] == $thisroz[1]  )
			{
			
			$searchtrade_content = $searchtrade_content . "
		<tr>
			<td>
			<center>
			$row_s[0]
			</center>
			</td>
			<td>
			<center>
			$row_s[1]
			</center>
			</td>
			<td>
			<center>
			$row_s[ship_name]
			</center>
			</td>
			<td>
			<center>
			$row_s[2]
			</center>
			</td>
			<td>
			<center>
			$row_s[date]
			</center>
			</td>
			<td>
			<center>
			$row_s[hour]
			</center>
			</td>
			<td>
			<center>
			$row_s[free_capacity]
			</center>
			</td>
			<td>
			<center>
			".number_format($row_s[fee])."
			</center>
			</td>
			<td>
			<center>
			$khl
			</center>
			</td>
		</tr>
		";
			}
		
		}
		
		$i++;
	}
		$searchtrade_content = $searchtrade_content . "
		</tbody>
		</table>
		";
		if (!$chk_cont){$error_message = "نتیجه ای برای جستجوی مورد نظر شما در دسترس نمی باشد.";$searchtrade_content = "";}
		
	
	
}
//
if ( $_REQUEST[trade] == "car" and $chk_all ){
	
	$mbd = addslashes($_REQUEST[mbd]);
	$mgh = addslashes($_REQUEST[mgh]);
	$sai = addslashes($_REQUEST[sai]);
	$mah = addslashes($_REQUEST[mah]);
	//
	if ( $sai == "all" ){
		$sql_sai = "";
	}else{
		$sql_sai = "and `id_sailing` = '$sai' ";
	}
	//
	if ( $mbd == "ch" ){
		$sql_mbd = "";
	}else{
		$sql_mbd = " `id_mabd` = '$mbd'  ";
	}
	//
	if ( $mgh == "ch" ){
		$sql_mgh = "";
	}else{
		if ($mbd == "ch"){$sql_mgh = " `id_magh` = '$mgh'  ";}else{$sql_mgh = " and `id_magh` = '$mgh'  ";}
	}
	//
	include $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
	$t_roz = jdate2('y-m-d', strtotime(' -1 day'));
   $t_hor = jdate2('H', strtotime('-3 hour -50 minutes'));
	
	$cyear = jdate('Y')-1;
	$q_s = "
	SELECT mabd.name , magh.name ,  sailing.name , gcms_cartrade.id , gcms_cartrade.date , gcms_cartrade.hour , gcms_cartrade.free_capacity ,gcms_cartrade.ship_name , gcms_cartrade.charter_fee, SUBSTRING_INDEX(gcms_cartrade.date,'-',1) yeardate
	FROM `gcms_cartrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
	WHERE $sql_mbd $sql_mgh $sql_sai and `type` = 'active'  AND `gcms_cartrade`.`date` >  '$t_roz' 
	Havin yeardate > $cyear
	ORDER BY `gcms_cartrade`.`date` ASC , `gcms_cartrade`.`hour` ASC
	 ";
	$r_s = mysql_query($q_s,$link);
	$i = 0 ;
	$searchtrade_content = "
	
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
			<b>نام کشتی</b>
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
			<b>ظرفیت خالی</b> (واحد)
			</center>
			</td>
			<td>
			<center>
			<b>قیمت چارتر</b>
			ریال
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
	while($row_s = mysql_fetch_array($r_s)){
		$trkh_chk = explode("-", $row_s[date]);
		
		if( $trkh_chk[1] == $_REQUEST[mah] ){
		$codelenght = 50;
		while($newcode_length < $codelenght) {
		$x=1;
		$y=3;
		$part = rand($x,$y);
		if($part==1){$a=48;$b=57;}  // Numbers
		if($part==2){$a=65;$b=90;}  // UpperCase
		if($part==3){$a=97;$b=122;} // LowerCase
		$code_part=chr(rand($a,$b));
		$newcode_length = $newcode_length + 1;
		$newcode = $newcode.$code_part;
		}
		$r_rand = $newcode;
		$chk_cont = true ;
		if ( $row_s[free_capacity] == "0"){
		$khl = "ظرفیت تکمیل";
		}else{
		$khl = "<a href='?part=buy&buy=cartrade&cartrade=$r_rand$row_s[3]&num=0&weigh=0&vehicle=0&stage=1' >خرید</a>";
		}
		
		$thishor = explode ( ":" , $row_s[hour] );
		$thisroz = explode ( "-" , $row_s[date] );
		$t_rozem = jdate2('d');
		
		if ($t_hor < $thishor[0] or $t_rozem < $thisroz[2] )
			{
			$searchtrade_content = $searchtrade_content . "
		<tr>
			<td>
			<center>
			$row_s[0]
			</center>
			</td>
			<td>
			<center>
			$row_s[1]
			</center>
			</td>
			<td>
			<center>
			$row_s[ship_name]
			</center>
			</td>
			<td>
			<center>
			$row_s[2]
			</center>
			</td>
			<td>
			<center>
			$row_s[date]
			</center>
			</td>
			<td>
			<center>
			$row_s[hour]
			</center>
			</td>
			<td>
			<center>
			$row_s[free_capacity]
			</center>
			</td>
			<td>
			<center>
			".number_format($row_s[charter_fee])."
			</center>
			</td>
			
			<td>
			<center>
			$khl
			</center>
			</td>
		</tr>
		";
			}
		
		}
		$i++;
	}
		$searchtrade_content = $searchtrade_content . "
		</tbody>
		</table>
		";
		if (!$chk_cont){$error_message = "نتیجه ای برای جستجوی مورد نظر شما در دسترس نمی باشد.";$searchtrade_content = "";}
		


}

/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',"?part=searchtrade"); 
			$gcms->assign('page_title',"جستجو");
			 
			$gcms->assign('error_message',"$error_message"); 
			$gcms->assign('success_message',"$success_message"); 
			$gcms->assign('searchtrade_content',"$searchtrade_content"); 
			
			$gcms->assign('part',"searchtrade"); 
			
			$gcms->display("index/index.tpl");
	
	

?>