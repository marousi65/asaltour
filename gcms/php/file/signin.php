<?php
declare(strict_types=1);
session_start();

// بارگذاری تنظیمات پایه
require_once __DIR__ . '/gconfig.php';

$error_message = '';

// خروج از سیستم
if (isset($_REQUEST['signout']) && $_REQUEST['signout'] === 'true') {
    $_SESSION = [];
    session_destroy();
    header('Location: ?part=page&id=1');
    exit;
}

// ورود کاربر
if (
    isset($_REQUEST['signin'], $_REQUEST['email'], $_REQUEST['pass'])
    && $_REQUEST['signin'] === 'true'
    && trim($_REQUEST['email']) !== ''
    && trim($_REQUEST['pass']) !== ''
) {
    $email = mysql_real_escape_string(trim($_REQUEST['email']));
    $sql   = "SELECT * FROM `gcms_login` 
              WHERE `email` = '{$email}' AND `active` = 'true' LIMIT 1";
    $res   = mysql_query($sql, $link);
    $row   = mysql_fetch_assoc($res);

    if ($row) {
        if (crypt($_REQUEST['pass'], $row['pass']) === $row['pass']) {
            // ست‌کردن مقادیر سشن
            $_SESSION['g_id_login']    = (int)$row['id'];
            $_SESSION['g_ip_login']    = $_SERVER['REMOTE_ADDR'];
            $_SESSION['g_t_login']     = $row['type'];
            $_SESSION['g_name_login']  = $row['fname'] . ' ' . $row['lname'];
            $_SESSION['g_email_login'] = $row['email'];

            if ($row['type'] === 'agency') {
                // بارگذاری متادیتای آژانس
                $metaSql = "
                  SELECT `key`, `value` 
                  FROM `gcms_metalogin` 
                  WHERE `login_id` = {$_SESSION['g_id_login']}";
                $metaRes = mysql_query($metaSql, $link);
                while ($m = mysql_fetch_assoc($metaRes)) {
                    $_SESSION['g_agency_' . $m['key']] = $m['value'];
                }
            }

            header('Location: ?part=page&id=1');
            exit;
        }
        else {
            $error_message = 'کلمه عبور اشتباه است.';
        }
    }
    else {
        $error_message = 'نام کاربری اشتباه است.';
    }

    mysql_close($link);
}

// اختصاص متغیرها به Smarty و نمایش
$gcms->assign('error_message', $error_message);
$gcms->assign('menu_active',   '?part=signin');
$gcms->assign('part',          'signin');
$gcms->assign('page_title',    'ورود به سایت');
$gcms->display('index/index.tpl');
