<?php
declare(strict_types=1);

// ۱) نمایش همهٔ خطاها
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

echo "STEP 1: reached test_smart.php\n";

// ۲) Autoloader طبق PSR-4 برای namespace = 'Smarty\'
spl_autoload_register(function(string $class) {
    $prefix  = 'Smarty\\';
    $baseDir = __DIR__ . '/gcms/php/src/';  // <--- این مسیر را اصلاح کنید
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return; // کلاسی که نمی‌خواهیم
    }
    // از 'Smarty\' عبور کنیم و ساختار دایرکتوری را بسازیم
    $relativeClass = substr($class, $len);
    $file = $baseDir
          . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass)
          . '.php';
    if (file_exists($file)) {
        require_once $file; // حتماً require_once تا از بارگذاری مجدد جلوگیری شود
    }
});

// ۳) تازه‌سازی خودِ کلاس
try {
    $smarty = new \Smarty\Smarty();
    echo "STEP 2: Smarty instantiated\n";

    $smarty->setTemplateDir(__DIR__ . '/templates')
           ->setCompileDir(__DIR__ . '/templates_c/')
           ->setCacheDir(__DIR__ . '/cache/')
           ->setConfigDir(__DIR__ . '/configs/');
    echo "STEP 3: directories set\n";

    $smarty->assign('foo','بار');
    echo "STEP 4: assigned foo\n";

    // یک tpl موقت بسازیم
    if (!file_exists(__DIR__.'/templates')) {
        mkdir(__DIR__.'/templates', 0755, true);
    }
    file_put_contents(__DIR__ . '/templates/hello.tpl', 'Hello {$foo}!');
    $smarty->display('hello.tpl');

} catch (\Throwable $e) {
    echo "FATAL ERROR:\n";
    echo $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
