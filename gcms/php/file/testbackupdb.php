<?php
declare(strict_types=1);
session_start();

// بارگذاری تنظیمات دیتابیس
require_once __DIR__ . '/gconfig.php';

$tableName  = 'gcms_login';
$backupPath = __DIR__ . '/gcms_login_backup.sql';

// کوئری خروجی به فایل
$query1 = "SELECT * INTO OUTFILE '{$backupPath}' FROM `{$tableName}`";
$query2 = "SELECT * FROM `{$tableName}`";

// اجرا
$res1 = mysql_query($query1, $link);
$res2 = mysql_query($query2, $link);

echo 'Backup to file: ' . ($res1 ? 'OK' : 'FAIL') . "<br>\n";
echo "Query1: {$query1}<br>\n";
if ($res2) {
    echo 'Rows in table: ' . mysql_num_rows($res2) . "<br>\n";
} else {
    echo "Query2 failed: {$query2}<br>\n";
}

mysql_close($link);
