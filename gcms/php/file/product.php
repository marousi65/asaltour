<?php
declare(strict_types=1);
session_start();

// تنظیمات کلی گراف CMS
require_once __DIR__ . '/gconfig.php';
// اگر لازم دارید NuSOAP را در این صفحه استفاده کنید، فعال کنید:
// require_once __DIR__ . '/nusoap.php';

// کد اصلی فروشگاه (محصولات) – همان‌طور که قبلاً بود ولی با ارجاع‌های اصلاح‌شده
if ($pluginsetup['product']) {
    // افزودن به سبد خرید
    if (isset($_GET['addtobasket'])) {
        $_SESSION['countbasket'] = ($_SESSION['countbasket'] ?? 0) + 1;
        $idx = $_SESSION['countbasket'];
        $_SESSION["pid{$idx}"]      = $_POST['pid'] ?? '';
        $_SESSION["pprice{$idx}"]   = $_POST['pprice'] ?? '';
        $_SESSION["pname{$idx}"]    = $_POST['pname'] ?? '';
        $_SESSION["pquantity{$idx}"]= "1";

        $message = "محصول {$_POST['pname']} با قیمت خرید {$_POST['pprice']} {$configset['currency']} با موفقیت به سبد خرید شما اضافه شد.<br>"
                 . "<a href='?part=basket'>مشاهده سبد خرید</a>";
        $gcms->assign('message', $message);
    }

    // ثبت نظر (کامنت)
    if (isset($_GET['opinion'], $_REQUEST['submitbtt'], $_REQUEST['email'])) {
        // ... (بقیهٔ منطق ثبت نظر بدون تغییر)
    }

    // نمایش لیست محصولات یا صفحهٔ تکی
    // ... (بقیهٔ کد اصلی بدون تغییر)
    
    $gcms->assign('part', "product");
    $gcms->display("index/index.tpl");

} else {
    header('Location: ?part=page&id=' . $configset['first_page']);
    exit;
}
