<?php
// /gcms/php/file/buyfunc.php
declare(strict_types=1);
use PDO;

function f_buy_psn_stage1(PDO $pdo, array &$v) {
    $id_enc = filter_input(INPUT_GET,'psngrtrade', FILTER_SANITIZE_STRING);
    // decode ID، سپس SELECT با Prepared
    // نمایش فرم انتخاب همراه و جزئیات کشتی
    // $v['buy_content'] = HTML fragment
}
function f_buy_psn_stage2(PDO $pdo, array &$v) {
    // POST processing → ثبت سفارش در جدول مربوطه
    // Prepared INSERT
}
function f_buy_car_stage1(PDO $pdo, array &$v){ /* … */ }
function f_buy_car_stage2(PDO $pdo, array &$v){ /* … */ }
