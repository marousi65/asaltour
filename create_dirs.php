<?php
declare(strict_types=1);

// لیست پوشه‌هایی که می‌خواهیم بسازیم
$dirs = ['templates_c', 'cache', 'configs'];
$base = __DIR__; // دایرکتوری فعلی (جایی که این فایل است)

foreach ($dirs as $dir) {
    $path = "$base/$dir";
    echo "---- بررسی: $path\n";

    if (file_exists($path)) {
        if (is_dir($path)) {
            echo "✔ پوشه موجود است.\n";
        } else {
            echo "⚠ خطا: یک فایل با نام $dir وجود دارد، در حال تغییر نام...\n";
            $bak = $path . '.bak_' . time();
            if (rename($path, $bak)) {
                echo "   فایل به $bak تغییر نام یافت.\n";
                if (mkdir($path, 0755)) {
                    echo "   پوشه $dir ساخته شد.\n";
                } else {
                    echo "   ✘ ساخت پوشه $dir با مشکل مواجه شد.\n";
                    continue;
                }
            } else {
                echo "   ✘ تغییر نام فایل با مشکل مواجه شد.\n";
                continue;
            }
        }
    } else {
        if (mkdir($path, 0755)) {
            echo "✔ پوشه $dir ایجاد شد.\n";
        } else {
            echo "✘ ایجاد پوشه $dir با مشکل مواجه شد.\n";
            continue;
        }
    }

    // تنظیم مجوز به 755
    if (chmod($path, 0755)) {
        echo "✔ مجوز پوشه $dir روی 755 تنظیم شد.\n";
    } else {
        echo "✘ تنظیم مجوز پوشه $dir با مشکل مواجه شد.\n";
    }

    echo "\n";
}

echo "انجام شد.\n";
