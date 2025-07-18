<?php
declare(strict_types=1);
session_start();

// بارگذاری تنظیمات پایه و تعامل با DB
require_once __DIR__ . '/gconfig.php';
require_once __DIR__ . '/jdf.php';

// اگر فرم تنظیمات ارسال شد، بروزرسانی کنید
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_setting'])) {
    // مثال:
    // $site_title = mysql_real_escape_string($_POST['site_title']);
    // mysql_query("UPDATE `gcms_config` SET `value`='{$site_title}' WHERE `key`='site_title'", $link);
    // $success_message = 'تنظیمات ذخیره شد.';
}

// بارگذاری مقادیر فعلی تنظیمات برای نمایش در فرم
// $config = fetch_all_settings();

$gcms->assign('menu_active', '?part=setting');
$gcms->assign('part',        'setting');
$gcms->assign('page_title',  'تنظیمات سیستم');
// $gcms->assign('config',      $config);
// $gcms->assign('success_message', $success_message ?? '');
$gcms->display('index/index.tpl');
