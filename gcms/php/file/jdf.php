<?php
declare(strict_types=1);

/**
 * کتابخانه تبدیل تاریخ شمسی – jdf.php
 * نسخهٔ اصلاح‌شده با strict types و حذف echo‌های ناخواسته
 */

/**
 * تبدیل تاریخ میلادی به رشتهٔ قالب‌بندی‌شدهٔ شمسی (مشابه date)
 *
 * @param string       $format   قالب‌بندی (مثل "Y-m-d H:i:s")
 * @param int|string   $maket    timestamp یا "now"
 * @return string
 */
function jdate(string $format, $maket = 'now'): string
{
    // اگر خواستید ترجمهٔ ارقام به فارسی باشد، این را true کنید:
    $transnumber = false;

    // تنظیمات منطقهٔ زمانی شمسی
    $TZhours   = 3;
    $TZminutes = 30;

    // تعیین timestamp نهایی
    if ($maket === 'now') {
        $time = time() + $TZhours * 3600 + $TZminutes * 60;
    } else {
        $time = (int)$maket + $TZhours * 3600 + $TZminutes * 60;
    }

    // تاریخ میلادی
    $gy = (int)date('Y', $time);
    $gm = (int)date('m', $time);
    $gd = (int)date('d', $time);

    // تبدیل به شمسی
    [$jy, $jm, $jd] = gregorian_to_jalali($gy, $gm, $gd);

    $result      = '';
    $escapeNext  = false;
    $len         = mb_strlen($format, 'UTF-8');

    for ($i = 0; $i < $len; $i++) {
        $char = mb_substr($format, $i, 1, 'UTF-8');
        if ($escapeNext) {
            $result     .= $char;
            $escapeNext = false;
            continue;
        }
        if ($char === '\\') {
            $escapeNext = true;
            continue;
        }
        switch ($char) {
            case 'd': // روز ۰۱–۳۱
                $d      = $jd < 10 ? "0{$jd}" : (string)$jd;
                $result .= $transnumber ? Convertnumber2farsi($d) : $d;
                break;
            case 'D': // روز هفته کوتاه
                $w      = date('D', $time);
                $mapD   = ['Sat'=>'ش','Sun'=>'ی','Mon'=>'د','Tue'=>'س','Wed'=>'چ','Thu'=>'پ','Fri'=>'ج'];
                $result .= $mapD[$w] ?? $w;
                break;
            case 'j': // روز بدون صفر پیشوند
                $d      = (string)$jd;
                $result .= $transnumber ? Convertnumber2farsi($d) : $d;
                break;
            case 'l': // روز هفته کامل
                $w      = date('l', $time);
                $mapL   = [
                    'Saturday'=>'شنبه','Sunday'=>'یک‌شنبه','Monday'=>'دوشنبه',
                    'Tuesday'=>'سه‌شنبه','Wednesday'=>'چهارشنبه','Thursday'=>'پنج‌شنبه','Friday'=>'جمعه'
                ];
                $result .= $mapL[$w] ?? $w;
                break;
            case 'm': // ماه ۰۱–۱۲
                $m      = $jm < 10 ? "0{$jm}" : (string)$jm;
                $result .= $transnumber ? Convertnumber2farsi($m) : $m;
                break;
            case 'n': // ماه بدون صفر پیشوند
                $result .= $transnumber ? Convertnumber2farsi((string)$jm) : $jm;
                break;
            case 'M': // نام ماه کوتاه
                $result .= short_monthname($jm);
                break;
            case 'F': // نام کامل ماه
                $result .= monthname($jm);
                break;
            case 'Y': // سال چهاررقمی
                $result .= $transnumber ? Convertnumber2farsi((string)$jy) : $jy;
                break;
            case 'y': // سال دونقطه‌ای
                $yy     = substr((string)$jy, 2, 2);
                $result .= $transnumber ? Convertnumber2farsi($yy) : $yy;
                break;
            case 'H': // ساعت ۲۴ساعته با صفر پیشوند
                $h      = date('H', $time);
                $result .= $transnumber ? Convertnumber2farsi($h) : $h;
                break;
            case 'h': // ساعت ۱۲ساعته با صفر پیشوند
                $h      = date('h', $time);
                $result .= $transnumber ? Convertnumber2farsi($h) : $h;
                break;
            case 'i': // دقیقه
                $i2     = date('i', $time);
                $result .= $transnumber ? Convertnumber2farsi($i2) : $i2;
                break;
            case 's': // ثانیه
                $s      = date('s', $time);
                $result .= $transnumber ? Convertnumber2farsi($s) : $s;
                break;
            case 'a': // am/pm کوتاه
                $ampm   = date('a', $time);
                $result .= $ampm === 'pm' ? 'ب.ظ' : 'ق.ظ';
                break;
            case 'A': // AM/PM طولانی
                $ampm   = date('a', $time);
                $result .= $ampm === 'pm' ? 'بعدازظهر' : 'قبل‌ازظهر';
                break;
            case 'U': // timestamp
                $result .= (string)time();
                break;
            case 'L': // کبیسه بودن سال شمسی
                $result .= is_kabise($jy) ? '1' : '0';
                break;
            case 'z': // روز سال (از ۰)
                $result .= (string)days_of_year($jm, $jd, $jy);
                break;
            default:
                $result .= $char;
        }
    }
    return $result;
}

