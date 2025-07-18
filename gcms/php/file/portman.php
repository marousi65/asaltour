<?php
declare(strict_types=1);
session_start();

// تنظیمات کلی و توابع پورت‌من
require_once __DIR__ . '/gconfig.php';
require_once __DIR__ . '/portmanfunc.php';

if ($_SESSION['g_t_login'] === "portman") {
    switch ($_GET['portman'] ?? '') {
        case "edit":
            if (($_REQUEST['edit'] ?? '') === "profile") {
                f_portman_edit_profile();
                $gcms->assign('page_title', "تغییر اطلاعات شخصی");
            }
            if (($_REQUEST['edit'] ?? '') === "pass") {
                f_portman_edit_pass();
                $gcms->assign('page_title', "تغییر کلمه عبور");
            }
            $gcms->assign('portman_content', $portman_content);
            break;

        case "report":
            // report=zlist, nlist, cncl, mcncl
            // فراخوانی توابع متناظر و تخصیص $admin_content
            // …
            $gcms->assign('portman_content', $admin_content);
            break;

        default:
            // …
    }

    mysql_close($link);
    $gcms->assign('error_message',   $error_message);
    $gcms->assign('success_message', $success_message);
    $gcms->assign('menu_active',     "?part=portman");
    $gcms->assign('part',            "portman");
    $gcms->display("index/index.tpl");

} else {
    $gcms->assign('error_message', "<center>شما اجازه دسترسی به این صفحه را ندارید</center>");
    $gcms->assign('page_title',     "غیر قابل دسترس");
    $gcms->assign('menu_active',    "?part=buy");
    $gcms->assign('part',           "buy");
    $gcms->display("index/index.tpl");
}
