<?php

// پیدا کردن خبرها///////////////////////////////////////////////////////////////////////
//کوئری
	
	$count_home_news = $configset[newsmainnum];
	$query_news = "SELECT * FROM `gcms_pages` WHERE page_status = 'publish' AND page_parent = '0' AND page_type = 'news' ORDER BY `gcms_pages`.`page_date` DESC LIMIT 0 , $count_home_news";
//نتایج
	$result_news = mysql_query($query_news,$link);
//سطر ها
	$i = 0;
	while ($row_news = mysql_fetch_array($result_news)){
		
		$smalis_news_title[$i] = $row_news['page_title'];
		$smalis_news_pic[$i] = $row_news['page_pic'];
		$smalis_news_excerpt[$i] = $row_news['page_excerpt']. "...";
		$smalis_news_url[$i] = "?part=news&id=".$row_news['id'];
		$smalis_news_date[$i] = jdate("l j  F  y ",$row_page['page_date']);


		$i++;
	
	}

// پیدا کردن خبرها///////////////////////////////////////////////////////////////////////

////////////ارسال های سایدبار اخبار ////////////////////////////////////////////////////////			

			$gcms->assign('smalis_news_title',$smalis_news_title); 
			$gcms->assign('smalis_news_pic',$smalis_news_pic); 
			$gcms->assign('smalis_news_excerpt',$smalis_news_excerpt); 
			$gcms->assign('smalis_news_url',$smalis_news_url); 
			$gcms->assign('smalis_news_date',$smalis_news_date); 
			
	
	

?>