<?php
declare(strict_types=1);
session_start();

// --------------------------------------------------
// ۱) بارگذاری تنظیمات و تابع CSRF
// --------------------------------------------------
require_once __DIR__ . '/../gcms/php/file/gconfig.php';    // اتصال به دیتابیس و $mysqli
require_once __DIR__ . '/../gcms/admin-gcms/inc/csrf.php'; // تابع csrf_check()

// --------------------------------------------------
// ۲) توابع کمکی برای اعتبارسنجی تاریخ و ساعت
// --------------------------------------------------
function isValidDate(string $d): bool {
    // فرمت YYYY-MM-DD
    return (bool) preg_match('/^[1-9]\d{3}-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/', $d);
}
function isValidTime(string $t): bool {
    // فرمت HH:MM (00–23 : 00–59)
    return (bool) preg_match('/^([01]\d|2[0-3]):([0-5]\d)$/', $t);
}

// --------------------------------------------------
// ۳) کنترل دسترسی و CSRF
// --------------------------------------------------
if (empty($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
$csrf = filter_input(INPUT_POST, 'csrf', FILTER_DEFAULT);
if (!$csrf || !csrf_check($csrf)) {
    http_response_code(400);
    exit('Invalid CSRF Token');
}

// --------------------------------------------------
// ۴) واکشی و اعتبارسنجی ورودی‌ها
// --------------------------------------------------
$userId     = $_SESSION['user_id'];
$tripId     = filter_input(INPUT_POST, 'trip_id',     FILTER_VALIDATE_INT);
$travelDate = filter_input(INPUT_POST, 'travel_date',  FILTER_DEFAULT);
$travelTime = filter_input(INPUT_POST, 'travel_time',  FILTER_DEFAULT);
$quantity   = filter_input(INPUT_POST, 'quantity',     FILTER_VALIDATE_INT);

if ($tripId === false || $tripId <= 0
    || !isValidDate((string)$travelDate)
    || !isValidTime((string)$travelTime)
    || $quantity === false || $quantity <= 0
) {
    $_SESSION['error'] = 'پارامترهای ارسالی نامعتبر هستند.';
    header('Location: purchase_form.php');
    exit;
}

// --------------------------------------------------
// ۵) واکشی قیمت واحد از جدول سفر
// --------------------------------------------------
$stmt = $mysqli->prepare("SELECT price FROM gcms_trip WHERE id = ?");
$stmt->bind_param('i', $tripId);
$stmt->execute();
$stmt->bind_result($pricePer);
if (!$stmt->fetch()) {
    $stmt->close();
    $_SESSION['error'] = 'سفر انتخاب‌شده یافت نشد.';
    header('Location: purchase_form.php');
    exit;
}
$stmt->close();

// --------------------------------------------------
// ۶) محاسبه مبلغ کل
// --------------------------------------------------
$totalPrice = $pricePer * $quantity;

// --------------------------------------------------
// ۷) اجرای تراکنش: قفل اعتبار → درج خرید → کسر اعتبار
// --------------------------------------------------
try {
    $mysqli->begin_transaction();

    // ۷-۱) قفل سطر اعتبار کاربر
    $stmt = $mysqli->prepare("SELECT amount FROM gcms_login WHERE id = ? FOR UPDATE");
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $stmt->bind_result($currentCredit);
    $stmt->fetch();
    $stmt->close();

    if ($currentCredit < $totalPrice) {
        throw new \RuntimeException('اعتبار کافی نیست.');
    }

    // ۷-۲) درج رکورد خرید
    $stmt = $mysqli->prepare("
        INSERT INTO gcms_buy
            (login_id, trip_id, travel_date, travel_time, quantity, price, created_at)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param(
        'iissid',
        $userId,
        $tripId,
        $travelDate,
        $travelTime,
        $quantity,
        $totalPrice
    );
    $stmt->execute();
    $buyId = $mysqli->insert_id;
    $stmt->close();

    // ۷-۳) کاهش اعتبار
    $stmt = $mysqli->prepare("
        UPDATE gcms_login
           SET amount = amount - ?
         WHERE id = ?
    ");
    $stmt->bind_param('ii', $totalPrice, $userId);
    $stmt->execute();
    $stmt->close();

    // ۷-۴) تأیید تراکنش
    $mysqli->commit();

    // --------------------------------------------------
    // ۸) هدایت به صفحهٔ پرینت
    // --------------------------------------------------
    header('Location: /gcms/print/print.php?buy_id=' . urlencode((string)$buyId));
    exit;

} catch (\Throwable $e) {
    // در صورت بروز خطا: rollback و لاگ در سرور
    $mysqli->rollback();
    error_log('[Purchase Error] ' . $e->getMessage());

    $_SESSION['error'] = 'خطا در ثبت خرید. لطفاً دوباره تلاش کنید.';
    header('Location: purchase_form.php');
    exit;
}
