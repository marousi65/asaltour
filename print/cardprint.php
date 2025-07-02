<?php
declare(strict_types=1);
session_start();

//-------------------------------------------------
//  ۱) کنترل دسترسی (در صورت نیاز)
//-------------------------------------------------
// اگر می‌خواهید فقط کاربران لاگین‌شده بتوانند پرینت بگیرند:
// if (!isset($_SESSION['user_id'])) {
//     header('HTTP/1.1 403 Forbidden');
//     exit('دسترسی غیرمجاز');
// }

//-------------------------------------------------
// ۲) توابع کمکی
//-------------------------------------------------
/**
 * جلوگیری از XSS در خروجی HTML
 */
function e(string $str): string
{
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * تبدیل ارقام لاتین به معادل فارسی
 */
function num2fa(string $number): string
{
    static $en = ['0','1','2','3','4','5','6','7','8','9'];
    static $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return str_replace($en, $fa, $number);
}

// بارگذاری لایبرری تبدیل تاریخ
require_once $_SERVER['DOCUMENT_ROOT'] . '/gcms/admin-gcms/inc/jdf.php';

//-------------------------------------------------
// ۳) واکشی و اعتبارسنجی ورودی‌ها
//-------------------------------------------------
$fname       = trim((string)  filter_input(INPUT_GET, 'fname',       FILTER_SANITIZE_STRING));
$lname       = trim((string)  filter_input(INPUT_GET, 'lname',       FILTER_SANITIZE_STRING));
$email       = (string)       filter_input(INPUT_GET, 'email',       FILTER_VALIDATE_EMAIL) ?: '';
$melicode    = trim((string)  filter_input(INPUT_GET, 'melicode',    FILTER_SANITIZE_STRING));
$regdateRaw  = trim((string)  filter_input(INPUT_GET, 'regdate',     FILTER_DEFAULT));
$tar_harkat  = trim((string)  filter_input(INPUT_GET, 'tarikh_harkat', FILTER_SANITIZE_STRING));
$saat_harkat = trim((string)  filter_input(INPUT_GET, 'saat_harekat',  FILTER_SANITIZE_STRING));
$fee         = trim((string)  filter_input(INPUT_GET, 'fee',         FILTER_SANITIZE_STRING));
$mess1       = trim((string)  filter_input(INPUT_GET, 'mess1',       FILTER_SANITIZE_STRING));
$mess2       = trim((string)  filter_input(INPUT_GET, 'mess2',       FILTER_SANITIZE_STRING));
$mess3       = trim((string)  filter_input(INPUT_GET, 'mess3',       FILTER_SANITIZE_STRING));

// تبدیل تاریخ میلادی به جلالی
// فرض: ورودی به صورت YYYY/MM/DD
$jalali = ['', '', ''];
if (preg_match('#^(\d{4})/(\d{1,2})/(\d{1,2})$#', $regdateRaw, $m)) {
    list(, $gy, $gm, $gd) = $m;
    $jalali = gregorian_to_jalali((int)$gy, (int)$gm, (int)$gd);
    // تبدیل اعداد به فارسی
    $jalali = array_map('num2fa', $jalali);
}

// در نهایت آماده‌سازی برای نمایش (اعداد به فارسی)
$melicode_fa    = num2fa($melicode);
$tar_harkat_fa  = num2fa($tar_harkat);
$saat_harkat_fa = num2fa($saat_harkat);
$fee_fa         = num2fa($fee);
$mess1_fa       = num2fa($mess1);
$mess2_fa       = num2fa($mess2);
$mess3_fa       = num2fa($mess3);

?><!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>پرینت کارت عضویت</title>
  <link rel="stylesheet"
        href="/gcms/css/crpr.css"
        media="all">
</head>
<body class="card-print">

  <table width="600" cellpadding="0" cellspacing="0" role="presentation">
    <tr>
      <td>
        <div class="print-wrapper" style="position:relative; width:600px; height:404px;">
          
          <!-- پس‌زمینه -->
          <img src="/gcms/images/bg_3.jpg"
               alt=""
               class="bg-image"
               style="position:absolute;top:10px;left:10px;z-index:0;width:580px;height:384px;">

          <!-- محتوا -->
          <div class="c1" style="z-index:1;position:absolute;top:40px;right:40px;">
            <?= e($fname) ?>
          </div>
          <div class="c2" style="z-index:1;position:absolute;top:80px;right:40px;">
            <?= e($lname) ?>
          </div>
          
          <div class="c3" style="z-index:1;position:absolute;top:140px;right:40px;">
            <?= e($melicode_fa) ?>
          </div>
          <div class="c4" style="z-index:1;position:absolute;top:180px;right:40px;">
            <?= e($email) ?>
          </div>
          
          <div class="c5" style="z-index:1;position:absolute;top:240px;right:40px;">
            <?= e("{$jalali[0]}/{$jalali[1]}/{$jalali[2]}") ?>
          </div>

        </div>
      </td>
    </tr>
  </table>

</body>
</html>
