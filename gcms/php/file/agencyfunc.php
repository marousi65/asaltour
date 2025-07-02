<?php


//
function f_agency_edit_profile(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
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
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=agency&agency=edit&edit=profile'\",5000);</script>
		";
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
	}

$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_SESSION[g_id_login]'  ",$link));

	

	$agency_content = "
<form action='?part=agency&agency=edit&edit=profile&profile=chng' method='post' >
<table id='hor-minimalist-a-1' >
<tbody>
	<tr>
		<td>
		نام آژانس
		</td>
		<td>
		$_SESSION[g_agency_name]
		</td>
	</tr>
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
function f_agency_edit_pass(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
	if ($_REQUEST['passw'] == "chng" and $_REQUEST['pass'] and $_REQUEST['repass']){
		if ($_REQUEST['pass'] == $_REQUEST['repass']){
			$newpass = crypt($_REQUEST[pass]);
			$up_sql = "
			UPDATE `gcms_login` SET
			`pass` = '$newpass' 
			WHERE `gcms_login`.`id` =$_SESSION[g_id_login] LIMIT 1 
			";
			if ( mysql_query($up_sql,$link) ){
			$success_message = "اطلاعات زیر با موفقیت به روز رسانی شد<br>
			کلمه عبور جدید : $_REQUEST[pass]
			<center>
			<img src='/gcms/images/load.gif' width='120' height='160' >
			</center>
			<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=agency&agency=edit&edit=pass'\",5000);</script>
			 ";
			}else{
			$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
			}
		}else{
			$error_message = "کلمات عبور هماهنگ نبود لطفا دوباره تلاش کنید. ";
		}
	}
	$agency_content = "
<form action='?part=agency&agency=edit&edit=pass&passw=chng' method='post' >
<table id='formtable1'>
	<tr>
		<td>
		کلمه عبور جدید
		</td>
		<td>
		<input type='password' name='pass'  class='reqd'  />
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
function f_agency_list_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
	 
	$q_page_l = " FROM `gcms_buypsngrtrade` 
	INNER JOIN `gcms_psngrtrade` ON `gcms_buypsngrtrade`.`id_psngrtrade` = `gcms_psngrtrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	WHERE `gcms_buypsngrtrade`.`id_login` = '$_SESSION[g_id_login]'  
	ORDER BY `gcms_buypsngrtrade`.`id`  DESC  ";

	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = "20"; 
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num $q_page_l "),0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=agency&agency=list&list=psngrtrade";
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
	$q_f = " SELECT   gcms_buypsngrtrade.id , gcms_buypsngrtrade.fname , gcms_buypsngrtrade.lname , gcms_buypsngrtrade.num , gcms_buypsngrtrade.buy_time , mabd.name , magh.name , gcms_buypsngrtrade.type , gcms_psngrtrade.date  , gcms_psngrtrade.hour , gcms_buypsngrtrade.charter  ".$q_page_l." LIMIT $from, $max_results";
	 
	$r_f = mysql_query($q_f,$link);
	$i = 0 ;

	$agency_content = "
	<table id='hor-minimalist-a' >
		<thead>
		<tr>
			<td>
			<center>
			<b>نام مسافر</b>
			</center>
			</td>
			<td>
			<center>
			<b>تعداد بلیط</b>
			</center>
			</td>
			<td>
			<center>
			<b>تاریخ خرید</b>
			</center>
			</td>
			<td>
			<center>
			<b>مسیر</b>
			</center>
			</td>
			<td>
			<center>
			<b>تاریخ حرکت</b>
			</center>
			</td>
			<td>
			<center>
			<b>وضعیت بلیط</b>
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
	while($row_f = mysql_fetch_array($r_f)){
	//
	if ($row_f[10]){
	$ted_blt = "چارتر" ;
	}else{
	$ted_blt = $row_f[num]+1 ." عدد " ;
	}
	//
	$arr_trkh_kharid = explode("-", $row_f['buy_time'] );
	$trkh_kharid = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	//
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

	//
	if ($row_f[type] == "active" ){
	$type = "پرداخت شده";
	}else{
		if ($row_f[type] == "cancel" ){
		$type = "لغو شده";
		$batel = true ;
		}else{
		$type = "تراکنش ناموفق";
		}
	}
	$tarikh_date = time();
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
	$tarikh_mrooz = jdate2("y-m-d",$tarikh_date);
	if ( $row_f[8] < $tarikh_mrooz ) {
		$batel = true ;
	}
	//
	if ($batel){
	$amalat = "
			<a href='?part=agency&agency=show&show=psngrtrade&psngrtrade=$r_rand$row_f[id]' >نمایش</a><br>
	" ;
	}else{
	$amalat = "
			<a href='?part=agency&agency=print&print=psngrtrade&psngrtrade=$r_rand$row_f[id]' >چاپ بلیط</a><br>
			<a href='?part=agency&agency=cancel&cancel=psngrtrade&psngrtrade=$r_rand$row_f[id]' >لغو بلیط</a>
	" ;
	}

	$agency_content = $agency_content."
		<tr>
			<td>
			<center>
			$row_f[fname] $row_f[lname] 
			</center>
			</td>
			<td>
			<center>
			$ted_blt
			</center>
			</td>
			<td>
			<center>
			$trkh_kharid[0]/$trkh_kharid[1]/$trkh_kharid[2]
			</center>
			</td>
			<td>
			<center>
			$row_f[5]-$row_f[6]
			</center>
			</td>
			<td>
			<center>
			$row_f[8] | $row_f[9]
			</center>
			</td>
			<td>
			<center>
			$type 
			</center>
			</td>
			<td>
			<center>
			$amalat
			</center>
			</td>
		</tr>

	";
		$i++;
	}
	
	$agency_content = $agency_content."
		</tbody>
		</table>
		<div class='clear' ></div>
		<div >$sendpage</div>
	";
	
}


//
function f_agency_print_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			$_REQUEST[psngrtrade] = $id_pt;
	
	 
	$q_f = " SELECT   
	gcms_buypsngrtrade.id , gcms_buypsngrtrade.fname , gcms_buypsngrtrade.lname , gcms_buypsngrtrade.mcode, gcms_buypsngrtrade.num , gcms_buypsngrtrade.buy_time , 
	mabd.name , magh.name  , 
	gcms_psngrtrade.date  , gcms_psngrtrade.hour , gcms_psngrtrade.ship_name , gcms_psngrtrade.fee , gcms_psngrtrade.mess1 , gcms_psngrtrade.mess2 , gcms_psngrtrade.mess3   , gcms_buypsngrtrade.num
	FROM `gcms_buypsngrtrade` 
	INNER JOIN `gcms_psngrtrade` ON `gcms_buypsngrtrade`.`id_psngrtrade` = `gcms_psngrtrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	WHERE `gcms_buypsngrtrade`.`id_login` = '$_SESSION[g_id_login]' AND `gcms_buypsngrtrade`.id = '$_REQUEST[psngrtrade]' AND  `gcms_buypsngrtrade`.type = 'active'    
	ORDER BY `gcms_buypsngrtrade`.`id`  DESC
	LIMIT 0,1";
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	if ($row_f[15] > 0){
		$q_f_h = "SELECT * FROM `gcms_metabuy` WHERE `id_buy` = '$row_f[0]' AND `type` = 'psngrtrade' ";
		$r_f_h = mysql_query($q_f_h,$link) ;
		$inum = 1 ;
		while($row_f_h = mysql_fetch_array($r_f_h)){
		$attch = $attch."<input type='hidden' name='hm_fname$inum' value='$row_f_h[3]'> " ;
		$attch = $attch."<input type='hidden' name='hm_lname$inum' value='$row_f_h[4]'> " ;
		$attch = $attch."<input type='hidden' name='hm_mcode$inum' value='$row_f_h[5]'> " ;
		++$inum ;
		}
	 }
	$agency_content = "
	<form name= 'print' action='print.php' method='post' target='_blank' >
	<input type='hidden' name='ship_name' value='$row_f[10]'>
	<input type='hidden' name='tarikh_sodor' value='$row_f[5]'>
	<input type='hidden' name='code_sodor' value='$_SESSION[g_id_login]'>
	<input type='hidden' name='seryal' value='$row_f[0]'>
	<input type='hidden' name='fname' value='$row_f[1]'>
	<input type='hidden' name='lname' value='$row_f[2]'>
	<input type='hidden' name='mcode' value='$row_f[3]'>
	<input type='hidden' name='mabd' value='$row_f[6]'>
	<input type='hidden' name='maghsd' value='$row_f[7]'>
	<input type='hidden' name='tarikh_harkat' value='$row_f[8]'>
	<input type='hidden' name='saat_harekat' value='$row_f[9]'>
	<input type='hidden' name='fee' value='$row_f[11]'>
	<input type='hidden' name='mess1' value='$row_f[12]'>
	<input type='hidden' name='mess2' value='$row_f[13]'>
	<input type='hidden' name='mess3' value='$row_f[14]'>
	<input type='hidden' name='num' value='$row_f[15]'>
	$attch
	</form>
	<script type=\"text/javascript\" language=\"JavaScript\">
	//submit form
	document.print.submit();
	</script>
	<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=agency&agency=list&list=psngrtrade'\",5000);</script>
	";

	
}

