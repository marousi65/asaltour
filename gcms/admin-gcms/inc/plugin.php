<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?PHP
	//level check
	if (leveluser(10) == "false"){
	//err view
	header("Location: /gcms/admin-gcms/gcms/?part=dashboard");
	}else{
	//normal view
	

// فراخوانی لوگین و تابع های یوزر
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/pluginfunc.php';


	switch ($_REQUEST[action]){
		//اگر اکشن برابر ادیت باشد	
		case "edit":
		if ($_REQUEST[edit]){
		//اگر ادیت شده باشد
		finaleditplugin($errmes);
		}else{
		// مراحل اولیه ادیت
		editplugin($errmes);
		}
		break;
		//اگر اکشن برابر اضافه کردن  باشد
		case "add":
		if ($_REQUEST[add]){
		//مرحله نهایی اضافه کردن 
		finaladdplugin($errmes);
		}
		break;
		//اگر اکشن برابر حذف باشد
		case "delete":
		deleteplugin($errmes);
		break;
		//اگر بخواهیم وضعیت  را عوض کنیم
		case "status":
		// به تابع تغییر وضعیت
		statusp($errmes);
		break;
		// در صفحه اصلی تابع لیست  را فراخوانی می کنیم
		default:
		listplugin($errmes);
	}

	// بستن ارتباط
	mysql_close($link);
	}
	//end level check	
?>
