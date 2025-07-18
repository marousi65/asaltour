<?php
declare(strict_types=1);
session_start();

// بارگذاری توابع shipman
require_once __DIR__ . '/shipmanfunc.php';

if (isset($_SESSION['g_t_login']) && $_SESSION['g_t_login'] === 'shipman') {
    // سوئیچ اصلی بر اساس پارامتر shipman
    switch ($_GET['shipman'] ?? '') {
        case 'edit':
            if (($_GET['edit'] ?? '') === 'profile') {
                f_shipman_edit_profile();
                $gcms->assign('page_title', 'ویرایش پروفایل');
            }
            if (($_GET['edit'] ?? '') === 'pass') {
                f_shipman_edit_pass();
                $gcms->assign('page_title', 'تغییر کلمه‌عبور');
            }
            if (($_GET['edit'] ?? '') === 'psngrtrade') {
                f_shipman_edit_psngrtrade();
                $gcms->assign('page_title', 'ویرایش مسیر مسافربری');
            }
            if (($_GET['edit'] ?? '') === 'cartrade') {
                f_shipman_edit_cartrade();
                $gcms->assign('page_title', 'ویرایش مسیر خودرویی');
            }
            break;

        case 'new':
            if (($_GET['new'] ?? '') === 'psngrtrade') {
                f_admin_new_psngrtrade();
                $gcms->assign('page_title', 'معرفی مسیر مسافربری جدید');
            }
            if (($_GET['new'] ?? '') === 'cartrade') {
                f_admin_new_cartrade();
                $gcms->assign('page_title', 'معرفی مسیر خودرویی جدید');
            }
            if (($_GET['new'] ?? '') === 'car') {
                f_admin_new_car();
                $gcms->assign('page_title', 'معرفی گروه خودرو جدید');
            }
            break;

        case 'list':
            if (($_GET['list'] ?? '') === 'psngrtrade') {
                if (isset($_GET['excel'])) {
                    echo "<script>location.href='/gcms/php/file/shipmanxls.php?list=psngrtrade'</script>";
                }
                f_admin_list_psngrtrade();
                $gcms->assign('page_title', 'لیست مسیرهای مسافربری');
            }
            if (($_GET['list'] ?? '') === 'car') {
                if (isset($_GET['excel'])) {
                    echo "<script>location.href='/gcms/php/file/shipmanxls.php?list=car&id={$_GET['id']}'</script>";
                }
                f_admin_list_car();
                $gcms->assign('page_title', 'لیست گروه خودروها');
            }
            if (($_GET['list'] ?? '') === 'cartrade') {
                if (isset($_GET['excel'])) {
                    echo "<script>location.href='/gcms/php/file/shipmanxls.php?list=cartrade&id={$_GET['id']}'</script>";
                }
                f_admin_list_cartrade();
                $gcms->assign('page_title', 'لیست مسیرهای خودرویی');
            }
            break;

        case 'report':
            // … توابع گزارش (zlist, nlist, cncl, mcncl)
            break;

        default:
            // صفحه پیش‌فرض
    }

    mysql_close($link);
    $gcms->assign('menu_active',   '?part=shipman');
    $gcms->assign('part',          'shipman');
    $gcms->assign('error_message', $error_message ?? '');
    $gcms->assign('success_message',$success_message ?? '');
    $gcms->display('index/index.tpl');
}
else {
    $gcms->assign('error_message', '<center>دسترسی غیرمجاز</center>');
    $gcms->assign('page_title',    'غیر قابل دسترس');
    $gcms->assign('menu_active',   '?part=buy');
    $gcms->assign('part',          'buy');
    $gcms->display('index/index.tpl');
}
