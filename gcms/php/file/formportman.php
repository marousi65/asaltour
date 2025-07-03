<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

//
if ($_REQUEST[edit] == "profile"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_SESSION[g_id_login]'  ",$link));

	$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_SESSION[g_id_login]'  ",$link));
	$arrsailiglist = explode(",", $sailiglist[value] );
	$taksailiglist = "";
	for ($i = 0; $i <= count($arrsailiglist); $i++) {
		if ($arrsailiglist[$i]){
		$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
		$taksailiglist =  $taksailiglist . $r_taksailiglist[0] . " - ";
		}
	}


$form_portman_edit_profile = "

<form action='?part=portman&portman=edit&edit=profile&profile=chng' method='post' >
<table id='hor-minimalist-a-1' >
<tbody>
	<tr>
		<td>
		نام
		</td>
		<td>
		<input type='text' name='fname' value='$row_1[fname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$row_1[lname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		$row_1[melicode]
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		$row_1[email]
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address' class='reqd' >$row_1[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$row_1[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$row_1[cell]'  />
		</td>
	</tr>
	<tr>
		<td>
		کشتیرانی 
		</td>
		<td>
		$taksailiglist
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ویرایش' onMouseDown='initForms()' >
		</td>
	</tr>
</tbody>
</table>
</form>


";
}


//
if ($_REQUEST[edit] == "pass"  ){
$form_portman_edit_pass = "

<form action='?part=portman&portman=edit&edit=pass&passw=chng' method='post' >
<table id='formtable1'>
	<tr>
		<td>
		کلمه عبور جدید
		</td>
		<td>
		<input type='password' name='pass'   class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		تکرار کلمه عبور
		</td>
		<td>
		<input type='password' name='repass'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='تغییر' onMouseDown='initForms()' >
		</td>
	</tr>
</table>
</form>


";
}


//
if ($_REQUEST['new'] == "psngrtrade"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';


$res_mabmagh_1 = mysql_query(" select * from gcms_des  ",$link);
$mabd = "<select name='mabd' >";
$magh = "<select name='magh' >";
while ($row_mabmagh_1 = mysql_fetch_array($res_mabmagh_1)){
$mabd = $mabd . "<option value='$row_mabmagh_1[id]' >$row_mabmagh_1[name]</option>";
$magh = $magh . "<option value='$row_mabmagh_1[id]' >$row_mabmagh_1[name]</option>";
}
$mabd = $mabd . "</select>";
$magh = $magh . "</select>";

$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_SESSION[g_id_login]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$taksailiglist = "<select name='sailing' >";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
$taksailiglist =  $taksailiglist ."<option value='$arrsailiglist[$i]' >$r_taksailiglist[0]</option>";
}
}
$taksailiglist =  $taksailiglist ."</select>";

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
for ($i = 93; $i <= 95; $i++) {
    $dy_sal = $dy_sal. "
	<option>$i</option>
	";
}


$form_portman_new_psngrtrade = "

