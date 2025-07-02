<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?PHP
// فراخوانی لوگین و تابع های یوزر
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/commentfunc.php';


	switch ($_REQUEST[action]){
		//اگر اکشن برابر ادیت باشد	
		case "edit":
		if ($_REQUEST[edit]){
		//اگر ادیت شده باشد
		finaleditcomment($errmes);
		}else{
		// مراحل اولیه ادیت
		editcomment($errmes);
		}
		break;
		//اگر اکشن برابر حذف باشد
		case "delete":
		deletecomment($errmes);
		break;
		//اگر بخواهیم وضعیت   را عوض کنیم
		case "status":
		// به تابع تغییر وضعیت
		statusc($errmes);
		break;
		//اگر بخواهیم تنضیمات را عوض کنیم
		case "setting":
		// به تابع تغییر وضعیت
		settingcomment($errmes);
		break;
		// در صفحه اصلی تابع لیست  را فراخوانی می کنیم
		default:
		listcomment($errmes);
	}

	// بستن ارتباط
	mysql_close($link);

?>
