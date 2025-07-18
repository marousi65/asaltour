<?php
declare(strict_types=1);
session_start();

// بارگذاری تنظیمات پایه
require_once __DIR__ . '/gconfig.php';

$list = $_GET['list'] ?? '';
$id   = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// بر اساس نوع گزارش، کوئری و نام فایل را تنظیم می‌کنیم
switch ($list) {
    case 'psngrtrade':
        $sql      = "
          SELECT p.*, 
                 mabd.title AS origin, 
                 magh.title AS destination 
          FROM `gcms_psngrtrade` p
          JOIN `gcms_des` mabd ON p.`id_mabd` = mabd.`id`
          JOIN `gcms_des` magh ON p.`id_magh` = magh.`id`
          WHERE p.`id_login` = {$_SESSION['g_id_login']}";
        $filename = 'reportpsngrtrade.xls';
        break;

    case 'car':
        $sql      = "
          SELECT * 
          FROM `gcms_car` 
          WHERE `id_login` = {$_SESSION['g_id_login']}";
        $filename = 'reportcar.xls';
        break;

    case 'cartrade':
        $sql      = "
          SELECT p.*, 
                 mabd.title AS origin, 
                 magh.title AS destination 
          FROM `gcms_cartrade` p
          JOIN `gcms_des` mabd ON p.`id_mabd` = mabd.`id`
          JOIN `gcms_des` magh ON p.`id_magh` = magh.`id`
          WHERE p.`id_login` = {$_SESSION['g_id_login']}";
        $filename = 'reportcartrade.xls';
        break;

    default:
        exit('Invalid report type.');
}

// اجرای کوئری
$res = mysql_query($sql, $link);

// هدر برای اکسل
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header("Content-Disposition: attachment; filename=\"{$filename}\"");
echo "\xEF\xBB\xBF"; // BOM UTF-8

// ساخت جدول خروجی
echo "<table border='1'><tr>";

// تیتر ستون‌ها
if ($list === 'psngrtrade' || $list === 'cartrade') {
    echo "<th>مبدا</th><th>مقصد</th><th>نام کشتی</th><th>تاریخ</th>"
       . "<th>ساعت</th><th>ظرفیت</th><th>ظرفیت خالی</th><th>وضعیت</th><th>درصد کنسلی</th>";
}
else { // car
    echo "<th>نام</th><th>تعداد واحد</th><th>قیمت بلیط</th>"
       . "<th>قیمت بار اضافه</th><th>حداکثر همراه</th><th>قیمت بلیط همراه</th>";
}

echo "</tr>";

// ردیف‌ها
while ($row = mysql_fetch_assoc($res)) {
    echo "<tr>";
    if ($list === 'psngrtrade' || $list === 'cartrade') {
        echo "<td>{$row['origin']}</td>"
           . "<td>{$row['destination']}</td>"
           . "<td>{$row['ship_name']}</td>"
           . "<td>{$row['date']}</td>"
           . "<td>{$row['hour']}</td>"
           . "<td>{$row['capacity']}</td>"
           . "<td>{$row['free_capacity']}</td>"
           . "<td>{$row['type']}</td>"
           . "<td>{$row['darsad_cancel']}</td>";
    }
    else {
        echo "<td>{$row['name']}</td>"
           . "<td>{$row['unit']}</td>"
           . "<td>{$row['fee']}</td>"
           . "<td>{$row['cargo_fee']}</td>"
           . "<td>{$row['max_cap']}</td>"
           . "<td>{$row['fee_cap']}</td>";
    }
    echo "</tr>";
}

echo "</table>";
exit;