<form action='?part=portman&portman=new&new=psngrtrade&psngrtrade=true' method='post' >
<table id='hor-minimalist-a-2'  >
<tbody>
	<tr>
		<td>
		مبدا سفر
		</td>
		<td>
		$mabd
		</td>
	</tr>
	<tr>
		<td>
		مقصد سفر
		</td>
		<td>
		$magh
		</td>
	</tr>
	<tr>
		<td>
		نام کشتیرانی
		</td>
		<td>
		$taksailiglist
		</td>
	</tr>
	<tr>
		<td>
		تاریخ حرکت
		</td>
		<td>
		<select name='roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='sal' id='selectroz' >
			$dy_sal
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ساعت حرکت
		</td>
		<td>
		<select name='min' id='selectroz' >
			<option >00</option>
			<option >15</option>
			<option >30</option>
			<option >45</option>
		</select>
		 : 
		<select name='hour' id='selectroz' >
			<option >01</option>
			<option >02</option>
			<option >03</option>
			<option >04</option>
			<option >05</option>
			<option >06</option>
			<option >07</option>
			<option >08</option>
			<option >09</option>
			<option >10</option>
			<option >11</option>
			<option >12</option>
			<option >13</option>
			<option selected='selected' >14</option>
			<option >15</option>
			<option >16</option>
			<option >17</option>
			<option >18</option>
			<option >19</option>
			<option >20</option>
			<option >21</option>
			<option >22</option>
			<option >23</option>
			<option >24</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ظرفیت مسافر (نفر)
		</td>
		<td>
		<input type='text' name='capacity' value='$_REQUEST[capacity]'  class='reqd' /> 
		</td>
	</tr>
	<tr>
		<td>
		مدت زمان سفر (دقیقه)
		</td>
		<td>
		<input type='text' name='time' value='$_REQUEST[time]'  class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		سرعت کشتی (مایل دریایی)
		</td>
		<td>
		<input type='text' name='speed' value='$_REQUEST[speed]'  class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		قیمت بلیط  (ریال)
		</td>
		<td>
		<input type='text' name='fee' value='$_REQUEST[fee]'  class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		قیمت چارتر (ریال)
		</td>
		<td>
		<input type='text' name='charter_fee' value='$_REQUEST[charter_fee]'  class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		نام کشتی 
		</td>
		<td>
		<input type='text' name='ship_name' value='$_REQUEST[ship_name]'  class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		اطلاعات کشتی 
		</td>
		<td>
		<textarea name='ship_info'  class='reqd' >$_REQUEST[ship_info]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		وضعیت سفر 
		</td>
		<td>
		<input type='radio' name='type' value='active' >درحال فروش بلیط &nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='type' value='pending' checked='checked' >غیرفعال
		</td>
	</tr>
	<tr>
		<td>
		پیغام -1
		</td>
		<td>
		<textarea name='mess1'  class='reqd' >$_REQUEST[mess1]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -2
		</td>
		<td>
		<textarea name='mess2'  class='reqd' >$_REQUEST[mess2]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -3
		</td>
		<td>
		<textarea name='mess3'  class='reqd' >$_REQUEST[mess3]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد'  onMouseDown='initForms()' >
		</td>
	</tr>
</tbody>
</table>
</form>


";
}


//
if ($_REQUEST[edit] == "psngrtrade"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1 = mysql_fetch_array(mysql_query(" select * FROM `gcms_psngrtrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id` where gcms_psngrtrade.id='$_REQUEST[id]'  ",$link));


$res_mabmagh_1 = mysql_query(" select * from gcms_des  ",$link);
$mabd = "<select name='mabd' >";
$magh = "<select name='magh' >";
while ($row_mabmagh_1 = mysql_fetch_array($res_mabmagh_1)){
if ($row_mabmagh_1[id] == $row_1[21]){ $selct1 = " selected='selected' ";	}else{$selct1 = "" ;}
if ($row_mabmagh_1[id] == $row_1[23]){ $selct2 = " selected='selected' ";	}else{$selct2 = "" ;}
$mabd = $mabd . "<option value='$row_mabmagh_1[id]' $selct1 >$row_mabmagh_1[name]</option>";
$magh = $magh . "<option value='$row_mabmagh_1[id]' $selct2 >$row_mabmagh_1[name]</option>";
}
$mabd = $mabd . "</select>";
$magh = $magh . "</select>";

$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_SESSION[g_id_login]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$taksailiglist = "<select name='sailing' >";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
if ($arrsailiglist[$i] == $row_1[19]){ $selct3 = " selected='selected' ";	}else{$selct3 = "" ;}
$taksailiglist =  $taksailiglist ."<option value='$arrsailiglist[$i]' $selct3 >$r_taksailiglist[0]</option>";
}
}
$taksailiglist =  $taksailiglist ."</select>";
$trikh_h = explode("-", $row_1[5] );
$roz = $trikh_h[2];
$mah = $trikh_h[1];
$sal = $trikh_h[0];
for ($i = 1; $i <= 31; $i++) {
	if ($roz == $i){ $selct4 = " selected='selected' ";	}else{$selct4 = "" ;}
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
    $dy_roz = $dy_roz. "
	<option $selct4 >$rpir$i</option>
	";
}
for ($i = 1; $i <= 12; $i++) {
	if ($mah == $i){ $selct5 = " selected='selected' ";	}else{$selct5 = "" ;}
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
    $dy_mah = $dy_mah. "
	<option $selct5 >$rpir$i</option>
	";
}
for ($i = 90; $i <= 95; $i++) {
	if ($sal == $i){ $selct6 = " selected='selected' ";	}else{$selct6 = "" ;}
    $dy_sal = $dy_sal. "
	<option $selct6 >$i</option>
	";
}

