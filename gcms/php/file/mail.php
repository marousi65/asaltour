<?php
declare(strict_types=1);

/**
 * ارسال ایمیل HTML
 * @return bool
 */
function sendmail(
    string $to,
    string $from,
    string $text,
    string $subject
): bool {
    // قالب HTML
    $message = <<<HTML
<!DOCTYPE html>
<html lang="fa">
<head>
  <meta charset="utf-8"/>
  <title>{$subject}</title>
  <style>
    body { font-size:11px; direction:rtl; }
    table { border:1px solid #000; border-collapse:collapse; font-size:12px; }
    td, th { border:1px inset #000; padding:5px; }
  </style>
</head>
<body>
  <table width="600">
    <tr><td>
      <div dir="rtl" align="right">
        <font color="#000066" face="tahoma" size="2">{$text}</font>
      </div>
    </td></tr>
  </table>
</body>
</html>
HTML;

    $headers  = "MIME-Version: 1.0\r\n"
              . "Content-type: text/html; charset=utf-8\r\n"
              . "From: {$from}\r\n";
    return mail($to, $subject, $message, $headers);
}
