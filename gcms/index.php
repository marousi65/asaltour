<?php

error_reporting(0);
	session_start();
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	//security////////////////////////
	if (mysql_fetch_array(mysql_query("SELECT * FROM `gcms_blocked` WHERE ip = '$_SERVER[REMOTE_ADDR]'",$link))){die("<center><br><br><br><br><font color=red face=tahoma>شما به عنوان یک هکر در سیستم شناخته شده اید !! اگر غیر از این است می توانید با ایمیل زیر تماس بگیرید . <br><br><br><br> 25 m o r d a d [ a t ] g m a i l . c o m</font></center>");}
	//security\\\\\\\\\\\\\\\\\\\\\\\
	
	require_once("$_SERVER[DOCUMENT_ROOT]/gcms/php/libs/Smarty.class.php");
	$gcms = new Smarty();
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/jdf.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/setting.php';


	if ( $configset[intro] != "no" and !$_GET['part']  ){
			require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
			$gcms->assign('part',"intro"); 
			$gcms->display("intro/index.tpl");
	
	}else{


		switch ($_GET['part']){
	
			case "page":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/page.php';
			break;
	
			case "form":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/form.php';
			break;
	
			case "poll":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/poll.php';
			break;
			
			case "news":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/news.php';
			break;
			
			case "gallery":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gallery.php';
			break;
			
			case "rss":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/rss2.php';
			break;
			
			case "search":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/search.php';
			break;
			
			case "newsletter":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/newsletter.php';
			break;
			
			case "product":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/product.php';
			break;
			
			case "basket":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/basket.php';
			break;
			
			case "signin":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/signin.php';
			break;
			
			case "signup":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/signup.php';
			break;
			
			case "forgotten":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/forgotten.php';
			break;
			
			case "admin":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/admin.php';
			break;
			
			case "shipman":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/shipman.php';
			break;
			
			case "portman":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/portman.php';
			break;
			
			case "searchtrade":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/searchtrade.php';
			break;
			
			case "buy":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/buy.php';
			break;
			
			case "free":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/free.php';
			break;
			
			case "agency":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/agency.php';
			break;
			
			
			default:
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/page.php';
		}

	}

?>