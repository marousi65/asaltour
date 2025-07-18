<?php
declare(strict_types=1);

namespace GCMS\File;

use Smarty;

// بارگذاری تنظیمات
require_once __DIR__ . '/../../gconfig.php';

global $gcms, $link;

$errors  = [];
$success = false;

// در صورت ارسال فرم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // اعتبارسنجی ایمیل
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    if (!$email) {
        $errors[] = 'ایمیل وارد شده معتبر نیست.';
    } else {
        // درج در جدول خبرنامه
        $query = "INSERT INTO `gcms_newsletter` (`email`, `subscribe_date`)
                  VALUES (?, ?)";
        if ($stmt = mysqli_prepare($link, $query)) {
            $now = time();
            mysqli_stmt_bind_param($stmt, 'si', $email, $now);
            if (mysqli_stmt_execute($stmt)) {
                $success = true;
            } else {
                $errors[] = 'در ثبت ایمیل خطایی رخ داده است.';
            }
        }
    }
}

// اختصاص نتایج به Smarty
$gcms->assign('newsletter_success', $success);
$gcms->assign('newsletter_errors',  $errors);
