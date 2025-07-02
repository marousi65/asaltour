<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/buyfunc.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
if ( $_SESSION['g_t_login'] == "free" or  $_SESSION['g_t_login'] == "agency" ){

		switch ($_GET['buy']){
	
			case "psngrtrade":
						
			if($_REQUEST[stage] == 1){
			f_buy_psn_stage1();			
			}
			if($_REQUEST[stage] == 2){
				if ($_REQUEST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
					$error_message = "کد امنیتی اشتباه وارد شده. <br>";
					f_buy_psn_stage1();		
				} else { 
				f_buy_psn_stage2();	
				}		
			}
			if($_REQUEST[stage] == 3){
				if ($_SESSION['rfrsh'] == $_REQUEST[psngrtrade] ){
				$error_message = "بلیط شما رزو شده است به بخش خریدهای خود مراجعه نمایید<br />";
				}else{
				f_buy_psn_stage3();			
				}
			}
			if($_REQUEST[stage] == 4){
			f_buy_psn_stage4();			
			}
			
			if($_REQUEST[stage] == "agency" ){
				if ($_SESSION['g_t_login']  == "agency"  ){
				if ($_REQUEST['mcode']){
				f_buy_psn_stage_agency();			
				}
				}else{
				$error_message = "شما حق دسترسی به این صفحه را ندارید";
				}
			}
			
			$gcms->assign('page_title',"خرید بلیط کشتی مسافربری"); 
			break;
	
	
			case "cartrade":
			if($_REQUEST[stage] == 1){
			f_buy_car_stage1();			
			}
			if($_REQUEST[stage] == 2){
				if ($_REQUEST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
					$error_message = "کد امنیتی اشتباه وارد شده. <br>";
					f_buy_car_stage1();		
				} else { 
				f_buy_car_stage2();	
				}		
			}
			if($_REQUEST[stage] == 3){
			f_buy_car_stage3();			
			}
			if($_REQUEST[stage] == 4){
			f_buy_psn_stage4();			
			}
			
			if($_REQUEST[stage] == "agency" ){
				if ($_SESSION['g_t_login']  == "agency"  ){
				if ($_REQUEST['mcode']){
				f_buy_car_stage_agency();			
				}
				}else{
				$error_message = "شما حق دسترسی به این صفحه را ندارید";
				}
			}
			
			
			$gcms->assign('page_title',"خرید بلیط کشتی لندیگرافت"); 
			break;
	
	
			default:
			//
		}
	
			mysql_close($link);
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('buy_content', $buy_content ); 
			$gcms->assign('error_message', $error_message ); 
			$gcms->assign('success_message', $success_message ); 
			$gcms->assign('menu_active',"?part=buy"); 
			$gcms->assign('part',"buy"); 
			$gcms->display("index/index.tpl");
}else{
	
		$error_message = "برای خرید بلیط حتما باید عضو سایت باشید و یا در صورت عضویت با استفاده از فرم ورود اعضا ، وارد سایت شوید. <br>
	<center><a href='?part=signup&signup=step1' >عضو شوید !</a></center>
	";
			$gcms->assign('error_message', $error_message );
			$gcms->assign('page_title',"غیر قابل دسترس"); 
			$gcms->assign('menu_active',"?part=buy"); 
			$gcms->assign('part',"buy"); 
			$gcms->display("index/index.tpl");
}

	
?>