$saat_h = explode(":", $row_1[6] );
$hour  = $saat_h[0];
$min   = $saat_h[1];
for ($i = 1; $i <= 24; $i++) {
	if ($hour == $i){ $selct7 = " selected='selected' ";	}else{$selct7 = "" ;}
    if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
    $t_hour = $t_hour. "
	<option $selct7 >$rpir$i</option>
	";
}
switch ($min){
	case "00":
	$t_min = "
	<option  selected='selected' >00</option>
	<option >15</option>
	<option >30</option>
	<option >45</option>
	";
	break;
	case "15":
	$t_min = "
	<option   >00</option>
	<option selected='selected'>15</option>
	<option >30</option>
	<option >45</option>
	";
	break;
	case "30":
	$t_min = "
	<option   >00</option>
	<option >15</option>
	<option selected='selected'>30</option>
	<option >45</option>
	";
	break;
	case "45":
	$t_min = "
	<option  >00</option>
	<option >15</option>
	<option >30</option>
	<option  selected='selected' >45</option>
	";
	break;
}

	if ($row_1[15] == "active"){
	$ac_li = "
	<input type='radio' name='type' value='active'  checked='checked' >درحال فروش بلیط &nbsp;&nbsp;&nbsp;&nbsp;
	<input type='radio' name='type' value='pending'>غیرفعال
	";
	}else{
		if ($row_1[type] == "close"){
		$ac_li = "بسته";
		}else{
		$ac_li = "
	<input type='radio' name='type' value='active'   >درحال فروش بلیط &nbsp;&nbsp;&nbsp;&nbsp;
	<input type='radio' name='type' value='pending' checked='checked'>غیرفعال
		";
		}
	}


$form_portman_edit_psngrtrade = "

<form action='?part=portman&portman=edit&edit=psngrtrade&id=$_REQUEST[id]&psngrtrade=chng' method='post' >
<table id='hor-minimalist-a-2'  >
<tbody>
	<tr>
		<td>
		مبدا سفر
		</td>
		<td>
		$mabd
		</td>
	</tr>
	<tr>
		<td>
		مقصد سفر
		</td>
		<td>
		$magh
		</td>
	</tr>
	<tr>
		<td>
		نام کشتیرانی
		</td>
		<td>
		$taksailiglist
		</td>
	</tr>
	<tr>
		<td>
		تاریخ حرکت
		</td>
		<td>
		<select name='roz' id='selectroz' >
			$dy_roz 
		</select>
		<select name='mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='sal' id='selectroz' >
			$dy_sal
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ساعت حرکت
		</td>
		<td>
		<select name='min' id='selectroz' >
			$t_min
		</select>
		 : 
		<select name='hour' id='selectroz' >
			$t_hour
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ظرفیت مسافر (نفر)
		</td>
		<td>
		<input type='text' name='capacity' value='$row_1[7]'  class='reqd'  /> 
		</td>
	</tr>
	<tr>
		<td>
		ظرفیت خالی (نفر)
		</td>
		<td>
		$row_1[8]
		</td>
	</tr>
	<tr>
		<td>
		مدت زمان سفر (دقیقه)
		</td>
		<td>
		<input type='text' name='time' value='$row_1[9]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		سرعت کشتی (مایل دریایی)
		</td>
		<td>
		<input type='text' name='speed' value='$row_1[10]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		قیمت بلیط  (ریال)
		</td>
		<td>
		<input type='text' name='fee' value='$row_1[11]'   class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		قیمت چارتر (ریال)
		</td>
		<td>
		<input type='text' name='charter_fee' value='$row_1[12]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		نام کشتی 
		</td>
		<td>
		<input type='text' name='ship_name' value='$row_1[13]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		اطلاعات کشتی 
		</td>
		<td>
		<textarea name='ship_info'  class='reqd'  >$row_1[14]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		وضعیت سفر 
		</td>
		<td>
		$ac_li
		</td>
	</tr>
	<tr>
		<td>
		پیغام -1
		</td>
		<td>
		<textarea name='mess1'  class='reqd' >$row_1[16]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -2
		</td>
		<td>
		<textarea name='mess2'  class='reqd'  >$row_1[17]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -3
		</td>
		<td>
		<textarea name='mess3'  class='reqd'  >$row_1[18]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ویرایش'  onMouseDown='initForms()'  >
		</td>
	</tr>
