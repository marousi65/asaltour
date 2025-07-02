<?php

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/shipmanfunc.php';

if ( $_SESSION['g_t_login'] == "shipman" ){

		switch ($_GET['shipman']){
	
			case "edit":
				if ($_REQUEST['edit'] == "profile"){
					f_shipman_edit_profile();
					$gcms->assign('page_title',"تغییر اطلاعات شخصی"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
				if ($_REQUEST['edit'] == "pass"){
					f_shipman_edit_pass();
					$gcms->assign('page_title',"تغییر کلمه عبور"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
				if ($_REQUEST['edit'] == "psngrtrade"){
					f_shipman_edit_psngrtrade();
					$gcms->assign('page_title',"ویرایش مسیر مسافربری"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
				if ($_REQUEST['edit'] == "cartrade"){
					f_shipman_edit_cartrade();
					$gcms->assign('page_title',"ویرایش مسیر لندیگرافت"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
			break;
	
			case "new":
				if ($_REQUEST['new'] == "psngrtrade"){
					f_admin_new_psngrtrade();
					$gcms->assign('page_title',"معرفی مسیر مسافرتی جدید"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
				if ($_REQUEST['new'] == "cartrade"){
					f_admin_new_cartrade();
					$gcms->assign('page_title',"معرفی مسیر لندیگرافت جدید"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
				if ($_REQUEST['new'] == "car"){
					f_admin_new_car();
					$gcms->assign('page_title',"معرفی گروه ماشین جدید"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
			break;
	
			case "list":
				if ($_REQUEST['list'] == "psngrtrade"){
					if ($_REQUEST[excel]){echo " <script language=\"JavaScript\">setTimeout(\"top.location.href = '/gcms/php/file/shipmanxls.php?list=psngrtrade'\",1);</script> ";}
					f_admin_list_psngrtrade();
					$gcms->assign('page_title',"لیست مسیر مسافرتی"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
				if ($_REQUEST['list'] == "car"){
					if ($_REQUEST[excel]){echo " <script language=\"JavaScript\">setTimeout(\"top.location.href = '/gcms/php/file/shipmanxls.php?list=car&id=$_REQUEST[id]'\",1);</script> ";}
					f_admin_list_car();
					$gcms->assign('page_title',"لیست گروه ماشین ها"); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
				if ($_REQUEST['list'] == "cartrade"){
					if ($_REQUEST[excel]){echo " <script language=\"JavaScript\">setTimeout(\"top.location.href = '/gcms/php/file/shipmanxls.php?list=cartrade&id=$_REQUEST[id]'\",1);</script> ";}
					f_admin_list_cartrade();
					$gcms->assign('page_title',"لیست مسیرهای لندیگرافت "); 
					$gcms->assign('shipman_content',"$shipman_content"); 
				}
			break;
	
	
			case "report":
				if ($_REQUEST['report'] == "zlist"){
					f_admin_repzlist();
					$gcms->assign('page_title',"گزارش لیست ظرفیت"); 
					$gcms->assign('shipman_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "nlist"){
					f_admin_repnlist();
					$gcms->assign('page_title',"گزارش لیست اسامی مسافرین"); 
					$gcms->assign('shipman_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "cncl"){
					f_admin_repcncl();
					$gcms->assign('page_title',"گزارش کنسلی ها"); 
					$gcms->assign('shipman_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "mcncl"){
					f_admin_repmcncl();
					$gcms->assign('page_title',"گزارش کنسلی مسیر"); 
					$gcms->assign('shipman_content',"$admin_content"); 
				}
			break;
	
			default:
			//
		}
	
	
			mysql_close($link);
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('error_message', $error_message ); 
			$gcms->assign('success_message', $success_message ); 

			$gcms->assign('menu_active',"?part=shipman"); 
			$gcms->assign('part',"shipman"); 
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