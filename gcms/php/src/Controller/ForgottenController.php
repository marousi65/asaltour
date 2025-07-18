<?php
declare(strict_types=1);

namespace GCMS\Controller;

use GCMS\Config\Database;
use PDO;
use Exception;

class ForgottenController
{
    private PDO $pdo;
    private array $errors   = [];
    private array $messages = [];

    public function __construct()
    {
        $this->pdo = Database::getConnection();
        session_start();
    }

    public function showStep1(): void
    {
        // render step1 template
    }

    public function handleStep2(): void
    {
        $vercode = filter_input(INPUT_POST, 'vercode', FILTER_SANITIZE_STRING);
        if (empty($vercode) || $vercode !== ($_SESSION['vercode'] ?? '')) {
            $this->errors[] = 'کد امنیتی اشتباه وارد شده.';
            $this->showStep1();
            return;
        }

        $melicode = filter_input(INPUT_POST, 'melicode', FILTER_SANITIZE_STRING);
        $email    = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if (!$melicode || !$email) {
            $this->errors[] = 'کد ملی یا ایمیل نامعتبر است.';
            $this->showStep1();
            return;
        }

        $stmt = $this->pdo->prepare(
            'SELECT id, email FROM gcms_login
             WHERE melicode = :m OR email = :e'
        );
        $stmt->execute([':m' => $melicode, ':e' => $email]);
        $user = $stmt->fetch();

        if (!$user) {
            $this->errors[] = 'کاربری با این مشخصات یافت نشد.';
            $this->showStep1();
            return;
        }

        // تولید کلمه‌عبور جدید و بروز رسانی
        $newPassRaw  = bin2hex(random_bytes(4)); // 8 chars
        $newPassHash = password_hash($newPassRaw, PASSWORD_DEFAULT);

        $upd = $this->pdo->prepare(
            'UPDATE gcms_login SET pass = :pass WHERE id = :id'
        );
        if (!$upd->execute([':pass' => $newPassHash, ':id' => $user['id']])) {
            throw new Exception('خطا در تغییر کلمه عبور.');
        }

        // ارسال ایمیل با PHPMailer یا SwiftMailer
        // … sendMail($user['email'], …, "your new pass: $newPassRaw");

        $this->messages[] = 'کلمه‌عبور جدید به ایمیل شما ارسال شد.';
        // render success template
    }
}
