<?php
// فایل gconfig.php شما باید چیزی شبیه به این داشته باشد:
// $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// if ($mysqli->connect_errno) { die("MySQLi connection failed: " . $mysqli->connect_error); }

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/formadmin.php';

//
// ویرایش پروفایل مدیر
//
function f_admin_editprofile(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_edit_profile;

    if (isset($_REQUEST['profile']) && $_REQUEST['profile'] === "chng") {
        // ایمن‌سازی ورودی‌ها
        $fname   = $mysqli->real_escape_string($_REQUEST['fname']);
        $lname   = $mysqli->real_escape_string($_REQUEST['lname']);
        $address = $mysqli->real_escape_string($_REQUEST['address']);
        $tell    = $mysqli->real_escape_string($_REQUEST['tell']);
        $cell    = $mysqli->real_escape_string($_REQUEST['cell']);
        $id      = (int) $_SESSION['g_id_login'];

        $sql = "
            UPDATE `gcms_login` SET
                `fname`   = '$fname',
                `lname`   = '$lname',
                `address` = '$address',
                `tell`    = '$tell',
                `cell`    = '$cell'
            WHERE `id` = {$id}
            LIMIT 1
        ";

        if ($mysqli->query($sql)) {
            $_SESSION['g_name_login'] = "{$fname} {$lname}";
            $success_message = "
                تغییرات با موفقیت انجام شد<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=edit&edit=profile';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام تغییرات لطفاً دوباره سعی کنید.";
        }
    }

    $admin_content = $form_admin_edit_profile;
}

//
// اضافه کردن کشتیرانی جدید
//
function f_admin_newsailing(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_new_sailing;

    if (isset($_REQUEST['new'], $_REQUEST['name'])
        && $_REQUEST['new'] === "sailing"
        && strlen(trim($_REQUEST['name'])) > 0
    ) {
        $name = $mysqli->real_escape_string($_REQUEST['name']);
        $sql  = "INSERT INTO `gcms_sailing` (`name`) VALUES ('{$name}')";

        if ($mysqli->query($sql)) {
            $success_message = "
                اطلاعات زیر با موفقیت اضافه شد:<br>
                کشتیرانی: {$name}<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=list&list=sailing';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام تغییرات لطفاً دوباره سعی کنید.";
        }
    }

    $admin_content = $form_admin_new_sailing;
}

//
// ویرایش کلمه عبور مدیر
//
function f_admin_editpass(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_edit_pass;

    if (isset($_REQUEST['passw'], $_REQUEST['pass'], $_REQUEST['repass'])
        && $_REQUEST['passw'] === "chng"
        && strlen($_REQUEST['pass']) > 0
        && strlen($_REQUEST['repass']) > 0
    ) {
        if ($_REQUEST['pass'] === $_REQUEST['repass']) {
            $newpass = crypt($_REQUEST['pass']);
            $id      = (int) $_SESSION['g_id_login'];
            $sql     = "
                UPDATE `gcms_login`
                SET `pass` = '{$newpass}'
                WHERE `id` = {$id}
                LIMIT 1
            ";

            if ($mysqli->query($sql)) {
                $p = htmlspecialchars($_REQUEST['pass'], ENT_QUOTES);
                $success_message = "
                    تغییر کلمه عبور با موفقیت انجام شد.<br>
                    کلمه عبور جدید: {$p}<br>
                    <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                    <script>setTimeout(function(){
                        top.location.href = '?part=admin&admin=edit&edit=pass';
                    }, 5000);</script>
                ";
            }
            else {
                $error_message = "مشکل در انجام تغییرات لطفاً دوباره سعی کنید.";
            }
        }
        else {
            $error_message = "کلمات عبور با هم مطابقت ندارند. لطفاً دوباره تلاش کنید.";
        }
    }

    $admin_content = $form_admin_edit_pass;
}

//
// لیست کشتیرانی‌ها
//
function f_admin_listsailing(){
    global $mysqli, $error_message, $success_message, $admin_content;

    $res = $mysqli->query("SELECT * FROM `gcms_sailing` ORDER BY `name` ASC");
    $html = "
        <table id='formtable'>
            <tr>
                <th>نام کشتیرانی</th>
                <th>عملیات</th>
            </tr>
    ";

    while ($row = $res->fetch_assoc()) {
        $id   = (int)$row['id'];
        $name = htmlspecialchars($row['name'], ENT_QUOTES);
        $html .= "
            <tr>
                <td><center>{$name}</center></td>
                <td>
                    <center>
                        <a href='?part=admin&admin=edit&edit=sailing&sailing={$id}'>ویرایش</a> |
                        <a href='?part=admin&admin=dell&dell=sailing&sailing={$id}'
                           onclick=\"return confirm('آیا از حذف این آیتم اطمینان دارید؟');\">
                           حذف
                        </a>
                    </center>
                </td>
            </tr>
        ";
    }

    $html .= "</table>";
    $admin_content = $html;
}

