<?php


//
function f_free_edit_profile(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
	if ($_REQUEST[profile] == "chng"){
	
		$_REQUEST[fname] = addslashes($_REQUEST[fname]);
		$_REQUEST[lname] = addslashes($_REQUEST[lname]);
		$_REQUEST[address] = addslashes($_REQUEST[address]);
		$_REQUEST[tell] = addslashes($_REQUEST[tell]);
		$_REQUEST[cell] = addslashes($_REQUEST[cell]);
		$up_sql = "
		UPDATE `gcms_login` SET
		`fname` =  '$_REQUEST[fname]',
		`lname` = '$_REQUEST[lname]' ,
		`address` = '$_REQUEST[address]' ,
		`tell` = '$_REQUEST[tell]' ,	
		`cell` = '$_REQUEST[cell]' ,
        `shomarehesab` = '$_REQUEST[shomarehesab]' ,
        `namehesab` = '$_REQUEST[namehesab]' ,
        `shomarecard` = '$_REQUEST[shomarecard]' 
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
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=free&free=edit&edit=profile'\",5000);</script>
		";
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formshipman.php';
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		}
	}

$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where id='$_SESSION[g_id_login]'  ",$link));

	

	$free_content = "
<form action='?part=free&free=edit&edit=profile&profile=chng' method='post' >
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
		<textarea name='address' class='reqd'  >$row_1[address]</textarea>
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
		شماره حساب
		</td>
		<td>
		<input type='text' name='shomarehesab' value='$row_1[shomarehesab]'  />
		</td>
	</tr>
	<tr>
		<td>
		نام و مشخصات صاحب حساب
		</td>
		<td>
		<input type='text' name='namehesab' value='$row_1[namehesab]'  />
		</td>
	</tr>
	<tr>
		<td>
		شماره کارت
		</td>
		<td>
		<input type='text' name='shomarecard' value='$row_1[shomarecard]'  />
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
function f_free_edit_pass(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
	if ($_REQUEST['passw'] == "chng" and $_REQUEST['pass'] and $_REQUEST['repass']){
		if ($_REQUEST['pass'] == $_REQUEST['repass']){
		$_REQUEST[pass] = addslashes($_REQUEST[pass]);
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
	$free_content = "
<form action='?part=free&free=edit&edit=pass&passw=chng' method='post' >
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
		<input type='password' name='repass'   class='reqd' />
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
function f_free_list_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
	 
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
	$pagelink = "?part=free&free=list&list=psngrtrade";
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
	$q_f = " SELECT   gcms_buypsngrtrade.id , gcms_buypsngrtrade.fname , gcms_buypsngrtrade.lname , gcms_buypsngrtrade.num , gcms_buypsngrtrade.buy_time , mabd.name , magh.name , gcms_buypsngrtrade.type , gcms_psngrtrade.date  , gcms_psngrtrade.hour 	 , gcms_buypsngrtrade.charter  ".$q_page_l." LIMIT $from, $max_results";
	 
	$r_f = mysql_query($q_f,$link);
	$i = 0 ;

	$free_content = "
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
	
	if ($row_f[10] == "true"){
	$ted_blt = "چارتر" ;
	}else{
	$ted_blt = $row_f[num]+1 ." عدد " ;
	}
	//
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
			<a href='?part=free&free=show&show=psngrtrade&psngrtrade=$r_rand$row_f[id]' >نمایش</a><br>
	" ;
	}else{
	
		if ($row_f[type] == "pending"){
		$row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
		if ( $row_get_amount['amount'] > 0 )
		{
		$amalat = "
				<a href='?part=free&free=retry&retry=psngrtrade&psngrtrade=$r_rand$row_f[id]' >سعی مجدد - آنلاین</a><br>
                
		" ;
		}else{
		$amalat = "
				<a href='?part=free&free=retry&retry=psngrtrade&psngrtrade=$r_rand$row_f[id]' >سعی مجدد - آنلاین</a><br>
                
		" ;
		}
		
		}
		else {
		$amalat = "
				<a href='?part=free&free=print&print=psngrtrade&psngrtrade=$r_rand$row_f[id]' >چاپ بلیط</a><br>
				<a href='?part=free&free=cancel&cancel=psngrtrade&psngrtrade=$r_rand$row_f[id]' >لغو بلیط</a>
		" ;
		}
	}

	$free_content = $free_content."
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
	
	$free_content = $free_content."
		</tbody>
		</table>
		<div class='clear' ></div>
		<div >$sendpage</div>
	";
	
}

//
function f_free_list_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
	 
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
	$pagelink = "?part=free&free=list&list=cartrade";
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

	$free_content = "
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
			<a href='?part=free&free=show&show=cartrade&cartrade=$r_rand$row_f[id]' >نمایش</a><br>
	" ;
	}else{
		if ($row_f[type] == "pending"){
		$amalat = "
				<a href='?part=free&free=retry&retry=cartrade&cartrade=$r_rand$row_f[id]' >سعی مجدد</a><br>
		" ;
		}
		else {
		$amalat = "
				<a href='?part=free&free=print&print=cartrade&cartrade=$r_rand$row_f[id]' >چاپ بلیط</a><br>
				<a href='?part=free&free=cancel&cancel=cartrade&cartrade=$r_rand$row_f[id]' >لغو بلیط</a>
		" ;
		}
	}

	$free_content = $free_content."
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
	
	$free_content = $free_content."
		</tbody>
		</table>
		<div class='clear' ></div>
		<div >$sendpage</div>
	";
	
}
function f_free_print_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
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
	
	$free_content = "
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
	<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=free&free=list&list=cartrade'\",5000);</script>
	";

	
}

