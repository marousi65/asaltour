<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/agencyfunc.php';

if ( $_SESSION['g_t_login'] == "agency" ){
		switch ($_GET['agency']){
	
			case "edit":
				if ($_REQUEST['edit'] == "profile"){
					f_agency_edit_profile();
					$gcms->assign('page_title',"تغییر اطلاعات شخصی"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
				if ($_REQUEST['edit'] == "pass"){
					f_agency_edit_pass();
					$gcms->assign('page_title',"تغییر کلمه عبور"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
				
			break;
	
			
	
			case "list":
				if ($_REQUEST['list'] == "psngrtrade"){
					f_agency_list_psngrtrade();
					$gcms->assign('page_title',"لیست خریدهای بلیط مسافربری"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
				if ($_REQUEST['list'] == "cartrade"){
					f_agency_list_cartrade();
					$gcms->assign('page_title',"لیست خریدهای بلیط لندیگرافت"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
			break;

			case "print":
				if ($_REQUEST['print'] == "psngrtrade"){
					f_agency_print_psngrtrade();
					$gcms->assign('page_title',"چاپ بلیط مسافربری"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
				if ($_REQUEST['print'] == "cartrade"){
					f_agency_print_cartrade();
					$gcms->assign('page_title',"چاپ بلیط لندیگرافت"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
			break;

			case "show":
				if ($_REQUEST['show'] == "psngrtrade"){
					f_agency_show_psngrtrade();
					$gcms->assign('page_title',"نمایش بلیط مسافربری"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
				if ($_REQUEST['show'] == "cartrade"){
					f_agency_show_cartrade();
					$gcms->assign('page_title',"نمایش بلیط لندیگرافت"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
			break;

			case "cancel":
				if ($_REQUEST['cancel'] == "psngrtrade"){
					f_agency_cancel_psngrtrade();
					$gcms->assign('page_title',"لغو بلیط مسافربری"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
				if ($_REQUEST['cancel'] == "cartrade"){
					f_agency_cancel_cartrade();
					$gcms->assign('page_title',"لغو بلیط لندیگرافت"); 
					$gcms->assign('agency_content',"$agency_content"); 
				}
			break;

			case "old":
					f_agency_old();
					$gcms->assign('page_title',"خرید بلیط برای مسافران قدیمی - جستجوی کد ملی"); 
					$gcms->assign('agency_content',"$agency_content"); 
			break;

			case "prdxt":
					f_agency_prdxt();
					$gcms->assign('page_title',"پرداخت آنلاین بدهی"); 
					$gcms->assign('agency_content',"$agency_content"); 
			break;
			
			case "report":
				if ($_REQUEST['report'] == "zlist"){
					f_admin_repzlist();
					$gcms->assign('page_title',"گزارش لیست ظرفیت"); 
					$gcms->assign('agency_content',"$admin_content"); 
				}

				if ($_REQUEST['report'] == "cncl"){
					f_admin_repcncl();
					$gcms->assign('page_title',"گزارش کنسلی ها"); 
					$gcms->assign('agency_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "mcncl"){
					f_admin_repmcncl();
					$gcms->assign('page_title',"گزارش کنسلی مسیر"); 
					$gcms->assign('agency_content',"$admin_content"); 
				}
				if ($_REQUEST['report'] == "alist"){
					f_admin_repalist();
					$gcms->assign('page_title',"گزارش لیست فروش آژانس ها"); 
					$gcms->assign('agency_content',"$admin_content"); 
				}
			break;
	
			default:
			//
		}
	
	
			mysql_close($link);
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('error_message', $error_message ); 
			$gcms->assign('success_message', $success_message ); 

			$gcms->assign('menu_active',"?part=agency"); 
			$gcms->assign('part',"agency"); 
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