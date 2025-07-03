<?PHP
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
// فراخوانی لوگین و تابع های یوزر
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/dashboardfunc.php';


	switch ($_REQUEST[action]){
		//	
		case "addfile":
		//
		finaladdfile($errmes);
		break;
		
		// 
		default:
		dashboardlist($errmes);
	}

	// بستن ارتباط
	mysql_close($link);

?>