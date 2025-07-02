<?php
declare(strict_types=1);

// ۱) نمایش خطا فقط در محیط توسعه
ini_set('display_errors', $_ENV['APP_ENV'] === 'dev' ? '1' : '0');
error_reporting(E_ALL);

// ۲) شروع امن سشن
session_set_cookie_params([
    'lifetime' => 0,
    'path'     => '/',
    'domain'   => $_SERVER['HTTP_HOST'],
    'secure'   => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
    'httponly' => true,
    'samesite' => 'Strict',
]);
session_start();

// ۳) هِدرهای امنیتی
header('X-Frame-Options: SAMEORIGIN');
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data:;");

// ۴) تابع امن خروجی
function e(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// ۵) بارگذاری تنظیمات و دیتابیس
require_once __DIR__ . '/gcms/php/file/gconfig.php';

// ۶) مدیریت پارامتر dyanmic include با لیست‌سفید
$allowed_parts = ['home','about','contact','purchase_form','report'];
$part = filter_input(INPUT_GET, 'part', FILTER_SANITIZE_STRING) ?: 'home';
if (!in_array($part, $allowed_parts, true)) {
    $part = 'home';
}

// ۷) include صفحه‌ی مربوطه
$page_file = __DIR__ . "/views/{$part}.php";
if (is_readable($page_file)) {
    include $page_file;
} else {
    include __DIR__ . '/views/home.php';
}
