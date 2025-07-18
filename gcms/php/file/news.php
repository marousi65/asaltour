<?php
declare(strict_types=1);

namespace GCMS\File;

use Smarty;

// بارگذاری تنظیمات و توابع
require_once __DIR__ . '/../../gconfig.php';
require_once __DIR__ . '/../../jdf.php';

global $gcms, $link;

// اگر یک نظر (comment) ارسال شده
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_GET['opinion'], $_POST['email'])) {
    // ساده‌ترین مکانیزم جلوگیری از اسپم (ارسال مکرر زیر ۳۰ ثانیه)
    $thirtyAgo = time() - 30;
    $ip = $_SERVER['REMOTE_ADDR'];
    $spamCheckQuery = "
        SELECT 1
          FROM `gcms_comment`
         WHERE comment_date > ? 
           AND comment_author_ip = ?
      LIMIT 1";
    $stm = mysqli_prepare($link, $spamCheckQuery);
    mysqli_stmt_bind_param($stm, 'is', $thirtyAgo, $ip);
    mysqli_stmt_execute($stm);
    mysqli_stmt_store_result($stm);
    if (mysqli_stmt_num_rows($stm) > 0) {
        // بلاک کردن آی‌پی یا نمایش خطای کاربر
        echo "<script>window.location='?part=page&id={$configset['first_page']}';</script>";
        exit;
    }

    // اعتبارسنجی کپچا
    if (empty($_SESSION['vercode']) || $_POST['vercode'] !== $_SESSION['vercode']) {
        $gcms->assign('comment_message', 'کد امنیتی اشتباه است.');
    } else {
        // آماده‌سازی داده‌ها
        $name    = htmlspecialchars($_POST['name']   ?? '', ENT_QUOTES, 'UTF-8');
        $email   = htmlspecialchars($_POST['email']  ?? '', ENT_QUOTES, 'UTF-8');
        $url     = htmlspecialchars($_POST['url']    ?? '', ENT_QUOTES, 'UTF-8');
        $content = htmlspecialchars($_POST['content']?? '', ENT_QUOTES, 'UTF-8');
        $date    = time();
        $approved= ($configset['comment_publish_immd']==='yes') ? 'confirm' : 'reject';

        $insertQ = "
          INSERT INTO `gcms_comment`
          (page_id, comment_author, comment_author_email, comment_author_url,
           comment_author_ip, comment_date, comment_approved, comment_content, comment_parent)
          VALUES (?,?,?,?,?,?,?,?,0)";
        $stm = mysqli_prepare($link, $insertQ);
        mysqli_stmt_bind_param(
            $stm, 'issssiss',
            $_GET['id'], $name, $email, $url, $ip, $date, $approved, $content
        );
        if (mysqli_stmt_execute($stm)) {
            $msg = 'نظر شما ثبت شد.';
            if ($approved==='reject') {
                $msg .= ' پس از تأیید نمایش داده می‌شود.';
            }
            $gcms->assign('comment_message', $msg);
        } else {
            $gcms->assign('comment_message', 'خطا در ثبت نظر، لطفاً مجدداً تلاش کنید.');
        }
    }
}

