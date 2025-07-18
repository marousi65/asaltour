<?php
// /gcms/php/file/basket.php
declare(strict_types=1);
require_once __DIR__.'/../lib/bootstrap.php';

use PDO;

$stage = filter_input(INPUT_REQUEST,'stage', FILTER_SANITIZE_STRING) ?? '1';
$view  = [
  'error_message'=>'',
  'success_message'=>'',
  'basket_content'=>'',
  'page_title'=>'سبد خرید'
];

// ساده‌ترین توکن CSRF
if ($_SERVER['REQUEST_METHOD']==='GET') {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
}

function f_basket_stage1(PDO $pdo, array &$v) {
    // بررسی CSRF برای GET کافی نیست؛ چون داده‌‌ای تغییر نمی‌دهد
    // اگر مشتری قدیمی است
    $email = filter_input(INPUT_POST,'email', FILTER_VALIDATE_EMAIL);
    $zip   = filter_input(INPUT_POST,'zip',   FILTER_SANITIZE_STRING);
    if ($email && $zip) {
        $stmt = $pdo->prepare(
          "SELECT * FROM gcms_customer
           WHERE email=:email AND zip=:zip LIMIT 1"
        );
        $stmt->execute([':email'=>$email,':zip'=>$zip]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $v['basket_content'] = 'مشتری یافت شد؛ لطفاً فرم زیر را تکمیل یا ویرایش کنید.';
            $v['old_customer']   = $row;
        } else {
            $v['basket_content'] = 'مشتری جدید؛ لطفاً اطلاعات را کامل کنید.';
        }
    }
}

function f_basket_stage2(PDO $pdo, array &$v) {
    // بررسی CSRF
    $token = filter_input(INPUT_POST,'csrf_token',FILTER_SANITIZE_STRING);
    if (!$token || !hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
        $v['error_message'] = 'خطای امنیتی (CSRF)';
        return;
    }
    // بررسی CAPTCHA
    $vercode = filter_input(INPUT_POST,'vercode',FILTER_SANITIZE_STRING);
    if (!isset($_SESSION['captcha_code']) 
        || strtolower($vercode) !== strtolower($_SESSION['captcha_code'])
    ) {
        $v['error_message'] = 'کد امنیتی صحیح نیست';
        return;
    }
    // ذخیره یا به‌روزرسانی مشتری
    $fields = [
      'first_name','last_name','email','state',
      'city','address','zip','tel'
    ];
    $data = [];
    foreach($fields as $f){
      $data[$f] = filter_input(INPUT_POST, $f, FILTER_SANITIZE_STRING) ?: '';
    }
    if (filter_input(INPUT_POST,'customer',FILTER_VALIDATE_INT)) {
        // UPDATE
        $sql = "UPDATE gcms_customer SET
                first_name=:first_name, last_name=:last_name,
                email=:email, state=:state, city=:city,
                address=:address, zip=:zip, tel=:tel
                WHERE customer_id=:id";
        $data['id'] = (int)$_POST['customer'];
    } else {
        // INSERT
        $sql = "INSERT INTO gcms_customer
                (first_name,last_name,email,state,city,address,zip,tel,registered)
                VALUES
                (:first_name,:last_name,:email,:state,:city,:address,:zip,:tel,:reg)";
        $data['reg'] = time();
    }
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($data)) {
        $v['success_message'] = 'اطلاعات مشتری ثبت/به‌روز شد';
        // ادامهٔ ساخت سفارش (orders + order_carts)…
    } else {
        $v['error_message'] = 'خطا در ثبت/به‌روز رسانی اطلاعات';
    }
}

// اجرا طبق stage
if ($stage==='1') {
    f_basket_stage1($pdo,$view);
} else {
    f_basket_stage2($pdo,$view);
}

$gcms->assign($view);
$gcms->assign('csrf_token', $_SESSION['csrf_token']);
$gcms->assign('menu_active','?part=basket');
$gcms->assign('part','basket');
$gcms->display('index/index.tpl');
