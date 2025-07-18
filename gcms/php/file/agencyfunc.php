<?php
// مثال: /gcms/php/file/agencyfunc.php
declare(strict_types=1);
use PDO;

function f_agency_edit_profile(PDO $pdo, array &$v) {
    // CSRF+POST check …
    // $sql = "UPDATE gcms_login … WHERE id=:id";
    // Prepared + bind + execute
    // $v['success_message'] یا $v['error_message']
    // $v['agency_content'] = فرم HTML از پیش آماده یا Smarty-rendered subtemplate
}

// سایر توابع: f_agency_list_psngrtrade, f_agency_print_psngrtrade, …
// درون هر کدام از PDO + filter_input + escaping در خروجی استفاده کنید.
