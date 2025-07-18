<?php
// /gcms/php/file/captcha.php
declare(strict_types=1);
session_start();

// تولید کد CAPTCHA
$chars = 'ABCDEFGHJKLMNPRSTUVWXYZ23456789';
$code  = substr(str_shuffle($chars), 0, 6);
$_SESSION['captcha_code'] = $code;

// ساخت تصویر
$width  = 120;
$height = 40;
$im     = imagecreatetruecolor($width, $height);
$bg     = imagecolorallocate($im, 255,255,255);
$fg     = imagecolorallocate($im,   0,  0,  0);
imagefilledrectangle($im,0,0,$width,$height,$bg);

// اگر فونت TTF دارید:
$fontFile = __DIR__.'/../fonts/arial.ttf';
if (file_exists($fontFile)) {
    imagettftext($im, 20, 0, 10, 30, $fg, $fontFile, $code);
} else {
    imagestring($im, 5, 35, 10, $code, $fg);
}

header('Content-Type: image/png');
imagepng($im);
imagedestroy($im);
