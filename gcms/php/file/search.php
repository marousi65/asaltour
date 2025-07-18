<?php
declare(strict_types=1);
session_start();

// تنظیمات اصلی
require_once __DIR__ . '/gconfig.php';

// تابع برش متن و برجسته‌سازی کلمه جستجو
function highlight_search(string $needle, string $haystack): string
{
    $plain = strip_tags($haystack);
    $parts = explode($needle, $plain, 2);
    $beforeLen = strlen($parts[0]);
    if ($beforeLen > 150) {
        $parts[0] = substr($parts[0], $beforeLen - 50);
    }
    $context = ' ... ' . substr($parts[0], strpos($parts[0], ' '));
    $after   = substr($parts[1], 0, 250);
    $after   = substr($after, 0, strrpos($after, ' ')) . ' ... ';
    return $context
         . "<span style='color:red;background-color:yellow'>{$needle}</span>"
         . $after;
}

$searchInput = trim($_REQUEST['inputsearch'] ?? '');
$option      = $_REQUEST['option'] ?? '';

// اعتبارسنجی
if ($_REQUEST['search'] === 'page' && $searchInput !== '') {
    // جلوگیری از اسپم
    $now = time();
    if (!isset($_SESSION['last_search_time']) || $now - $_SESSION['last_search_time'] > 10) {
        $_SESSION['last_search_time'] = $now;
        $_SESSION['search_count'] = 0;
    }
    if (++$_SESSION['search_count'] > 3) {
        mysql_query(
            "INSERT INTO `gcms_blocked` (`ip`) VALUES ('" . mysql_real_escape_string($_SERVER['REMOTE_ADDR']) . "')",
            $link
        );
        die('Too many search attempts.');
    }

    $needle = mysql_real_escape_string($searchInput);
    $likeStr = str_replace(' ', '%', $needle);
    $where  = $option === 'page_title'
            ? "page_title LIKE '%{$likeStr}%'"
            : "(page_content LIKE '%{$likeStr}%' OR page_title LIKE '%{$likeStr}%')";

    $sql   = "SELECT * FROM `gcms_pages` WHERE {$where}";
    $res   = mysql_query($sql, $link);
    $resultHtml = '';

    while ($row = mysql_fetch_assoc($res)) {
        $field = $option === 'page_title' ? 'page_title' : 'page_content';
        $row[$field] = highlight_search($searchInput, $row[$field]);
        $resultHtml .= sprintf(
            "%d - <b><a href='?part=pages&id=%d'>%s</a></b><br>%s<br>",
            ++$i, $row['id'], $row['page_title'], $row[$field]
        );
    }

    if (empty($resultHtml)) {
        $message = "هیچ نتیجه‌ای برای «{$searchInput}» یافت نشد.";
        $gcms->assign('message', $message);
    } else {
        $gcms->assign('searchresult', $resultHtml);
    }
} else {
    $gcms->assign('message', 'لطفاً عبارت جستجو را وارد کنید.');
}

$gcms->assign('menu_active', '?part=search');
$gcms->assign('part', 'search');
$gcms->display('index/index.tpl');