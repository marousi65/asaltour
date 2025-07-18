<?php
// /gcms/php/file/buy.php
declare(strict_types=1);
require_once __DIR__.'/../lib/bootstrap.php';

use PDO;

$action = filter_input(INPUT_GET,'buy', FILTER_SANITIZE_STRING) ?? 'psngrtrade';
$stage  = filter_input(INPUT_GET,'stage',FILTER_SANITIZE_STRING) ?? '1';

require_once __DIR__.'/buyfunc.php';

$view = [
  'error_message'=>'',
  'success_message'=>'',
  'buy_content'=>'',
  'page_title'=>'خرید بلیط',
];

$map = [
  'psngrtrade'=>['1'=>'f_buy_psn_stage1','2'=>'f_buy_psn_stage2'],
  'cartrade'  =>['1'=>'f_buy_car_stage1','2'=>'f_buy_car_stage2'],
];

if (isset($map[$action][$stage])) {
    $fn = $map[$action][$stage];
    $fn($pdo,$view);
} else {
    $view['error_message'] = 'پارامتر نامعتبر';
}

$gcms->assign($view);
$gcms->assign('menu_active','?part=buy');
$gcms->assign('part','buy');
$gcms->display('index/index.tpl');
