<?php
declare(strict_types=1);
require_once __DIR__.'/../lib/bootstrap.php';
require_once __DIR__.'/agencyfunc.php';  // مشابه adminfunc

if (!isset($_SESSION['g_t_login']) || $_SESSION['g_t_login']!=='agency') {
    $gcms->assign([
      'error_message'=>"دسترسی غیرمجاز",
      'page_title'=>"خطا",
      'part'=>'buy','menu_active'=>'?part=buy'
    ]);
    $gcms->display('index/index.tpl');
    exit;
}

// پارامترها
$action = filter_input(INPUT_GET,'agency',FILTER_SANITIZE_STRING);
$sub    = filter_input(INPUT_GET,'sub',   FILTER_SANITIZE_STRING);

$view = ['error_message'=>'','success_message'=>'','agency_content'=>''];

$map = [
  'list'=>[
    'psngrtrade'=>'f_agency_list_psngrtrade',
    'cartrade'  =>'f_agency_list_cartrade',
  ],
  'edit'=>[
    'profile'=>'f_agency_edit_profile',
    'pass'   =>'f_agency_edit_pass',
  ],
  // …
];

if (isset($map[$action][$sub])) {
    $func = $map[$action][$sub];
    $func($pdo,$view);
    $gcms->assign('page_title',$view['page_title'] ?? 'پنل آژانس');
} else {
    $view['agency_content'] = 'به پنل آژانس خوش آمدید.';
}

$gcms->assign($view);
$gcms->assign('menu_active','?part=agency');
$gcms->assign('part','agency');
$gcms->display('index/index.tpl');
