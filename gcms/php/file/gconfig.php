<?php
declare(strict_types=1);

// اگر session فعال نیست، شروعش کن
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// تنظیمات اتصال به دیتابیس
define('DB_HOST',     'localhost');
define('DB_USERNAME', 'asaltour_asltrgc');
define('DB_PASSWORD', 'H^}r_3;aA@%;');
define('DB_NAME',     'asaltour_aslgcms');

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
        DB_USERNAME,
        DB_PASSWORD,
        [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ]
    );
} catch (PDOException $e) {
    error_log("DB Connection Error: " . $e->getMessage());
    die("خطا در اتصال به پایگاه‌داده. لطفاً بعداً تلاش کنید.");
}

/**
 * فرار دادن امن داده برای HTML/XSS
 */
function esc(string $str): string
{
    return htmlspecialchars(trim($str), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * اجرای Prepared Statement با PDO
 *
 * @param string               $sql
 * @param array<int,string|int> $params
 * @return PDOStatement
 */
function db_query(string $sql, array $params = []): PDOStatement
{
    global $pdo;
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}
