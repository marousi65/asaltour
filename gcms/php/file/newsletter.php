<?php
if ($pluginsetup[newsletter]){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

if ( $_REQUEST[email]  ){

	//security////////////////////////
	$sec30time = time()-30;
	if (mysql_fetch_array(mysql_query("SELECT * FROM `gcms_newsletter` WHERE date > '$sec30time' AND ip = '$_SERVER[REMOTE_ADDR]' ",$link))){
	if ($_SESSION["hacker"] == "newsletter" and $_SESSION['counterpage'] > 2 ){mysql_query("INSERT INTO `gcms_blocked` ( `ip` ) VALUES ('$_SERVER[REMOTE_ADDR]')",$link);}
	$_SESSION['hacker'] = "newsletter";
	if ( $_SESSION['counternewsletter']  >= 1  ) { ++$_SESSION['counternewsletter']; }else { $_SESSION['counternewsletter']= 1; }
	//sleep(15);
	echo "<script>window.location='?part=page&id=$configset[first_page]';</script>";
	}
	//security\\\\\\\\\\\\\\\\\\\\\\\
	if (mysql_fetch_array(mysql_query("SELECT * FROM `gcms_newsletter` WHERE email='$_REQUEST[email]' ",$link))){
	
		$message = " این ایمیل یک بار در خبرنامه عضو شده است. لطفا دوباره تلاش نکنید " ;

	}else{	
	if ( !$_REQUEST[name] ){
	 $name = explode("@", $_REQUEST[email]);
	$_REQUEST[name] =$name[0];

	}
	$ip = $_SERVER['REMOTE_ADDR'] ;
	$nowdate = time();
	// تعریف کوئری   
		$querysp = "INSERT INTO `gcms_newsletter` ( `full_name` , `email` , `status` , `ip` , `date` )
VALUES ( '$_REQUEST[name]', '$_REQUEST[email]', 'open', '$ip', '$nowdate')";
	// نتایج کوئری
		if( mysql_query($querysp,$link) ){
		
		$message = " ثبت نام شما در خبر نامه با موفقیت انجام شد " ;
		
		}else {
		$message = " مشکل در ثبت نام لطفا دوباره تلاش کنید " ;
		}
				
		}
	}
/////////////////////////////////////////////////////////////////////////////////////////			

			$gcms->assign('message',$message); 


/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',"?part=newsletter"); 
			$gcms->assign('part',"newsletter"); 
			
			$gcms->display("index/index.tpl");
}else {
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>
	";

}
	

?>