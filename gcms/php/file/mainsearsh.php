<?php
declare(strict_types=1);

namespace GCMS\File;

use Smarty;

// بارگذاری تنظیمات و توابع
require_once __DIR__ . '/../../gconfig.php';
require_once __DIR__ . '/../../jdf.php';

global $gcms, $link;

// --- استخراج مقادیر دلخواه از ورودی یا سشن ---
$selDest   = filter_input(INPUT_GET, 'des', FILTER_VALIDATE_INT)     ?: null;
$selSail   = filter_input(INPUT_GET, 'sailing', FILTER_VALIDATE_INT) ?: null;
$selMonth  = filter_input(INPUT_GET, 'month', FILTER_VALIDATE_INT)   ?: (int) ($_SESSION['g_s_m'] ?? 0);

// اگر سشن ماه تنظیم نشده، مقدار پیش‌فرض jdate استخراج شده و در سشن ذخیره می‌شود
if ($selMonth < 1 || $selMonth > 12) {
    $jm = jdate('n');
    $_SESSION['g_s_m'] = $jm;
    $selMonth = $jm;
}

// --- لیست مقاصد ---
$stmt = mysqli_prepare(
    $link,
    "SELECT `id`,`name` 
       FROM `gcms_des`
      ORDER BY `name` ASC"
);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$optDes  = ['<option value="">انتخاب مقصد …</option>'];
while ($row = mysqli_fetch_assoc($res)) {
    $selected = ($selDest === (int)$row['id']) ? ' selected' : '';
    $optDes[] = sprintf(
        "<option value=\"%d\"%s>%s</option>",
        $row['id'],
        $selected,
        htmlspecialchars($row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
    );
}
$gcms->assign('opt_des', implode("\n", $optDes));

// --- لیست شرکت‌های کشتیرانی ---
$stmt = mysqli_prepare(
    $link,
    "SELECT `id`,`name`
       FROM `gcms_sailing`
      ORDER BY `name` ASC"
);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$optSail = ['<option value="">تمام کشتیرانی‌ها</option>'];
while ($row = mysqli_fetch_assoc($res)) {
    $selected = ($selSail === (int)$row['id']) ? ' selected' : '';
    $optSail[] = sprintf(
        "<option value=\"%d\"%s>%s</option>",
        $row['id'],
        $selected,
        htmlspecialchars($row['name'], ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8')
    );
}
$gcms->assign('opt_sailing', implode("\n", $optSail));

// --- لیست ماه‌های شمسی (با چرخش از خرداد تا اردیبهشت) ---
$months = [
    1=>'فروردین',2=>'اردیبهشت',3=>'خرداد',4=>'تیر',5=>'مرداد',6=>'شهریور',
    7=>'مهر',8=>'آبان',9=>'آذر',10=>'دی',11=>'بهمن',12=>'اسفند'
];
$optionsMonth = [];
for ($i = $selMonth; $i<=12; $i++) {
    $sel = ($i === $selMonth) ? ' selected' : '';
    $optionsMonth[] = "<option value=\"$i\"$sel>{$months[$i]}</option>";
}
for ($i = 1; $i<$selMonth; $i++) {
    $sel = ($i === $selMonth) ? ' selected' : '';
    $optionsMonth[] = "<option value=\"$i\"$sel>{$months[$i]}</option>";
}
$gcms->assign('opt_month', implode("\n", $optionsMonth));
