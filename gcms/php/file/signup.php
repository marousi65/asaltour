<?php
declare(strict_types=1);
session_start();

// بارگذاری تنظیمات پایه و تابع ارسال ایمیل
require_once __DIR__ . '/gconfig.php';
require_once __DIR__ . '/mail.php';

$error_message   = '';
$success_message = '';
$signup_content  = '';

/**
 * نمایش فرم مرحله اول ثبت‌نام
 */
function f_newsignup(): void {
    global $signup_content;
    // مقادیر پیش‌فرض فیلدها
    $fname    = htmlspecialchars($_REQUEST['fname']    ?? '', ENT_QUOTES);
    $lname    = htmlspecialchars($_REQUEST['lname']    ?? '', ENT_QUOTES);
    $melicode = htmlspecialchars($_REQUEST['melicode'] ?? '', ENT_QUOTES);
    $email    = htmlspecialchars($_REQUEST['email']    ?? '', ENT_QUOTES);
    $address  = htmlspecialchars($_REQUEST['address']  ?? '', ENT_QUOTES);
    $tell     = htmlspecialchars($_REQUEST['tell']     ?? '', ENT_QUOTES);
    $cell     = htmlspecialchars($_REQUEST['cell']     ?? '', ENT_QUOTES);
    $trkh     = date("Y/m/d");

    $signup_content = <<<HTML
<form action="?part=signup&signup=step2" method="post" onsubmit="return ValidateRegistration(this);" name="signup">
<table id="hor-minimalist-a-1">
<tbody>
    <tr><td>نام</td><td><input type="text" name="fname"    value="{$fname}"    class="reqd" lang="fa" /></td></tr>
    <tr><td>نام خانوادگی</td><td><input type="text" name="lname"    value="{$lname}"    class="reqd" lang="fa" /></td></tr>
    <tr><td>کد ملی</td>
        <td>
            <input type="text" name="melicode" value="{$melicode}" class="reqd" onKeyUp="javascript:checkNumber(signup.melicode);" />
            <div id="melicode-status"></div>
        </td>
    </tr>
    <tr><td>ایمیل</td><td><input type="text" name="email"   value="{$email}"   class="email" /></td></tr>
    <tr><td>رمز عبور</td><td><input type="password" name="pass" class="reqd" /></td></tr>
    <tr><td>آدرس</td><td><textarea name="address" class="reqd" lang="fa">{$address}</textarea></td></tr>
    <tr><td>تلفن</td>
        <td>
            <input type="text" name="tell" value="{$tell}" onKeyUp="javascript:checkNumber(signup.tell);" />
            <div id="tell-status"></div>
        </td>
    </tr>
    <tr><td>موبایل</td>
        <td>
            <input type="text" name="cell" value="{$cell}" onKeyUp="javascript:checkNumber(signup.cell);" />
            <div id="cell-status"></div>
        </td>
    </tr>
    <tr><td>تاریخ عضویت</td><td>{$trkh}</td></tr>
    <tr><td>کد امنیتی</td>
        <td>
            <input type="text" name="vercode" class="reqd" />
            <div id="vercode-status"></div>
        </td>
    </tr>
    <tr><td></td><td><img src="/gcms/php/file/captcha.php" align="absmiddle" /></td></tr>
    <tr><td></td><td><input type="submit" value="ایجاد" onMouseDown="initForms()" /></td></tr>
</tbody>
</table>
</form>

<script type="text/javascript">
// تنظیم Limiter برای فیلدها (مثال برای melicode)
fieldlimiter.setup({
  thefield: document.signup.melicode,
  maxlength: 10,
  statusids: ['melicode-status']
});
// … باقی تنظیمات مشابه برای tell, cell, vercode
</script>
HTML;
}