//
// ویرایش یک کشتیرانی
//
function f_admin_editsailing(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_edit_sailing;

    if (isset($_REQUEST['editsailing'], $_REQUEST['name'], $_REQUEST['sailing'])
        && $_REQUEST['editsailing'] === "chng"
    ) {
        $name      = $mysqli->real_escape_string($_REQUEST['name']);
        $sailingId = (int) $_REQUEST['sailing'];
        $sql       = "
            UPDATE `gcms_sailing`
            SET `name` = '{$name}'
            WHERE `id` = {$sailingId}
            LIMIT 1
        ";

        if ($mysqli->query($sql)) {
            $success_message = "
                تغییرات با موفقیت انجام شد.<br>
                نام جدید: {$name}<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=list&list=sailing';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام تغییرات لطفاً دوباره سعی کنید.";
        }
    }

    $admin_content = $form_admin_edit_sailing;
}

//
// حذف یک کشتیرانی
//
function f_admin_delsailing(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_new_sailing;

    if (isset($_REQUEST['dell'], $_REQUEST['sailing'])
        && $_REQUEST['dell'] === "sailing"
    ) {
        $sailingId = (int) $_REQUEST['sailing'];
        $sql       = "
            DELETE FROM `gcms_sailing`
            WHERE `id` = {$sailingId}
            LIMIT 1
        ";

        if ($mysqli->query($sql)) {
            $success_message = "
                سطر مورد نظر با موفقیت حذف شد.<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=list&list=sailing';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام حذف لطفاً دوباره تلاش کنید.";
        }
    }

    // جهت نمایش فرم حذف یا لیست می‌توانید $form_admin_new_sailing را مجدداً تنظیم کنید یا قالب دلخواه را در $admin_content قرار دهید.
}

//
// اضافه کردن مقصد جدید (شهر)
//
function f_admin_newdes(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_new_des;

    if (isset($_REQUEST['des'], $_REQUEST['name'])
        && $_REQUEST['des'] === "true"
        && strlen(trim($_REQUEST['name'])) > 0
    ) {
        $name = $mysqli->real_escape_string($_REQUEST['name']);
        $sql  = "INSERT INTO `gcms_des` (`name`) VALUES ('{$name}')";

        if ($mysqli->query($sql)) {
            $success_message = "
                اطلاعات زیر با موفقیت اضافه شد:<br>
                نام شهر: {$name}<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=list&list=des';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام تغییرات لطفاً دوباره سعی کنید.";
        }
    }

    $admin_content = $form_admin_new_des;
}

//
// لیست مقاصد (شهرها)
//
function f_admin_listdes(){
    global $mysqli, $error_message, $success_message, $admin_content;

    $res = $mysqli->query("SELECT * FROM `gcms_des` ORDER BY `name` ASC");
    $html = "
        <table id='formtable'>
            <tr>
                <th>نام شهر</th>
                <th>عملیات</th>
            </tr>
    ";

    while ($row = $res->fetch_assoc()) {
        $id   = (int)$row['id'];
        $name = htmlspecialchars($row['name'], ENT_QUOTES);
        $html .= "
            <tr>
                <td><center>{$name}</center></td>
                <td>
                    <center>
                        <a href='?part=admin&admin=edit&edit=des&des={$id}'>ویرایش</a> |
                        <a href='?part=admin&admin=dell&dell=des&des={$id}'
                           onclick=\"return confirm('آیا از حذف این شهر اطمینان دارید؟');\">
                           حذف
                        </a>
                    </center>
                </td>
            </tr>
        ";
    }

    $html .= "</table>";
    $admin_content = $html;
}

