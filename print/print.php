<?php
declare(strict_types=1);

//--------------------------------------------------
// ۱) بوت‌استرپ (بارگذاری تنظیمات و استارت سشن)
//--------------------------------------------------
session_start();
require_once __DIR__ . '/../gcms/php/file/gconfig.php';  // مسیر را مطابق ساختار پروژه تنظیم کنید
require_once __DIR__ . '/../gcms/admin-gcms/inc/jdf.php'; // برای تبدیل تاریخ

//--------------------------------------------------
// ۲) تابع کمکی برای ایمن‌سازی خروجی HTML
//--------------------------------------------------
function e(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

//--------------------------------------------------
// ۳) تابع کمکی برای تبدیل اعداد لاتین به فارسی
//--------------------------------------------------
function num2fa(string $number): string
{
    static $en = ['0','1','2','3','4','5','6','7','8','9'];
    static $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return str_replace($en, $fa, $number);
}

//--------------------------------------------------
// ۴) کنترل دسترسی: کاربر لاگین‌شده باشد
//--------------------------------------------------
if (empty($_SESSION['user_id'])) {
    http_response_code(403);
    exit('لطفاً وارد شوید.');
}

//--------------------------------------------------
// ۵) واکشی و اعتبارسنجی ورودی‌ها
//--------------------------------------------------
$buyId = filter_input(INPUT_GET, 'buy_id', FILTER_VALIDATE_INT);
if ($buyId === false || $buyId === null || $buyId <= 0) {
    http_response_code(400);
    exit('شناسه نامعتبر.');
}

//--------------------------------------------------
// ۶) واکشی اطلاعات بلیط از دیتابیس
//--------------------------------------------------
$stmt = db_query(
    "SELECT b.*, t.name AS trip_name
     FROM gcms_buy AS b
     JOIN gcms_trip AS t ON t.id = b.trip_id
     WHERE b.id = ? AND b.login_id = ?",
    [$buyId, $_SESSION['user_id']]
);

$result = $stmt->get_result();
if ($result->num_rows === 0) {
    http_response_code(404);
    exit('بلیط یافت نشد.');
}
$data = $result->fetch_assoc();
$stmt->close();

//--------------------------------------------------
// ۷) تبدیل و قالب‌بندی داده‌ها
//--------------------------------------------------
// تبدیل تاریخ حرکت: YYYY-MM-DD → جلالی و فارسی
[$gy, $gm, $gd] = explode('-', $data['travel_date']);
[$jy, $jm, $jd] = gregorian_to_jalali((int)$gy, (int)$gm, (int)$gd);
$jalaliDateFa  = num2fa((string)$jy) . '/' . num2fa((string)$jm) . '/' . num2fa((string)$jd);

// تبدیل سایر مقادیر عددی به فارسی
$ticketIdFa    = num2fa((string)$data['id']);
$timeFa        = num2fa((string)$data['travel_time']);
$qtyFa         = num2fa((string)$data['quantity']);
$priceFa       = num2fa(number_format((float)$data['price']));
$createdAtFa   = e($data['created_at']); // می‌توانید اینجا هم با jdf یا DateTime فرمت کنید

//--------------------------------------------------
// ۸) خروجی HTML
//--------------------------------------------------
?><!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>پرینت بلیط #<?= e($ticketIdFa) ?></title>
  <link rel="stylesheet" href="/gcms/css/carblpr.css" media="all">
  <style>
    body { direction: rtl; font-family: Tahoma, sans-serif; }
    .pagebreak { page-break-after: always; }
    .ticket { margin: 20px; }
    .ticket h2 { margin-bottom: 10px; }
    .ticket p { margin: 5px 0; }
  </style>
</head>
<body>

  <!-- نسخه اصلی بلیط -->
  <div class="ticket">
    <h2>بلیط شماره <?= e($ticketIdFa) ?></h2>
    <p>مسیر: <?= e($data['trip_name']) ?></p>
    <p>تاریخ حرکت: <?= e($jalaliDateFa) ?></p>
    <p>ساعت حرکت: <?= e($timeFa) ?></p>
    <p>تعداد: <?= e($qtyFa) ?></p>
    <p>مبلغ کل: <?= e($priceFa) ?> تومان</p>
    <hr>
    <p>تاریخ خرید: <?= $createdAtFa ?></p>
  </div>

  <!-- جداکننده صفحه (در چاپ دو نسخه پشت‌سرهم) -->
  <div class="pagebreak"></div>

  <!-- نسخه کپی بلیط -->
  <div class="ticket copy">
    <h2>کپی بلیط شماره <?= e($ticketIdFa) ?></h2>
    <p>مسیر: <?= e($data['trip_name']) ?></p>
    <p>تاریخ حرکت: <?= e($jalaliDateFa) ?></p>
    <!-- ادامه فیلدها مشابه بالا… -->
  </div>

  <script>
    // فراخوانی خودکار دیالوگ چاپ
    window.addEventListener('load', function(){
      window.print();
    });
  </script>
</body>
</html>
