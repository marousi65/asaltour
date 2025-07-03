<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?PHP
// فراخوانی لوگین و تابع های یوزر
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/filefunc.php';


	switch ($_REQUEST[action]){
		//	
		case "addfile":
		//
		finaladdfile($errmes);
		break;
		//	
		case "editfolder":
		//
		finaleditfolder($errmes);
		break;
		
		// 
		default:
		filelist($errmes);
	}

	// بستن ارتباط
	mysql_close($link);

?>
