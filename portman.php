<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use GCMS\Controller\PortmanController;

$ctrl = new PortmanController();
$ctrl->dispatch();