//
function f_free_print_card(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			$_REQUEST[psngrtrade] = $id_pt;
	
	 
	$q_f = " SELECT   
	fname , lname , melicode  , email , regdate 
	FROM `gcms_login` 
	WHERE `gcms_login`.`id` = '$_SESSION[g_id_login]'
	LIMIT 0,1";
	 
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	$free_content = "
	<form name= 'print' action='cardprint.php' method='post' target='_blank' >
	<input type='hidden' name='fname' value='$row_f[0]'>
	<input type='hidden' name='lname' value='$row_f[1]'>
	<input type='hidden' name='melicode' value='$row_f[2]'>
	<input type='hidden' name='email' value='$row_f[3]'>
	<input type='hidden' name='regdate' value='$row_f[4]'>
	</form>
	<script type=\"text/javascript\" language=\"JavaScript\">
	//submit form
	document.print.submit();
	</script>
	<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=free&free=list&list=psngrtrade'\",5000);</script>
	";

	
}

//
function f_free_print_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
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
	gcms_psngrtrade.date  , gcms_psngrtrade.hour , gcms_psngrtrade.ship_name , gcms_psngrtrade.fee , gcms_psngrtrade.mess1 , gcms_psngrtrade.mess2 , gcms_psngrtrade.mess3   
	FROM `gcms_buypsngrtrade` 
	INNER JOIN `gcms_psngrtrade` ON `gcms_buypsngrtrade`.`id_psngrtrade` = `gcms_psngrtrade`.`id`
	INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
	INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
	WHERE `gcms_buypsngrtrade`.`id_login` = '$_SESSION[g_id_login]' AND `gcms_buypsngrtrade`.id = '$_REQUEST[psngrtrade]' AND  `gcms_buypsngrtrade`.type = 'active'    
	ORDER BY `gcms_buypsngrtrade`.`id`  DESC
	LIMIT 0,1";
	 
	$row_f = mysql_fetch_array(mysql_query($q_f,$link)) ;
	if ($row_f[4] > 0){
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
	$free_content = "
	<form name= 'print' action='print.php' method='post' target='_blank' >
	<input type='hidden' name='ship_name' value='$row_f[10]'>
	<input type='hidden' name='tarikh_sodor' value='$row_f[5]'>
	<input type='hidden' name='code_sodor' value='0'>
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
	<input type='hidden' name='num' value='$row_f[4]'>
	$attch
	</form>
	<script type=\"text/javascript\" language=\"JavaScript\">
	//submit form
	document.print.submit();
	</script>
	<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=free&free=list&list=psngrtrade'\",5000);</script>
	";

	
}

