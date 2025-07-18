<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/login.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	switch ($_REQUEST[part]){
		case "dashboard":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/dashboard.php';
		break;
		case "users":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/users.php';
		break;
		case "pages":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/pages.php';
		break;
		case "setting":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/setting.php';
		break;
		case "comment":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/comment.php';
		break;
		case "file":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/file.php';
		break;
		case "rss2":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/rss2.php';
		break;

		case "form":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/form.php';
		break;

		case "plugin":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/plugin.php';
		break;

		case "news":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/news.php';
		break;
		
		case "gallery":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/gallery.php';
		break;

		case "poll":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/poll.php';
		break;

		case "map":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/map.php';
		break;

		case "newsletter":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/newsletter.php';
		break;
		
		case "search":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/search.php';
		break;
		
		case "product":
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/product.php';
		break;
		
		default :
		$_REQUEST[part] = "dashboard";
		include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/admin-gcms/inc/dashboard.php';
		}
		
?>
