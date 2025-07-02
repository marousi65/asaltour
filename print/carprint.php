<?php
declare(strict_types=1);
session_start();

//-------------------------------------------------
// ۱) در صورت نیاز، کنترل دسترسی کاربر
//-------------------------------------------------
// if (!isset($_SESSION['user_id'])) {
//     header('HTTP/1.1 403 Forbidden');
//     exit('دسترسی غیرمجاز');
//}

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
 * تبدیل ارقام لاتین به فارسی
 */
function num2fa(string $input): string
{
    static $en = ['0','1','2','3','4','5','6','7','8','9'];
    static $fa = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
    return str_replace($en, $fa, $input);
}

//-------------------------------------------------
// ۳) بارگذاری لایبرری تبدیل تاریخ
//-------------------------------------------------
require_once $_SERVER['DOCUMENT_ROOT'] . '/gcms/admin-gcms/inc/jdf.php';

//-------------------------------------------------
// ۴) واکشی و اعتبارسنجی ورودی‌ها
//-------------------------------------------------
// کلیه پارامترها با GET خوانده می‌شوند:
$get = static function(string $name, int $filter = FILTER_SANITIZE_STRING, $options = null) {
    return filter_input(INPUT_GET, $name, $filter, $options);
};

$tarikhSodorRaw = trim((string) $get('tarikh_sodor', FILTER_DEFAULT));   // مثلاً "2023-07-15"
$seryalRaw      = trim((string) $get('seryal',      FILTER_DEFAULT));   // عدد رشته‌ای
$maghsd         = trim((string) $get('maghsd',      FILTER_SANITIZE_STRING));
$fname          = trim((string) $get('fname',       FILTER_SANITIZE_STRING));
$lname          = trim((string) $get('lname',       FILTER_SANITIZE_STRING));
$mcodeRaw       = trim((string) $get('mcode',       FILTER_SANITIZE_STRING));
$numRaw         = trim((string) $get('num',         FILTER_SANITIZE_NUMBER_INT));
$carname        = trim((string) $get('carname',     FILTER_SANITIZE_STRING));
$plateRaw       = trim((string) $get('plate',       FILTER_DEFAULT));
$tarikhHarkatRaw= trim((string) $get('tarikh_harkat', FILTER_SANITIZE_STRING));
$saatHarkatRaw  = trim((string) $get('saat_harekat',  FILTER_SANITIZE_STRING));
$shipName       = trim((string) $get('ship_name',   FILTER_SANITIZE_STRING));
$codeSodor      = trim((string) $get('code_sodor',  FILTER_SANITIZE_STRING));
$certificateRaw = trim((string) $get('certificate', FILTER_SANITIZE_NUMBER_INT));
$modelRaw       = trim((string) $get('model',       FILTER_SANITIZE_NUMBER_INT));
$shasiRaw       = trim((string) $get('shasi',       FILTER_DEFAULT));
$mabd           = trim((string) $get('mabd',        FILTER_SANITIZE_STRING));
$feeRaw         = trim((string) $get('fee',         FILTER_SANITIZE_NUMBER_INT));
$mess1Raw       = trim((string) $get('mess1',       FILTER_SANITIZE_STRING));
$mess2Raw       = trim((string) $get('mess2',       FILTER_SANITIZE_STRING));
$mess3Raw       = trim((string) $get('mess3',       FILTER_SANITIZE_STRING));

//-------------------------------------------------
// ۵) تبدیل تاریخ میلادی (YYYY-MM-DD) به جلالی و فارسی
//-------------------------------------------------
$jalali = ['','',''];
if (preg_match('#^(\d{4})-(\d{1,2})-(\d{1,2})$#', $tarikhSodorRaw, $m)) {
    list(, $gy, $gm, $gd) = $m;
    $jalali = gregorian_to_jalali((int)$gy, (int)$gm, (int)$gd);
    $jalali = array_map('num2fa', $jalali);
}