</tbody>
</table>
</form>


";
}

//
if ($_REQUEST['new'] == "cartrade"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';


$res_mabmagh_1 = mysql_query(" select * from gcms_des  ",$link);
$mabd = "<select name='mabd' >";
$magh = "<select name='magh' >";
while ($row_mabmagh_1 = mysql_fetch_array($res_mabmagh_1)){
$mabd = $mabd . "<option value='$row_mabmagh_1[id]' >$row_mabmagh_1[name]</option>";
$magh = $magh . "<option value='$row_mabmagh_1[id]' >$row_mabmagh_1[name]</option>";
}
$mabd = $mabd . "</select>";
$magh = $magh . "</select>";

$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_SESSION[g_id_login]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$taksailiglist = "<select name='sailing' >";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
$taksailiglist =  $taksailiglist ."<option value='$arrsailiglist[$i]' >$r_taksailiglist[0]</option>";
}
}
$taksailiglist =  $taksailiglist ."</select>";

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
for ($i = 93; $i <= 95; $i++) {
    $dy_sal = $dy_sal. "
	<option>$i</option>
	";
}

$rsl_list_car = mysql_query(" SELECT * FROM `gcms_car` WHERE `id_login` = '$_SESSION[g_id_login]' AND `type`='active'  ",$link);
$i= 0 ;
while ($row_list_car = mysql_fetch_array($rsl_list_car)){
$list_car = $list_car. "<div ONMOUSEOVER=\"ddrivetip('نام خودرو : $row_list_car[name] - تعداد واحد : $row_list_car[unit] - قیمت : $row_list_car[fee] ریال - قیمت بار اضافه : $row_list_car[cargo_fee] ریال ', 400)\"; ONMOUSEOUT=\"hideddrivetip()\" >$row_list_car[name] <input type='checkbox' name='carcard[]' value='$row_list_car[id]'  ></div>" ;
}

$form_portman_new_cartrade = "

