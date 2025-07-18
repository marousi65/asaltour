// خطوط echo "[Autoload] ..." و پرینت get_declared_classes()  
// و همه‌ی `<pre>` … `</pre>`  
// را از test.php حذف کنید

- انتقال به محیط واقعی پروژه  
۱) اگر این تست صرفاً برای تست بود، دیگر `test.php` را وارد چرخه‌ی لایو نکنید.  
۲) بهتر است به جای PSR-4 دستی، از Composer برای نصب و اتولودینگ استفاده کنید:
        cd public_html/gcms/php
    composer require smarty/smarty
    ```
   سپس در کد اصلی‌تان:
    ```php
    require __DIR__.'/vendor/autoload.php';
    $smarty = new \Smarty\Smarty();
    // پیکربندی مسیر قالب و کامپایل و کش:
    $smarty->setTemplateDir(__DIR__.'/templates/');
    $smarty->setCompileDir(__DIR__.'/templates_c/');
    $smarty->setCacheDir(__DIR__.'/cache/');
    ```
۳) فولدرهای `templates/`, `templates_c/` و `cache/` را ایجاد کنید و دسترسی نوشتن (write) را بدهید.  

از این به بعد می‌توانید بدون مشکل از تمام امکانات Smarty استفاده کنید. اگر قدم بعدی‌تان اجرای یک قالب تستی است، کافی‌ست در `templates/hello.tpl` بنویسید:

سلام {$name}!

و در PHP:

php
$smarty->assign('name','علی');
$smarty->display('hello.tpl');

تا خروجی «سلام علی!» را ببینید. موفق باشید!