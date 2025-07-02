<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?PHP
	error_reporting(E_ALL ^ E_NOTICE);
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
// تعیین ارسال خبرنامه

// تعریف کوئری
	$query_nwslt_num = "SELECT * FROM `gcms_setting` WHERE  setting_name='nwslt_num' ";
// نتایج کوئری
	$result_nwslt_num = mysql_query($query_nwslt_num,$link);
// دریافت نتایج در سطر	
	$row_nwslt_num = mysql_fetch_array($result_nwslt_num);
	
// تعریف کوئری
	$query_nwslt_from = "SELECT * FROM `gcms_setting` WHERE  setting_name='email' ";
// نتایج کوئری
	$result_nwslt_from = mysql_query($query_nwslt_from,$link);
// دریافت نتایج در سطر	
	$row_nwslt_from = mysql_fetch_array($result_nwslt_from);
	

	if ($row_nwslt_num[2] == 0){
	// do nothing
    die();
	}else{
	//ارسال به تمامی ایمیل های فعال
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/mail.php';
// تعریف کوئری
	$query_nwslt = "SELECT * FROM `gcms_sentmail` WHERE  id='$row_nwslt_num[2]' ";
// نتایج کوئری
	$result_nwslt = mysql_query($query_nwslt,$link);
// دریافت نتایج در سطر	
	$row_nwslt = mysql_fetch_array($result_nwslt);
	
		$subject = $row_nwslt[subject];
		$body = $row_nwslt[body];

// تعریف کوئری
	$query_limit = "SELECT * FROM `gcms_setting` WHERE  setting_name='limit_nwsltr' ";
// نتایج کوئری
	$result_limit = mysql_query($query_limit,$link);
// دریافت نتایج در سطر	
	$row_limit = mysql_fetch_array($result_limit);
	
	if ($row_limit[2] == 0){
	$x = 0;
	$y = 1;
	}else{
	$x = $row_limit[2];
	$y = $row_limit[2];
	}

// تعریف کوئری
	$queryum = "SELECT * FROM `gcms_newsletter` WHERE status='open' LIMIT $x , $y ";
// نتایج کوئری
	$resultum = mysql_query($queryum,$link);
// دریافت نتایج در سطر	
	while($rowum = mysql_fetch_array($resultum)){
		
		//  کوئری
		$query_ins_rel = "INSERT INTO `gcms_relationships_newsletter_sentmail` (  `id_newsletter` , `id_sentmail` )	VALUES ( '$rowum[0]', '$row_nwslt_num[2]'	)";
		mysql_query($query_ins_rel,$link);


		$text = "
		<center><div style='font-family:Tahoma; font-size:12px; direction:rtl ;' >
<font color=red > <b> لطفا تا انتهای عملیات ارسال ایمیل ها صبر کنید و پیجره را نبندید </b></font>
</div><br><img src='/gcms/admin-gcms/images/load.gif'  /></center><br><br>
		<div style='font-family:Tahoma; font-size:12px; direction:rtl ; padding-right:50px' >
 در حال ارسال ایمیل به کاربر $rowum[1]  با ایمیل $rowum[2] 
</div>
";
		echo " $text";
			$t= $x+1;

		// تعریف کوئری
			$querycont = "SELECT COUNT(*) FROM `gcms_newsletter` WHERE status='open'  ";
		// نتایج کوئری
			$resultcont = mysql_query($querycont,$link);
		// دریافت نتایج در سطر	
			$rowcont = mysql_fetch_array($resultcont);
			
			if ($rowcont[0] == $t){
		$queryup = "UPDATE gcms_setting SET setting_value='0'  WHERE setting_name = 'limit_nwsltr' ";
			
			mysql_query($queryup,$link);
		$queryupnn = "UPDATE gcms_setting SET setting_value='0'  WHERE setting_name = 'nwslt_num' ";
			
			mysql_query($queryupnn,$link);
			$body = "<div align='right' style='direction:rtl ;' > <font face='Tahoma' >
			<br>کاربر گرامی $rowum[1] <br>
			 ".$body." <br><br><br>
			 <small>
			 این خبرنامه به صورت خودکار برای شما ارسال شده است . در صورتی که مایل نیستید خبرنامه را دریافت کنید با ما تماس بگیرید تا آدرس ایمیل شما را از لیست افراد در خبرنامه حذف کنیم
			 <br>
			 <a href='http://gatriya.com' >
			 ارسال شده توسط سیستم ارسال خبرنامه گاتریا - gcms
			 </a>
			 </small>
			 </font></div>";
			sendmail($rowum[2],$row_nwslt_from[2],$body,$subject,$messmail);
			echo "<center><div style='font-family:Tahoma; font-size:12px; direction:rtl ;' >
<font color=red > <b>پایان </b></font>
</div><br><a href='javascript:window.close();'> X لطفا پنجره را ببندید </a></center>";
			
			}else{
		$queryup = "UPDATE gcms_setting SET setting_value='$t'  WHERE setting_name = 'limit_nwsltr' ";
		$baghim = $rowcont[0]-$t;
		$tbaghim = ($baghim)*50/60;
			echo "<div style='font-family:Tahoma; font-size:12px; direction:rtl ; padding-right:50px' >
 تعداد $t نفر تا کنون برایشان ایمیل ارسال شده و تعداد باقیمانده  $baghim نفر می باشد .زمان باقیمانده برابر است با $tbaghim دقیقه 
</div>";
			mysql_query($queryup,$link);
			$body = "<div align='right' > <font face='Tahoma' >
			<br>کاربر گرامی $rowum[1] <br>
			 ".$body." <br><br><br>
			 <small>
			 این خبرنامه به صورت خودکار برای شما ارسال شده است . در صورتی که مایل نیستید خبرنامه را دریافت کنید با ما تماس بگیرید تا آدرس ایمیل شما را از لیست افراد در خبرنامه حذف کنیم
			 <br>
			 <a href='http://gatriya.com' >
			 ارسال شده توسط سیستم ارسال خبرنامه گاتریا - gcms
			 </a>
			 </small>
			 </font></div>";
			sendmail($rowum[2],$row_nwslt_from[2],$body,$subject,$messmail);
			echo "<BODY onLoad=window.setTimeout(\"location.href='mailnewslt.php'\",50000)>
			</BODY>";
			}

	}
	
	}


	// بستن ارتباط
	mysql_close($link);

?>

