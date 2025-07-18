<?php
declare(strict_types=1);

namespace GCMS\File;

// بارگذاری تنظیمات
require_once __DIR__ . '/../../gconfig.php';

session_start();
global $gcms;

// استخراج امن مقادیر سشن
$g_id     = $_SESSION['g_id_login']    ?? 0;
$g_ip     = $_SESSION['g_ip_login']    ?? '';
$g_type   = $_SESSION['g_t_login']     ?? '';
$g_name   = $_SESSION['g_name_login']  ?? '';
$g_email  = $_SESSION['g_email_login'] ?? '';

// اختصاص مقادیر پایه
$gcms->assign('g_id_login',   $g_id);
$gcms->assign('g_ip_login',   $g_ip);
$gcms->assign('g_t_login',    $g_type);
$gcms->assign('g_name_login', $g_name);
$gcms->assign('g_email_login',$g_email);

// در صورت کاربر از نوع Agency
if ($g_type === 'agency') {
    $g_agency_name   = $_SESSION['g_agency_name']      ?? '';
    $g_agency_credit = (int) ($_SESSION['g_agency_credit'] ?? 0);
    $g_agency_use    = (int) ($_SESSION['g_agency_use']    ?? 0);
    $remaining       = $g_agency_credit - $g_agency_use;

    $gcms->assign('g_agency_name',   $g_agency_name);
    $gcms->assign('g_agency_credit', number_format($g_agency_credit));
    $gcms->assign('g_agency_use',    number_format($g_agency_use));
    $gcms->assign('baghimande_poll', number_format($remaining));

    // در صورت وجود Customer ID
    if (!empty($_SESSION['g_customer_id_buy'])) {
        $gcms->assign('g_customer_name_buy',
                     $_SESSION['g_customer_name_buy']);
    }
}