//
function f_agency_print_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			$_REQUEST[cartrade] = $id_pt;
	

	$q_f = " SELECT   
	gcms_buycartrade.id ,gcms_buycartrade.fname  ,gcms_buycartrade.lname  ,gcms_buycartrade.mcode , gcms_buycartrade.num , gcms_buycartrade.fee , gcms_buycartrade.certificate , gcms_buycartrade.model , gcms_buycartrade.plate ,  gcms_buycartrade.shasi , gcms_buycartrade.buy_time  , 
	mabd.name , magh.name  , 
	gcms_cartrade.date , gcms_cartrade.hour , gcms_cartrade.ship_name  , gcms_cartrade.mess1 ,  gcms_cartrade.mess2 ,  gcms_cartrade.mess3 , 
	gcms_car.name 
	FROM `gcms_buycartrade` 
	INNER JOIN `gcms_cartrade` ON `gcms_buycartrade`.`id_cartrade` = `gcms_cartrade`.`id`
	INNER JOIN `gcms_car` ON `gcms_buycartrade`.`id_car` = `gcms_car`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
	WHERE `gcms_buycartrade`.`id_login` = '$_SESSION[g_id_login]'  AND `gcms_buycartrade`.`id` = '$_REQUEST[cartrade]'
	ORDER BY `gcms_buycartrade`.`id`  DESC
	LIMIT 0,1";
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	
	if ($row_f[4] > 0){
		$q_f_h = "SELECT * FROM `gcms_metabuy` WHERE `id_buy` = '$row_f[0]' AND `type` = 'cartrade' ";
		$r_f_h = mysql_query($q_f_h,$link) ;
		$inum = 1 ;
		while($row_f_h = mysql_fetch_array($r_f_h)){
		$attch = $attch."<input type='hidden' name='hm_fname$inum' value='$row_f_h[3]'> " ;
		$attch = $attch."<input type='hidden' name='hm_lname$inum' value='$row_f_h[4]'> " ;
		$attch = $attch."<input type='hidden' name='hm_mcode$inum' value='$row_f_h[5]'> " ;
		++$inum ;
		}
	 }
	$arr_trkh_kharid = explode("-",  $row_f[5] );
	$tarikh_sodor = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	$row_f[0] = $row_f[0]+111111 ;
	$kol_fee =  ( $row_f[12]+1 )* $row_f[11];
	
	$agency_content = "
	<form name= 'print' action='carprint.php' method='post' target='_blank' >
	<input type='hidden' name='ship_name' value='$row_f[15]'>
	<input type='hidden' name='tarikh_sodor' value='$row_f[10]'>
	<input type='hidden' name='code_sodor' value='$_SESSION[g_id_login]'>
	<input type='hidden' name='seryal' value='$row_f[0]'>
	<input type='hidden' name='fname' value='$row_f[1]'>
	<input type='hidden' name='lname' value='$row_f[2]'>
	<input type='hidden' name='mcode' value='$row_f[3]'>
	<input type='hidden' name='certificate' value='$row_f[6]'>
	<input type='hidden' name='num' value='$row_f[4]'>
	<input type='hidden' name='carname' value='$row_f[19]'>
	<input type='hidden' name='plate' value='$row_f[8]'>
	<input type='hidden' name='model' value='$row_f[7]'>
	<input type='hidden' name='shasi' value='$row_f[9]'>
	<input type='hidden' name='mabd' value='$row_f[11]'>
	<input type='hidden' name='maghsd' value='$row_f[12]'>
	<input type='hidden' name='tarikh_harkat' value='$row_f[13]'>
	<input type='hidden' name='saat_harekat' value='$row_f[14]'>
	<input type='hidden' name='fee' value='$row_f[5]'>
	<input type='hidden' name='mess1' value='$row_f[16]'>
	<input type='hidden' name='mess2' value='$row_f[17]'>
	<input type='hidden' name='mess3' value='$row_f[18]'>
	</form>
	<script type=\"text/javascript\" language=\"JavaScript\">
	//submit form
	document.print.submit();
	</script>
	<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=agency&agency=list&list=cartrade'\",5000);</script>
	";

	
}

