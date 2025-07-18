<?php
declare(strict_types=1);
session_start();

require_once __DIR__ . '/gconfig.php';

// اگر نیاز به تابع خاصی شبیه highlight_search دارید، اینجا include کنید
require_once __DIR__ . '/search.php';

// یا مستقیماً منطق جستجوی مربوط به تراکنش‌های تجاری را پیاده کنید:
//
// $term = mysql_real_escape_string(trim($_REQUEST['term'] ?? ''));
// $sql  = "SELECT * FROM `trade_table` WHERE `column` LIKE '%{$term}%'";
// …
// $gcms->assign('searchtrade_results', $html);
//

$gcms->assign('menu_active', '?part=searchtrade');
$gcms->assign('part', 'searchtrade');
$gcms->display('index/index.tpl');

--------------------------------------------------------------------------------  
**مکان قرارگیری نهایی**  
تمامِ فایل‌های فوق را در فولدر:  

<project_root>/
└─ gcms/
   └─ php/
      └─ file/
         ├─ reverse.php
         ├─ rss_generator.inc.php
         ├─ rss2.php
         ├─ search.php
         ├─ searchtrade.php
         └─ nusoap.php       ← Bootstrap NuSOAP