<?php
declare(strict_types=1);

// مطمئن شو session شروع شده
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/** @var array $configset از setting.php بارگذاری می‌شود */
/** @var Smarty $gcms از index.php ارسال می‌شود */

$total = 0;
ob_start();
?>
<form method="post" action="?part=basket&apply=true">
<table>
  <thead>
    <tr>
      <th>حذف</th><th>نام محصول</th><th>قیمت واحد</th>
      <th>تعداد</th><th>قیمت کل</th>
    </tr>
  </thead>
  <tbody>
    <?php for ($i = 1; $i <= ($_SESSION['countbasket'] ?? 0); $i++):
      $pid = $_SESSION["pid{$i}"] ?? null;
      if (!$pid) continue;
      $price = (int)($_SESSION["pprice{$i}"] ?? 0);
      $name  = $_SESSION["pname{$i}"] ?? '';
      $qty   = (int)($_SESSION["pquantity{$i}"] ?? 0);
      $line  = $price * $qty;
      $total += $line;
    ?>
    <tr>
      <td><a href="?part=basket&pdel=<?= $i ?>"><div class="basketdel">&times;</div></a></td>
      <td><?= esc($name) ?></td>
      <td><?= number_format($price) ?></td>
      <td><input type="text" name="p<?= $i ?>" value="<?= $qty ?>" class="basketquantity"></td>
      <td><?= number_format($line) ?></td>
    </tr>
    <?php endfor; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="3">
        <input type="submit" value="اعمال تغییرات" class="basketsubmitapply">
      </form>
      <form method="post" action="?part=basket&stage=1">
    </td>
      <td>قیمت نهایی</td>
      <td><?= number_format($total) ?></td>
    </tr>
    <tr>
      <td colspan="3">
        <b>روش پرداخت :</b><br>
        <select name="payment_type" class="basketselect">
          <option>هنگام دریافت محصول</option>
          <option>واریز به بانک</option>
        </select>
      </td>
      <td>تخفیف نهایی</td>
      <td>
        <input type="hidden" name="rebate_bpp_amount" value="<?= esc($configset['rebate_bpp_amount']) ?>">
        - <?= number_format($configset['rebate_bpp_amount']) ?>
      </td>
    </tr>
    <tr>
      <td colspan="3">
        <select name="bank" class="basketselect">
          <option>صادرات</option><option>ملی</option><!-- و بقیه بانک‌ها -->
        </select>
      </td>
      <td>کوپن تخفیف</td>
      <td>0</td>
    </tr>
    <tr>
      <td colspan="3">
        <input type="text" name="fish" value="شماره فیش پرداختی"
               onfocus="if(this.value==='شماره فیش پرداختی')this.value='';"
               class="basketinput">
      </td>
      <td>اضافه هزینه</td>
      <td>
        <input type="hidden" name="cost_bpp" value="<?= esc($configset['cost_bpp']) ?>">
        + <?= number_format($configset['cost_bpp']) ?>
      </td>
    </tr>
    <tr>
      <th colspan="3">
        <input type="submit" value="خرید نهایی" class="basketsubmitfinal">
      </th>
      <th>جمع کل</th>
      <?php $final = $total - $configset['rebate_bpp_amount'] + $configset['cost_bpp']; ?>
      <th><?= number_format($final) ?> <?= esc($configset['currency']) ?></th>
    </tr>
  </tfoot>
</table>
<?php
$mainbasketpart = ob_get_clean();
$gcms->assign('mainbasketpart', $mainbasketpart);
