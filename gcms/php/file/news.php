<?php

if ($pluginsetup[news]){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	if ($_GET[opinion] AND $_REQUEST[submitbtt] AND $_REQUEST[email]){
		
	//security////////////////////////
	$sec30time = time()-30;
	if (mysql_fetch_array(mysql_query("SELECT * FROM `gcms_comment` WHERE comment_date > '$sec30time' AND comment_author_ip = '$_SERVER[REMOTE_ADDR]' ",$link))){
	if ($_SESSION["hacker"] == "news" and $_SESSION['counternews'] > 2 ){mysql_query("INSERT INTO `gcms_blocked` ( `ip` ) VALUES ('$_SERVER[REMOTE_ADDR]')",$link);}
	$_SESSION['hacker'] = "news";
	if ( $_SESSION['counternews']  >= 1 ) { ++$_SESSION['counternews']; }else { $_SESSION['counternews']= 1; }
	//sleep(15);
	echo "<script>window.location='?part=page&id=$configset[first_page]';</script>";
	}
	//security\\\\\\\\\\\\\\\\\\\\\\\
		
		
		if ( $configset[comment_publish_immd] == "yes" ){
		 $comment_approved = "confirm";
		}else {
		 $comment_approved = "rejcet";
		 $comes =  "  و بعد از تایید مدیر سایت نمایش داده می شود";
		}
		if ($_REQUEST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
			$message = "
				کد امنیتی اشتباه وارد شده. <br>
			";
		} else { 
		$comdate = time();
		$ip = $_SERVER['REMOTE_ADDR'] ;
		$_REQUEST[content] = htmlspecialchars("$_REQUEST[content]", ENT_QUOTES);
		$_REQUEST[name] = htmlspecialchars("$_REQUEST[name]", ENT_QUOTES);
		$_REQUEST[url] = htmlspecialchars("$_REQUEST[url]", ENT_QUOTES);
			//کوئری اضافه کردن به جدول 
			$que_add = "INSERT INTO `gcms_comment` ( `page_id` ,`comment_author` ,`comment_author_email` ,`comment_author_url` ,`comment_author_ip` ,`comment_date` ,`comment_approved` ,`comment_content`, `comment_parent` ) 
			VALUES ('$_REQUEST[id]' ,'$_REQUEST[name]' ,'$_REQUEST[email]' ,'$_REQUEST[url]' ,'$ip' ,'$comdate', '$comment_approved', '$_REQUEST[content]' ,'0' )";
			//انجام کوئری
			
				if ( mysql_query($que_add,$link) ){
				$message = "نظر شما با موفقیت به ثبت رسید" . $comes;
				}else{
				// در صورت برخورد با مشکل
				$message  = "مشکل در ثبت نظر شما لطفا دوباره تلاش کنید";
				}
				}
////////////ارسال های پیام  ////////////////////////////////////////////////////////			
			$gcms->assign('message',$message); 
		
	}

if ( !$_GET[id] ){
		///////// list of news
		
		////find group
		
			$query_group = "SELECT * FROM `gcms_term`  WHERE term_tax = 'news_group'  ORDER BY `gcms_term`.`term_name` DESC  ";

		//نتایج
			$result_group = mysql_query($query_group,$link);
		//سطر ها
			$ing = 0;
			while ($row_group = mysql_fetch_array($result_group)){
			
				$news_groupname[$ing]    = $row_group['term_name'];
				$news_groupurl[$ing]     = "?part=news&term=".$row_group['term_id'];

				$ing++;
			}
			
////////////ارسال های گروه ها ////////////////////////////////////////////////////////			
			$gcms->assign('news_groupname',$news_groupname); 
			$gcms->assign('news_groupurl',$news_groupurl); 
		
		//\\\end find group
		
// تعریف کوئری برای لیست 

			//کوئری
			$query_list = " FROM `gcms_pages` JOIN gcms_relationships_page_term ON gcms_relationships_page_term.page_id = gcms_pages.id JOIN gcms_term ON gcms_term.term_id = gcms_relationships_page_term.term_id   WHERE page_status  = 'publish' AND page_type = 'news' ORDER BY `gcms_pages`.`page_date` DESC ";
	
	if ($_REQUEST[term]){
	$query_list = " FROM `gcms_pages` JOIN gcms_relationships_page_term ON gcms_relationships_page_term.page_id = gcms_pages.id JOIN gcms_term ON gcms_term.term_id = gcms_relationships_page_term.term_id   WHERE page_status  = 'publish' AND page_type = 'news' AND gcms_relationships_page_term.term_id = '$_REQUEST[term]' ORDER BY `gcms_pages`.`page_date` DESC";
	
	$termlink = "&term=$_REQUEST[term]";
	}
		
	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = $configset[newsnum];
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$tt = mysql_query("SELECT COUNT(*) as Num $query_list ");
	if (!$tt){
	echo "
		<script>
		window.location='?part=news';
		</script>	";
	}
	$total_results = mysql_result($tt,0); 
	if (!$total_results){
	echo "
		<script>
		window.location='?part=news';
		</script>	";
	}
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=news".$termlink;
	//////////////////////////////////////////////////////////////////////////////////////

			////////////////////////////////////////////////////////////////////////////////////
			//صفحه قبلی
			if($page > 1){ 
				$prev = ($page - 1); 
				$sendpage =  $sendpage."<a href='$pagelink&page=$prev'><div id='page' title='صفحه قبلی' >&laquo;</div></a>"; 
			} 
			//صفحه حاضر
			for($ipage = 1; $ipage <= $total_pages; $ipage++){ 
				if(($page) == $ipage){$sendpage =  $sendpage. "<div id='pagenolink' >$ipage</div>";} else { 
						$sendpage =  $sendpage. "<a href='$pagelink&page=$ipage'><div id='page' title='صفحه $ipage' >$ipage</div></a>"; 
				} 
			}
				//صفحه بعدی
			if($page < $total_pages){ 
				$next = ($page + 1); 
				$sendpage =  $sendpage. "<a href='$pagelink&page=$next'><div id='page' title='صفحه بعدی' >&raquo;</div></a>"; 
			} 
			////////////////////////////////////////////////////////////////////////////////////
////////////ارسال های صفحه ////////////////////////////////////////////////////////			
			$gcms->assign('page',$sendpage); 
			////////////////////////////////////////////////////////////////////////////////////
		// درست کردن لیست
		$query_list = "SELECT * ".$query_list." LIMIT $from, $max_results";
		
		//نتایج
			$result_list = mysql_query($query_list,$link);
		//سطر ها
			$i = 0;
			while ($row_list = mysql_fetch_array($result_list)){
			
				$list_page_title[$i]    = $row_list['page_title'];
				$list_page_excerpt[$i]  = $row_list['page_excerpt'];
				$list_page_pic[$i]      = $row_list['page_pic'];
				$list_page_date[$i]     = $date("l j  F  y ",$row_list['page_date']);
				$list_page_url[$i]      = "?part=news&id=".$row_list['id'];
				$list_page_group[$i]    = $row_list['term_name'];
				$list_page_groupid[$i]  = "?part=news&term=".$row_list['term_id'];

				$i++;
			}
			
////////////ارسال های لیست ////////////////////////////////////////////////////////			
			$gcms->assign('list_page_title',$list_page_title); 
			$gcms->assign('list_page_excerpt',$list_page_excerpt); 
			$gcms->assign('list_page_pic',$list_page_pic); 
			$gcms->assign('list_page_date',$list_page_date); 
			$gcms->assign('list_page_url',$list_page_url); 
			$gcms->assign('list_page_group',$list_page_group); 
			$gcms->assign('list_page_groupid',$list_page_groupid); 

	}else{

// پیدا کردن محتوای صفحه اصلی///////////////////////////////////


///////////////////////////////////////////////////////////

//کوئری
	$query_page = "SELECT * FROM `gcms_pages` JOIN gcms_metauser ON gcms_metauser.user_id = gcms_pages.page_author JOIN gcms_relationships_page_term ON gcms_relationships_page_term.page_id = gcms_pages.id JOIN gcms_term ON gcms_term.term_id = gcms_relationships_page_term.term_id JOIN gcms_metapage ON gcms_metapage.page_id = gcms_pages.id WHERE gcms_pages.id = '$_REQUEST[id]' AND gcms_metauser.metauser_key = 'first_name' ";
//نتایج
	$result_page = mysql_query($query_page,$link);
	
	
//سطر ها
	$row_page = mysql_fetch_array($result_page);
	
	if (!$row_page){
	echo "
		<script>
		window.location='?part=news';
		</script>
	";
	}
		
		$page_title   = $row_page['page_title'];
		$page_author  = $row_page['metauser_value'];
		$page_date    = $date("l j  F  y ",$row_page['page_date']);
		$page_content = $row_page['page_content'];
		$page_excerpt = $row_page['page_excerpt'] . "...";
		$page_costus  = $row_page['comment_status'];
		$page_pic     = $row_page['page_pic'];
		$form_id      = $row_page['form_id'];
		$newskeyword      = $row_page['meta_value'];
		
		$news_group   = $row_page['term_name'];
		$news_groupid = "?part=news&term=".$row_page['term_id'];

		/////// کامنت 
		if ($page_costus == "open"){
		
		$commentform = "
			<form method='post' action='?part=news&id=$row_page[id]&opinion=true' >
			نام&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='name'  id='commentinput' /><br />
			ایمیل&nbsp;<input type='text' name='email' id='commentinput' class='email' /><br />
			وب&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='url'  id='commentinput' /><br />
			<textarea name='content' id='commenttextarea' class='reqd' ></textarea><br />
			<img src='/gcms/php/file/captcha.php' align='absmiddle'><input type='text' name='vercode'  class='reqd' id='commentinputsecur' /> <br>
			لطفا کد تصوری را وارد کنید <br />
			<input type='submit' value='ارسال نظر' name='submitbtt' id='commentsubmit' onMouseDown='initForms()' /><br />
			</form>
		";
		
		///////// find all comment
		
			//کوئری
			$query_allcomment = "SELECT * FROM `gcms_comment` WHERE page_id  = '$row_page[id]' AND comment_approved = 'confirm' ";
		//نتایج
			$result_allcomment = mysql_query($query_allcomment,$link);
		//سطر ها
			$i = 0;
			while ($row_allcomment = mysql_fetch_array($result_allcomment)){
			
				$comment_author[$i]       = $row_allcomment['comment_author'];
				$comment_author_url[$i]   = $row_allcomment['comment_author_url'];
				$comment_date[$i]         = $date("l j  F  y ",$row_allcomment['comment_date']);
				$comment_content[$i]      = $row_allcomment['comment_content'];
				
				$i++;
			}
////////////ارسال های همه نظرات ////////////////////////////////////////////////////////			
			$gcms->assign('comment_author',$comment_author); 
			$gcms->assign('comment_author_url',$comment_author_url); 
			$gcms->assign('comment_date',$comment_date); 
			$gcms->assign('comment_content',$comment_content); 
		
		}
		
	
	

// پیدا کردن محتوای صفحه اصلی///////////////////////////////////




	}//end else

//تعریف منوی فعال
	$menu_active = "?part=news";

////////////ارسال های محتوای صفحه ////////////////////////////////////////////////////////			

			$gcms->assign('page_title',$page_title); 
			$gcms->assign('page_author',$page_author); 
			$gcms->assign('page_date',$page_date); 
			$gcms->assign('page_content',$page_content); 
			$gcms->assign('page_excerpt',$page_excerpt); 
			$gcms->assign('commentform',$commentform); 
			$gcms->assign('page_pic',$page_pic); 
			$gcms->assign('form_id',$form_id); 
			$gcms->assign('newskeyword',$newskeyword); 
			
			$gcms->assign('news_group',$news_group); 
			$gcms->assign('news_groupid',$news_groupid); 

/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',$menu_active); 
			$gcms->assign('part',"news"); 

			$gcms->display("index/index.tpl");
}else {
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>
	";

}


	
	

?>