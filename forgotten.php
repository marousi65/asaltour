<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use GCMS\Controller\ForgottenController;

$ctrl = new ForgottenController();
$step = filter_input(INPUT_GET, 'forgotten', FILTER_SANITIZE_STRING) ?? '';

if ($step === 'step2' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $ctrl->handleStep2();
} else {
    $ctrl->showStep1();
}