//
function f_free_cancel_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	//date_default_timezone_set(UCT);
	$d_t1 = jdate("G:i:s");
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
	SELECT gcms_buypsngrtrade.id_psngrtrade , gcms_psngrtrade.date , gcms_buypsngrtrade.num   , gcms_psngrtrade.free_capacity , charter , gcms_psngrtrade.capacity , gcms_buypsngrtrade.fname , gcms_buypsngrtrade.lname, gcms_buypsngrtrade.buy_time , gcms_buypsngrtrade.fee  
	FROM `gcms_buypsngrtrade`
	INNER JOIN `gcms_psngrtrade` ON `gcms_buypsngrtrade`.`id_psngrtrade` = `gcms_psngrtrade`.`id`
	WHERE gcms_buypsngrtrade.`id` = '$_REQUEST[psngrtrade]' AND gcms_buypsngrtrade.`id_login` = '$_SESSION[g_id_login]' AND gcms_buypsngrtrade.`type` = 'active'  
	";
	$row_qu_fnd = mysql_fetch_array(mysql_query($qu_fnd,$link)) ;
	
	if ($row_qu_fnd[0]){ 	
	
	if ($_REQUEST['agree'] ){
	/*
	$_REQUEST[h_name] = addslashes($_REQUEST[h_name]);
	$_REQUEST[h_no] = addslashes($_REQUEST[h_no]);
	$_REQUEST[h_bank] = addslashes($_REQUEST[h_bank]);
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
		'$_REQUEST[h_name]', 
		'$_REQUEST[h_no]', 
		'$_REQUEST[h_bank]'
		);
	";
    
	if ( mysql_query($add_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
    */
    // get amount 
    $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
    $new_amount = ($row_get_amount[0] + (int)$_REQUEST['amount']) ;

    mysql_query("UPDATE `gcms_login` SET `amount` = '$new_amount' WHERE `id` =$_SESSION[g_id_login] LIMIT 1 ;",$link);
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
	
			//////////////////////////////////email
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
		$subject = "Asaltour.ir | Ticket cancel  " ;
		$seryl = $_REQUEST[psngrtrade] + 111111;
		$jdval = "
		<table border=1  cellpadding=0 cellspacing=0 >
			<tr>
				<td width=100>
				<center><b>نام مسافر</b></center>
				</td>
				<td width=100>
				<center><b>تاریخ صدور</b></center>
				</td>
				<td width=100>
				<center><b>تاریخ حرکت</b></center>
				</td>
				<td width=250>
				<center><b>تعداد همراه</b></center>
				</td>
				<td width=100>
				<center><b>شماره سریال بلیط</b></center>
				</td>
				<td width=200>
				<center><b>تاریخ لغو</b></center>
				</td>
				
                
				<td width=200>
				<center><b>مبلغ کل</b></center>
				</td>
			</tr>
			<tr>
				<td>
				<center>$row_qu_fnd[fname] $row_qu_fnd[lname] </center>
				</td>
				<td>
				<center>$row_qu_fnd[buy_time]</center>
				</td>
				<td>
				<center>$row_qu_fnd[date]</center>
				</td>
				<td>
				<center>$row_qu_fnd[num]</center>
				</td>
				<td>
				<center>$seryl</center>
				</td>
				<td>
				 <center>$d_t2 $d_t1</center>
				</td>
				
                
				<td>
				 <center>$row_qu_fnd[fee] ریال</center>
				</td>
			</tr>
			</table>
		";
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 کاربر گرامی  $_SESSION[g_name_login] $_SESSION[g_email_login] <br>



مبلغ کنسلی برابر 
$_REQUEST[amount] ريال
به اعتبار شما واریز شد

		<br><br>
$jdval 
<br>
ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br /></div><img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$_SESSION[g_email_login]" ,"support@asaltour.ir",$text,$subject,$messmail);
		$row_f_m = mysql_fetch_array(mysql_query("SELECT email FROM `gcms_login` WHERE `type` = 'admin' LIMIT 0 , 1",$link)) ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 مدیر کل محترم سایت <br />

یکی از مشتریان بلیط خود را به مشخصات زیر کنسل نموده است.بلیط مورد نظر کنسل شده و به ظرفیت کشتی مورد نظر اضافه شده است.این ایمیل
جهت اطلاع شما ارسال شده است
		<br><br>
$jdval 
<br>
ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br /></div><img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_m[0]" ,"support@asaltour.ir",$text,$subject,$messmail);
			//////////////////////////////////email
	
	}else{
	$error_message = "
	مشکل در لغو بلیط .
	";
	}
	}else{	 
	$q_f = " SELECT   
	gcms_buypsngrtrade.id , gcms_buypsngrtrade.fname , gcms_buypsngrtrade.lname , gcms_buypsngrtrade.mcode, gcms_buypsngrtrade.num , gcms_buypsngrtrade.buy_time ,  
	mabd.name , magh.name  , 
	gcms_psngrtrade.date  , gcms_psngrtrade.hour , gcms_psngrtrade.ship_name , gcms_buypsngrtrade.fee , gcms_psngrtrade.mess1 , gcms_psngrtrade.mess2 , gcms_psngrtrade.mess3  , gcms_buypsngrtrade.darsad_cancel , gcms_buypsngrtrade.cancel_fee 
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
			/////
			$fnd_ghann = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '17' ",$link));
			$fnd_ghann[page_content] = strip_tags($fnd_ghann[page_content]);
			/////
	$free_content = "
	<form action='?part=free&free=cancel&cancel=psngrtrade&psngrtrade=$old_url&agree=true' method='post' >
	آیا می خواهید بلیط با مشخصات زیر را لغو کنید ؟  <br>
	تاریخ صدور : $tarikh_sodor[2] / $tarikh_sodor[1] / $tarikh_sodor[0] <br>
	شماره سریال :  $row_f[0] <br>
	نام :  $row_f[1] <br>
	نام خانوادگی : $row_f[2] <br>
	کد ملی : $row_f[3] <br>
	مسیر :  $row_f[6] - $row_f[7] <br>
	تاریخ و ساعت حرکت : $row_f[8] | $row_f[9]<br>
	مبلغ  : $row_f[11] <br> 
    <br />
    <b> مبلغ  ". number_format($row_f[11]-$row_f[16]) ."  ریال به اعتبار شما اضافه می گردد </b>
    <br />
	<b>ساعت لغو بلیط : $d_t1</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>تاریخ لغو بلیط : $show_d_t2</b><br>
    
    <!--
	برای برگشت وجه به حساب شما لازم است اطلاعات زیر را تکمیل نمایید : 
	<br>
	<input type='text' name='h_name'   class='reqd' />  نام بانک<br>
	<input type='text' name='h_no'  class='reqd' />  شماره حساب<br>
	<input type='text' name='h_bank' class='reqd' />  نام صاحب حساب<br>
		-->	
    <input type='hidden' name='amount' value='".($row_f[11]-$row_f[16])."' />
			تایید اطلاعات &raquo;<input type='checkbox' onclick=\"if (this.checked){this.form.tr.disabled=0}else{this.form.tr.disabled=1}\">
			<input name='tr' type='submit' disabled='1' value='با توجه به تمامی موارد می خواهم بلیط را لغو کنم !' onMouseDown='initForms()' >
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
function f_free_cancel_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
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
	SELECT gcms_buycartrade.id_cartrade , gcms_cartrade.date , gcms_buycartrade.num   , gcms_cartrade.free_capacity  , car.max_cap , charter , gcms_cartrade.capacity , gcms_buycartrade.fname , gcms_buycartrade.lname, gcms_buycartrade.buy_time , gcms_buycartrade.fee 
	FROM `gcms_buycartrade`
	INNER JOIN `gcms_cartrade` ON `gcms_buycartrade`.`id_cartrade` = `gcms_cartrade`.`id`
	INNER JOIN `gcms_car` AS car ON `gcms_buycartrade`.`id_car` = `car`.`id`
	WHERE gcms_buycartrade.`id` = '$_REQUEST[cartrade]' AND gcms_buycartrade.`id_login` = '$_SESSION[g_id_login]' AND gcms_buycartrade.`type` = 'active'  
	";
	$row_qu_fnd = mysql_fetch_array(mysql_query($qu_fnd,$link)) ;

	if ($row_qu_fnd[0]){ 	
	
	if ($_REQUEST['agree'] ){
		/*
	$_REQUEST[h_name] = addslashes($_REQUEST[h_name]);
	$_REQUEST[h_no] = addslashes($_REQUEST[h_no]);
	$_REQUEST[h_bank] = addslashes($_REQUEST[h_bank]);
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
		'$_REQUEST[h_name]', 
		'$_REQUEST[h_no]', 
		'$_REQUEST[h_bank]'
		);
	";
	if ( mysql_query($add_qu_cncl,$link)){
	$scs = true ; 
	}else{
	$scs = false ;
	}
    */
    // get amount 
    $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
    $new_amount = ($row_get_amount[0] + (int)$_REQUEST['amount']) ;

    mysql_query("UPDATE `gcms_login` SET `amount` = '$new_amount' WHERE `id` =$_SESSION[g_id_login] LIMIT 1 ;",$link);
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



			//////////////////////////////////email
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
		$subject = "Asaltour.ir | Ticket cancel  " ;
		$seryl = $_REQUEST[cartrade] + 111111;
		$jdval = "
		<table border=1  cellpadding=0 cellspacing=0 >
			<tr>
				<td width=100>
				<center><b>نام مسافر</b></center>
				</td>
				<td width=100>
				<center><b>تاریخ صدور</b></center>
				</td>
				<td width=100>
				<center><b>تاریخ حرکت</b></center>
				</td>
				<td width=250>
				<center><b>تعداد همراه</b></center>
				</td>
				<td width=100>
				<center><b>شماره سریال بلیط</b></center>
				</td>
				<td width=200>
				<center><b>تاریخ لغو</b></center>
				</td>
				
				<td width=200>
				<center><b>مبلغ کل</b></center>
				</td>
			</tr>
			<tr>
				<td>
				<center>$row_qu_fnd[fname] $row_qu_fnd[lname] </center>
				</td>
				<td>
				<center>$row_qu_fnd[buy_time]</center>
				</td>
				<td>
				<center>$row_qu_fnd[date]</center>
				</td>
				<td>
				<center>$row_qu_fnd[num]</center>
				</td>
				<td>
				<center>$seryl</center>
				</td>
				<td>
				 <center>$d_t2 $d_t1</center>
				</td>
				
				<td>
				 <center>$row_qu_fnd[fee] ریال</center>
				</td>
			</tr>
			</table>
		";
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 کاربر گرامی  $_SESSION[g_name_login] $_SESSION[g_email_login] <br>

مبلغ کنسلی برابر 
$_REQUEST[amount] ريال
به اعتبار شما واریز شد

		<br><br>
$jdval 
<br>
ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br /></div><img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$_SESSION[g_email_login]" ,"support@asaltour.ir",$text,$subject,$messmail);
		$row_f_m = mysql_fetch_array(mysql_query("SELECT email FROM `gcms_login` WHERE `type` = 'admin' LIMIT 0 , 1",$link)) ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 مدیر کل محترم سایت <br />

یکی از مشتریان بلیط خود را به مشخصات زیر کنسل نموده است.بلیط مورد نظر کنسل شده و به ظرفیت کشتی مورد نظر اضافه شده است.این ایمیل فقط جهت اطلاع شما ارسال شده است

		<br><br>
$jdval 
<br>
ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br /></div><img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_m[0]" ,"support@asaltour.ir",$text,$subject,$messmail);
			//////////////////////////////////email
			

	
	}else{
	$error_message = "
	مشکل در لغو بلیط .
	";
	}
	}else{	 
	$q_f = " SELECT   
	gcms_buycartrade.id , gcms_buycartrade.fname , gcms_buycartrade.lname , gcms_buycartrade.mcode, gcms_buycartrade.num , gcms_buycartrade.buy_time ,  
	mabd.name , magh.name  , 
	gcms_cartrade.date  , gcms_cartrade.hour , gcms_cartrade.ship_name , gcms_buycartrade.fee , gcms_cartrade.mess1 , gcms_cartrade.mess2 , gcms_cartrade.mess3 , gcms_buycartrade.cancel_fee   
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
			/////
			$fnd_ghann = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '17' ",$link));
			$fnd_ghann[page_content] = strip_tags($fnd_ghann[page_content]);
			/////
	$free_content = "
	<form action='?part=free&free=cancel&cancel=cartrade&cartrade=$old_url&agree=true' method='post' >
	آیا می خواهید بلیط با مشخصات زیر را لغو کنید ؟  <br>
	تاریخ صدور : $tarikh_sodor[2] / $tarikh_sodor[1] / $tarikh_sodor[0] <br>
	شماره سریال :  $row_f[0] <br>
	نام :  $row_f[1] <br>
	نام خانوادگی : $row_f[2] <br>
	کد ملی : $row_f[3] <br>
	مسیر :  $row_f[6] - $row_f[7] <br>
	تاریخ و ساعت حرکت : $row_f[8] | $row_f[9]<br>
	مبلغ  : $row_f[11] ريال<br>
    <b>مبلغی که به شما برگشت داده می شود  :". number_format($row_f[11]-$row_f[15]) ." ريال</b>   
    
    <br />
    
	<b>ساعت لغو بلیط : $d_t1</b>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>تاریخ لغو بلیط : $show_d_t2</b><br>
	
    <!--
	برای برگشت وجه به حساب شما لازم است اطلاعات زیر را تکمیل نمایید : 
	<br>
    
	<input type='text' name='h_name'   class='reqd' />  نام بانک<br>
	<input type='text' name='h_no'  class='reqd' />  شماره حساب<br>
	<input type='text' name='h_bank' class='reqd' />  نام صاحب حساب<br>
	-->
			<input type='hidden' name='amount' value='".($row_f[11]-$row_f[15])."' />

			تایید اطلاعات &raquo;<input type='checkbox' onclick=\"if (this.checked){this.form.tr.disabled=0}else{this.form.tr.disabled=1}\">
			<input name='tr' type='submit' disabled='1' value='با توجه به تمامی موارد می خواهم بلیط را لغو کنم !' onMouseDown='initForms()' >
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
function f_free_show_psngrtrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
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
	gcms_buypsngrtrade.num , gcms_psngrtrade.mess2 , gcms_psngrtrade.mess3   
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
	
	$free_content = "
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
	قیمت بلیط : $row_f[11] ریال
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	تعداد همراه : $row_f[12] نفر
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<b>جمع کل : $kol_fee ریال</b>
	</center>
	<b>نام مسافر</b> : $row_f[1] <br><br>
	<b>نام خانوادگی</b> : $row_f[2] <br><br>
	<b>کد ملی</b> : $row_f[3] <br><br>
	
	";

	
}

//
function f_free_show_cartrade(){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;
	
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
	
	$free_content = "
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
function f_free_retry_psngrtrade(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;

	
			//
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			
			$q_f_r = "
			SELECT fee 
			FROM gcms_buypsngrtrade
			WHERE `id` = '$id_pt' AND `id_login`='$_SESSION[g_id_login]' AND `type` = 'pending' 
			LIMIT 0 , 1
			";
			$row_f_r = mysql_fetch_array(mysql_query($q_f_r,$link)) ;
			if ($row_f_r[0]){
			 if (!isset($_REQUEST['shop']))
                {
			$f_free_retry = "
			<center>بلیط شما رزو شده است شما باید مبلغ <b>$row_f_r[0]</b> ریال را بپردازید . </center><br />
			
				<form name= 'order' action='https://pna.shaparak.ir/CardServices' method='post'>
			<input type='hidden' id='Amount' name='Amount' value='$row_f_r[0]'>
			<input type='hidden' id='MID' name='MID' value='00109713-128933'>
			<input type='hidden' id='ResNum' name='ResNum' value='psngrtrade-$id_pt'>
			<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&stage=4'>
			</form>
			<script type=\"text/javascript\" language=\"JavaScript\">
			//submit form
			document.order.submit();
			</script>
			<br />
			در صورت عدم پرداخت مبلغ فوق تا 1 ساعت دیگر رزور شما باطل می گردد.
		";
                 }else{
                    $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
                   if ($row_get_amount[0]<$jam_fee){
                       $f_free_retry = "
                        اعتبار شما کمتر از مبلغ بلیط می باشد.
                   ";
                    }else{
                        
                        $new_amount = ($row_get_amount[0] - $row_f_r[0]) ;

   mysql_query("UPDATE `gcms_login` SET `amount` = '$new_amount' WHERE `id` =$_SESSION[g_id_login] LIMIT 1 ;",$link);
   $up_qu_buypsngrtrade = "UPDATE `gcms_buypsngrtrade` SET `type` = 'active'  WHERE `gcms_buypsngrtrade`.`id` = '$id_pt' AND `gcms_buypsngrtrade`.`id_login` = '$_SESSION[g_id_login]' LIMIT 1 ;";
			
				mysql_query($up_qu_buypsngrtrade,$link);
                       $f_free_retry = "
                       مبلغ 
                       $row_f_r[0] ريال
                       از اعتبار شما کسر گردید .  <br />
                        خرید با استفاده از اعتبار تایید شد.
                        
                   ";
                   
                    }
                    
                                     
                 }                    
			//
			$free_content = "$f_free_retry";
			}else{
			$error_message = "شما اجازه دسترسی به این صفحه را ندارید ";
			}
			
	
}

//
function f_free_retry_cartrade(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;

	
			//
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			$q_f_r = "
			SELECT fee
			FROM gcms_buycartrade
			WHERE `id` = '$id_pt' AND `id_login`='$_SESSION[g_id_login]' AND `type` = 'pending' 
			LIMIT 0 , 1
			";
			$row_f_r = mysql_fetch_array(mysql_query($q_f_r,$link)) ;
			if ($row_f_r[0]){
			$f_free_retry = "
			<center>بلیط شما رزو شده است شما باید مبلغ <b>$row_f_r[0]</b> ریال را بپردازید . </center><br />
			
				<form name= 'order' action='https://pna.shaparak.ir/CardServices' method='post'>
			<input type='hidden' id='Amount' name='Amount' value='$row_f_r[0]'>
			<input type='hidden' id='MID' name='MID' value='00109713-128933'>
			<input type='hidden' id='ResNum' name='ResNum' value='cartrade-$id_pt'>
			<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&stage=4'>
			</form>
			<script type=\"text/javascript\" language=\"JavaScript\">
			//submit form
			document.order.submit();
			</script>
			<br />
			در صورت عدم پرداخت مبلغ فوق تا 1 ساعت دیگر رزور شما باطل می گردد.
		";
			//
			$free_content = "$f_free_retry";
			}else{
			$error_message = "شما اجازه دسترسی به این صفحه را ندارید ";
			}
			

			
	
}

//
function f_free_retry_amount(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$free_content;

	if (isset($_REQUEST['back']))
    {
        if ( $_REQUEST[ResNum] and $_REQUEST[RefNum]  ){
				//
				$arr_ResNum = explode("-",  $_REQUEST['ResNum'] );
				$ttype = $arr_ResNum[0];
				$tid = $arr_ResNum[1];
				//
				$client = new SoapClient("https://pna.shaparak.ir/ref-payment/jax/merchantAuth?wsdl");
				$result = $client->VerifyTransaction("$_REQUEST[RefNum]", "00109713-128933");
				
				if ( $result <= 0 )
				{
				$err_mess = 'خطا : کد خطا '.$result;
				}

				if ( $_REQUEST[State] == "OK" and $result > 0 ){
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
				
					if ( mysql_query($q_a_prdxt,$link) ){
					    $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
                        $new_amount = ($row_get_amount[0] + $result) ;

   mysql_query("UPDATE `gcms_login` SET `amount` = '$new_amount' WHERE `id` =$_SESSION[g_id_login] LIMIT 1 ;",$link);

                        
					$success_message =  " مبلغ $result  ریال واریز گردید . <br> با تشکر از شما ";	
					
		
		$subject = "Asaltour.ir | Payment successful " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
کاربر گرامی  $_SESSION[g_name_login] $_SESSION[g_email_login] <br>

با عرض تشکر از جنابعالی ، مبلغ $result ریال طی پرداخت آنلاین به رسید دیجیتالی  $_REQUEST[RefNum] به حساب ما واریز شد.

<br>
	 
	 ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
		sendmail("$_SESSION[g_email_login]" ,"support@asaltour.ir",$text,$subject,$messmail);
		sendmail("info@asaltour.ir" ,"support@asaltour.ir",$text,$subject,$messmail);
					
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
 			//
		
			$f_free_retry = "
			<center>
            مبلغی را که می خواهید به صورت آنلاین به اعتبار خود اضافه کنید را در فیلد مربوطه به ریال وارد نمایید 
            </center><br />
			
				<form name= 'order' action='https://pna.shaparak.ir/CardServices' method='post'>
			مبلغ <input type='text' id='Amount' name='Amount' value=''> ریال
			<input type='hidden' id='MID' name='MID' value='00109713-128933'>
			<input type='hidden' id='ResNum' name='ResNum' value='amount-$id_pt'>
			<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=free&free=retry&retry=amount&back=true'> <br />
            <input type='submit' value='پرداخت' >
			</form>
			
			
		";
			//
			$free_content = "$f_free_retry";
			
       
    }
			

			
	
}


?>