// سوئیچ مراحل ثبت‌نام
switch ($_GET['signup'] ?? '') {
    case 'step1':
        f_newsignup();
        $gcms->assign('page_title',       'ثبت نام کاربر جدید');
        $gcms->assign('signup_content',   $signup_content);
        break;

    case 'step2':
        // بررسی کپچا
        if (empty($_SESSION['vercode']) || $_REQUEST['vercode'] !== $_SESSION['vercode']) {
            $error_message = 'کد امنیتی اشتباه وارد شده.';
            f_newsignup();
        }
        else {
            // حداقل فیلدهای اجباری
            if (trim($_REQUEST['fname'] ?? '') === '' ||
                trim($_REQUEST['lname'] ?? '') === '' ||
                trim($_REQUEST['melicode'] ?? '') === '' ||
                trim($_REQUEST['email'] ?? '') === '' ||
                trim($_REQUEST['pass'] ?? '') === '')
            {
                $error_message = 'لطفاً تمامی فیلدهای اجباری را تکمیل کنید.';
                f_newsignup();
            }
            else {
                // جلوگیری از تکرار ایمیل یا کد ملی
                $melicode = mysql_real_escape_string($_REQUEST['melicode'], $link);
                $email    = mysql_real_escape_string($_REQUEST['email'],    $link);
                $chk      = mysql_fetch_assoc(mysql_query(
                    "SELECT `id` FROM `gcms_login`
                     WHERE `melicode`='{$melicode}' OR `email`='{$email}' LIMIT 1",
                    $link
                ));
                if ($chk['id']) {
                    $error_message = 'کد ملی یا ایمیل تکراری است.';
                    f_newsignup();
                }
                else {
                    // آماده‌سازی داده‌ها
                    $fname   = mysql_real_escape_string($_REQUEST['fname'],   $link);
                    $lname   = mysql_real_escape_string($_REQUEST['lname'],   $link);
                    $address = mysql_real_escape_string($_REQUEST['address'], $link);
                    $tell    = mysql_real_escape_string($_REQUEST['tell'],    $link);
                    $cell    = mysql_real_escape_string($_REQUEST['cell'],    $link);
                    $pass    = crypt($_REQUEST['pass']);

                    $trkh = date("Y/m/d");
                    $sql  = "
                        INSERT INTO `gcms_login`
                        (`fname`,`lname`,`melicode`,`email`,`pass`,`address`,`tell`,`cell`,`type`,`active`,`regdate`)
                        VALUES
                        ('{$fname}','{$lname}','{$melicode}','{$email}','{$pass}','{$address}','{$tell}','{$cell}','free','true','{$trkh}')
                    ";
                    if (mysql_query($sql, $link)) {
                        $success_message = "
                        کاربر گرامی، ثبت نام شما با موفقیت انجام شد.<br>
                        نام کاربری: {$email}<br>
                        کلمه عبور: {$_REQUEST['pass']}<br>
                        ";
                        // ایمیل خوش‌آمدگویی
                        $subject = "Asaltour.ir | New User";
                        $body    = "<div>کاربر گرامی {$fname} {$lname}, ثبت نام شما با موفقیت انجام شد.</div>";
                        sendmail($email, "support@asaltour.ir", $body, $subject, $messmail);
                    }
                    else {
                        $error_message = 'خطا در ذخیره‌سازی اطلاعات، لطفاً دوباره تلاش کنید.';
                        f_newsignup();
                    }
                }
            }
        }

        $gcms->assign('page_title',     'ثبت نام کاربر جدید');
        $gcms->assign('signup_content', $signup_content);
        break;

    default:
        // هدایت به مرحله اول
        header('Location: ?part=signup&signup=step1');
        exit;
}

mysql_close($link);

// پاس دادن متغیرها به قالب Smarty
$gcms->assign('error_message',   $error_message);
$gcms->assign('success_message', $success_message);
$gcms->assign('menu_active',     '?part=signup');
$gcms->assign('part',            'signup');
$gcms->display('index/index.tpl');
