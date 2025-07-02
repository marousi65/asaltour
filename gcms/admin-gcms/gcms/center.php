<?php
// مسیر فایل gconfig.php
require_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
// کنترل ورود
require_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';

// لیست بخش‌های مجاز
$allowed_parts = [
    'dashboard','users','pages','setting','comment','file',
    'rss2','form','plugin','news','gallery','poll',
    'map','newsletter','search','product'
];

// دریافت پارامتر و اعتبارسنجی
$part = $_GET['part'] ?? 'dashboard';
if(!in_array($part, $allowed_parts, true)){
    $part = 'dashboard';
}

// مسیر فایل شامل شده
$inc_file = $_SERVER['DOCUMENT_ROOT']."/gcms/admin-gcms/inc/{$part}.php";
if(is_readable($inc_file)){
    include_once $inc_file;
} else {
    // اگر به هر دلیل فایل پیدا نشد، داشبورد را نمایش بده
    include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/dashboard.php';
}