//
function f_agency_show_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			$_REQUEST[psngrtrade] = $id_pt;
	
	 
	$q_f = " SELECT   
	gcms_buypsngrtrade.id , gcms_buypsngrtrade.fname , gcms_buypsngrtrade.lname , gcms_buypsngrtrade.mcode, gcms_buypsngrtrade.num , gcms_buypsngrtrade.buy_time , 
	mabd.name , magh.name  , 
	gcms_psngrtrade.date  , gcms_psngrtrade.hour , gcms_psngrtrade.ship_name , gcms_psngrtrade.fee ,
	gcms_buypsngrtrade.num , gcms_psngrtrade.mess2 , gcms_psngrtrade.mess3  , gcms_buypsngrtrade.charter , gcms_psngrtrade.charter_fee
	FROM `gcms_buypsngrtrade` 
	INNER JOIN `gcms_psngrtrade` ON `gcms_buypsngrtrade`.`id_psngrtrade` = `gcms_psngrtrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	WHERE `gcms_buypsngrtrade`.`id_login` = '$_SESSION[g_id_login]' AND `gcms_buypsngrtrade`.id = '$_REQUEST[psngrtrade]'     
	ORDER BY `gcms_buypsngrtrade`.`id`  DESC
	LIMIT 0,1";
	 
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	
	$arr_trkh_kharid = explode("-",  $row_f[5] );
	$tarikh_sodor = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	$row_f[0] = $row_f[0]+111111 ;
	$kol_fee =  ( $row_f[12]+1 )* $row_f[11];
	
			if ($row_f[charter] == "true" )
			{
			$charternum ="
	قیمت بلیط : $row_f[charter_fee] ریال
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	بلیط چارتر
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>جمع کل : $row_f[charter_fee]	 ریال</b>
			";
			}else{
			$charternum ="
	قیمت بلیط : $row_f[11] ریال
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	تعداد همراه : $row_f[12] نفر
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>جمع کل : $kol_fee ریال</b>
			";
			}
	
	
	$agency_content = "
	<center>
	تاریخ صدور بلیط :
	$tarikh_sodor[2] / $tarikh_sodor[1] / $tarikh_sodor[0] 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	شماره سریال بلیط :  $row_f[0]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	نام کشتی : $row_f[10]
	<br>
	مبدا : $row_f[6]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	مقصد : $row_f[7]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	تاریخ حرکت: $row_f[8]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	ساعت حرکت : $row_f[9]
	<br>	
	$charternum
	</center>
	<b>نام مسافر</b> : $row_f[1] <br><br>
	<b>نام خانوادگی</b> : $row_f[2] <br><br>
	<b>کد ملی</b> : $row_f[3] <br><br>
	
	";

	
}


//
function f_agency_cancel_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	//date_default_timezone_set(UCT);
	$d_t1 = date("G:i:s");
	$d_t2 = date("Y-n-j");
	$show_d_t2 = jdate("Y-n-j");
			//
			$old_url = $_REQUEST[psngrtrade];
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			$_REQUEST[psngrtrade] = $id_pt;
	$qu_fnd = "
	SELECT gcms_buypsngrtrade.id_psngrtrade , gcms_psngrtrade.date , gcms_buypsngrtrade.num   , gcms_psngrtrade.free_capacity  , charter , gcms_psngrtrade.capacity
	FROM `gcms_buypsngrtrade`
	INNER JOIN `gcms_psngrtrade` ON `gcms_buypsngrtrade`.`id_psngrtrade` = `gcms_psngrtrade`.`id`
	WHERE gcms_buypsngrtrade.`id` = '$_REQUEST[psngrtrade]' AND gcms_buypsngrtrade.`id_login` = '$_SESSION[g_id_login]' AND gcms_buypsngrtrade.`type` = 'active'  
	";
	$row_qu_fnd = mysql_fetch_array(mysql_query($qu_fnd,$link)) ;
	
	if ($row_qu_fnd[0]){ 	
	
	if ($_REQUEST['agree'] ){
		
	//
	$add_qu_cncl = "
		INSERT INTO `gcms_cancel` (
		`type` ,
		`id_buy` ,
		`hour` ,
		`date` ,
		`h_name` ,
		`h_no` ,
		`h_bank`
		)
		VALUES (
		'psngrtrade', 
		'$_REQUEST[psngrtrade]', 
		'$d_t1', 
		'$d_t2', 
		'agency', 
		'agency', 
		'agency'
		);
	";
	if ( mysql_query($add_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
	//
	$up1_qu_cncl = "
	UPDATE `gcms_buypsngrtrade` SET `type` = 'cancel' WHERE `gcms_buypsngrtrade`.`id` =$_REQUEST[psngrtrade] LIMIT 1 ;
	";
	if ( mysql_query($up1_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
	
	//
	if ($row_qu_fnd[charter] == "true"){
	$new_cap = $row_qu_fnd[capacity] ;
	}else{
	$new_cap = $row_qu_fnd[free_capacity] + 1 + $row_qu_fnd[num] ;
	}
	$up2_qu_cncl = "
	UPDATE `gcms_psngrtrade` SET `free_capacity` = '$new_cap' WHERE `gcms_psngrtrade`.`id` =$row_qu_fnd[id_psngrtrade] LIMIT 1 ;
	";
	if ( mysql_query($up2_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
	
	
	//
	if ($scs){
	$success_message = "
	لغو بلیط با موفقیت انجام شد . 
	";
	}else{
	$error_message = "
	مشکل در لغو بلیط .
	";
	}
	}else{	 
	$q_f = " SELECT   
	gcms_buypsngrtrade.id , gcms_buypsngrtrade.fname , gcms_buypsngrtrade.lname , gcms_buypsngrtrade.mcode, gcms_buypsngrtrade.num , gcms_buypsngrtrade.buy_time ,  
	mabd.name , magh.name  , 
	gcms_psngrtrade.date  , gcms_psngrtrade.hour , gcms_psngrtrade.ship_name , gcms_buypsngrtrade.fee , gcms_psngrtrade.mess1 , gcms_psngrtrade.mess2 , gcms_psngrtrade.mess3   
	FROM `gcms_buypsngrtrade` 
	INNER JOIN `gcms_psngrtrade` ON `gcms_buypsngrtrade`.`id_psngrtrade` = `gcms_psngrtrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	WHERE `gcms_buypsngrtrade`.`id_login` = '$_SESSION[g_id_login]' AND `gcms_buypsngrtrade`.id = '$_REQUEST[psngrtrade]' AND  `gcms_buypsngrtrade`.type = 'active'    
	ORDER BY `gcms_buypsngrtrade`.`id`  DESC
	LIMIT 0,1";
	 
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	$arr_trkh_kharid = explode("-", $row_f[5] );
	$tarikh_sodor = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	$row_f[0] =  $row_f[0]+111111 ;
	
	if ($row_qu_fnd[charter] == "true"){
	$add_chrtr_1 = "
	 بلیط چاتر  <br> 
 	";
	}else{
	
	}
			/////
			$fnd_ghann = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '17' ",$link));
			$fnd_ghann[page_content] = strip_tags($fnd_ghann[page_content]);
			/////
	$agency_content = "
	<form action='?part=agency&agency=cancel&cancel=psngrtrade&psngrtrade=$old_url&agree=true' method='post' >
	آیا می خواهید بلیط با مشخصات زیر را لغو کنید ؟  <br>
    $add_chrtr_1 	تاریخ صدور : $tarikh_sodor[2] / $tarikh_sodor[1] / $tarikh_sodor[0] <br>
	شماره سریال :  $row_f[0] <br>
	نام :  $row_f[1] <br>
	نام خانوادگی : $row_f[2] <br>
	کد ملی : $row_f[3] <br>
	مسیر :  $row_f[6] - $row_f[7] <br>
	تاریخ و ساعت حرکت : $row_f[8] | $row_f[9]<br>
	مبلغ  : $row_f[11] <br>
	<b>ساعت لغو بلیط : $d_t1</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>تاریخ لغو بلیط : $show_d_t2</b><br>
	<!-- 
	برای برگشت وجه به حساب شما لازم است اطلاعات زیر را تکمیل نمایید : 
	<br>
	<input type='text' name='tell' value='نام بانک'  /><br>
	<input type='text' name='tell' value='شماره حساب'  /><br>
	<input type='text' name='tell' value='نام صاحب حساب'  /><br>
	!-->
			

			تایید اطلاعات &raquo;<input type='checkbox' onclick=\"if (this.checked){this.form.tr.disabled=0}else{this.form.tr.disabled=1}\">
			<input name='tr' type='submit' disabled='1' value='با توجه به تمامی موارد می خواهم بلیط را لغو کنم !' >
			</form>
			<br>
			<textarea name='roll' readonly='readonly' id='txarroll'  disabled='disabled' >$fnd_ghann[page_content]</textarea>

	";
	}
	}else{
	$error_message = "
	شما اجازه دسترسی به این بخش را ندارید
	";
	}
	
}

