<?php
declare(strict_types=1);

// بارگذاری کتابخانه RSS
require_once __DIR__ . '/rss_generator.inc.php';

// پیکربندی کانال
$rss_channel = new rssGenerator_channel();
$rss_channel->title       = 'My News';
$rss_channel->link        = 'http://mysite.com/news.php';
$rss_channel->description = 'The latest news about web-development.';
$rss_channel->language    = 'en-us';
// … سایر مشخصات کانال

// افزودن آیتم‌ها
$item = new rssGenerator_item();
$item->title       = 'New website launched';
$item->link        = 'http://newsite.com';
$item->description = 'Today I finally launched a new website.';
$item->pubDate     = 'Tue, 07 Mar 2006 00:00:01 GMT';
$rss_channel->items[] = $item;

// آیتم دوم …
  
// تولید خروجی
$rss_feed = new rssGenerator_rss();
$rss_feed->encoding = 'UTF-8';
header('Content-Type: application/xml; charset=UTF-8');
echo $rss_feed->createFeed($rss_channel);