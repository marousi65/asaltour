<?php
declare(strict_types=1);

// --- 1) شروع Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --- 2) Composer Autoload (در صورت استفاده)
if (file_exists(__DIR__ . '/../../vendor/autoload.php')) {
    require __DIR__ . '/../../vendor/autoload.php';
}

// --- 3) CSRF Token
if (empty($_SESSION['_csrf_token'])) {
    $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
}

// --- 4) اتصال PDO
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=gcms;charset=utf8mb4',
        'dbuser',
        'dbpass',
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    http_response_code(500);
    exit('Database connection failed');
}

// --- 5) راه‌اندازی Smarty
require __DIR__ . '/../../gcms/libs/Smarty.class.php';
$gcms = new Smarty();
$gcms->setTemplateDir(__DIR__ . '/../templates');
$gcms->setCompileDir(__DIR__ . '/../templates_c');
$gcms->setCacheDir(__DIR__ . '/../cache');
$gcms->setConfigDir(__DIR__ . '/../configs');

// (اختیاری) اگر نیاز داریدتوکن را در قالب داشته باشید:
// $gcms->assign('csrf_token', $_SESSION['_csrf_token']);
