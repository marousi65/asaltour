<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
if ( $_REQUEST['signout'] == 'true' ){
		$_SESSION['g_id_login']    = "0";
		$_SESSION['g_ip_login']    = "" ;
		$_SESSION['g_t_login']     = "" ;
		$_SESSION['g_name_login']  = "" ;
		$_SESSION['g_email_login'] = "" ;
		$_SESSION['g_agency_credit'] = "" ;
		$_SESSION['g_agency_use'] = "" ;
		$_SESSION['g_agency_name'] = "" ;
		echo "
		<script type=\"text/javascript\">window.location = \"?part=page&id=1\"</script>
		";
}
if ($_REQUEST['email'] != '' && $_REQUEST['pass'] != '' && $_REQUEST['signin'] == 'true' ){
	$_REQUEST[email] = addslashes($_REQUEST[email]);

	$row_1 = mysql_fetch_array(mysql_query(" select * from gcms_login where email='$_REQUEST[email]' AND active='true' ",$link));

	if ( $row_1 ){

		if( crypt($_REQUEST[pass], $row_1[pass]) == $row_1[pass] ){

		$_SESSION['g_id_login'] = $row_1[id];
		$_SESSION['g_ip_login'] =$_SERVER['REMOTE_ADDR'] ;
		$_SESSION['g_t_login'] = $row_1[type];
		$_SESSION['g_name_login'] = $row_1[fname] . " " . $row_1[lname];
		$_SESSION['g_email_login'] = $row_1[email];
		
		if ($row_1[type] == "agency" ){
		$row_2 = mysql_fetch_array(mysql_query("select value FROM `gcms_metalogin` where `login_id`='$row_1[id]' AND `key` = 'agency_credit' ",$link));
		$_SESSION['g_agency_credit'] = $row_2[value];
		//
		$row_3 = mysql_fetch_array(mysql_query(" select value FROM `gcms_metalogin` where `login_id`='$row_1[id]' AND `key` = 'agency_use' ",$link));
		$_SESSION['g_agency_use'] = $row_3[value];
		//
		$row_4 = mysql_fetch_array(mysql_query(" select value FROM `gcms_metalogin` where `login_id`='$row_1[id]' AND `key` = 'agency_name' ",$link));
		$_SESSION['g_agency_name'] = $row_4[value];
		}
		echo "
		<script type=\"text/javascript\">window.location = \"?part=page&id=1\"</script>
		";
		}
		else{
	
		$_SESSION['g_id_login'] = "0";
		$error_message = "کلمه عبور اشتباه است.";
		}

	}else{
		$_SESSION['g_id_login'] = "0";
		$error_message = "نام کاربری اشتباه است.";
	}
// بستن ارتباط با جدول
	mysql_close($link);
// end login

}



/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('error_message', $error_message ); 

			$gcms->assign('menu_active',"?part=signin"); 
			$gcms->assign('part',"signin"); 
			$gcms->assign('page_title',"ورود به سایت"); 
			$gcms->display("index/index.tpl");
	
	

?>