//
function f_agency_list_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
	 
	$q_page_l = " FROM `gcms_buycartrade` 
	INNER JOIN `gcms_cartrade` ON `gcms_buycartrade`.`id_cartrade` = `gcms_cartrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_car` AS car ON `gcms_buycartrade`.`id_car` = `car`.`id`
	WHERE `gcms_buycartrade`.`id_login` = '$_SESSION[g_id_login]'  
	ORDER BY `gcms_buycartrade`.`id`  DESC  ";

	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = "20"; 
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num $q_page_l "),0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=agency&agency=list&list=cartrade";
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
	$q_f = " SELECT   gcms_buycartrade.id , gcms_buycartrade.fname , gcms_buycartrade.lname , gcms_buycartrade.num , gcms_buycartrade.buy_time , mabd.name , magh.name , gcms_buycartrade.type , gcms_cartrade.date  , gcms_cartrade.hour , car.name	  ".$q_page_l." LIMIT $from, $max_results";
	 
	$r_f = mysql_query($q_f,$link);
	$i = 0 ;

	$agency_content = "
	<table id='hor-minimalist-a' >
		<thead>
		<tr>
			<td>
			<center>
			<b>نام مسافر</b>
			</center>
			</td>
			<td>
			<center>
			<b>تعداد همراه</b>
			</center>
			</td>
			<td>
			<center>
			<b>نوع ماشین</b>
			</center>
			</td>
			<td>
			<center>
			<b>تاریخ خرید</b>
			</center>
			</td>
			<td>
			<center>
			<b>مسیر</b>
			</center>
			</td>
			<td>
			<center>
			<b>تاریخ حرکت</b>
			</center>
			</td>
			<td>
			<center>
			<b>وضعیت بلیط</b>
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
	while($row_f = mysql_fetch_array($r_f)){
	//
	$ted_blt = $row_f[num] ;
	//
	$arr_trkh_kharid = explode("-", $row_f['buy_time'] );
	$trkh_kharid = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	//
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

	//
	if ($row_f[type] == "active" ){
	$type = "پرداخت شده";
	}else{
		if ($row_f[type] == "cancel" ){
		$type = "لغو شده";
		$batel = true ;
		}else{
		$type = "تراکنش ناموفق";
		}
	}
	$tarikh_date = time();
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
	$tarikh_mrooz = jdate2("y-m-d",$tarikh_date);
	if ( $row_f[8] < $tarikh_mrooz ) {
		$batel = true ;
	}
	//
	if ($batel){
	$amalat = "
			<a href='?part=agency&agency=show&show=cartrade&cartrade=$r_rand$row_f[id]' >نمایش</a><br>
	" ;
	}else{
	$amalat = "
			<a href='?part=agency&agency=print&print=cartrade&cartrade=$r_rand$row_f[id]' >چاپ بلیط</a><br>
			<a href='?part=agency&agency=cancel&cancel=cartrade&cartrade=$r_rand$row_f[id]' >لغو بلیط</a>
	" ;
	}

	$agency_content = $agency_content."
		<tr>
			<td>
			<center>
			$row_f[fname] $row_f[lname] 
			</center>
			</td>
			<td>
			<center>
			$ted_blt نفر
			</center>
			</td>
			<td>
			<center>
			$row_f[10]
			</center>
			</td>
			<td>
			<center>
			$trkh_kharid[0]/$trkh_kharid[1]/$trkh_kharid[2]
			</center>
			</td>
			<td>
			<center>
			$row_f[5]-$row_f[6]
			</center>
			</td>
			<td>
			<center>
			$row_f[8] | $row_f[9]
			</center>
			</td>
			<td>
			<center>
			$type 
			</center>
			</td>
			<td>
			<center>
			$amalat
			</center>
			</td>
		</tr>

	";
		$i++;
	}
	
	$agency_content = $agency_content."
		</tbody>
		</table>
		<div class='clear' ></div>
		<div >$sendpage</div>
	";
	
}


