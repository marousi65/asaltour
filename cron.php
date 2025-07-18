<?php
declare(strict_types=1);

use GCMS\Config\Database;
use GCMS\Cron\CronJob;

require __DIR__ . '/../vendor/autoload.php';

// کانفیگ‌های محیطی را در constants تعریف کنید (DB_HOST, DB_NAME,…)
$pdo  = Database::getConnection();
$cron = new CronJob($pdo);
$cron->run();
