<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

if ($_REQUEST[edit] == "profile"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_SESSION[g_id_login]'  ",$link));
$form_admin_edit_profile = "

<form action='?part=admin&admin=edit&edit=profile&profile=chng' method='post' >
<table id='formtable'>
	<tr>
		<td>
		نام
		</td>
		<td>
		<input type='text' name='fname' value='$row_1[fname]'  class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$row_1[lname]'  class='reqd' />
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
		<textarea name='address'  class='reqd' >$row_1[address]</textarea>
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
		
		</td>
		<td>
		<input type='submit' value='ویرایش'  onMouseDown='initForms()' >
		</td>
	</tr>
</table>
</form>


";
}
if ($_REQUEST['new'] == "sailing"  ){
$form_admin_new_sailing = "

<form action='?part=admin&admin=new&new=sailing&sailing=true' method='post' >
<table id='formtable'>
	<tr>
		<td>
		نام کشتیرانی
		</td>
		<td>
		<input type='text' name='name'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد'  onMouseDown='initForms()' >
		</td>
	</tr>
</table>
</form>


";
}

if ($_REQUEST[edit] == "pass"  ){
$form_admin_edit_pass = "

<form action='?part=admin&admin=edit&edit=pass&passw=chng' method='post' >
<table id='formtable1'>
	<tr>
		<td>
		کلمه عبور جدید
		</td>
		<td>
		<input type='password' name='pass'    class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		تکرار کلمه عبور
		</td>
		<td>
		<input type='password' name='repass'    class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='تغییر'  onMouseDown='initForms()'  >
		</td>
	</tr>
</table>
</form>


";
}
if ($_REQUEST[edit] == "sailing"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_sailing where id='$_REQUEST[sailing]'  ",$link));
$form_admin_edit_sailing = "

<form action='?part=admin&admin=edit&edit=sailing&sailing=$_REQUEST[sailing]&editsailing=chng' method='post' >
<table id='formtable'>
	<tr>
		<td>
		نام کشتیرانی
		</td>
		<td>
		<input type='text' name='name' value='$row_1[name]'   class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ویرایش'   onMouseDown='initForms()'>
		</td>
	</tr>
</table>
</form>


";
}

if ($_REQUEST['new'] == "des"  ){
$form_admin_new_des = "

<form action='?part=admin&admin=new&new=des&des=true' method='post' >
<table id='formtable'>
	<tr>
		<td>
		نام شهر
		</td>
		<td>
		<input type='text' name='name'  class='reqd'   />
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد'  onMouseDown='initForms()' >
		</td>
	</tr>
</table>
</form>


";
}

if ($_REQUEST[edit] == "des"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_des where id='$_REQUEST[des]'  ",$link));
$form_admin_edit_des = "

<form action='?part=admin&admin=edit&edit=des&des=$_REQUEST[des]&editdes=chng' method='post' >
<table id='formtable'>
	<tr>
		<td>
		نام شهر
		</td>
		<td>
		<input type='text' name='name' value='$row_1[name]' class='reqd'    />
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ویرایش' onMouseDown='initForms()'  >
		</td>
	</tr>
</table>
</form>


";
}

