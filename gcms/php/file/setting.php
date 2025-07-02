<?php

// پیدا کردن منوها///////////////////////////////////////////////////////////////////////
//کوئری
	$query_menu = "SELECT * FROM `gcms_pages` WHERE page_status = 'publish' AND page_parent = '0' AND page_type = 'page' ORDER BY `gcms_pages`.`menu_order` ASC ";
//نتایج
	$result_menu = mysql_query($query_menu,$link);
//سطر ها
	$i = 0;
	while ($row_menu = mysql_fetch_array($result_menu)){
		
		$menu_title[$i] = $row_menu['page_title'];
		$menu_url[$i] = "?part=page&id=".$row_menu['id'];

		/////////////////// صفحات فرعی مرتبط با این صفحه 
		
			//کوئری
				$query_menu_child = "SELECT * FROM `gcms_pages` WHERE page_status = 'publish' AND page_parent = '$row_menu[id]' ORDER BY `gcms_pages`.`menu_order` ASC ";
			//نتایج
				$result_menu_child = mysql_query($query_menu_child,$link);
			//سطر ها
			
				$j = 0;
				while ($row_menu_child = mysql_fetch_array($result_menu_child)){
				
				$menu_child_title[$i][$j] = $row_menu_child['page_title'];
				$menu_child_url[$i][$j] = "?part=page&id=".$row_menu_child['id'];
				$j++;
				}
				
		///\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
		
		$i++;
	
	}
	
	
	
////////////////////////////////////// plugin


//کوئری
	$query_menu_plugin = "SELECT * FROM `gcms_plugin` WHERE status = 'active' ORDER BY `gcms_plugin`.`date` ASC ";
//نتایج
	$result_menu_plugin = mysql_query($query_menu_plugin,$link);
//سطر ها
				$iplu = 0;
	while ($row_menu_plugin = mysql_fetch_array($result_menu_plugin)){
		
		$plugin_menu_title[$iplu] = $row_menu_plugin['f_name'];
		$plugin_menu_url[$iplu] = "?part=".$row_menu_plugin['e_name'];
		$pluginsetup[$row_menu_plugin[e_name]] = "true";

		$iplu++;
	
	}
	
	
// پیدا کردن منوها\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\



// پیدا کردن تنظیمات///////////////////////////////////////////////////////////////////////
// تعریف کوئری برای پیدا کردن تنظیمات 
	$query_fsett = "SELECT * FROM `gcms_setting`  ";
// نتایج کوئری
	$result_fsett = mysql_query($query_fsett,$link);
// دریافت نتایج در سطر	

	while ($row_fsett = mysql_fetch_array($result_fsett)) { 
	
			$configset[$row_fsett['setting_name']]=$row_fsett['setting_value'];
			
	
	}
///////////////////////////////////////////////////////////
//  پیدا کردن زمان سایت شمسی یا میلادی 

	$date = "date";
		if ( $configset[defult_date] == "shamsi" )
		{
		$date = "jdate";
		}
// پیدا کردن تنظیمات\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\


// پیدا کردن صفحات پلاگین ها///////////////////////////////////////////////////////////////////////

		$plugarr = array(
		// در صورت اضافه شدن پلاگین در این قسمت اضافه می شود
		"1" => "news",
		"2" => "gallery", 
		"3" => "poll",
		"4" => "newsletter"
		);
		
		for ($ipl = 1; $ipl <= count($plugarr); $ipl++) {
			if ( $pluginsetup[$plugarr[$ipl]] ){
				require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/main'.$plugarr[$ipl].'.php';

			} 
		}
		
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mainlogin.php';
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mainsearsh.php';

// پیدا کردن صفحات پلاگین ها\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
		///////////////////////////
			$row_gcms_1 = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '4' ",$link));
			$gcms_1_content = $row_gcms_1['page_content'];
			$gcms_1_title   = $row_gcms_1['page_title'];
			$gcms_1_pic     = $row_gcms_1['page_pic'];
			$gcms->assign('gcms_1_content',$gcms_1_content); 
			$gcms->assign('gcms_1_title',$gcms_1_title); 
			$gcms->assign('gcms_1_pic',$gcms_1_pic); 
		///////////////////////////
	
		///////////////////////////
			$row_gcms_2 = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '52' ",$link));
			$gcms_2_content = $row_gcms_2['page_content'];
			$gcms_2_title   = $row_gcms_2['page_title'];
			$gcms_2_pic     = $row_gcms_2['page_pic'];
			$gcms->assign('gcms_2_content',$gcms_2_content); 
			$gcms->assign('gcms_2_title',$gcms_2_title); 
			$gcms->assign('gcms_2_pic',$gcms_2_pic); 
		///////////////////////////
	
		///////////////////////////
			$row_gcms_3 = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '15' ",$link));
			$gcms_3_pic     = $row_gcms_3['page_pic'];
			$gcms->assign('gcms_3_pic',$gcms_3_pic); 
		///////////////////////////
	
		///////////////////////////
			$row_gcms_4 = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '18' ",$link));
			$gcms_4_pic     = $row_gcms_4['page_pic'];
			$gcms->assign('gcms_4_pic',$gcms_4_pic); 
		///////////////////////////
		///////////////////////////
			$row_gcms_5 = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '19' ",$link));
			$gcms_5_content = $row_gcms_5['page_content'];
			$gcms_5_title   = $row_gcms_5['page_title'];
			$gcms->assign('gcms_5_content',$gcms_5_content); 
			$gcms->assign('gcms_5_title',$gcms_5_title); 
		///////////////////////////
////////////ارسال های تنظیمات ////////////////////////////////////////////////////////			

			$gcms->assign('title',"$configset[title] "); 
			$gcms->assign('keyword',"$configset[keyword]"); 
			$gcms->assign('description',"$configset[description]"); 
			$gcms->assign('language',"$configset[language]"); 
			$gcms->assign('copyright',"$configset[copyright]"); 
////////////ارسال های منو ها ////////////////////////////////////////////////////////////			
			$gcms->assign('menu_title',$menu_title); 
			$gcms->assign('menu_url',$menu_url); 

			$gcms->assign('plugin_menu_title',$plugin_menu_title); 
			$gcms->assign('plugin_menu_url',$plugin_menu_url); 
			
			$gcms->assign('menu_child_title',$menu_child_title); 
			$gcms->assign('menu_child_url',$menu_child_url); 
	
// get amount 
if (isset($_SESSION[g_id_login]))
{
    $u_amount=mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link));
$gcms->assign('u_amount',number_format($u_amount[0])); 
    
}

	
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/cron.php';
?>