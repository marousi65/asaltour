<?php
declare(strict_types=1);
require_once __DIR__.'/../lib/bootstrap.php';
require_once __DIR__.'/adminfunc.php';

$list = filter_input(INPUT_GET,'list',FILTER_SANITIZE_STRING);
header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
header('Content-Disposition: attachment; filename="report_'.$list.'.xls"');
echo "\xEF\xBB\xBF"; // BOM UTF-8

switch($list){
  case 'shipman':
    $stmt = $pdo->prepare("SELECT fname,lname,email,cell,active 
                           FROM gcms_login WHERE type='shipman'");
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "<table><tr>
            <th>نام</th><th>ایمیل</th><th>موبایل</th><th>وضعیت</th>
          </tr>";
    foreach($rows as $r){
      $status = $r['active'] ? 'فعال':'غیرفعال';
      echo "<tr>
        <td>{$r['fname']} {$r['lname']}</td>
        <td>{$r['email']}</td>
        <td>{$r['cell']}</td>
        <td>{$status}</td>
      </tr>";
    }
    echo "</table>";
    break;
  // … agency, free, …
  default:
    exit('Invalid list');
}
