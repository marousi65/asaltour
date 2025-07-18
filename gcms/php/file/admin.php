<?php
declare(strict_types=1);
require_once __DIR__.'/../lib/bootstrap.php';
require_once __DIR__.'/adminfunc.php';

// ۱) اعتبارسنجی دسترسی
if (!isset($_SESSION['g_t_login']) || $_SESSION['g_t_login']!=='admin') {
    $gcms->assign([
      'error_message'=>"دسترسی غیرمجاز",
      'page_title'=>"خطا",
      'part'=>'buy',
      'menu_active'=>'?part=buy',
    ]);
    $gcms->display('index/index.tpl');
    exit;
}

// ۲) دریافت پارامترها
$admin_action = filter_input(INPUT_GET,'admin', FILTER_SANITIZE_STRING) ?? 'dashboard';
$sub_action   = filter_input(INPUT_GET,'sub',   FILTER_SANITIZE_STRING) ?? null;
$id           = filter_input(INPUT_GET,'id',    FILTER_VALIDATE_INT);

// ۳) نگهداری اطلاعات برای قالب
$view = [
  'error_message'=>'',
  'success_message'=>'',
  'admin_content'=>'',
  'page_title'=>'پنل مدیریت',
  // در اینجا می‌توانید فرم‌های HTML یا نام قالب را تعریف کنید
  'forms'=>[
    'edit_profile' => file_get_contents(__DIR__.'/forms/edit_profile.tpl'),
    // …
  ]
];

// ۴) نگاشت action → تابع
$map = [
  'edit'=>[
     'profile' => 'f_admin_editprofile',
     'sailing' => 'f_admin_editsailing',
     // …
  ],
  'list'=>[
     'sailing' => 'f_admin_listsailing',
     // …
  ],
  // …
];

if (isset($map[$admin_action][$sub_action])) {
    $func = $map[$admin_action][$sub_action];
    $func($pdo, $view);
    $gcms->assign('page_title', $view['page_title'] ?? ucfirst($admin_action));
} else {
    // پیش‌فرض: داشبورد یا ریدایرکت
    $view['admin_content'] = 'به پنل مدیریت خوش آمدید.';
}

// ۵) ارسال به قالب
$gcms->assign($view);
$gcms->assign('menu_active','?part=admin');
$gcms->assign('part','admin');
$gcms->display('index/index.tpl');
