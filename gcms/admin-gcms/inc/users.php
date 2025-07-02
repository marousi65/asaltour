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
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/userfunc.php';


	switch ($_REQUEST[action]){
		//اگر اکشن برابر ادیت باشد	
		case "edit":
		if ($_REQUEST[edit]){
		//اگر ادیت شده باشد
		finaledituser($errmes);
		}else{
		// مراحل اولیه ادیت
		edituser($errmes);
		}
		break;
		//اگر اکشن برابر اضافه کردن کاربر باشد
		case "add":
		if ($_REQUEST[add]){
		//مرحله نهایی اضافه کردن کاربر
		finaladduser($errmes);
		}else{
		//مرحله ابتدایی اضافه کردن کاربر
		adduser($errmes);
		}
		break;
		//اگر اکشن برابر حذف باشد
		case "del":
		// این قسمت هنوز تکمیل نشده و به صفحه اصلی هدایت می شود
		$errmes ="این قسمت هنوز تکمیل نشده است";
		listuser($errmes);
		break;
		// در صفحه اصلی تابع لیست یوزر را فراخوانی می کنیم
		default:
		listuser($errmes);
	}

	// بستن ارتباط
	mysql_close($link);
	}
	//end level check	
?>
