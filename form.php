<?php
declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use GCMS\Controller\FormController;

$ctrl = new FormController();

if (($_GET['form'] ?? '') === 'contact' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $ctrl->handleContact();
    } catch (Exception $e) {
        $error = $e->getMessage();
        // render form with $error
    }
} else {
    $id   = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?: FIRST_PAGE;
    $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT) ?: 1;
    $ctrl->showPage($id, $page);
}