/**
 * مبدل تاریخ شمسی به timestamp
 */
function jmaketime(int $hour = 0, int $minute = 0, int $second = 0, int $jmonth = 1, int $jday = 1, int $jyear = 1300): int
{
    [$gy, $gm, $gd] = jalali_to_gregorian($jyear, $jmonth, $jday);
    return mktime($hour, $minute, $second, $gm, $gd, $gy);
}

/**
 * اولین روز هفتهٔ ماه (۰=شنبه … ۶=جمعه)
 */
function mstart(int $month, int $day, int $year): int
{
    [$jy, $jm, $jd]     = gregorian_to_jalali($year, $month, $day);
    [$gy, $gm, $gd]     = jalali_to_gregorian($jy, $jm, 1);
    return (int)date('w', mktime(0, 0, 0, $gm, $gd, $gy));
}

/**
 * تعداد روزهای ماه شمسی داده‌شده
 */
function lastday(int $month, int $day, int $year): int
{
    $lastEn = (int)date('d', mktime(0, 0, 0, $month + 1, 0, $year));
    [$jy, $jm, $jd] = gregorian_to_jalali($year, $month, $day);

    $count = 0;
    $d     = 1;
    while (true) {
        [$gy, $gm, $gd] = jalali_to_gregorian($jy, $jm, $d);
        if ($gd > $lastEn) {
            break;
        }
        $count++;
        $d++;
    }
    return $count;
}

/**
 * تعداد روزهای گذشته از ابتدای سال شمسی تا تاریخ داده‌شده
 */
function days_of_year(int $jmonth, int $jday, int $jyear): int
{
    $sum = 0;
    for ($m = 1; $m < $jmonth; $m++) {
        $sum += lastday(...jalali_to_gregorian($jyear, $m, 1));
    }
    return $sum + $jday;
}

/**
 * نام کامل ماه شمسی
 */
function monthname(int $month): string
{
    $names = [
        1=>'فروردین',2=>'اردیبهشت',3=>'خرداد',4=>'تیر',
        5=>'مرداد',6=>'شهریور',7=>'مهر',8=>'آبان',
        9=>'آذر',10=>'دی',11=>'بهمن',12=>'اسفند'
    ];
    return $names[$month] ?? '';
}

/**
 * نام کوتاه ماه شمسی
 */
function short_monthname(int $month): string
{
    $short = [
        1=>'فرورد',2=>'اردی',3=>'خرد',4=>'تیر',
        5=>'مردا',6=>'شهر',7=>'مهر',8=>'آبا',
        9=>'آذر',10=>'دی',11=>'بهم',12=>'اسفن'
    ];
    return $short[$month] ?? '';
}

/**
 * تبدیل ارقام لاتین به فارسی
 */
function Convertnumber2farsi(string $str): string
{
    $map = ['0'=>'۰','1'=>'۱','2'=>'۲','3'=>'۳','4'=>'۴',
            '5'=>'۵','6'=>'۶','7'=>'۷','8'=>'۸','9'=>'۹'];
    return str_replace(array_keys($map), array_values($map), $str);
}

/**
 * بررسی کبیسه بودن سال شمسی
 */
function is_kabise(int $jy): bool
{
    // تقویم 33 ساله‌ی شمسی: سال‌هایی که باقیماندهٔ تقسیم بر 33 == 1 کبیسه‌اند
    return ($jy % 33) % 4 === 1;
}

/**
 * اعتبارسنجی تاریخ شمسی
 */
function jcheckdate(int $month, int $day, int $year): bool
{
    if ($month < 1 || $month > 12) {
        return false;
    }
    $mdays = [31,31,31,31,31,31,30,30,30,30,30,29];
    if ($day < 1 || $day > $mdays[$month - 1]) {
        // اگر اسفند 30 و سال کبیسه باشد
        if ($month === 12 && is_kabise($year) && $day === 30) {
            return true;
        }
        return false;
    }
    return true;
}

