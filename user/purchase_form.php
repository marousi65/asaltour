<?php
declare(strict_types=1);
session_start();

// --------------------------------------------------
// ۱) بارگذاری تنظیمات، کنترل ورود و CSRF
// --------------------------------------------------
require_once __DIR__ . '/../gcms/php/file/gconfig.php';      // اتصال به دیتابیس و $mysqli
require_once __DIR__ . '/../gcms/admin-gcms/inc/login.php'; // چک لاگین
require_once __DIR__ . '/../gcms/admin-gcms/inc/csrf.php';  // csrf_token(), csrf_check()

// اگر کاربر لاگین نیست، به صفحه‌ی لاگین بفرست
if (empty($_SESSION['user_id'])) {
    header('Location: /login.php');
    exit;
}

// --------------------------------------------------
// ۲) تابع کمکی برای خروجی امن در HTML
// --------------------------------------------------
function e(string $str): string {
    return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

// --------------------------------------------------
// ۳) واکشی خطاها و مقادیر قبلی پس از ریدایرکت
// --------------------------------------------------
$errors = $_SESSION['errors'] ?? [];
$old    = $_SESSION['old']    ?? [];
unset($_SESSION['errors'], $_SESSION['old']);

// --------------------------------------------------
// ۴) واکشی لیست سفرها
// --------------------------------------------------
$trips = [];
try {
    $stmt = $mysqli->prepare("SELECT id, name FROM gcms_trip ORDER BY name");
    $stmt->execute();
    $stmt->bind_result($id, $name);
    while ($stmt->fetch()) {
        $trips[] = ['id' => $id, 'name' => $name];
    }
    $stmt->close();
} catch (\Throwable $e) {
    error_log('[Trip Fetch Error] ' . $e->getMessage());
    $errors[] = 'خطا در واکشی لیست سفرها. لطفاً بعداً تلاش کنید.';
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <title>خرید بلیط</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
  <style>
    body { direction: rtl; text-align: right; }
  </style>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow-sm">
      <div class="card-header bg-primary text-white">فرم خرید بلیط</div>
      <div class="card-body">

        <?php if ($errors): ?>
          <div class="alert alert-danger">
            <ul class="mb-0">
              <?php foreach ($errors as $err): ?>
                <li><?= e($err) ?></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endif; ?>

        <form method="post" action="purchase.php" novalidate>
          <!-- CSRF Token -->
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">

          <!-- مسیر حرکت -->
          <div class="form-group">
            <label for="trip_id">مسیر حرکت</label>
            <select id="trip_id" name="trip_id"
                    class="form-control" required>
              <option value="">انتخاب کنید…</option>
              <?php foreach ($trips as $trip): ?>
                <option value="<?= e((string)$trip['id']) ?>"
                  <?= (isset($old['trip_id']) && $old['trip_id']==$trip['id'])
                      ? 'selected' : '' ?>>
                  <?= e($trip['name']) ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="invalid-feedback">لطفاً یک مسیر انتخاب کنید.</div>
          </div>

          <div class="form-row">
            <!-- تاریخ حرکت -->
            <div class="form-group col-md-6">
              <label for="travel_date">تاریخ حرکت</label>
              <input type="date" id="travel_date" name="travel_date"
                     class="form-control"
                     min="<?= date('Y-m-d') ?>"
                     value="<?= e($old['travel_date'] ?? '') ?>"
                     required>
              <div class="invalid-feedback">لطفاً تاریخ معتبر وارد کنید.</div>
            </div>

            <!-- ساعت حرکت -->
            <div class="form-group col-md-6">
              <label for="travel_time">ساعت حرکت</label>
              <input type="time" id="travel_time" name="travel_time"
                     class="form-control"
                     value="<?= e($old['travel_time'] ?? '') ?>"
                     required>
              <div class="invalid-feedback">لطفاً ساعت معتبر وارد کنید.</div>
            </div>
          </div>

          <!-- تعداد بلیط -->
          <div class="form-group">
            <label for="quantity">تعداد بلیط</label>
            <input type="number" id="quantity" name="quantity"
                   class="form-control"
                   min="1" max="10"
                   value="<?= e($old['quantity'] ?? '1') ?>"
                   required>
            <div class="invalid-feedback">تعداد باید بین ۱ تا ۱۰ باشد.</div>
          </div>

          <button type="submit" class="btn btn-success btn-block">
            خرید بلیط
          </button>
        </form>

      </div>
    </div>
  </div>

  <!-- فعال‌سازی اعتبارسنجی HTML5 با جاوااسکریپت -->
  <script>
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByTagName('form');
        Array.prototype.forEach.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
</body>
</html>