if ($_REQUEST['new'] == "shipman"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
//$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_SESSION[g_id_login]'  ",$link));
$res_1 = mysql_query(" select * from gcms_sailing  ",$link);
while ($row_1 = mysql_fetch_array($res_1)){
$sllst = $sllst."$row_1[name] <input type='checkbox' name='sllst[]' value='$row_1[id]' checked='checked' ><br>";
}
$trkh = date("Y/m/d");
$form_admin_new_shipman = "

<form action='?part=admin&admin=new&new=shipman&shipman=true' method='post' >
<table id='formtable'>
	<tr>
		<td>
		نام مدیر
		</td>
		<td>
		<input type='text' name='fname' value='$_REQUEST[fname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$_REQUEST[lname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		<input type='text' name='melicode' value='$_REQUEST[melicode]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		<input type='text' name='email' value='$_REQUEST[email]' class='email'  />
		</td>
	</tr>
	<tr>
		<td>
		رمز عبور
		</td>
		<td>
		<input type='password' name='pass' value='$_REQUEST[pass]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address' class='reqd'  >$_REQUEST[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$_REQUEST[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$_REQUEST[cell]'  />
		</td>
	</tr>
	<tr>
		<td>
		کشتیرانی 
		</td>
		<td>
		$sllst
		</td>
	</tr>
	<tr>
		<td>
		وضعیت مدیر 
		</td>
		<td>
		<input type='radio' name='active' value='true' >فعال &nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='active' value='false' checked='checked' >غیرفعال
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$trkh
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد' onMouseDown='initForms()'  >
		</td>
	</tr>
</table>
</form>


";
}

if ($_REQUEST['new'] == "portman"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
//$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_SESSION[g_id_login]'  ",$link));
$res_1 = mysql_query(" select * from gcms_sailing  ",$link);
while ($row_1 = mysql_fetch_array($res_1)){
$sllst = $sllst."$row_1[name] <input type='checkbox' name='sllst[]' value='$row_1[id]' checked='checked' ><br>";
}
$trkh = date("Y/m/d");
$form_admin_new_portman = "

<form action='?part=admin&admin=new&new=portman&portman=true' method='post' >
<table id='formtable'>
	<tr>
		<td>
		نام مدیر
		</td>
		<td>
		<input type='text' name='fname' value='$_REQUEST[fname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$_REQUEST[lname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		<input type='text' name='melicode' value='$_REQUEST[melicode]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		<input type='text' name='email' value='$_REQUEST[email]' class='email'  />
		</td>
	</tr>
	<tr>
		<td>
		رمز عبور
		</td>
		<td>
		<input type='password' name='pass' value='$_REQUEST[pass]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address' class='reqd'  >$_REQUEST[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$_REQUEST[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$_REQUEST[cell]'  />
		</td>
	</tr>
	<tr>
		<td>
		کشتیرانی 
		</td>
		<td>
		$sllst
		</td>
	</tr>
	<tr>
		<td>
		وضعیت مدیر 
		</td>
		<td>
		<input type='radio' name='active' value='true' >فعال &nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='active' value='false' checked='checked' >غیرفعال
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$trkh
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد' onMouseDown='initForms()'  >
		</td>
	</tr>
</table>
</form>


";
}

//
if ($_REQUEST[edit] == "shipman"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_REQUEST[shipman]'  ",$link));

$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_REQUEST[shipman]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$taksailiglist = "";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
$taksailiglist =  $taksailiglist ."$r_taksailiglist[0] <input type='checkbox' name='sllst[]' value='$arrsailiglist[$i]'  checked='checked' ><br>";
}
}
$res_1_2 = mysql_query(" select * from gcms_sailing  ",$link);
while ($row_1_2 = mysql_fetch_array($res_1_2)){

if (!in_array("$row_1_2[id]", $arrsailiglist)){
$taksailiglist = $taksailiglist."$row_1_2[name] <input type='checkbox' name='sllst[]' value='$row_1_2[id]' ><br>";
}
}
if ($row_1_1[active] == "true"){
$ac_li = "فعال";
}else{
$ac_li = "غیر فعال";
}


$form_admin_edit_shipman = "

<form action='?part=admin&admin=edit&edit=shipman&shipman=$_REQUEST[shipman]&editshipman=chng' method='post' >
<table id='hor-minimalist-a-1' >
	<tbody>
	<tr>
		<td>
		نام مدیر
		</td>
		<td>
		<input type='text' name='fname' value='$row_1_1[fname]' class='reqd'   />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$row_1_1[lname]' class='reqd'   />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		$row_1_1[melicode]
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		$row_1_1[email]
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address' class='reqd'  >$row_1_1[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$row_1_1[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$row_1_1[cell]'  />
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
		وضعیت مدیر 
		</td>
		<td>
		$ac_li
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$row_1_1[regdate]
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ویرایش' onMouseDown='initForms()'>
		</td>
	</tr>
	</tbody>
</table>
</form>


";
}

//
if ($_REQUEST[edit] == "portman"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_REQUEST[portman]'  ",$link));

$sailiglist =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'sailing' and `login_id` = '$_REQUEST[portman]'  ",$link));
$arrsailiglist = explode(",", $sailiglist[value] );
$taksailiglist = "";
for ($i = 0; $i <= count($arrsailiglist); $i++) {
if ($arrsailiglist[$i]){
$r_taksailiglist =  mysql_fetch_array(mysql_query(" SELECT name FROM `gcms_sailing` WHERE `id` = '$arrsailiglist[$i]' ",$link));
$taksailiglist =  $taksailiglist ."$r_taksailiglist[0] <input type='checkbox' name='sllst[]' value='$arrsailiglist[$i]'  checked='checked' ><br>";
}
}
$res_1_2 = mysql_query(" select * from gcms_sailing  ",$link);
while ($row_1_2 = mysql_fetch_array($res_1_2)){

if (!in_array("$row_1_2[id]", $arrsailiglist)){
$taksailiglist = $taksailiglist."$row_1_2[name] <input type='checkbox' name='sllst[]' value='$row_1_2[id]' ><br>";
}
}
if ($row_1_1[active] == "true"){
$ac_li = "فعال";
}else{
$ac_li = "غیر فعال";
}


$form_admin_edit_portman = "

<form action='?part=admin&admin=edit&edit=portman&portman=$_REQUEST[portman]&editportman=chng' method='post' >
<table id='hor-minimalist-a-1' >
	<tbody>
	<tr>
		<td>
		نام مدیر
		</td>
		<td>
		<input type='text' name='fname' value='$row_1_1[fname]' class='reqd'   />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$row_1_1[lname]' class='reqd'   />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		$row_1_1[melicode]
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		$row_1_1[email]
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address' class='reqd'  >$row_1_1[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$row_1_1[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$row_1_1[cell]'  />
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
		وضعیت مدیر 
		</td>
		<td>
		$ac_li
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$row_1_1[regdate]
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ویرایش' onMouseDown='initForms()'>
		</td>
	</tr>
	</tbody>
</table>
</form>


";
}

//
if ($_REQUEST['new'] == "agency"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$trkh = date("Y/m/d");
$form_admin_new_agency = "

<form action='?part=admin&admin=new&new=agency&agency=true' method='post' >
<table id='hor-minimalist-a-1' >
<tbody>
	<tr>
		<td>
		نام آژانس
		</td>
		<td>
		<input type='text' name='agencyname' value='$_REQUEST[agencyname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		نام مدیر
		</td>
		<td>
		<input type='text' name='fname' value='$_REQUEST[fname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$_REQUEST[lname]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		<input type='text' name='melicode' value='$_REQUEST[melicode]' class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		<input type='text' name='email' value='$_REQUEST[email]' class='email' />
		</td>
	</tr>
	<tr>
		<td>
		رمز عبور
		</td>
		<td>
		<input type='password' name='pass'  class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address' class='reqd' >$_REQUEST[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$_REQUEST[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$_REQUEST[cell]'  />
		</td>
	</tr>
	<tr>
		<td>
		مبلغ اعتبار
		</td>
		<td>
		<input type='text' name='credit' value='$_REQUEST[credit]' class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		وضعیت مدیر 
		</td>
		<td>
		<input type='radio' name='active' value='true' >فعال &nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='active' value='false' checked='checked' >غیرفعال
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$trkh
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد' onMouseDown='initForms()'>
		</td>
	</tr>
</tbody>
</table>
</form>


";
}

//
if ($_REQUEST[edit] == "agency"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_REQUEST[agency]'  ",$link));

$agency_name =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'agency_name' and `login_id` = '$_REQUEST[agency]'  ",$link));

$agency_credit =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'agency_credit' and `login_id` = '$_REQUEST[agency]'  ",$link));

$agency_use =  mysql_fetch_array(mysql_query(" SELECT value FROM `gcms_metalogin` WHERE `key` = 'agency_use' and `login_id` = '$_REQUEST[agency]'  ",$link));

if ($row_1_1[active] == "true"){
$ac_li = "فعال";
}else{
$ac_li = "غیر فعال";
}


$form_admin_edit_agency = "

<form action='?part=admin&admin=edit&edit=agency&agency=$_REQUEST[agency]&editagency=chng' method='post' >
<table id='hor-minimalist-a-1' >
	<tbody>
	<tr>
		<td>
		نام آژانس
		</td>
		<td>
		<input type='text' name='agency_name' value='$agency_name[value]' class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		اعتبار
		</td>
		<td>
		<input type='text' name='agency_credit' value='$agency_credit[value]' class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		میزان مصرف
		</td>
		<td>
		$agency_use[value] ریال
		</td>
	</tr>
	<tr>
		<td>
		نام مدیر
		</td>
		<td>
		<input type='text' name='fname' value='$row_1_1[fname]' class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$row_1_1[lname]' class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		$row_1_1[melicode]
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		$row_1_1[email]
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address' class='reqd' >$row_1_1[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$row_1_1[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$row_1_1[cell]'  />
		</td>
	</tr>
	<tr>
		<td>
		وضعیت 
		</td>
		<td>
		$ac_li
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$row_1_1[regdate]
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
if ($_REQUEST[edit] == "free"  ){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
$row_1_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_REQUEST[free]'  ",$link));


if ($row_1_1[active] == "true"){
$ac_li = "فعال";
}else{
$ac_li = "غیر فعال";
}

$form_admin_edit_free = "

<form action='?part=admin&admin=edit&edit=free&free=$_REQUEST[free]&editfree=chng' method='post' >
<table id='hor-minimalist-a-1' >
	<tbody>
	<tr>
		<td>
		نام 
		</td>
		<td>
		<input type='text' name='fname' value='$row_1_1[fname]'  class='reqd'   />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$row_1_1[lname]'  class='reqd'  />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		$row_1_1[melicode]
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		$row_1_1[email]
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address'  class='reqd'  >$row_1_1[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$row_1_1[tell]'  />
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$row_1_1[cell]'  />
		</td>
	</tr>
	<tr>
		<td>
		اعتبار
		</td>
		<td>
		<input type='text' name='amount' value='$row_1_1[amount]'  /> ريال
		</td>
	</tr>
	<tr>
		<td>
		شماره حساب 
		</td>
		<td>
			$row_1_1[shomarehesab]
		</td>
	</tr>
	<tr>
		<td>
		نام صاحب حساب
		</td>
		<td>
		$row_1_1[namehesab]
		</td>
	</tr>
	<tr>
		<td>
		شماره کارت
		</td>
		<td>
			$row_1_1[shomarecard]
		</td>
	</tr>
	<tr>
		<td>
		وضعیت 
		</td>
		<td>
		$ac_li
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$row_1_1[regdate]
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


?>