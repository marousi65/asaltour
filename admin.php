<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use GCMS\Controller\AdminController;

$ctrl = new AdminController();
$ctrl->dispatch();