<form action='?part=portman&portman=new&new=cartrade&cartrade=true' method='post' >
<table id='hor-minimalist-a-2'  >
<tbody>
	<tr>
		<td>
		مبدا سفر
		</td>
		<td>
		$mabd
		</td>
	</tr>
	<tr>
		<td>
		مقصد سفر
		</td>
		<td>
		$magh
		</td>
	</tr>
	<tr>
		<td>
		نام کشتیرانی
		</td>
		<td>
		$taksailiglist
		</td>
	</tr>
	<tr>
		<td>
		تاریخ حرکت
		</td>
		<td>
		<select name='roz' id='selectroz' >
			$dy_roz
		</select>
		<select name='mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='sal' id='selectroz' >
			$dy_sal
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ساعت حرکت
		</td>
		<td>
		<select name='min' id='selectroz' >
			<option >00</option>
			<option >15</option>
			<option >30</option>
			<option >45</option>
		</select>
		 : 
		<select name='hour' id='selectroz' >
			<option >01</option>
			<option >02</option>
			<option >03</option>
			<option >04</option>
			<option >05</option>
			<option >06</option>
			<option >07</option>
			<option >08</option>
			<option >09</option>
			<option >10</option>
			<option >11</option>
			<option >12</option>
			<option >13</option>
			<option selected='selected' >14</option>
			<option >15</option>
			<option >16</option>
			<option >17</option>
			<option >18</option>
			<option >19</option>
			<option >20</option>
			<option >21</option>
			<option >22</option>
			<option >23</option>
			<option >24</option>
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ظرفیت حمل خودرو(واحد)
		</td>
		<td>
		<input type='text' name='capacity' value='$_REQUEST[capacity]'  class='reqd'  /> 
		</td>
	</tr>
	<tr>
		<td>
		انتخاب لیست خودروها
		</td>
		<td>
		$list_car
		</td>
	</tr>
	<tr>
		<td>
		مدت زمان سفر (دقیقه)
		</td>
		<td>
		<input type='text' name='time' value='$_REQUEST[time]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		سرعت کشتی (مایل دریایی)
		</td>
		<td>
		<input type='text' name='speed' value='$_REQUEST[speed]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		قیمت چارتر (ریال)
		</td>
		<td>
		<input type='text' name='charter_fee' value='$_REQUEST[charter_fee]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		نام کشتی 
		</td>
		<td>
		<input type='text' name='ship_name' value='$_REQUEST[ship_name]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		اطلاعات کشتی 
		</td>
		<td>
		<textarea name='ship_info'  class='reqd'  >$_REQUEST[ship_info]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		وضعیت سفر 
		</td>
		<td>
		<input type='radio' name='type' value='active' >درحال فروش بلیط &nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='type' value='pending' checked='checked' >غیرفعال
		</td>
	</tr>
	<tr>
		<td>
		پیغام -1
		</td>
		<td>
		<textarea name='mess1'  class='reqd' >$_REQUEST[mess1]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -2
		</td>
		<td>
		<textarea name='mess2'  class='reqd' >$_REQUEST[mess2]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -3
		</td>
		<td>
		<textarea name='mess3'  class='reqd'  >$_REQUEST[mess3]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد'  onMouseDown='initForms()' >
		</td>
	</tr>
</tbody>
</table>
</form>


";
}


//
if ($_REQUEST['new'] == "car"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';



for ($i = 1; $i <= 50; $i++) {
    $unit = $unit. "
	<option >$i</option>
	";
}
for ($i = 0; $i <= 20; $i++) {
    $max_cap = $max_cap. "
	<option >$i</option>
	";
}


$form_portman_new_car = "

<form action='?part=portman&portman=new&new=car&car=true' method='post' >
<table id='hor-minimalist-a-2'  >
<tbody>
	<tr>
		<td>
		نام وسیله نقلیه
		</td>
		<td>
		<input type='text' name='name' value='$_REQUEST[name]' class='reqd'  /> 
		</td>
	</tr>
	<tr>
		<td>
		تعداد واحد
		</td>
		<td>
		<select name='unit' id='selectroz' >
			$unit
		</select>
		</td>
	</tr>
	<tr>
		<td>
		قیمت بلیط
		</td>
		<td>
		<input type='text' name='fee' value='$_REQUEST[fee]' class='reqd' /> 
		</td>
	</tr>
	<tr>
		<td>
		قیمت هر تن بار اضافه
		</td>
		<td>
		<input type='text' name='cargo_fee' value='0' class='reqd' /> 
		</td>
	</tr>
	<tr>
		<td>
		حداکثر تعداد همراه
		</td>
		<td>
		<select name='max_cap' id='selectroz'  >
			$max_cap
		</select>
		</td>
	</tr>
	<tr>
		<td>
		قیمت بلیط همراه
		</td>
		<td>
		<input type='text' name='fee_cap' value='$_REQUEST[fee_cap]' class='reqd'  /> 
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد' onMouseDown='initForms()'   >
		</td>
	</tr>
</tbody>
</table>
</form>


";
}

