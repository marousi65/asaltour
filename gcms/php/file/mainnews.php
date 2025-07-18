<?php
declare(strict_types=1);

namespace GCMS\File;

use Smarty;

// بارگذاری تنظیمات و توابع تاریخ
require_once __DIR__ . '/../../gconfig.php';
require_once __DIR__ . '/../../jdf.php';

global $gcms, $link;

// تعداد اخبار نمایشی در صفحه اصلی
$countHomeNews = (int) ($configset['newsmainnum'] ?? 5);

// کوئری با Prepared Statement
$query  = "SELECT id, page_title, page_pic, page_excerpt, page_date
           FROM `gcms_pages`
           WHERE page_status = 'publish'
             AND page_parent = 0
             AND page_type   = 'news'
           ORDER BY page_date DESC
           LIMIT ?";
$stmt   = mysqli_prepare($link, $query);
mysqli_stmt_bind_param($stmt, 'i', $countHomeNews);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// جمع‌آوری نتایج
$smalis_news = [];
while ($row = mysqli_fetch_assoc($result)) {
    $smalis_news[] = [
        'title'   => htmlspecialchars($row['page_title'], ENT_QUOTES, 'UTF-8'),
        'pic'     => $row['page_pic'],
        'excerpt' => $row['page_excerpt'] . '...',
        'url'     => "?part=news&id={$row['id']}",
        'date'    => jdate("l j F y", (int) $row['page_date']),
    ];
}

// اختصاص آرایه‌ی اخبار به Smarty
$gcms->assign('smalis_news', $smalis_news);
