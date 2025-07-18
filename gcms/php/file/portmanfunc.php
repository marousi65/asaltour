<?php
declare(strict_types=1);

// تنظیمات کلی
require_once __DIR__ . '/gconfig.php';

// تابع ویرایش پروفایل
function f_portman_edit_profile(): void {
    require_once __DIR__ . '/formportman.php';
    global $error_message, $success_message, $portman_content, $link;

    if (($_REQUEST['profile'] ?? '') === "chng") {
        $sql = "
            UPDATE `gcms_login` SET
                `fname`   = '" . mysql_real_escape_string($_REQUEST['fname'] ?? '') . "',
                `lname`   = '" . mysql_real_escape_string($_REQUEST['lname'] ?? '') . "',
                `address` = '" . mysql_real_escape_string($_REQUEST['address'] ?? '') . "',
                `tell`    = '" . mysql_real_escape_string($_REQUEST['tell'] ?? '') . "',
                `cell`    = '" . mysql_real_escape_string($_REQUEST['cell'] ?? '') . "'
            WHERE `id` = " . intval($_SESSION['g_id_login']) . "
            LIMIT 1
        ";
        if (mysql_query($sql, $link)) {
            // … پیام موفقیت و ریدایرکت
        } else {
            $error_message = "مشکل در انجام تغییرات لطفا دوباره تلاش کنید.";
        }
    }

    $portman_content = $form_portman_edit_profile;
}

// تابع ویرایش کلمه‌عبور
function f_portman_edit_pass(): void {
    require_once __DIR__ . '/formportman.php';
    global $error_message, $success_message, $portman_content, $link;

    if (($_REQUEST['passw'] ?? '') === "chng" && !empty($_REQUEST['pass']) && !empty($_REQUEST['repass'])) {
        if ($_REQUEST['pass'] === $_REQUEST['repass']) {
            $newpass = crypt($_REQUEST['pass']);
            $sql = "
                UPDATE `gcms_login` SET
                    `pass` = '" . mysql_real_escape_string($newpass) . "'
                WHERE `id` = " . intval($_SESSION['g_id_login']) . "
                LIMIT 1
            ";
            if (mysql_query($sql, $link)) {
                // … پیام موفقیت
            } else {
                $error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید.";
            }
        } else {
            $error_message = "کلمات عبور هماهنگ نبود لطفا دوباره تلاش کنید.";
        }
    }

    $portman_content = $form_portman_edit_pass;
}

// توابع گزارشات (zlist, nlist, cncl, mcncl) – بدون تغییر منطق اصلی
// …