//
if ($_REQUEST[edit] == "cartrade"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1 = mysql_fetch_array(mysql_query(" select * FROM `gcms_cartrade`
	INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id` where gcms_cartrade.id='$_REQUEST[id]'  ",$link));


$res_mabmagh_1 = mysql_query(" select * from gcms_des  ",$link);
$mabd = "<select name='mabd' >";
$magh = "<select name='magh' >";
while ($row_mabmagh_1 = mysql_fetch_array($res_mabmagh_1)){
if ($row_mabmagh_1[id] == $row_1[21]){ $selct1 = " selected='selected' ";	}else{$selct1 = "" ;}
if ($row_mabmagh_1[id] == $row_1[23]){ $selct2 = " selected='selected' ";	}else{$selct2 = "" ;}
$mabd = $mabd . "<option value='$row_mabmagh_1[id]' $selct1 >$row_mabmagh_1[name]</option>";
$magh = $magh . "<option value='$row_mabmagh_1[id]' $selct2 >$row_mabmagh_1[name]</option>";
}
$mabd = $mabd . "</select>";
$magh = $magh . "</select>";

$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_SESSION[g_id_login]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$taksailiglist = "<select name='sailing' >";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
if ($arrsailiglist[$i] == $row_1[19]){ $selct3 = " selected='selected' ";	}else{$selct3 = "" ;}
$taksailiglist =  $taksailiglist ."<option value='$arrsailiglist[$i]' $selct3 >$r_taksailiglist[0]</option>";
}
}
$taksailiglist =  $taksailiglist ."</select>";
$trikh_h = explode("-", $row_1[5] );
$roz = $trikh_h[2];
$mah = $trikh_h[1];
$sal = $trikh_h[0];
for ($i = 1; $i <= 31; $i++) {
	if ($roz == $i){ $selct4 = " selected='selected' ";	}else{$selct4 = "" ;}
	if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
    $dy_roz = $dy_roz. "
	<option $selct4 >$rpir$i</option>
	";
}
for ($i = 1; $i <= 12; $i++) {
	if ($mah == $i){ $selct5 = " selected='selected' ";	}else{$selct5 = "" ;}
	if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
    $dy_mah = $dy_mah. "
	<option $selct5 >$rpir$i</option>
	";
}
for ($i = 90; $i <= 95; $i++) {
	if ($sal == $i){ $selct6 = " selected='selected' ";	}else{$selct6 = "" ;}
    $dy_sal = $dy_sal. "
	<option $selct6 >$i</option>
	";
}

$saat_h = explode(":", $row_1[6] );
$hour  = $saat_h[0];
$min   = $saat_h[1];
for ($i = 1; $i <= 24; $i++) {
	if ($hour == $i){ $selct7 = " selected='selected' ";	}else{$selct7 = "" ;}
	if ($i < 10 ) {$rpir = "0";}else{$rpir = "";}
    $t_hour = $t_hour. "
	<option $selct7 >$rpir$i</option>
	";
}
switch ($min){
	case "00":
	$t_min = "
	<option  selected='selected' >00</option>
	<option >15</option>
	<option >30</option>
	<option >45</option>
	";
	break;
	case "15":
	$t_min = "
	<option   >00</option>
	<option selected='selected'>15</option>
	<option >30</option>
	<option >45</option>
	";
	break;
	case "30":
	$t_min = "
	<option   >00</option>
	<option >15</option>
	<option selected='selected'>30</option>
	<option >45</option>
	";
	break;
	case "45":
	$t_min = "
	<option  >00</option>
	<option >15</option>
	<option >30</option>
	<option  selected='selected' >45</option>
	";
	break;
}

	if ($row_1[15] == "active"){
	$ac_li = "
	<input type='radio' name='type' value='active'  checked='checked' >درحال فروش بلیط &nbsp;&nbsp;&nbsp;&nbsp;
	<input type='radio' name='type' value='pending'>غیرفعال
	";
	}else{
		if ($row_1[type] == "close"){
		$ac_li = "بسته";
		}else{
		$ac_li = "
	<input type='radio' name='type' value='active'   >درحال فروش بلیط &nbsp;&nbsp;&nbsp;&nbsp;
	<input type='radio' name='type' value='pending' checked='checked'>غیرفعال
		";
		}
	}

//

$arr_list = explode(",", $row_1[18] );
$chek_car = "";
for ($i = 0; $i <= count($arr_list); $i++) {
if ($arr_list[$i]){
$r_tak_car =  mysql_fetch_array(mysql_query(" SELECT * FROM `gcms_car` WHERE `id_login` = '$_SESSION[g_id_login]' AND `type`='active' AND `id` = '$arr_list[$i]'  ",$link));
$chek_car =  $chek_car ."<div ONMOUSEOVER=\"ddrivetip('نام خودرو : $r_tak_car[name] - تعداد واحد : $r_tak_car[unit] - قیمت : $r_tak_car[fee] ریال - قیمت بار اضافه : $r_tak_car[cargo_fee] ریال ', 400)\"; ONMOUSEOUT=\"hideddrivetip()\" >$r_tak_car[name] <input type='checkbox' name='carcard[]' value='$r_tak_car[id]' checked='checked'  ></div>";
}
}
//
$rsl_list_car = mysql_query(" SELECT * FROM `gcms_car` WHERE `id_login` = '$_SESSION[g_id_login]' AND `type`='active'  ",$link);
$i= 0 ;
while ($row_list_car = mysql_fetch_array($rsl_list_car)){

if (!in_array("$row_list_car[id]", $arr_list)){
$list_car = $list_car. "<div ONMOUSEOVER=\"ddrivetip('نام خودرو : $row_list_car[name] - تعداد واحد : $row_list_car[unit] - قیمت : $row_list_car[fee] ریال - قیمت بار اضافه : $row_list_car[cargo_fee] ریال ', 400)\"; ONMOUSEOUT=\"hideddrivetip()\" >$row_list_car[name] <input type='checkbox' name='carcard[]' value='$row_list_car[id]'  ></div>" ;
}

}


$form_portman_edit_cartrade = "

<form action='?part=portman&portman=edit&edit=cartrade&id=$_REQUEST[id]&cartrade=chng' method='post' >
<table id='hor-minimalist-a-2'  >
<tbody>
	<tr>
		<td>
		مبدا سفر
		</td>
		<td>
		$mabd
		</td>
	</tr>
	<tr>
		<td>
		مقصد سفر
		</td>
		<td>
		$magh
		</td>
	</tr>
	<tr>
		<td>
		نام کشتیرانی
		</td>
		<td>
		$taksailiglist
		</td>
	</tr>
	<tr>
		<td>
		تاریخ حرکت
		</td>
		<td>
		<select name='roz' id='selectroz' >
			$dy_roz 
		</select>
		<select name='mah' id='selectroz' >
			$dy_mah
		</select>
		<select name='sal' id='selectroz' >
			$dy_sal
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ساعت حرکت
		</td>
		<td>
		<select name='min' id='selectroz' >
			$t_min
		</select>
		 : 
		<select name='hour' id='selectroz' >
			$t_hour
		</select>
		</td>
	</tr>
	<tr>
		<td>
		ظرفیت حمل خودرو(واحد) 
		</td>
		<td>
		<input type='text' name='capacity' value='$row_1[7]' class='reqd' /> 
		</td>
	</tr>
	<tr>
		<td>
		ظرفیت خالی (واحد)
		</td>
		<td>
		$row_1[8]
		</td>
	</tr>
	<tr>
		<td>
		انتخاب لیست خودروها 
		</td>
		<td>
		$chek_car
		$list_car
		</td>
	</tr>
	<tr>
		<td>
		مدت زمان سفر (دقیقه)
		</td>
		<td>
		<input type='text' name='time' value='$row_1[9]' class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		سرعت کشتی (مایل دریایی)
		</td>
		<td>
		<input type='text' name='speed' value='$row_1[10]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		قیمت چارتر (ریال)
		</td>
		<td>
		<input type='text' name='charter_fee' value='$row_1[11]'  class='reqd'/>
		</td>
	</tr>
	<tr>
		<td>
		نام کشتی 
		</td>
		<td>
		<input type='text' name='ship_name' value='$row_1[12]' class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		اطلاعات کشتی 
		</td>
		<td>
		<textarea name='ship_info' class='reqd' >$row_1[13]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		وضعیت سفر 
		</td>
		<td>
		$ac_li
		</td>
	</tr>
	<tr>
		<td>
		پیغام -1
		</td>
		<td>
		<textarea name='mess1' class='reqd' >$row_1[15]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -2
		</td>
		<td>
		<textarea name='mess2' class='reqd' >$row_1[16]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		پیغام -3
		</td>
		<td>
		<textarea name='mess3' class='reqd' >$row_1[17]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ویرایش' onMouseDown='initForms()'  >
		</td>
	</tr>
</tbody>
</table>
</form>


";
}


?>