//
// ویرایش یک مقصد
//
function f_admin_editdes(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_edit_des;

    if (isset($_REQUEST['editdes'], $_REQUEST['name'], $_REQUEST['des'])
        && $_REQUEST['editdes'] === "chng"
    ) {
        $name = $mysqli->real_escape_string($_REQUEST['name']);
        $id   = (int) $_REQUEST['des'];
        $sql  = "
            UPDATE `gcms_des`
            SET `name` = '{$name}'
            WHERE `id` = {$id}
            LIMIT 1
        ";

        if ($mysqli->query($sql)) {
            $success_message = "
                تغییرات با موفقیت انجام شد.<br>
                نام جدید: {$name}<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=list&list=des';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام تغییرات لطفاً دوباره سعی کنید.";
        }
    }

    $admin_content = $form_admin_edit_des;
}

//
// حذف یک مقصد
//
function f_admin_deldes(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_new_des;

    if (isset($_REQUEST['dell'], $_REQUEST['des'])
        && $_REQUEST['dell'] === "des"
    ) {
        $id  = (int) $_REQUEST['des'];
        $sql = "
            DELETE FROM `gcms_des`
            WHERE `id` = {$id}
            LIMIT 1
        ";

        if ($mysqli->query($sql)) {
            $success_message = "
                سطر مورد نظر با موفقیت حذف شد.<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=list&list=des';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام حذف لطفاً دوباره تلاش کنید.";
        }
    }
}

//
// ثبت مدیر کشتی (shipman)
//
function f_admin_newshipman(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_new_shipman;

    if (isset($_REQUEST['shipman'])
        && $_REQUEST['shipman'] === "true"
        && !empty($_REQUEST['fname'])
        && !empty($_REQUEST['lname'])
        && !empty($_REQUEST['melicode'])
        && !empty($_REQUEST['email'])
        && !empty($_REQUEST['pass'])
    ) {
        // ایمن‌سازی
        $fname     = $mysqli->real_escape_string($_REQUEST['fname']);
        $lname     = $mysqli->real_escape_string($_REQUEST['lname']);
        $melicode  = $mysqli->real_escape_string($_REQUEST['melicode']);
        $email     = $mysqli->real_escape_string($_REQUEST['email']);
        $pass      = crypt($_REQUEST['pass']);
        $address   = $mysqli->real_escape_string($_REQUEST['address']);
        $tell      = $mysqli->real_escape_string($_REQUEST['tell']);
        $cell      = $mysqli->real_escape_string($_REQUEST['cell']);
        $active    = ($mysqli->real_escape_string($_REQUEST['active']) === '1') ? 1 : 0;
        $regdate   = date("Y/m/d");

        // جلوگیری از تکرار
        $chk_sql = "
            SELECT `id`
            FROM `gcms_login`
            WHERE `melicode` = '{$melicode}'
               OR `email`    = '{$email}'
            LIMIT 1
        ";
        $chk_res = $mysqli->query($chk_sql);
        if ($chk_res->num_rows > 0) {
            $error_message = "کد ملی یا ایمیل تکراری است.";
        }
        else {
            // درج در جدول اصلی
            $sql = "
                INSERT INTO `gcms_login`(
                    `fname`,`lname`,`melicode`,`email`,`pass`,
                    `address`,`tell`,`cell`,`type`,`active`,`regdate`
                ) VALUES (
                    '{$fname}','{$lname}','{$melicode}','{$email}','{$pass}',
                    '{$address}','{$tell}','{$cell}','shipman',{$active},'{$regdate}'
                )
            ";
            if ($mysqli->query($sql)) {
                $uid = $mysqli->insert_id;

                // جمع‌آوری مجوزهای sailing
                $arrsl    = [];
                $mil_sail = '';
                if (!empty($_REQUEST['sllst']) && is_array($_REQUEST['sllst'])) {
                    foreach ($_REQUEST['sllst'] as $sid) {
                        $sid = (int)$sid;
                        if ($sid > 0) {
                            $arrsl[] = $sid;
                            // نام کشتیرانی
                            $r = $mysqli->query("SELECT `name` FROM `gcms_sailing` WHERE `id` = {$sid} LIMIT 1");
                            if ($r && $rr = $r->fetch_assoc()) {
                                $mil_sail .= htmlspecialchars($rr['name'], ENT_QUOTES) . "، ";
                            }
                        }
                    }
                }
                $sailing_list = implode(',', $arrsl);

                // درج در metalogin
                $meta_sql = "
                    INSERT INTO `gcms_metalogin`(`login_id`,`key`,`value`)
                    VALUES ({$uid}, 'sailing', '{$sailing_list}')
                ";
                $mysqli->query($meta_sql);

                // پیام موفقیت
                $pwd_safe = htmlspecialchars($_REQUEST['pass'], ENT_QUOTES);
                $success_message = "
                    اطلاعات با موفقیت ثبت شد:<br>
                    نام: {$fname}<br>
                    نام خانوادگی: {$lname}<br>
                    کد ملی: {$melicode}<br>
                    ایمیل: {$email}<br>
                    کلمه عبور: {$pwd_safe}<br>
                    آدرس: {$address}<br>
                    تلفن: {$tell}<br>
                    موبایل: {$cell}<br>
                    تاریخ ثبت: {$regdate}<br>
                    <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                    <script>setTimeout(function(){
                        top.location.href = '?part=admin&admin=list&list=shipman';
                    }, 20000);</script>
                ";

                // ارسال ایمیل دعوت
                require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
                $subject = "Asaltour.ir | new manager";
                $body    = "
                    <div style='direction:rtl; font-family:tahoma;'>
                    <img src='http://asaltour.ir/gcms/img/1.gif' /><br>
                    جناب آقای/خانم {$fname} {$lname}،<br>
                    به سامانه رزرواسیون بلیط کشتی خوش آمدید.<br>
                    نام کاربری: {$email}<br>
                    کلمه عبور: {$pwd_safe}<br>
                    لینک ورود: <a href='http://asaltour.ir'>http://asaltour.ir</a><br>
                    دسترسی شما به کشتیرانی‌های: {$mil_sail}<br>
                    جهت آموزش به: http://asaltour.ir/?part=page&id=26 مراجعه نمایید.
                    </div>
                ";
                send_mail($email, $subject, $body);
            }
            else {
                $error_message = "مشکل در ثبت داده‌ها لطفاً دوباره تلاش کنید.";
            }
        }
    }

    $admin_content = $form_admin_new_shipman;
}

