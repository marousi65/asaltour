<?php
declare(strict_types=1);

// --------------------------------------------------
// ۰) راه‌اندازی امن Session
// --------------------------------------------------
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// --------------------------------------------------
// ۱) بارگذاری تنظیمات محیطی (ENV)
// --------------------------------------------------
// روش پیشنهادی: با بهره از phpdotenv یا Apache/nginx SetEnv
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'asaltour_asltrgc';
$dbPass = getenv('DB_PASS') ?: 'H^}r_3;aA@%;';
$dbName = getenv('DB_NAME') ?: 'asaltour_aslgcms';

// --------------------------------------------------
// ۲) اتصال به دیتابیس با mysqli در حالت Exception-Mode
// --------------------------------------------------
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
    $mysqli->set_charset('utf8mb4');
} catch (mysqli_sql_exception $e) {
    // لاگ کردن خطای واقعی
    error_log('[DB Connection Error] ' . $e->getMessage());
    // نمایش پیام عمومی به کاربر
    exit('در حال حاضر امکان اتصال به دیتابیس وجود ندارد. لطفاً بعداً تلاش کنید.');
}

// --------------------------------------------------
// ۳) تابع فرارگذاری خروجی HTML
// --------------------------------------------------
if (!function_exists('e')) {
    function e(string $str): string {
        return htmlspecialchars($str, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

// --------------------------------------------------
// ۴) تابع اجرایی کوئری با Prepared Statement
//    - $types: هر حرف یک پارامتر (s,i,d,b) 
//    - به کاربر اجازه می‌دهد انواع را صریح مشخص کند
// --------------------------------------------------
if (!function_exists('db_query')) {
    /**
     * @param string     $sql    رشته‌ی SQL با ؟ به‌عنوان placeholder
     * @param array      $params آرایه‌ی مقادیر برای bind
     * @param string     $types  رشته‌ای از حروف s, i, d, b
     * @return mysqli_stmt
     * @throws RuntimeException
     */
    function db_query(string $sql, array $params = [], string $types = ''): mysqli_stmt {
        global $mysqli;
        try {
            $stmt = $mysqli->prepare($sql);
            if ($stmt === false) {
                throw new RuntimeException('Prepare failed');
            }
            if (!empty($params)) {
                // اگر نوع‌ها مشخص نشده‌اند، فرض رشته‌ای ('s') برای همه
                if ($types === '') {
                    $types = str_repeat('s', count($params));
                }
                $stmt->bind_param($types, ...$params);
            }
            $stmt->execute();
            return $stmt;
        } catch (mysqli_sql_exception $e) {
            // لاگ و پرتاب Exception
            error_log('[DB Query Error] ' . $e->getMessage() . ' -- SQL: ' . $sql);
            throw new RuntimeException('خطا در اجرای پرس‌وجو.');
        }
    }
}

// --------------------------------------------------
// ۵) تولید و بررسی CSRF Token
// --------------------------------------------------
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

/**
 * برگرداندن توکن CSRF جاری
 */
function csrf_token(): string {
    return $_SESSION['csrf_token'];
}

/**
 * اعتبارسنجی توکن CSRF
 * @param string $token
 * @return bool
 */
function csrf_check(string $token): bool {
    return hash_equals($_SESSION['csrf_token'], $token);
}