/**
 * timestamp کنونی
 */
function jtime(): int
{
    return time();
}

/**
 * آرایهٔ تاریخ شمسی مشابه getdate
 */
function jgetdate(int $timestamp = 0): array
{
    if ($timestamp === 0) {
        $timestamp = time();
    }
    return [
        'seconds' => jdate('s', $timestamp),
        'minutes' => jdate('i', $timestamp),
        'hours'   => jdate('G', $timestamp),
        'mday'    => jdate('j', $timestamp),
        'wday'    => jdate('w', $timestamp),
        'mon'     => jdate('n', $timestamp),
        'year'    => jdate('Y', $timestamp),
        'yday'    => days_of_year((int)jdate('n', $timestamp), (int)jdate('j', $timestamp), (int)jdate('Y', $timestamp)),
        'weekday' => jdate('l', $timestamp),
        'month'   => jdate('F', $timestamp),
    ];
}

/**
 * تبدیل میلادی به شمسی
 * @return array [year, month, day]
 */
function gregorian_to_jalali(int $gy, int $gm, int $gd): array
{
    $gDaysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];
    // بررسی کبیسهٔ میلادی
    if ((($gy % 4 === 0 && $gy % 100 !== 0) || ($gy % 400 === 0))) {
        $gDaysInMonth[1] = 29;
    }

    $gy2 = $gy - 1600;
    $gm2 = $gm - 1;
    $gd2 = $gd - 1;

    $gDayNo = 365 * $gy2 + (int)(($gy2 + 3) / 4) - (int)(($gy2 + 99) / 100) + (int)(($gy2 + 399) / 400);
    for ($i = 0; $i < $gm2; $i++) {
        $gDayNo += $gDaysInMonth[$i];
    }
    $gDayNo += $gd2;

    $jDayNo = $gDayNo - 79;
    $jNp    = (int)($jDayNo / 12053);
    $jDayNo %= 12053;

    $jy = 979 + 33 * $jNp + 4 * (int)($jDayNo / 1461);
    $jDayNo %= 1461;

    if ($jDayNo >= 366) {
        $jy += (int)(($jDayNo - 1) / 365);
        $jDayNo = ($jDayNo - 1) % 365;
    }

    $jDaysInMonth = [31,31,31,31,31,31,30,30,30,30,30,29];
    for ($i = 0; $i < 11 && $jDayNo >= $jDaysInMonth[$i]; $i++) {
        $jDayNo -= $jDaysInMonth[$i];
    }
    $jm = $i + 1;
    $jd = $jDayNo + 1;

    return [$jy, $jm, $jd];
}

/**
 * تبدیل شمسی به میلادی
 * @return array [year, month, day]
 */
function jalali_to_gregorian(int $jy, int $jm, int $jd): array
{
    $jDaysInMonth = [31,31,31,31,31,31,30,30,30,30,30,29];

    $jy2 = $jy - 979;
    $jm2 = $jm - 1;
    $jd2 = $jd - 1;

    $jDayNo = 365 * $jy2 + (int)($jy2 / 33) * 8 + (int)((($jy2 % 33) + 3) / 4);
    for ($i = 0; $i < $jm2; $i++) {
        $jDayNo += $jDaysInMonth[$i];
    }
    $jDayNo += $jd2;

    $gDayNo = $jDayNo + 79;
    $gy     = 1600 + 400 * (int)($gDayNo / 146097);
    $gDayNo %= 146097;

    $leap = true;
    if ($gDayNo >= 36525) {
        $gDayNo--;
        $gy     += 100 * (int)($gDayNo / 36524);
        $gDayNo %= 36524;
        if ($gDayNo >= 365) {
            $gDayNo++;
        } else {
            $leap = false;
        }
    }

    $gy += 4 * (int)($gDayNo / 1461);
    $gDayNo %= 1461;

    if ($gDayNo >= 366) {
        $leap  = false;
        $gDayNo--;
        $gy    += (int)($gDayNo / 365);
        $gDayNo %= 365;
    }

    $gDaysInMonth = [31,28,31,30,31,30,31,31,30,31,30,31];
    if ($leap) {
        $gDaysInMonth[1] = 29;
    }

    for ($i = 0; $i < 12 && $gDayNo >= $gDaysInMonth[$i]; $i++) {
        $gDayNo -= $gDaysInMonth[$i];
    }

    $gm = $i + 1;
    $gd = $gDayNo + 1;

    return [$gy, $gm, $gd];
}
