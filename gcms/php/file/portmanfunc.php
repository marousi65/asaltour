<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';


//
function f_portman_edit_profile(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formportman.php';
	
	global $error_message,$success_message,$portman_content;
	
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
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=portman&portman=edit&edit=profile'\",5000);</script>
		";
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formportman.php';
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
	}
	$portman_content = "$form_portman_edit_profile";
	
}


//
function f_portman_edit_pass(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formportman.php';
	
	global $error_message,$success_message,$portman_content;
	
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
			<script language=\"JavaScript\">setTimeout(\"?part=portman&portman=edit&edit=pass'\",5000);</script>
			 ";
			}else{
			$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
			}
		}else{
			$error_message = "کلمات عبور هماهنگ نبود لطفا دوباره تلاش کنید. ";
		}
	}
	$portman_content = "$form_portman_edit_pass";
	
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
for ($i = 1389; $i <= jdate('Y')+1; $i++) {
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
for ($i = 1389; $i <= jdate('Y')+1; $i++) {
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

	<form  action='?part=portman&portman=report&report=nlist&nlist=true' method='post' name='report' >
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
for ($i = 1389; $i <= jdate('Y')+1; $i++) {
    $dy_sal = $dy_sal. "
	<option>$i</option>
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
	
	
	$admin_content = "

	<form target='_blank' action='/gcms/report.php?report=cncl' method='post' >
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
		
		<select name='sail_name' >
			<option value='0' >انتخاب کشتی رانی ... </option>
			$sel_sai_name
		</select>
		
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
for ($i = 1389; $i <= jdate('Y')+1; $i++) {
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

	<form  action='?part=portman&portman=report&report=mcncl&mcncl=true' method='post' name='report' >
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
