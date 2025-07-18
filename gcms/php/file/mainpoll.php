<?php
declare(strict_types=1);

namespace GCMS\File;

use Smarty;

// بارگذاری تنظیمات
require_once __DIR__ . '/../../gconfig.php';

global $gcms, $link;

$pollId     = (int) ($_GET['poll_id'] ?? 0);
$voteOption = (int) ($_POST['option'] ?? 0);
$pollData   = [];

// ثبت رای در صورت ارسال فرم
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $pollId > 0 && $voteOption > 0) {
    $queryVote = "UPDATE `gcms_polls_options`
                  SET votes = votes + 1
                  WHERE id = ? AND poll_id = ?";
    if ($stmt = mysqli_prepare($link, $queryVote)) {
        mysqli_stmt_bind_param($stmt, 'ii', $voteOption, $pollId);
        mysqli_stmt_execute($stmt);
        $gcms->assign('poll_voted', true);
    }
}

// واکشی اطلاعات نظرسنجی
if ($pollId > 0) {
    // پرسش اصلی
    $queryPoll = "SELECT question
                  FROM `gcms_polls`
                  WHERE id = ? AND status = 'publish'";
    if ($stmt = mysqli_prepare($link, $queryPoll)) {
        mysqli_stmt_bind_param($stmt, 'i', $pollId);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        if ($row = mysqli_fetch_assoc($res)) {
            $pollData['question'] = $row['question'];
        }
    }
    // گزینه‌ها و آرای آنها
    $queryOpts = "SELECT id, option_text, votes
                  FROM `gcms_polls_options`
                  WHERE poll_id = ?";
    if ($stmt = mysqli_prepare($link, $queryOpts)) {
        mysqli_stmt_bind_param($stmt, 'i', $pollId);
        mysqli_stmt_execute($stmt);
        $resOpts = mysqli_stmt_get_result($stmt);
        $totalVotes = 0;
        $options    = [];
        while ($opt = mysqli_fetch_assoc($resOpts)) {
            $options[] = [
                'id'     => (int) $opt['id'],
                'text'   => htmlspecialchars($opt['option_text'], ENT_QUOTES, 'UTF-8'),
                'votes'  => (int) $opt['votes'],
            ];
            $totalVotes += (int) $opt['votes'];
        }
        $pollData['options']     = $options;
        $pollData['total_votes'] = $totalVotes;
    }
}

// اختصاص به Smarty
$gcms->assign('poll', $pollData);
