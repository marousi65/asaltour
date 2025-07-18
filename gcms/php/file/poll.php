<?php
declare(strict_types=1);
session_start();

// تنظیمات کلی
require_once __DIR__ . '/gconfig.php';
// اگر تقویم شمسی لازم دارید:
// require_once __DIR__ . '/jdf.php';

// منطق نمایش نظرسنجی (poll)
// …
// مثلاً:
// if (isset($_POST['vote'])) { /* ثبت رأی */ }
// $gcms->assign('options', $options);
// $gcms->assign('results', $results);

$gcms->assign('menu_active', "?part=poll");
$gcms->assign('part',        "poll");
$gcms->display("index/index.tpl");
