<?php
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

echo "1) reached\n";

$autoload = __DIR__ . '/vendor/autoload.php';
if (! file_exists($autoload)) {
    die("2) ERROR: $autoload not found\n");
}
require $autoload;
echo "3) autoload OK\n";

if (class_exists(\Smarty\Smarty::class)) {
    echo "4) Smarty class OK\n";
} else {
    echo "5) Smarty class NOT found\n";
}
