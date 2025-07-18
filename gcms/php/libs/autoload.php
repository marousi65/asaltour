<?php
spl_autoload_register(function($class){
    // اگر از Composer استفاده نمی‌کنید:
    $base = __DIR__ . '/../vendor/';
    $file = $base . str_replace('\\','/',$class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});
