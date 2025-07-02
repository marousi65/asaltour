<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?PHP
// فراخوانی لوگین و تابع های یوزر
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/pagefunc.php';


	switch ($_REQUEST[action]){
		//اگر اکشن برابر ادیت باشد	
		case "edit":
		if ($_REQUEST[edit]){
		//اگر ادیت شده باشد
		finaleditpage($errmes);
		}else{
		// مراحل اولیه ادیت
		editpage($errmes);
		}
		break;
		//اگر اکشن برابر اضافه کردن  باشد
		case "add":
		if ($_REQUEST[add]){
		//مرحله نهایی اضافه کردن 
		finaladdpage($errmes);
		}else{
		//مرحله ابتدایی اضافه کردن 
		addpage($errmes);
		}
		break;
		//اگر اکشن برابر حذف باشد
		case "delete":
		deletepage($errmes);
		break;
		//اگر بخواهیم وضعیت یک صفحه را عوض کنیم
		case "status":
		// به تابع تغییر وضعیت
		statusp($errmes);
		break;
		// در صفحه اصلی تابع لیست  را فراخوانی می کنیم
		default:
		listpage($errmes);
	}

	// بستن ارتباط
	mysql_close($link);

?>
