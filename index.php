<?php
declare(strict_types=1);

// -----------------------------------------------------------------
// ۰) نمایش موقت همهٔ خطاها (برای Debug ؛ در محیط Live غیرفعال کنید)
// -----------------------------------------------------------------
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// -----------------------------------------------------------------
// ۱) شروع سشن
// -----------------------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// -----------------------------------------------------------------
// ۲) بارگذاری تنظیمات PDO و توابع کمکی (gconfig.php)
//    ابتدا مسیرهای ممکن را چک می‌کنیم
// -----------------------------------------------------------------
$configPaths = [
    __DIR__ . '/gconfig.php',
    __DIR__ . '/gcms/php/file/gconfig.php',
    __DIR__ . '/includes/gconfig.php',
    __DIR__ . '/config/gconfig.php',
];
$configFile = null;
foreach ($configPaths as $path) {
    if (file_exists($path)) {
        $configFile = $path;
        break;
    }
}
if (! $configFile) {
    die('خطا: فایل تنظیمات «gconfig.php» پیدا نشد. لطفاً مسیر آن را بررسی کنید.');
}
require_once $configFile;

// -----------------------------------------------------------------
// ۳) امنیت: بررسی IP در جدول gcms_blocked با PDO
// -----------------------------------------------------------------
$ip = $_SERVER['REMOTE_ADDR'] ?? '0.0.0.0';
try {
    $stmt = db_query(
        "SELECT COUNT(*) FROM `gcms_blocked` WHERE `ip` = ?",
        [$ip]
    );
    $blocked = (int) $stmt->fetchColumn();
    if ($blocked > 0) {
        die(
            '<center style="margin-top:100px;">'
            . '<font color="red" face="tahoma">'
            . 'شما به عنوان یک هکر در سیستم شناخته شده‌اید!!<br>'
            . 'اگر غیر از این است، لطفاً با ایمیل زیر تماس بگیرید:<br>'
            . '25 m o r d a d [ a t ] g m a i l . c o m'
            . '</font></center>'
        );
    }
} catch (Throwable $e) {
    error_log("[Blocked IP Check Error] " . $e->getMessage());
}

// -----------------------------------------------------------------
// ۴) (اختیاری) مخفی کردن Noticeها
// -----------------------------------------------------------------
error_reporting(E_ALL & ~E_NOTICE);

// -----------------------------------------------------------------
// ۵) بارگذاری Smarty (ابتدا Composer؛ در صورت ناموفق شدن، دستی)
// -----------------------------------------------------------------
$smarty = null;
$composerAutoload = __DIR__ . '/vendor/autoload.php';
$manualSmartyClass = __DIR__ . '/gcms/php/libs/Smarty.class.php';

if (file_exists($composerAutoload)) {
    require_once $composerAutoload;
    if (class_exists('\Smarty\Smarty')) {
        // نسخه رسمی از Packagist
        $smarty = new \Smarty\Smarty();
    }
}

if (! $smarty) {
    // بارگذاری دستی
    if (! file_exists($manualSmartyClass)) {
        die("خطا: کلاس Smarty پیدا نشد. فایل {$manualSmartyClass} وجود ندارد.");
    }
    require_once $manualSmartyClass;
    if (! class_exists('Smarty')) {
        die('خطا: کلاس global Smarty در فایل Smarty.class.php تعریف نشده است.');
    }
    $smarty = new Smarty();
}

// -----------------------------------------------------------------
// ۶) تنظیم دایرکتوری‌های قالب/کامپایل/کش/کانفیگ
// -----------------------------------------------------------------
$smarty->setTemplateDir(__DIR__ . '/templates');
$smarty->setCompileDir(__DIR__ . '/templates_c');
$smarty->setCacheDir(__DIR__ . '/cache');
$smarty->setConfigDir(__DIR__ . '/configs');

// -----------------------------------------------------------------
// ۷) بارگذاری توابع کمکی جلالی و تنظیمات دیگر
// -----------------------------------------------------------------
require_once __DIR__ . '/gcms/admin-gcms/inc/jdf.php';
require_once __DIR__ . '/gcms/php/file/setting.php';

// -----------------------------------------------------------------
// ۸) مسیریابی براساس پارامتر part
// -----------------------------------------------------------------
$part = $_GET['part'] ?? '';

if (
    isset($configset['intro'])
    && $configset['intro'] !== 'no'
    && $part === ''
) {
    $smarty->assign('part', 'intro');
    $smarty->display('intro/index.tpl');
    exit;
}

switch ($part) {
    case 'page':
        require_once __DIR__ . '/gcms/php/file/page.php';
        break;
    case 'form':
        require_once __DIR__ . '/gcms/php/file/form.php';
        break;
    case 'poll':
        require_once __DIR__ . '/gcms/php/file/poll.php';
        break;
    case 'news':
        require_once __DIR__ . '/gcms/php/file/news.php';
        break;
    case 'gallery':
        require_once __DIR__ . '/gcms/php/file/gallery.php';
        break;
    case 'rss':
        require_once __DIR__ . '/gcms/php/file/rss2.php';
        break;
    case 'search':
        require_once __DIR__ . '/gcms/php/file/search.php';
        break;
    case 'newsletter':
        require_once __DIR__ . '/gcms/php/file/newsletter.php';
