<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/freefunc.php';

if ( $_SESSION['g_t_login'] == "free" ){

		switch ($_GET['free']){
	
			case "edit":
				if ($_REQUEST['edit'] == "profile"){
					f_free_edit_profile();
					$gcms->assign('page_title',"تغییر اطلاعات شخصی"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				if ($_REQUEST['edit'] == "pass"){
					f_free_edit_pass();
					$gcms->assign('page_title',"تغییر کلمه عبور"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				
			break;
	
			case "print":
				if ($_REQUEST['print'] == "psngrtrade"){
					f_free_print_psngrtrade();
					$gcms->assign('page_title',"چاپ بلیط مسافربری"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				if ($_REQUEST['print'] == "card"){
					f_free_print_card();
					$gcms->assign('page_title',"صدور کارت عضویت"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				if ($_REQUEST['print'] == "cartrade"){
					f_free_print_cartrade();
					$gcms->assign('page_title',"چاپ بلیط لندیگرافت"); 
					$gcms->assign('free_content',"$free_content"); 
				}
			break;

	
			case "list":
				if ($_REQUEST['list'] == "psngrtrade"){
					f_free_list_psngrtrade();
					$gcms->assign('page_title',"لیست خریدهای بلیط مسافربری"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				if ($_REQUEST['list'] == "cartrade"){
					f_free_list_cartrade();
					$gcms->assign('page_title',"لیست خریدهای بلیط لندیگرافت"); 
					$gcms->assign('free_content',"$free_content"); 
				}
			break;

			case "cancel":
				if ($_REQUEST['cancel'] == "psngrtrade"){
					f_free_cancel_psngrtrade();
					$gcms->assign('page_title',"لغو بلیط مسافربری"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				if ($_REQUEST['cancel'] == "cartrade"){
					f_free_cancel_cartrade();
					$gcms->assign('page_title',"لغو بلیط لندیگرافت"); 
					$gcms->assign('free_content',"$free_content"); 
				}
			break;

			case "show":
				if ($_REQUEST['show'] == "psngrtrade"){
					f_free_show_psngrtrade();
					$gcms->assign('page_title',"نمایش بلیط مسافربری"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				if ($_REQUEST['show'] == "cartrade"){
					f_free_show_cartrade();
					$gcms->assign('page_title',"نمایش بلیط لندیگرافت"); 
					$gcms->assign('free_content',"$free_content"); 
				}
			break;

			case "retry":
				if ($_REQUEST['retry'] == "psngrtrade"){
					f_free_retry_psngrtrade();
					$gcms->assign('page_title',"سعی مجدد"); 
					$gcms->assign('free_content',"$free_content"); 
				}
				if ($_REQUEST['retry'] == "cartrade"){
					f_free_retry_cartrade();
					$gcms->assign('page_title',"سعی مجدد"); 
					$gcms->assign('free_content',"$free_content"); 
				}
                	if ($_REQUEST['retry'] == "amount"){
					f_free_retry_amount();
					$gcms->assign('page_title',"افزایش اعتبار"); 
					$gcms->assign('free_content',"$free_content"); 
				}
			break;

			default:
			//
		}
	
	
			mysql_close($link);
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('error_message', $error_message ); 
			$gcms->assign('success_message', $success_message ); 

			$gcms->assign('menu_active',"?part=free"); 
			$gcms->assign('part',"free"); 
			$gcms->display("index/index.tpl");
}else{
	
		$error_message = " <br><br>
	<center>
	شما اجازه دسترسی به این صفحه را ندارید
	</center>
	<br><br><br>
	";
			$gcms->assign('error_message', $error_message );
			$gcms->assign('page_title',"غیر قابل دسترس"); 
			$gcms->assign('menu_active',"?part=buy"); 
			$gcms->assign('part',"buy"); 
			$gcms->display("index/index.tpl");
}
	
?>