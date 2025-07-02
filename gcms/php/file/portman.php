<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/portmanfunc.php';

if ( $_SESSION['g_t_login'] == "portman" ){

		switch ($_GET['portman']){
	
			case "edit":
				if ($_REQUEST['edit'] == "profile"){
					f_portman_edit_profile();
					$gcms->assign('page_title',"تغییر اطلاعات شخصی"); 
					$gcms->assign('portman_content',"$portman_content"); 
				}
				if ($_REQUEST['edit'] == "pass"){
					f_portman_edit_pass();
					$gcms->assign('page_title',"تغییر کلمه عبور"); 
					$gcms->assign('portman_content',"$portman_content"); 
				}
			break;
	
	
	
			case "report":
				if ($_REQUEST['report'] == "zlist"){
					f_admin_repzlist();
					$gcms->assign('page_title',"گزارش لیست ظرفیت"); 
					$gcms->assign('portman_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "nlist"){
					f_admin_repnlist();
					$gcms->assign('page_title',"گزارش لیست اسامی مسافرین"); 
					$gcms->assign('portman_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "cncl"){
					f_admin_repcncl();
					$gcms->assign('page_title',"گزارش کنسلی ها"); 
					$gcms->assign('portman_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "mcncl"){
					f_admin_repmcncl();
					$gcms->assign('page_title',"گزارش کنسلی مسیر"); 
					$gcms->assign('portman_content',"$admin_content"); 
				}
			break;
	
			default:
			//
		}
	
	
			mysql_close($link);
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('error_message', $error_message ); 
			$gcms->assign('success_message', $success_message ); 

			$gcms->assign('menu_active',"?part=portman"); 
			$gcms->assign('part',"portman"); 
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