//
function f_agency_cancel_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	//date_default_timezone_set(UCT);
	$d_t1 = jdate("G:i:s");
	$d_t2 = date("Y-n-j");
	$show_d_t2 = jdate("Y-n-j");

			//
			$old_url = $_REQUEST[cartrade];
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			$_REQUEST[cartrade] = $id_pt;
	$qu_fnd = "
	SELECT gcms_buycartrade.id_cartrade , gcms_cartrade.date , gcms_buycartrade.num   , gcms_cartrade.free_capacity  , car.max_cap , charter , gcms_cartrade.capacity
	FROM `gcms_buycartrade`
	INNER JOIN `gcms_cartrade` ON `gcms_buycartrade`.`id_cartrade` = `gcms_cartrade`.`id`
	INNER JOIN `gcms_car` AS car ON `gcms_buycartrade`.`id_car` = `car`.`id`
	WHERE gcms_buycartrade.`id` = '$_REQUEST[cartrade]' AND gcms_buycartrade.`id_login` = '$_SESSION[g_id_login]' AND gcms_buycartrade.`type` = 'active'  
	";
	$row_qu_fnd = mysql_fetch_array(mysql_query($qu_fnd,$link)) ;

	if ($row_qu_fnd[0]){ 	
	
	if ($_REQUEST['agree'] ){
		
	//
	$add_qu_cncl = "
		INSERT INTO `gcms_cancel` (
		`type` ,
		`id_buy` ,
		`hour` ,
		`date` ,
		`h_name` ,
		`h_no` ,
		`h_bank`
		)
		VALUES (
		'cartrade', 
		'$_REQUEST[cartrade]', 
		'$d_t1', 
		'$d_t2', 
		'agency', 
		'agency', 
		'agency'
		);
	";
	if ( mysql_query($add_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
	//
	$up1_qu_cncl = "
	UPDATE `gcms_buycartrade` SET `type` = 'cancel' WHERE `gcms_buycartrade`.`id` =$_REQUEST[cartrade] LIMIT 1 ;
	";
	if ( mysql_query($up1_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
	
	//
	if ($row_qu_fnd[charter] == "true"){
	$new_cap = $row_qu_fnd[capacity] ;
	}else{
	$new_cap = $row_qu_fnd[free_capacity] + $row_qu_fnd[4] ;
	}
	$up2_qu_cncl = "
	UPDATE `gcms_cartrade` SET `free_capacity` = '$new_cap' WHERE `gcms_cartrade`.`id` =$row_qu_fnd[id_cartrade] LIMIT 1 ;
	";
	if ( mysql_query($up2_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
	
	
	//
	if ($scs){
	$success_message = "
	لغو بلیط با موفقیت انجام شد . 
	";
	}else{
	$error_message = "
	مشکل در لغو بلیط .
	";
	}
	}else{	 
	$q_f = " SELECT   
	gcms_buycartrade.id , gcms_buycartrade.fname , gcms_buycartrade.lname , gcms_buycartrade.mcode, gcms_buycartrade.num , gcms_buycartrade.buy_time ,  
	mabd.name , magh.name  , 
	gcms_cartrade.date  , gcms_cartrade.hour , gcms_cartrade.ship_name , gcms_buycartrade.fee , gcms_cartrade.mess1 , gcms_cartrade.mess2 , gcms_cartrade.mess3   
	FROM `gcms_buycartrade` 
	INNER JOIN `gcms_cartrade` ON `gcms_buycartrade`.`id_cartrade` = `gcms_cartrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
	WHERE `gcms_buycartrade`.`id_login` = '$_SESSION[g_id_login]' AND `gcms_buycartrade`.id = '$_REQUEST[cartrade]' AND  `gcms_buycartrade`.type = 'active'    
	ORDER BY `gcms_buycartrade`.`id`  DESC
	LIMIT 0,1";
	 
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	$arr_trkh_kharid = explode("-", $row_f[5] );
	$tarikh_sodor = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	$row_f[0] =  $row_f[0]+111111 ;
	if ($row_qu_fnd[charter] == "true"){
	$add_chrtr_1 = "
	 بلیط چاتر  <br> 
 	";
	}else{
	
	}
	
			/////
			$fnd_ghann = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '17' ",$link));
			$fnd_ghann[page_content] = strip_tags($fnd_ghann[page_content]);
			/////
	$agency_content = "
	<form action='?part=agency&agency=cancel&cancel=cartrade&cartrade=$old_url&agree=true' method='post' >
	آیا می خواهید بلیط با مشخصات زیر را لغو کنید ؟  <br>
	$add_chrtr_1  تاریخ صدور : $tarikh_sodor[2] / $tarikh_sodor[1] / $tarikh_sodor[0] <br>
	شماره سریال :  $row_f[0] <br>
	نام :  $row_f[1] <br>
	نام خانوادگی : $row_f[2] <br>
	کد ملی : $row_f[3] <br>
	مسیر :  $row_f[6] - $row_f[7] <br>
	تاریخ و ساعت حرکت : $row_f[8] | $row_f[9]<br>
	مبلغ  : $row_f[11] <br>
	<b>ساعت لغو بلیط : $d_t1</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>تاریخ لغو بلیط : $show_d_t2</b><br>
	<!-- 
	برای برگشت وجه به حساب شما لازم است اطلاعات زیر را تکمیل نمایید : 
	<br>
	<input type='text' name='tell' value='نام بانک'  /><br>
	<input type='text' name='tell' value='شماره حساب'  /><br>
	<input type='text' name='tell' value='نام صاحب حساب'  /><br>
	--!>
			

			تایید اطلاعات &raquo;<input type='checkbox' onclick=\"if (this.checked){this.form.tr.disabled=0}else{this.form.tr.disabled=1}\">
			<input name='tr' type='submit' disabled='1' value='با توجه به تمامی موارد می خواهم بلیط را لغو کنم !' >
			</form>
			<br>
			<textarea name='roll' readonly='readonly' id='txarroll'  disabled='disabled' >$fnd_ghann[page_content]</textarea>

	";
	}
	}else{
	$error_message = "
	شما اجازه دسترسی به این بخش را ندارید
	";
	}
	
}

//
function f_agency_show_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			$_REQUEST[cartrade] = $id_pt;
	
	 
	$q_f = " SELECT   
	gcms_buycartrade.id , gcms_buycartrade.fname , gcms_buycartrade.lname , gcms_buycartrade.mcode, gcms_buycartrade.num , gcms_buycartrade.buy_time , 
	mabd.name , magh.name  , 
	gcms_cartrade.date  , gcms_cartrade.hour , gcms_cartrade.ship_name , car.name , car.fee , car.cargo_fee , car.fee_cap ,
	  gcms_buycartrade.weigh 	 ,gcms_buycartrade.fee 
	FROM `gcms_buycartrade` 
	INNER JOIN `gcms_cartrade` ON `gcms_buycartrade`.`id_cartrade` = `gcms_cartrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
	INNER JOIN `gcms_car` AS car ON `gcms_buycartrade`.`id_car` = `car`.`id`
	WHERE `gcms_buycartrade`.`id_login` = '$_SESSION[g_id_login]' AND `gcms_buycartrade`.id = '$_REQUEST[cartrade]'     
	ORDER BY `gcms_buycartrade`.`id`  DESC
	LIMIT 0,1";
	 
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	
	$arr_trkh_kharid = explode("-",  $row_f[5] );
	$tarikh_sodor = gregorian_to_jalali($arr_trkh_kharid[0] , $arr_trkh_kharid[1] , $arr_trkh_kharid[2] );
	$row_f[0] = $row_f[0]+111111 ;
	$kol_fee =  ( $row_f[12]+1 )* $row_f[11];
	
	$agency_content = "
	<center>
	تاریخ صدور بلیط :
	$tarikh_sodor[2] / $tarikh_sodor[1] / $tarikh_sodor[0] 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	شماره سریال بلیط :  $row_f[0]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	نام کشتی : $row_f[10]
	<br>
	مبدا : $row_f[6]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	مقصد : $row_f[7]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	تاریخ حرکت: $row_f[8]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	ساعت حرکت : $row_f[9]
	<br>
	وسیله نقیله: $row_f[11]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	مقدار بار اضافه: $row_f[15]
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	قیمت هر تن بار اضافه: $row_f[13] ریال
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<br>	
	قیمت بلیط : $row_f[12] ریال
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	تعداد همراه : $row_f[4] نفر
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	قیمت بلیط همراه : $row_f[14] ریال
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>جمع کل :$row_f[16] ریال</b>
	</center>
	<b>نام مسافر</b> : $row_f[1] <br><br>
	<b>نام خانوادگی</b> : $row_f[2] <br><br>
	<b>کد ملی</b> : $row_f[3] <br><br>
	
	";

	
}

//
function f_agency_old(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$agency_content;
	if ($_REQUEST[del]){
		$success_message = "
		مسافر ، $_SESSION[g_customer_name_buy] ، از لیست خرید حذف شد .
		";
	$_SESSION['g_customer_id_buy'] = "";
	$_SESSION['g_customer_name_buy'] = "";
	$_SESSION['g_customer_type_buy'] = "";
	$_SESSION['g_customer_mcode_buy'] ="";
	
	}
	if ($_REQUEST[mcode]){
	$q_f = " 
	SELECT id,fname,lname,state,city,address,cell,tell
	FROM `gcms_".$_REQUEST[table]."`
	WHERE `id_login` = '$_SESSION[g_id_login]' AND `mcode` = '$_REQUEST[mcode]'
	LIMIT 0,1";
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	
		if ($row_f[0]){
		$success_message = "
		نام مسافر : $row_f[1] $row_f[2]<br>
		آدرس :  $row_f[3] - $row_f[4] - $row_f[5]<br>
		تلفن : $row_f[6]<br>
		موبایل : $row_f[7]<br>
		<br>
		&gt;&gt; <a href='?part=agency&agency=old&add=true&mcode=$_REQUEST[mcode]&table=$_REQUEST[table]' >می خواهم برای $row_f[1] $row_f[2] بلیط بگیرم ! </a><br><br>
		";
			echo "f";
			if ($_REQUEST[add]){
			$_SESSION['g_customer_id_buy'] = $row_f[0];
			$_SESSION['g_customer_name_buy'] = "$row_f[1] $row_f[2] ";
			$_SESSION['g_customer_type_buy'] = "gcms_".$_REQUEST[table];
			$success_message = "
			خرید های شما برای مسافر \" $row_f[1] $row_f[2] \" انجام می شود . <br>
			&gt;&gt; <a href='?part=agency&agency=old&del=true' >حذف $row_f[1] $row_f[2] از لیست خرید </a><br><br>
			";
			}
		
		}else{
		$error_message = "
		آژانس شما چنین مسافری را قبلا ثبت نکرده است .
		";
		}
	}
	$agency_content = "
	<br>جستجوی قدیمی مسافر با استفاده از کد ملی : <br><br><br>
	<form action='?part=agency&agency=old' method='post' >
		کد ملی مسافر :
		<input type='text' name='mcode' value='$_REQUEST[mcode]' class='reqd' />
		<input type='submit' value='جستجو' onMouseDown='initForms()' >
		<br>
		<input type='radio' name='table' value='buypsngrtrade' checked='checked' />در خریدهای مسافربری
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input type='radio' name='table' value='buycartrade'  />در خریدهای لندیگرافت
		
	</form>
	<br><br><br><br><br><br>
	";

	
}

//
function f_agency_prdxt(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	if($_GET['c'] == "c")
    {
        echo "<script type=\"text/javascript\">
                setTimeout(\"window.location = '?part=agency&agency=prdxt'\",1);
                </script>";
    }
	global $error_message,$success_message,$agency_content;
	if ($_REQUEST[prdxt] and $_REQUEST[id] ){
		
		if ($_REQUEST[id] == $_SESSION[g_id_login]){
			if ( $_REQUEST[ResNum] and $_REQUEST[RefNum] and $_REQUEST[State]  ){
				//
                
				$client = new SoapClient("https://modern.enbank.net/ref-payment/ws/ReferencePayment?WSDL");
				$result = $client->VerifyTransaction("$_REQUEST[RefNum]", "00109713-128933");
				
				if ( $result <= 0 )
				{
				$err_mess = 'خطا : کد خطا '.$result;
				}
                $q_v = "
                SELECT * FROM `gcms_prdxt` WHERE `RefNum` = '$_REQUEST[RefNum]' 
                ";
                $r_v = mysql_fetch_array(mysql_query($q_v,$link));
				if ( $_REQUEST[State] == "OK" and $result > 0 and !$r_v[0]  ){
				   
				//date_default_timezone_set(UCT);
				$d_t1 = jdate("G:i:s");
				$d_t2 = jdate("Y/n/j");

				$q_a_prdxt = " 
				INSERT INTO `gcms_prdxt` (
				`id_login` ,
				`RefNum` ,
				`fee` ,
				`date`
				)
				VALUES (
				'$_SESSION[g_id_login]', 
				'$_REQUEST[RefNum]',
				'$result', 
				'$d_t2 $d_t1'
				)
				";
				if ( mysql_query($q_a_prdxt,$link)){
				$success_message =  " مبلغ $result  ریال واریز گردید . <br> با تشکر از شما 
                <script type=\"text/javascript\">
                setTimeout(\"window.location = '?part=agency&agency=prdxt'\",3000);
                </script>
                ";	

		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
		$subject = "Asaltour.ir | Payment " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 آژانس محترم $_SESSION[g_agency_name] <br />

 با عرض تشکر از جنابعالی ، مبلغ $result ریال طی پرداخت آنلاین به رسید دیجیتالی   $_REQUEST[RefNum] به حساب ما واریز شد.لازم به ذکر است که در صورت اینکه به مدت 12 ساعت اعتبار سیستم شما افزوده نشد با شماره پشتیبانی 091999999 تماس حاصل فرمائید. $d_t2 $d_t1
	
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$_SESSION[g_email_login]" ,"support@asaltour.ir",$text,$subject,$messmail);
		$subject2 = "Asaltour.ir | Agency Payment  " ;
		$row_f_m = mysql_fetch_array(mysql_query("SELECT email FROM `gcms_login` WHERE `type` = 'admin' LIMIT 0 , 1",$link)) ;
		$text2 = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
   مدیر کل محترم <br />

به اطلاع جنابعالی می رسانیم که  آزانس $_SESSION[g_agency_name] مبلغ $result  ریال طی رسید دیجیتالی  $_REQUEST[RefNum] واریز آنلاین به سیستم داشته اند.خواهشمندیم جهت افزایش اعتبار این اژانس اقدام فرمائید.
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_m[0]" ,"support@asaltour.ir",$text2,$subject2,$messmail);
        
				
				}else{
				$error_message = "
				مشکل در سیستم :
				حتما اطلاعات زیر را یادداشت کنید و به مدیر سیستم اطلاع دهید :<br>
				شماره ارجاع : $_REQUEST[RefNum] <br>
				مبلغ واریزی : $result ریال<br>
				تاریخ : $d_t2 $d_t1 <br>
				";
				}
				}else{
				$error_message = "
				مبلغ واریزی تایید نشد . <br>
				$err_mess 
				";
				}
				//
			}else{
			$error_message = "
			مشکل در دریافت اطلاعات
			";
			}
		}else{
		$error_message = "
		شما اجازه دسترسی به این بخش را ندارید.
		";
		}

	}
    if ($_SESSION['success_message'])
    {
        $success_message = $_SESSION['success_message'];
        $_SESSION['success_message'] = "";
    }
	$numberformatg_agency_use = number_format($_SESSION[g_agency_use]);
	$baghimande_poll = number_format($_SESSION[g_agency_credit] - $_SESSION[g_agency_use]) ;
	
	$q_p = " 
	SELECT *
	FROM `gcms_prdxt` 
	WHERE `id_login` = '$_SESSION[g_id_login]' 
	";
	$r_p = mysql_query($q_p,$link) ;
	$i = 1 ;
	while ($row_p = mysql_fetch_array($r_p)){
	$row_p[fee] = number_format($row_p[fee]) ;
	$prx = $prx." $i - مبلغ $row_p[fee] ریال در تاریخ $row_p[date] <br> ";
	++$i;
	}
	$agency_content = "
	
	<br>
	اعتبار مصرفی شما : $numberformatg_agency_use ریال<br>
	باقی مانده اعتبار شما  : $baghimande_poll ریال <br>
	<br>لطفا مبلغ پرداختی خود را به ریال وارد کنید : <br><br><br>
		
	<form name= 'order' action='https://modern.enbank.net/CardServices/controller' method='post'>
		<input type='hidden' id='MID' name='MID' value='00109713-128933'>
		<input type='hidden' id='ResNum' name='ResNum' value='agency_prdxt'>
		<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=agency&agency=prdxt&prdxt=true&id=$_SESSION[g_id_login]'>
		مبلغ 
		<input type='text' id='Amount' name='Amount'  class='reqd' /> ریال 
		<input type='submit' value='پرداخت' onMouseDown='initForms()' >
		<br>
	</form>
	<br><br>
	<b>لیست پرداخت های شما : </b> <br>
	$prx
	<br><br><br><br>
	";

	
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

	
	
	$admin_content = "

	<form target='_blank' action='/gcms/report.php?report=cncl' method='post' >
	<select name='shiptype' >
			<option value='psngrtrade'  >کشتی مسافربری</option>
			<option value='cartrade'  >کشتی لندیگرافت</option>
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
for ($i = 1389; $i <= jdate('Y')+1; $i++) {
	if ($_REQUEST[sal] == "$i" ){$sel_sal = " selected='selected' "; }else{$sel_sal = " "; }
    $dy_sal = $dy_sal. "
	<option $sel_sal>$i</option>
	";
}

	//
	$sai_name = mysql_query("SELECT *  FROM `gcms_sailing` ",$link);
	$i = 0;
	while ($row_sai_name = mysql_fetch_array($sai_name)){
	if ($_REQUEST[sail_name] == "$row_sai_name[id]" ){$sel_sail_name = " selected='selected' "; }else{$sel_sail_name = " "; }
	$sel_sai_name = $sel_sai_name ."<option value='$row_sai_name[id]' $sel_sail_name>$row_sai_name[name]</option>";
	$i++;
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

//
function f_admin_repalist(){
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
for($i = 1389; $i <= jdate('Y')+1; $i++) {
    $dy_sal = $dy_sal. "
	<option>$i</option>
	";
}

	
	
	$admin_content = "

	<form target='_blank' action='/gcms/report.php?report=alist' method='post' >
		<img src='/gcms/images/blank.gif' width='38' height='1'> 
		<select name='shiptype' >
			<option value='psngrtrade' >کشتی مسافربری</option>
			<option value='cartrade' >کشتی لندیگرافت</option>
		</select>
		<img src='/gcms/images/blank.gif' width='70' height='1'> 
		<select name='sail_name' >
			<option value='$_SESSION[g_id_login]' >$_SESSION[g_agency_name]</option>
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



?>


