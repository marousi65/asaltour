<?php
declare(strict_types=1);

// ۱) بارگذاری تنظیمات و سشن
require_once __DIR__ . '/gcms/php/file/gconfig.php';
session_start();

// ۲) احراز هویت
if (empty($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

// ۳) بررسی دسترسی (مثلاً فقط مدیر)
if (empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    http_response_code(403);
    exit('Access denied');
}

// ۴) فیلتر و اعتبارسنجی ورودی
$reportId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if ($reportId === false || $reportId === null) {
    http_response_code(400);
    exit('Invalid report ID');
}

// ۵) آماده‌سازی و اجرای prepared statement
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($mysqli->connect_errno) {
    http_response_code(500);
    exit('Database connection failed');
}
$stmt = $mysqli->prepare('SELECT title, content, created_at FROM gcms_reports WHERE id = ?');
$stmt->bind_param('i', $reportId);
$stmt->execute();
$result = $stmt->get_result();
$report = $result->fetch_assoc();
if (!$report) {
    http_response_code(404);
    exit('Report not found');
}

// ۶) تابع امن خروجی
function e(string $v): string {
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-Frame-Options" content="SAMEORIGIN">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= e($report['title']) ?></title>
  <style>
    /* سبک‌های ساده برای گزارش */
    body { font-family: Tahoma, sans-serif; line-height: 1.6; padding: 1rem; }
    h1 { font-size: 1.8rem; }
    .meta { font-size: 0.9rem; color: #666; margin-bottom: 1rem; }
    .content { margin-top: 1rem; }
  </style>
</head>
<body>
  <h1><?= e($report['title']) ?></h1>
  <div class="meta">تاریخ: <?= e($report['created_at']) ?></div>
  <div class="content">
    <?= nl2br(e($report['content'])) ?>
  </div>
</body>
</html>