// اگر آی‌دی خبر داده نشده، لیست خبری نمایش داده شود
if (empty($_GET['id'])) {
    // بارگذاری گروه‌ها
    $groupQ = "SELECT term_id, term_name 
               FROM `gcms_term` 
               WHERE term_tax='news_group' 
               ORDER BY term_name ASC";
    $resG   = mysqli_query($link, $groupQ);
    $groups = [];
    while ($g = mysqli_fetch_assoc($resG)) {
        $groups[] = [
            'name'=>$g['term_name'],
            'url' =>"?part=news&term={$g['term_id']}"
        ];
    }
    $gcms->assign('news_groups', $groups);

    // معیار فیلتر term
    $baseFilter = "page_status='publish' AND page_type='news'";
    if (!empty($_GET['term'])) {
        $termId = (int) $_GET['term'];
        $baseFilter .= " AND EXISTS(
            SELECT 1 FROM gcms_relationships_page_term rpt
             WHERE rpt.page_id=gcms_pages.id
               AND rpt.term_id={$termId}
        )";
        $termSuffix="&term={$termId}";
    } else {
        $termSuffix = '';
    }

    // شمارش و صفحه‌بندی
    $page   = max(1, (int)($_GET['page'] ?? 1));
    $per    = (int)($configset['newsnum'] ?? 10);
    $offset = ($page -1)* $per;
    $countQ = "SELECT COUNT(*) AS cnt
                 FROM `gcms_pages`
                WHERE {$baseFilter}";
    $cntR   = mysqli_query($link, $countQ);
    $total  = (int) mysqli_fetch_assoc($cntR)['cnt'];
    $pages  = (int) ceil($total / $per);

    // لینک صفحه‌بندی
    $links = [];
    for ($p=1; $p<=$pages; $p++) {
        $links[] = ($p===$page)
            ? "<strong>{$p}</strong>"
            : "<a href=\"?part=news{$termSuffix}&page={$p}\">{$p}</a>";
    }
    $gcms->assign('pagination', implode(' ', $links));

    // استخراج لیست
    $listQ = "
        SELECT p.id, p.page_title, p.page_excerpt, p.page_pic, p.page_date, t.term_name
          FROM gcms_pages p
     LEFT JOIN gcms_relationships_page_term rpt ON rpt.page_id=p.id
     LEFT JOIN gcms_term t ON t.term_id=rpt.term_id
         WHERE {$baseFilter}
      ORDER BY p.page_date DESC
         LIMIT ?,?";
    $stm   = mysqli_prepare($link, $listQ);
    mysqli_stmt_bind_param($stm, 'ii', $offset, $per);
    mysqli_stmt_execute($stm);
    $resL  = mysqli_stmt_get_result($stm);
    $news  = [];
    while ($r = mysqli_fetch_assoc($resL)) {
        $news[] = [
            'id'      => (int)$r['id'],
            'title'   => htmlspecialchars($r['page_title'], ENT_QUOTES, 'UTF-8'),
            'excerpt' => $r['page_excerpt'] . ' …',
            'pic'     => $r['page_pic'],
            'date'    => jdate("l j F y", (int)$r['page_date']),
            'group'   => $r['term_name'] ?? '',
            'url'     => "?part=news&id={$r['id']}"
        ];
    }
    $gcms->assign('news_list', $news);

} else {
    // نمایش جزئیات یک خبر
    $newsId = (int)$_GET['id'];
    $pageQ  = "
      SELECT p.page_title, p.page_content, p.page_excerpt, p.page_date,
             u.metauser_value AS author, p.comment_status, p.page_pic, t.term_name, t.term_id
        FROM gcms_pages p
   LEFT JOIN gcms_metauser u ON u.user_id=p.page_author AND u.metauser_key='first_name'
   LEFT JOIN gcms_relationships_page_term rpt ON rpt.page_id=p.id
   LEFT JOIN gcms_term t ON t.term_id=rpt.term_id
       WHERE p.id=? AND p.page_type='news' AND p.page_status='publish'
    ";
    $stm = mysqli_prepare($link, $pageQ);
    mysqli_stmt_bind_param($stm, 'i', $newsId);
    mysqli_stmt_execute($stm);
    $res= mysqli_stmt_get_result($stm);
    if (!$row = mysqli_fetch_assoc($res)) {
        echo "<script>window.location='?part=news';</script>";
        exit;
    }
    // مقادیر را به Smarty اختصاص می‌دهیم
    $gcms->assignMultiple([
        'page_title'   => $row['page_title'],
        'page_content' => $row['page_content'],
        'page_excerpt' => $row['page_excerpt'] . ' …',
        'page_pic'     => $row['page_pic'],
        'page_date'    => jdate("l j F y", (int)$row['page_date']),
        'page_author'  => $row['author'],
        'news_group'   => $row['term_name'],
        'news_group_url'=> "?part=news&term={$row['term_id']}",
        'comment_open'=> $row['comment_status']==='open'
    ]);

    // واکشی و اختصاص کامنت‌های تأییدشده
    if ($row['comment_status']==='open') {
        $cQ  = "SELECT comment_author, comment_date, comment_content
                  FROM gcms_comment
                 WHERE page_id=? AND comment_approved='confirm'
              ORDER BY comment_date ASC";
        $stm = mysqli_prepare($link, $cQ);
        mysqli_stmt_bind_param($stm, 'i', $newsId);
        mysqli_stmt_execute($stm);
        $resC= mysqli_stmt_get_result($stm);
        $comments = [];
        while ($c = mysqli_fetch_assoc($resC)) {
            $comments[] = [
                'author'  => $c['comment_author'],
                'date'    => jdate("l j F y", (int)$c['comment_date']),
                'content' => $c['comment_content']
            ];
        }
        $gcms->assign('comments', $comments);
    }

    // فرم ارسال نظر در قالب Smarty قرار گرفته است
}

// در پایان قالب news.tpl را فراخوانی کنید
$gcms->display('news.tpl');
