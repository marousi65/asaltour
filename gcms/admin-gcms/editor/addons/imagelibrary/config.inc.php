<?php
/********************************************************************
 * openImageLibrary addon v0.2.2    اصلاح‌شده برای امنیت بیشتر
 ********************************************************************/

// دایرکتوری پایهٔ تصاویر (واقعی)
$imageBaseDir = realpath($_SERVER['DOCUMENT_ROOT'].'/gcms/upload/filetype');
if($imageBaseDir === false || !is_dir($imageBaseDir)){
    die('Invalid image base directory');
}

// URL نسبی به پوشهٔ تصاویر
$imageBaseUrl = '/gcms/upload/filetype';

// آیا امکان مرور زیرپوشه‌ها باشد؟
$browseDirs = true;

// آیا اجازهٔ آپلود فعال است؟
$allowUploads = true;

// آیا فایل‌های هم‌نام بازنویسی شوند؟
$overwrite = false;

// پسوندهای مجاز برای نمایش و آپلود
$supportedExtensions = ['gif','png','jpeg','jpg','bmp'];

/**
 * امن‌سازی مسیر ورودی کاربر جهت جلوگیری از traversal
 * @param string $subdir  – نام دایرکتوری فرعی (مثلاً از GET یا POST)
 * @return string realpath‌ی پوشهٔ مقصد
 */
function sanitizeDir($subdir){
    global $imageBaseDir, $browseDirs;
    if(!$browseDirs){
        $subdir = '';
    }
    // حذف هرگونه ../
    $subdir = trim(str_replace(['../','..\\'], '', $subdir), '/\\');
    $target = realpath($imageBaseDir . DIRECTORY_SEPARATOR . $subdir);
    if($target === false || strpos($target, $imageBaseDir)!==0){
        die('Invalid directory access');
    }
    return $target;
}

// مثال استفادهٔ ساده برای نمایش لیست فایل‌ها
$currentDir = sanitizeDir($_GET['dir'] ?? '');
// scan پوشه
$files = scandir($currentDir);
// ... و ادامهٔ کد برای نمایش و آپلود

// === تابع آپلود امن
function handleUpload($file, $subdir=''){
    global $imageBaseDir, $supportedExtensions, $overwrite;
    if($file['error']!==UPLOAD_ERR_OK){
        return 'Upload error';
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if(!in_array($ext, $supportedExtensions, true)){
        return 'Unsupported file type';
    }
    // تولید نام یکتا اگر overwrite=false
    $baseName = pathinfo($file['name'], PATHINFO_FILENAME);
    $targetDir = sanitizeDir($subdir);
    $targetPath = $targetDir . DIRECTORY_SEPARATOR . $file['name'];
    if(file_exists($targetPath) && !$overwrite){
        $fileName = $baseName . '_' . uniqid() . '.' . $ext;
        $targetPath = $targetDir . DIRECTORY_SEPARATOR . $fileName;
    }
    if(!move_uploaded_file($file['tmp_name'], $targetPath)){
        return 'Could not move uploaded file';
    }
    return true;
}
