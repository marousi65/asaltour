<?php

	include_once $_SERVER["DOCUMENT_ROOT"]."/gcms/php/file/gconfig.php";
// find setting///////////////////////////////////////////////////////////////////////
// def query 
	$query_fsett = "SELECT * FROM `gcms_setting`  ";
// query result
	$result_fsett = mysql_query($query_fsett,$link);
// row	

	while ($row_fsett = mysql_fetch_array($result_fsett)) { 
	
			$configset[$row_fsett["setting_name"]]=$row_fsett["setting_value"];
			
	
	}

require_once "rss_generator.inc.php";

$rss_channel = new rssGenerator_channel();
$rss_channel->atomLinkHref = "";
$rss_channel->title = "$configset[title]";
$rss_channel->link = "$configset[site_address]";
$rss_channel->description = "$configset[description]";
$rss_channel->language = "$configset[language]";
$rss_channel->generator = "Gatriya Gcms";
$rss_channel->managingEditor = "gcms@gatriya.com ( Gatriya.com )";
$rss_channel->webMaster = "$configset[email] ($configset[site_address])";

//query
	$query_page = "SELECT * FROM `gcms_pages` WHERE page_status='publish' AND page_type='news' ORDER BY `gcms_pages`.`id` DESC   LIMIT 0 , 10";
//result
	$result_page = mysql_query($query_page,$link);
//all row
	while ($row_page = mysql_fetch_array($result_page)){


$item = new rssGenerator_item();
$item->title = "$row_page[page_title]";
$item->description = "$row_page[page_excerpt]";
$item->link = "$configset[site_address]/gcms/?part=page&amp;id=$row_page[id]";
$item->guid = "$configset[site_address]/gcms/?part=page&amp;id=$row_page[id]";
//$item->pubDate = "Tue, 07 Mar 2006 00:00:01 GMT";
$rss_channel->items[] = $item;

	}

$rss_feed = new rssGenerator_rss();
$rss_feed->encoding = "UTF-8";
$rss_feed->version = "2.0";
header("Content-Type: text/xml");
echo $rss_feed->createFeed($rss_channel);

?>