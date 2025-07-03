<?php
// admin.php - اصلاح شده
// این فایل به gconfig.php و adminfunc.php نیاز دارد
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/adminfunc.php';

// شروع سشن - اگر هنوز شروع نشده است
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// برای جلوگیری از هشدارهای undefined index
$admin_action = isset($_GET['admin']) ? $_GET['admin'] : '';
$sub_action = '';
if (isset($_REQUEST[$admin_action])) {
    $sub_action = $_REQUEST[$admin_action];
}

// فیلتر کردن ورودی ها برای جلوگیری از XSS
$admin_action = htmlspecialchars($admin_action, ENT_QUOTES, 'UTF-8');
$sub_action = htmlspecialchars($sub_action, ENT_QUOTES, 'UTF-8');

// متغیرهای خطا و موفقیت (اگر در adminfunc تعریف نشده اند)
$error_message = '';
$success_message = '';

// اگر از Smarty استفاده می کنید، باید اینجا نمونه سازی شود
// مطمئن شوید که مسیر Smarty.class.php درست است
require_once $_SERVER['DOCUMENT_ROOT'].'/gcms/libs/Smarty.class.php'; // مسیر Smarty شما
$gcms = new Smarty();
$gcms->setTemplateDir($_SERVER['DOCUMENT_ROOT'].'/gcms/templates');
$gcms->setCompileDir($_SERVER['DOCUMENT_ROOT'].'/gcms/templates_c');
$gcms->setConfigDir($_SERVER['DOCUMENT_ROOT'].'/gcms/configs');
$gcms->setCacheDir($_SERVER['DOCUMENT_ROOT'].'/gcms/cache');
// $gcms->assign('SITE_URL','http://localhost/gcms'); // مثال: اگر نیاز به مسیر سایت دارید

if (isset($_SESSION['g_t_login']) && $_SESSION['g_t_login'] == "admin" ){

    switch ($admin_action){

        case "edit":
            if ($sub_action == "profile"){
                f_admin_editprofile(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"تغییر اطلاعات شخصی");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "pass"){
                f_admin_editpass(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"تغییر کلمه عبور");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "sailing"){
                f_admin_editsailing(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"ویرایش نام کشتیرانی");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "des"){
                f_admin_editdes(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"ویرایش نام مبدا و مقصد");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "shipman"){
                f_admin_editshipman(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"ویرایش مدیر کشتیرانی");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "portman"){
                f_admin_editportman(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"ویرایش مدیر کشتیرانی");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "agency"){
                f_admin_editagency(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"ویرایش آژانس");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "free"){
                f_admin_editfree(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"ویرایش کاربر");
                $gcms->assign('admin_content',"$admin_content");
            }
        break;

        case "new":
            if ($sub_action == "sailing"){
                f_admin_newsailing(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"معرفی کشتی رانی جدید");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "des"){
                f_admin_newdes(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"معرفی مبدا و مقصد جدید");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "shipman"){
                f_admin_newshipman(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"معرفی مدیر کشتیرانی جدید");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "portman"){
                f_admin_newportman(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"معرفی مدیر بنادر جدید");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "agency"){
                f_admin_newagency(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"معرفی آژانس جدید");
                $gcms->assign('admin_content',"$admin_content");
            }
        break;

        case "list":
            // بررسی وجود 'excel' به صورت امن
            $excel_request = (isset($_REQUEST['excel']) && $_REQUEST['excel'] == true);

            if ($sub_action == "sailing"){
                f_admin_listsailing(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست کشتی رانی");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "des"){
                f_admin_listdes(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست مبدا و مقصد ها");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "shipman"){
                if ($excel_request){
                    // ریدایرکت با PHP بجای JavaScript
                    header("Location: /gcms/php/file/adminxls.php?list=shipman");
                    exit();
                }
                f_admin_listshipman(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست مدیران کشتیرانی");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "portman"){
                if ($excel_request){
                    header("Location: /gcms/php/file/adminxls.php?list=portman");
                    exit();
                }
                f_admin_listportman(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست مدیران بنادر");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "agency"){
                if ($excel_request){
                    header("Location: /gcms/php/file/adminxls.php?list=agency");
                    exit();
                }
                f_admin_listagency(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست آژانس ها");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "free"){
                if ($excel_request){
                    header("Location: /gcms/php/file/adminxls.php?list=free");
                    exit();
                }
                f_admin_listfree(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست کاربران");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "prdxt"){
                f_admin_listprdxt(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست پرداخت ها");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "cancel"){
                f_admin_listcancel(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"لیست کنسلی ها");
                $gcms->assign('admin_content',"$admin_content");
            }
        break;

        case "dell":
            if ($sub_action == "sailing"){
                f_admin_delsailing(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"حذف کشتیرانی");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "des"){
                f_admin_deldes(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"حذف شهر");
                $gcms->assign('admin_content',"$admin_content");
            }
        break;

        case "report":
            if ($sub_action == "zlist"){
                f_admin_repzlist(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"گزارش لیست ظرفیت");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "nlist"){
                f_admin_repnlist(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"گزارش لیست اسامی مسافرین");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "cncl"){
                f_admin_repcncl(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"گزارش کنسلی ها");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "mcncl"){
                f_admin_repmcncl(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"گزارش کنسلی مسیر");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "alist"){
                f_admin_repalist(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"گزارش لیست فروش آژانس ها");
                $gcms->assign('admin_content',"$admin_content");
            }
            if ($sub_action == "user"){
                f_admin_repuser(); // این تابع باید بازنگری شود
                $gcms->assign('page_title',"گزارش کاربران");
                $gcms->assign('admin_content',"$admin_content");
            }
        break;

        case "bckup":
            // این بخش نیاز به بازنویسی کامل و امن دارد.
            // استفاده از `SELECT ... INTO OUTFILE` امن نیست و به مجوزهای خاصی نیاز دارد.
            // برای بکاپ‌گیری، استفاده از ابزارهای دیتابیس (مثل mysqldump) یا پیاده‌سازی یک منطق امن PHP توصیه می‌شود.
            // در حال حاضر این بخش خالی می‌ماند تا زمانی که راهکار مناسب ارائه شود.
            // برای جلوگیری از مشکلات احتمالی، بهتر است این بخش را فعلاً غیرفعال کنید.
            $error_message = "امکان بکاپ گیری از طریق وب فعلاً غیرفعال است.";
        break;

        default:
            // در صورت عدم وجود پارامتر admin معتبر
            // می توانید به یک صفحه پیش فرض ریدایرکت کنید یا یک پیام نمایش دهید.
            // $gcms->assign('page_title',"پنل مدیریت"); // یا هر عنوان دیگری
            // $gcms->assign('admin_content',"به پنل مدیریت خوش آمدید."); // یا محتوای پیش فرض
        break;
    }

    // بستن اتصال دیتابیس (اگر از mysqli استفاده می کنید، معمولاً خودکار بسته می شود،
    // اما صریح بستن آن مشکلی ندارد و گاهی مفید است)
    if (isset($link) && $link instanceof mysqli) {
        $link->close();
    }

    $gcms->assign('error_message', $error_message );
    $gcms->assign('success_message', $success_message );

    $gcms->assign('menu_active',"?part=admin");
    $gcms->assign('part',"admin");
    $gcms->display("index/index.tpl");
} else {
    // اگر کاربر لاگین نکرده یا اجازه دسترسی ندارد
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