//
// لیست shipman
//
function f_admin_listshipman(){
    global $mysqli, $error_message, $success_message, $admin_content;

    // تغییر وضعیت فعال/غیرفعال
    if (isset($_REQUEST['chngact'], $_REQUEST['id'])) {
        $id   = (int)$_REQUEST['id'];
        $act  = ($_REQUEST['chngact']==='1')?1:0;
        $mysqli->query("
            UPDATE `gcms_login`
            SET `active` = {$act}
            WHERE `id` = {$id}
            LIMIT 1
        ");
    }

    $res = $mysqli->query("SELECT * FROM `gcms_login` WHERE `type`='shipman' ORDER BY `fname` ASC");
    $html = "
        <table id='formtable'>
            <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>موبایل</th>
                    <th>سفارشات</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
    ";

    while ($row = $res->fetch_assoc()) {
        $id    = (int)$row['id'];
        $name  = htmlspecialchars($row['fname'].' '.$row['lname'], ENT_QUOTES);
        $email = htmlspecialchars($row['email'], ENT_QUOTES);
        $cell  = htmlspecialchars($row['cell'], ENT_QUOTES);
        $active = $row['active'] ? '<span style="color:green">فعال</span>' : '<span style="color:red">غیر فعال</span>';

        // جمع‌آوری sailing برای هر کاربر
        $r2 = $mysqli->query("
            SELECT `value`
            FROM `gcms_metalogin`
            WHERE `login_id`={$id} AND `key`='sailing'
            LIMIT 1
        ");
        $sail_list = '';
        if ($r2 && $r2->num_rows > 0) {
            $val = $r2->fetch_assoc()['value'];
            $ids = array_filter(explode(',', $val), 'strlen');
            foreach ($ids as $sid) {
                $rid = (int)$sid;
                $r3 = $mysqli->query("SELECT `name` FROM `gcms_sailing` WHERE `id`={$rid} LIMIT 1");
                if ($r3 && $rr = $r3->fetch_assoc()) {
                    $sail_list .= htmlspecialchars($rr['name'], ENT_QUOTES) . "، ";
                }
            }
        }

        $toggle = $row['active'] ? 0 : 1;
        $html .= "
            <tr>
                <td>{$name}</td>
                <td>{$email}</td>
                <td>{$cell}</td>
                <td>{$sail_list}</td>
                <td>{$active}</td>
                <td>
                    <a href='?part=admin&admin=edit&edit=shipman&shipman={$id}'>ویرایش</a> |
                    <a href='?part=admin&admin=list&list=shipman&chngact={$toggle}&id={$id}'>
                        " . ($toggle? 'فعال‌سازی' : 'غیرفعال‌سازی') . "
                    </a>
                </td>
            </tr>
        ";
    }

    $html .= "
            </tbody>
        </table>
        <a href='?part=admin&admin=list&list=shipman&excel=true' target='_blank'>خروجی اکسل</a>
    ";
    $admin_content = $html;
}

//
// ویرایش shipman
//
function f_admin_editshipman(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_edit_shipman;

    if (isset($_REQUEST['editshipman'], $_REQUEST['shipman'])
        && $_REQUEST['editshipman'] === "chng"
    ) {
        $id      = (int)$_REQUEST['shipman'];
        $fname   = $mysqli->real_escape_string($_REQUEST['fname']);
        $lname   = $mysqli->real_escape_string($_REQUEST['lname']);
        $address = $mysqli->real_escape_string($_REQUEST['address']);
        $tell    = $mysqli->real_escape_string($_REQUEST['tell']);
        $cell    = $mysqli->real_escape_string($_REQUEST['cell']);

        // لیست sailing جدید
        $slist = [];
        if (!empty($_REQUEST['sllst']) && is_array($_REQUEST['sllst'])) {
            foreach ($_REQUEST['sllst'] as $sid) {
                $sid = (int)$sid;
                if ($sid>0) {
                    $slist[] = $sid;
                }
            }
        }
        $sailing_list = implode(',', $slist);

        // آپدیت جدول اصلی
        $sql1 = "
            UPDATE `gcms_login`
            SET
                `fname`   = '{$fname}',
                `lname`   = '{$lname}',
                `address` = '{$address}',
                `tell`    = '{$tell}',
                `cell`    = '{$cell}'
            WHERE `id` = {$id}
            LIMIT 1
        ";

        if ($mysqli->query($sql1)) {
            // آپدیت metalogin
            $sql2 = "
                UPDATE `gcms_metalogin`
                SET `value` = '{$sailing_list}'
                WHERE `login_id` = {$id}
                  AND `key` = 'sailing'
                LIMIT 1
            ";
            $mysqli->query($sql2);

            $success_message = "
                تغییرات با موفقیت انجام شد:<br>
                {$fname} {$lname}<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=edit&edit=shipman&shipman={$id}';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام آپدیت لطفاً دوباره تلاش کنید.";
        }
    }

    $admin_content = $form_admin_edit_shipman;
}

//
// لیست portman
//
function f_admin_listportman(){
    global $mysqli, $error_message, $success_message, $admin_content;

    // تغییر وضعیت
    if (isset($_REQUEST['chngact'], $_REQUEST['id'])) {
        $id   = (int)$_REQUEST['id'];
        $act  = ($_REQUEST['chngact']==='1')?1:0;
        $mysqli->query("
            UPDATE `gcms_login`
            SET `active` = {$act}
            WHERE `id` = {$id}
            LIMIT 1
        ");
    }

    $res = $mysqli->query("SELECT * FROM `gcms_login` WHERE `type`='portman' ORDER BY `fname` ASC");
    $html = "
        <table id='formtable'>
            <thead>
                <tr>
                    <th>نام و نام خانوادگی</th>
                    <th>ایمیل</th>
                    <th>موبایل</th>
                    <th>سفارشات</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
    ";

    while ($row = $res->fetch_assoc()) {
        $id    = (int)$row['id'];
        $name  = htmlspecialchars($row['fname'].' '.$row['lname'], ENT_QUOTES);
        $email = htmlspecialchars($row['email'], ENT_QUOTES);
        $cell  = htmlspecialchars($row['cell'], ENT_QUOTES);
        $active = $row['active'] ? '<span style="color:green">فعال</span>' : '<span style="color:red">غیرفعال</span>';

        // جمع‌آوری sailing
        $r2 = $mysqli->query("
            SELECT `value`
            FROM `gcms_metalogin`
            WHERE `login_id`={$id} AND `key`='sailing'
            LIMIT 1
        ");
        $sail_list = '';
        if ($r2 && $r2->num_rows > 0) {
            $val = $r2->fetch_assoc()['value'];
            $ids = array_filter(explode(',', $val), 'strlen');
            foreach ($ids as $sid) {
                $rid = (int)$sid;
                $r3 = $mysqli->query("SELECT `name` FROM `gcms_sailing` WHERE `id`={$rid} LIMIT 1");
                if ($r3 && $rr = $r3->fetch_assoc()) {
                    $sail_list .= htmlspecialchars($rr['name'], ENT_QUOTES) . "، ";
                }
            }
        }

        $toggle = $row['active'] ? 0 : 1;
        $html .= "
            <tr>
                <td>{$name}</td>
                <td>{$email}</td>
                <td>{$cell}</td>
                <td>{$sail_list}</td>
                <td>{$active}</td>
                <td>
                    <a href='?part=admin&admin=edit&edit=portman&portman={$id}'>ویرایش</a> |
                    <a href='?part=admin&admin=list&list=portman&chngact={$toggle}&id={$id}'>
                        " . ($toggle? 'فعال‌سازی' : 'غیرفعال‌سازی') . "
                    </a>
                </td>
            </tr>
        ";
    }

    $html .= "
            </tbody>
        </table>
        <a href='?part=admin&admin=list&list=portman&excel=true' target='_blank'>خروجی اکسل</a>
    ";
    $admin_content = $html;
}

//
// ویرایش portman
//
function f_admin_editportman(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_edit_portman;

    if (isset($_REQUEST['editportman'], $_REQUEST['portman'])
        && $_REQUEST['editportman'] === "chng"
    ) {
        $id      = (int)$_REQUEST['portman'];
        $fname   = $mysqli->real_escape_string($_REQUEST['fname']);
        $lname   = $mysqli->real_escape_string($_REQUEST['lname']);
        $address = $mysqli->real_escape_string($_REQUEST['address']);
        $tell    = $mysqli->real_escape_string($_REQUEST['tell']);
        $cell    = $mysqli->real_escape_string($_REQUEST['cell']);

        // لیست sailing
        $slist = [];
        if (!empty($_REQUEST['sllst']) && is_array($_REQUEST['sllst'])) {
            foreach ($_REQUEST['sllst'] as $sid) {
                $sid = (int)$sid;
                if ($sid>0) {
                    $slist[] = $sid;
                }
            }
        }
        $sailing_list = implode(',', $slist);

        // آپدیت جدول اصلی
        $sql1 = "
            UPDATE `gcms_login`
            SET
                `fname`   = '{$fname}',
                `lname`   = '{$lname}',
                `address` = '{$address}',
                `tell`    = '{$tell}',
                `cell`    = '{$cell}'
            WHERE `id` = {$id}
            LIMIT 1
        ";
        if ($mysqli->query($sql1)) {
            // آپدیت metalogin
            $sql2 = "
                UPDATE `gcms_metalogin`
                SET `value` = '{$sailing_list}'
                WHERE `login_id` = {$id}
                  AND `key` = 'sailing'
                LIMIT 1
            ";
            $mysqli->query($sql2);

            $success_message = "
                تغییرات با موفقیت انجام شد:<br>
                {$fname} {$lname}<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=edit&edit=portman&portman={$id}';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام آپدیت لطفاً دوباره تلاش کنید.";
        }
    }

    $admin_content = $form_admin_edit_portman;
}

//
// ثبت آژانس جدید
//
function f_admin_newagency(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_new_agency;

    if (isset($_REQUEST['agency'])
        && $_REQUEST['agency'] === "true"
        && !empty($_REQUEST['fname'])
        && !empty($_REQUEST['lname'])
        && !empty($_REQUEST['melicode'])
        && !empty($_REQUEST['email'])
        && !empty($_REQUEST['pass'])
    ) {
        // ایمن‌سازی
        $fname      = $mysqli->real_escape_string($_REQUEST['fname']);
        $lname      = $mysqli->real_escape_string($_REQUEST['lname']);
        $melicode   = $mysqli->real_escape_string($_REQUEST['melicode']);
        $email      = $mysqli->real_escape_string($_REQUEST['email']);
        $pass       = crypt($_REQUEST['pass']);
        $address    = $mysqli->real_escape_string($_REQUEST['address']);
        $tell       = $mysqli->real_escape_string($_REQUEST['tell']);
        $cell       = $mysqli->real_escape_string($_REQUEST['cell']);
        $agencyname = $mysqli->real_escape_string($_REQUEST['agencyname']);
        $credit     = (float) $_REQUEST['credit'];
        $active     = ($mysqli->real_escape_string($_REQUEST['active'])==='1')?1:0;
        $regdate    = date("Y/m/d");

        // بررسی تکراری نبودن
        $chk_sql = "
            SELECT `id`
            FROM `gcms_login`
            WHERE `melicode`='{$melicode}'
               OR `email`='{$email}'
            LIMIT 1
        ";
        $chk_res = $mysqli->query($chk_sql);
        if ($chk_res->num_rows > 0) {
            $error_message = "کد ملی یا ایمیل تکراری است.";
        }
        else {
            // درج اصلی
            $sql = "
                INSERT INTO `gcms_login`(
                    `fname`,`lname`,`melicode`,`email`,`pass`,
                    `address`,`tell`,`cell`,`type`,`active`,`regdate`
                ) VALUES (
                    '{$fname}','{$lname}','{$melicode}','{$email}','{$pass}',
                    '{$address}','{$tell}','{$cell}','agency',{$active},'{$regdate}'
                )
            ";

            if ($mysqli->query($sql)) {
                $uid = $mysqli->insert_id;

                // متا: نام آژانس
                $mysqli->query("
                    INSERT INTO `gcms_metalogin`(`login_id`,`key`,`value`)
                    VALUES ({$uid}, 'agency_name', '{$agencyname}')
                ");
                // متا: اعتبار
                $mysqli->query("
                    INSERT INTO `gcms_metalogin`(`login_id`,`key`,`value`)
                    VALUES ({$uid}, 'agency_credit', '{$credit}')
                ");
                // متا: مصرف
                $mysqli->query("
                    INSERT INTO `gcms_metalogin`(`login_id`,`key`,`value`)
                    VALUES ({$uid}, 'agency_use', '0')
                ");

                // پیام موفقیت
                $pwd_safe = htmlspecialchars($_REQUEST['pass'], ENT_QUOTES);
                $success_message = "
                    آژانس جدید با موفقیت ثبت شد:<br>
                    مدیر آژانس: {$fname} {$lname}<br>
                    نام آژانس: {$agencyname}<br>
                    کد ملی: {$melicode}<br>
                    ایمیل: {$email}<br>
                    کلمه عبور: {$pwd_safe}<br>
                    آدرس: {$address}<br>
                    تلفن: {$tell}<br>
                    موبایل: {$cell}<br>
                    اعتبار: {$credit} ریال<br>
                    مصرف: 0 ریال<br>
                    تاریخ ثبت: {$regdate}<br>
                    <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                    <script>setTimeout(function(){
                        top.location.href = '?part=admin&admin=list&list=agency';
                    }, 20000);</script>
                ";

                // ارسال ایمیل دعوت
                require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
                $subject = "Asaltour.ir | new agency";
                $body    = "
                    <div style='direction:rtl; font-family:tahoma;'>
                    مدیر محترم آژانس {$fname} {$lname}<br>
                    به سامانه رزرواسیون خوش آمدید.<br>
                    نام کاربری: {$email}<br>
                    کلمه عبور: {$pwd_safe}<br>
                    لینک ورود: <a href='http://asaltour.ir'>http://asaltour.ir</a><br>
                    جهت آموزش قوانین ویژه مدیران: <a href='http://asaltour.ir/?part=page&id=26'>
                    قوانین ویژه مدیران</a>
                    </div>
                ";
                send_mail($email, $subject, $body);
            }
            else {
                $error_message = "مشکل در ثبت آژانس جدید لطفاً دوباره تلاش کنید.";
            }
        }
    }

    $admin_content = $form_admin_new_agency;
}

//
// لیست agency
//
function f_admin_listagency(){
    global $mysqli, $error_message, $success_message, $admin_content;

    // تغییر وضعیت
    if (isset($_REQUEST['chngact'], $_REQUEST['id'])) {
        $id   = (int)$_REQUEST['id'];
        $act  = ($_REQUEST['chngact']==='1')?1:0;
        $mysqli->query("
            UPDATE `gcms_login`
            SET `active` = {$act}
            WHERE `id` = {$id}
            LIMIT 1
        ");
    }

    $res = $mysqli->query("SELECT * FROM `gcms_login` WHERE `type`='agency' ORDER BY `fname` ASC");
    $html = "
        <table id='formtable'>
            <thead>
                <tr>
                    <th>آژانس</th>
                    <th>مدیر</th>
                    <th>ایمیل</th>
                    <th>موبایل</th>
                    <th>اعتبار (ریال)</th>
                    <th>مصرف (ریال)</th>
                    <th>وضعیت</th>
                    <th>عملیات</th>
                </tr>
            </thead>
            <tbody>
    ";

    while ($row = $res->fetch_assoc()) {
        $id        = (int)$row['id'];
        $manager   = htmlspecialchars($row['fname'].' '.$row['lname'], ENT_QUOTES);
        $email     = htmlspecialchars($row['email'], ENT_QUOTES);
        $cell      = htmlspecialchars($row['cell'], ENT_QUOTES);
        $active    = $row['active'] ? '<span style="color:green">فعال</span>' : '<span style="color:red">غیرفعال</span>';

        // اعتبار و مصرف از metalogin
        $credit_r = 0; $use_r = 0;
        $r2 = $mysqli->query("
            SELECT `key`,`value`
            FROM `gcms_metalogin`
            WHERE `login_id` = {$id}
              AND `key` IN ('agency_credit','agency_use')
        ");
        while ($meta = $r2->fetch_assoc()) {
            if ($meta['key'] === 'agency_credit') {
                $credit_r = (float)$meta['value'];
            }
            elseif ($meta['key'] === 'agency_use') {
                $use_r = (float)$meta['value'];
            }
        }

        $toggle = $row['active'] ? 0 : 1;
        $html .= "
            <tr>
                <td>" . htmlspecialchars($row['fname'], ENT_QUOTES) . "</td>
                <td>{$manager}</td>
                <td>{$email}</td>
                <td>{$cell}</td>
                <td>" . number_format($credit_r) . "</td>
                <td>" . number_format($use_r) . "</td>
                <td>{$active}</td>
                <td>
                    <a href='?part=admin&admin=edit&edit=agency&agency={$id}'>ویرایش</a> |
                    <a href='?part=admin&admin=list&list=agency&chngact={$toggle}&id={$id}'>
                        " . ($toggle? 'فعال‌سازی' : 'غیرفعال‌سازی') . "
                    </a>
                </td>
            </tr>
        ";
    }

    $html .= "
            </tbody>
        </table>
        <a href='?part=admin&admin=list&list=agency&excel=true' target='_blank'>خروجی اکسل</a>
    ";
    $admin_content = $html;
}

//
// ویرایش agency
//
function f_admin_editagency(){
    global $mysqli, $error_message, $success_message, $admin_content, $form_admin_edit_agency;

    if (isset($_REQUEST['editagency'], $_REQUEST['agency'])
        && $_REQUEST['editagency'] === "chng"
    ) {
        $id         = (int)$_REQUEST['agency'];
        $fname      = $mysqli->real_escape_string($_REQUEST['fname']);
        $lname      = $mysqli->real_escape_string($_REQUEST['lname']);
        $address    = $mysqli->real_escape_string($_REQUEST['address']);
        $tell       = $mysqli->real_escape_string($_REQUEST['tell']);
        $cell       = $mysqli->real_escape_string($_REQUEST['cell']);
        $agencyname = $mysqli->real_escape_string($_REQUEST['agencyname']);
        $credit     = (float) $_REQUEST['credit'];

        // آپدیت جدول اصلی
        $sql1 = "
            UPDATE `gcms_login`
            SET
                `fname`   = '{$fname}',
                `lname`   = '{$lname}',
                `address` = '{$address}',
                `tell`    = '{$tell}',
                `cell`    = '{$cell}'
            WHERE `id` = {$id}
            LIMIT 1
        ";

        if ($mysqli->query($sql1)) {
            // آپدیت نام آژانس
            $mysqli->query("
                UPDATE `gcms_metalogin`
                SET `value` = '{$agencyname}'
                WHERE `login_id`={$id} AND `key`='agency_name'
            ");
            // آپدیت اعتبار
            $mysqli->query("
                UPDATE `gcms_metalogin`
                SET `value` = '{$credit}'
                WHERE `login_id`={$id} AND `key`='agency_credit'
            ");

            $success_message = "
                تغییرات با موفقیت انجام شد:<br>
                {$fname} {$lname}<br>
                آژانس: {$agencyname}<br>
                اعتبار: " . number_format($credit) . " ریال<br>
                <center><img src='/gcms/images/load.gif' width='120' height='160'></center>
                <script>setTimeout(function(){
                    top.location.href = '?part=admin&admin=edit&edit=agency&agency={$id}';
                }, 5000);</script>
            ";
        }
        else {
            $error_message = "مشکل در انجام آپدیت لطفاً دوباره تلاش کنید.";
        }
    }

    $admin_content = $form_admin_edit_agency;
}
