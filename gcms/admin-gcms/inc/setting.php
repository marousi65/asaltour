<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?PHP

	//level check
	if (leveluser(8) == "false"){
	//err view
	header("Location: /gcms/admin-gcms/gcms/?part=dashboard");
	}else{
	//normal view

// فراخوانی لوگین و تابع های یوزر
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/settingfunc.php';


	switch ($_REQUEST[action]){
		//اگر اکشن برابر ادیت باشد	
		case "edit":
		if ($_REQUEST[edit]){
		//اگر ادیت شده باشد
		finaleditsetting($errmes);
		}else{
		// مراحل اولیه ادیت
		editsetting($errmes);
		}
		break;
		// در صفحه اصلی تابع لیست یوزر را فراخوانی می کنیم
		default:
		editsetting($errmes);
	}

	// بستن ارتباط
	mysql_close($link);
	}
	//end level check	
?>
