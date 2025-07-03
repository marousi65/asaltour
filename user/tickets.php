<?php
declare(strict_types=1);
session_start();

// --------------------------------------------------
// ۱) بارگذاری تنظیمات و کنترل لاگین
// --------------------------------------------------
require_once __DIR__ . '/../gcms/php/file/gconfig.php';      // تعریف $mysqli و BASE_URL
require_once __DIR__ . '/../gcms/admin-gcms/inc/login.php'; // تابع check_login()

// اگر لاگین نشده، به صفحه ورود هدایت کن
if (empty($_SESSION['user_id']) || !is_int($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}
$userId = $_SESSION['user_id'];

// --------------------------------------------------
// ۲) تابع کمکی برای فرارگذاری خروجی در HTML
// --------------------------------------------------
function e(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// --------------------------------------------------
// ۳) واکشی بلیط‌ها
// --------------------------------------------------
$tickets = [];
$errorMsg = '';

try {
    $sql = "
        SELECT 
          b.id, 
          t.name AS trip_name, 
          b.quantity, 
          b.price, 
          b.created_at
        FROM gcms_buy AS b
        JOIN gcms_trip AS t ON t.id = b.trip_id
        WHERE b.login_id = ?
        ORDER BY b.created_at DESC
    ";

    $stmt = $mysqli->prepare($sql);
    if ($stmt === false) {
        throw new RuntimeException('Prepare failed: ' . $mysqli->error);
    }
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $tickets[] = $row;
    }
    $stmt->close();

} catch (Throwable $e) {
    error_log('[Tickets Fetch Error] ' . $e->getMessage());
    $errorMsg = 'متأسفانه در واکشی بلیط‌ها خطایی رخ داده. لطفاً بعداً تلاش کنید.';
}

// --------------------------------------------------
// ۴) نمایش HTML
// --------------------------------------------------
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>بلیط‌های من</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <style> body { text-align: right; } </style>
</head>
<body class="p-4 bg-light">

  <div class="container">
    <h3 class="mb-4">بلیط‌های خریداری‌شده شما</h3>

    <?php if ($errorMsg): ?>
      <div class="alert alert-danger"><?= e($errorMsg) ?></div>
    <?php elseif (empty($tickets)): ?>
      <div class="alert alert-info">شما هنوز هیچ بلیطی خریداری نکرده‌اید.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-bordered table-striped">
          <thead class="thead-dark">
            <tr>
              <th>شناسه</th>
              <th>مسیر</th>
              <th>تعداد</th>
              <th>مبلغ (تومان)</th>
              <th>تاریخ خرید</th>
              <th>عملیات</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($tickets as $row): ?>
            <tr>
              <td><?= e((string)$row['id']) ?></td>
              <td><?= e($row['trip_name']) ?></td>
              <td><?= e((string)$row['quantity']) ?></td>
              <td><?= e(number_format((int)$row['price'])) ?></td>
              <td><?= e($row['created_at']) ?></td>
              <td>
                <a href="<?= rtrim(e(BASE_URL), '/') ?>/print.php?buy_id=<?= urlencode((string)$row['id']) ?>"
                   target="_blank" rel="noopener noreferrer">
                  پرینت
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>

  </div>
</body>
</html>
