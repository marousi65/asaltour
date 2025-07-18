<?php
declare(strict_types=1);

namespace GCMS\File;

use Smarty;

// بارگذاری تنظیمات و توابع تاریخ
require_once __DIR__ . '/../../gconfig.php';
require_once __DIR__ . '/../../jdf.php';

global $gcms, $link;

// تعداد آیتم‌های گالری (پیش‌فرض 10)
$count = (int) ($configset['gallerymainnum'] ?? 10);

// تهیه و اجرای کوئری با Prepared Statement
$query  = "SELECT id, title, pic, date
           FROM `gcms_galleries`
           WHERE `status` = 'publish'
           ORDER BY `date` DESC
           LIMIT ?";
$stmt   = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 'i', $count);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// جمع‌آوری نتایج
$gallery_items = [];
while ($row = mysqli_fetch_assoc($result)) {
    $gallery_items[] = [
        'id'    => (int) $row['id'],
        'title' => htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8'),
        'pic'   => $row['pic'],
        'url'   => "?part=gallery&id={$row['id']}",
        // فرمت تاریخ شمسی
        'date'  => jdate("Y/m/d H:i", (int) $row['date']),
    ];
}

// اختصاص به Smarty
$gcms->assign('gallery_items', $gallery_items);
