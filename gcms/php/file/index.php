<?php
	session_start();
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	//security////////////////////////
	if (mysql_fetch_array(mysql_query("SELECT * FROM `gcms_blocked` WHERE ip = '$_SERVER[REMOTE_ADDR]'",$link))){die("<center><br><br><br><br><font color=red face=tahoma>شما به عنوان یک هکر در سیستم شناخته شده اید !! اگر غیر از این است می توانید با ایمیل زیر تماس بگیرید . <br><br><br><br> 25 m o r d a d [ a t ] g m a i l . c o m</font></center>");}
	//security\\\\\\\\\\\\\\\\\\\\\\\
	error_reporting(E_ALL ^ E_NOTICE);
	require_once("$_SERVER[DOCUMENT_ROOT]/gcms/php/libs/Smarty.class.php");
	$gcms = new Smarty();
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/jdf.php';
	include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/setting.php';


	if ( $configset[intro] != "no" and !$_GET['part']  ){
	
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
			
			default:
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/page.php';
		}

	}

?>