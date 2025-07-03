<?PHP
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
// فراخوانی لوگین و تابع های یوزر
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/searchfunc.php';


	switch ($_REQUEST[search]){
		//	
		case "page":
		//
		search();
		break;
		
		// 
		default:
		search();
	}

	// بستن ارتباط
	mysql_close($link);

?>