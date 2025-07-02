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
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/formfunc.php';


	switch ($_REQUEST[action]){
		//اگر اکشن برابر ادیت باشد	
		case "edit":
		if ($_REQUEST[edit]){
		//اگر ادیت شده باشد
		finaleditform($errmes);
		}else{
		// مراحل اولیه ادیت
		editform($errmes);
		}
		break;
		//اگر اکشن برابر اضافه کردن  باشد
		case "add":
		if ($_REQUEST[add]){
		//مرحله نهایی اضافه کردن 
		finaladdform($errmes);
		}
		break;
		//اگر اکشن برابر حذف باشد
		case "delete":
		deleteform($errmes);
		break;
		// در صفحه اصلی تابع لیست  را فراخوانی می کنیم
		default:
		listform($errmes);
	}

	// بستن ارتباط
	mysql_close($link);
	}
	//end level check	
?>