//-------------------------------------------------
// ۶) آماده‌سازی تبدیل اعداد به فارسی
//-------------------------------------------------
$seryal       = num2fa((string)((int)$seryalRaw + 111111));
$mcode        = num2fa($mcodeRaw);
$num          = num2fa($numRaw);
$plate        = num2fa($plateRaw);
$tarikhHarkat = num2fa($tarikhHarkatRaw);
$saatHarkat   = num2fa($saatHarkatRaw);
$certificate  = num2fa($certificateRaw);
$model        = num2fa($modelRaw);
$shasi        = num2fa($shasiRaw);
$fee          = num2fa($feeRaw);
$mess1        = num2fa($mess1Raw);
$mess2        = num2fa($mess2Raw);
$mess3        = num2fa($mess3Raw);

?><!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>پرینت بلیط</title>
  <link rel="stylesheet" href="/gcms/css/carblpr.css" media="all">
</head>
<body class="ticket-print">

  <table width="600" cellpadding="0" cellspacing="0" role="presentation">
    <tr valign="top">
      <td width="600" height="430">
        <div class="print-container" style="position:relative; width:600px; height:430px;">
          
          <!-- پس‌زمینه -->
          <img src="/gcms/images/bg_2.jpg"
               alt=""
               class="bg-image"
               style="position:absolute; top:10px; left:10px; z-index:0;">

          <!-- سمت گمرک -->
          <div class="gomrk" style="z-index:1; position:absolute; top:20px; left:20px;">
            <div class="b1"><?= e($seryal) ?></div>
            <div class="b2"><?= e($maghsd) ?></div>
            <div class="b2"><?= e($fname) ?></div>
            <div class="b2"><?= e($lname) ?></div>
            <div class="b2"><?= e($mcode) ?></div>
            <div class="b3"><?= e($num) ?></div>
            <div class="b4"><?= e($carname) ?></div>
            <div class="b5"><?= e($plate) ?></div>
            <div class="b6"><?= e($tarikhHarkat) ?></div>
            <div class="b2"><?= e($saatHarkat) ?></div>
          </div>

          <!-- سمت کنترل -->
          <div class="contrl" style="z-index:1; position:absolute; top:20px; left:260px;">
            <div class="b1"><?= e($seryal) ?></div>
            <div class="b2"><?= e($maghsd) ?></div>
            <div class="b2"><?= e($fname) ?></div>
            <div class="b2"><?= e($lname) ?></div>
            <div class="b2"><?= e($mcode) ?></div>
            <div class="b3"><?= e($num) ?></div>
            <div class="b4"><?= e($carname) ?></div>
            <div class="b5"><?= e($plate) ?></div>
            <div class="b6"><?= e($tarikhHarkat) ?></div>
            <div class="b2"><?= e($saatHarkat) ?></div>
          </div>

          <!-- سمت راست بلیط -->
          <div class="details" style="z-index:1; position:absolute; top:240px; left:20px;">
            <div class="l1"><?= e($shipName) ?></div>
            <div class="l2"><?= e("{$jalali[0]} / {$jalali[1]} / {$jalali[2]}") ?></div>
            <div class="clear"></div>
            <div class="l3"><?= e($codeSodor) ?></div>
            <div class="l4"><?= e($seryal) ?></div>
            <div class="clear"></div>
            <div class="l5"><?= e($fname) ?></div>
            <div class="l6"><?= e($lname) ?></div>
            <div class="l7"><?= e($mcode) ?></div>
            <div class="clear"></div>
            <div class="l16"><?= e($certificate) ?></div>
            <div class="l17"><?= e($num) ?></div>
            <div class="clear"></div>
            <div class="l18"><?= e($carname) ?></div>
            <div class="l19"><?= e($model) ?></div>
            <div class="l20"><?= e($plate) ?></div>
            <div class="l21"><?= e($shasi) ?></div>
            <div class="clear"></div>
            <div class="l8"><?= e($mabd) ?></div>
            <div class="l9"><?= e($maghsd) ?></div>
            <div class="clear"></div>
            <div class="l10"><?= e($tarikhHarkat) ?></div>
            <div class="l11"><?= e($saatHarkat) ?></div>
            <div class="clear"></div>
            <div class="l12"><?= e($fee) ?></div>
            <div class="clear"></div>
            <div class="l13"><?= e($mess1) ?></div>
            <div class="clear"></div>
            <div class="l14"><?= e($mess2) ?></div>
            <div class="clear"></div>
            <div class="l15"><?= e($mess3) ?></div>
            <div class="clear"></div>
          </div>

        </div>
      </td>
    </tr>
  </table>

</body>
</html>
