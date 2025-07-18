<?php
declare(strict_types=1);
session_start();

// تنظیمات کلی
require_once __DIR__ . '/gconfig.php';
require_once __DIR__ . '/jdf.php';

// منطق نمایش صفحات ثابت و ثبت نظرات
// …
// if (isset($_REQUEST['opinion'])) { /* ثبت نظر */ }
// $gcms->assign('page_title',   $page_title);
// $gcms->assign('page_content', $page_content);
// $gcms->assign('comments',     $comments);

$gcms->assign('menu_active', "?part=page");
$gcms->assign('part',        "page");
$gcms->display("index/index.tpl");
