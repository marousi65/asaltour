<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

if ($_REQUEST[form] == "contact"){
	if ($_REQUEST[submitbtt] AND $_REQUEST[text] AND $_REQUEST[email]){
		if ($_REQUEST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
			$message = "
				کد امنیتی اشتباه وارد شده. <br>
			";
		} else { 
	//security////////////////////////
	$sec30time = time()-30;
	if ( $_SESSION['cotactformtime'] > $sec30time){
		if ($_SESSION["hacker"] == "cotactformtime" and $_SESSION['countercotactform'] > 2 ){
		mysql_query("INSERT INTO `gcms_blocked` ( `ip` ) VALUES ('$_SERVER[REMOTE_ADDR]')",$link);
		}
		$_SESSION['hacker'] = "cotactformtime"  ;
	if ( $_SESSION['countercotactform']  >= 1 ) { ++$_SESSION['countercotactform']; }else { $_SESSION['countercotactform']= 1; }
		//sleep(15);
		echo "<script>window.location='?part=page&id=$configset[first_page]';</script>";
	 }else{ $_SESSION['cotactformtime'] =  time();}
	
	//security\\\\\\\\\\\\\\\\\\\\\\\
	
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';

		$subject = "Contact From " .  $configset[site_address];
		$text = "	
				  <p>تماس از $configset[site_address] - بخش پشتیبانی</p>
				  <table>
					<tr>
					  <td align=center dir=rtl  > نام تماس گیرنده : $_POST[name] </td>
					</tr>
					<tr>
					  <td align=center dir=rtl > ایمیل تماس گیرنده : $_POST[email]</td>
					</tr>
					<tr>
					  <td align=center dir=rtl > متن فرستاده شده : $_POST[text] </td>
					</tr>
				
				  </table>
		";
		$from = "$configset[site_address]";
					
				if ( sendmail($configset[email],$_POST[email],$text,$subject,$messmail) ){
				$message = " از تماس شما متشکریم ... مطلب شما به مدیر سایت ارسال شد " ;
				
				}else{
				// در صورت برخورد با مشکل
				$message  = "مشکل در ارسال مطلب شما لطفا دوباره تلاش کنید ";
				}
				}
////////////ارسال های پیام  ////////////////////////////////////////////////////////			
			$gcms->assign('message',$message); 
		
	}
}

if (!$_REQUEST[id]){
	
	$_REQUEST[id] = $configset[first_page];
	
	}

// پیدا کردن محتوای صفحه اصلی///////////////////////////////////

//تعریف منوی فعال
	$menu_active = "?part=page&id=$_REQUEST[id]";

///////////////////////////////////////////////////////////

//کوئری
	$query_page = "SELECT id,page_title,metauser_value,page_date,page_content,page_excerpt,comment_status,page_pic,form_id FROM `gcms_pages` JOIN gcms_metauser ON gcms_metauser.user_id = gcms_pages.page_author WHERE id = '$_REQUEST[id]' AND metauser_key = 'first_name' ";
//نتایج
	$result_page = mysql_query($query_page,$link);
//سطر ها
	$row_page = mysql_fetch_array($result_page);
	
	if (!$row_page){
	header("Location: ?part=page&id=$configset[first_page]");
	}
		$page_id   = $row_page['id'];
		$page_title   = $row_page['page_title'];
		$page_author  = $row_page['metauser_value'];
		$page_date    = $date("l j  F  y ",$row_page['page_date']);
		$page_content = $row_page['page_content'];
		$page_excerpt = $row_page['page_excerpt'] . "...";
		$page_costus  = $row_page['comment_status'];
		$page_pic     = $row_page['page_pic'];
		$form_id      = $row_page['form_id'];


		/////// کامنت 
		if ($form_id != 0){

			//کوئری
			$query_form = "SELECT * FROM `gcms_form` WHERE form_id  = '$form_id' ";
		//نتایج
			$result_form = mysql_query($query_form,$link);
		//سطر 
			
			$row_form = mysql_fetch_array($result_form);

			$form_html      = $row_form['form_html'];
////////////ارسال فرم ////////////////////////////////////////////////////////			
			$gcms->assign('form_html',$form_html); 

		}
		/////// کامنت 
		if ($page_costus == "open"){
		
		$commentform = "
			<form method='post' action='?part=page&id=$row_page[id]&opinion=true' >
			نام &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='text' name='name'  id='commentinput' /><br />
			ایمیل &nbsp;&nbsp;<input type='text' name='email' id='commentinput' /><br />
			 وب &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='url' id='commentinput' /><br />
			<textarea name='content' id='commenttextarea' ></textarea><br />
			<input type='submit' value='ارسال نظر' name='submitbtt' id='commentsubmit' /><br />
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
		
// زیر مجموعه ی صفحه //////////////////////////


	$query_child = " FROM `gcms_pages`  WHERE page_parent = $row_page[id] AND page_status = 'publish' ORDER BY `gcms_pages`.`menu_order` ASC ";

	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = 1; 
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$total_results = mysql_result(mysql_query("SELECT COUNT(*) as Num $query_child "),0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=page&id=$_REQUEST[id]";
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

//کوئری
	$query_child = "SELECT * ".$query_child." LIMIT $from, $max_results";
//نتایج
	$result_child = mysql_query($query_child,$link);
//سطر ها
	$i = 0;
	while ($row_child = mysql_fetch_array($result_child)){
		
		$childlist_title[$i] = $row_child['page_title'];
		$childlist_url[$i] = "?part=page&id=".$row_child['id'];
		$childlist_excerpt[$i] = $row_child['page_excerpt']." ...";
		$childlist_pic[$i] = $row_child['page_pic'];
		$i++;
	
	}
	
	
	
// زیر مجموعه ی صفحه //////////////////////////

// پیدا کردن محتوای صفحه اصلی///////////////////////////////////








////////////ارسال های محتوای صفحه ////////////////////////////////////////////////////////			
			$gcms->assign('page_id',$page_id); 
			$gcms->assign('page_title',$page_title); 
			$gcms->assign('page_author',$page_author); 
			$gcms->assign('page_date',$page_date); 
			$gcms->assign('page_content',$page_content); 
			$gcms->assign('page_excerpt',$page_excerpt); 
			$gcms->assign('commentform',$commentform); 
			$gcms->assign('page_pic',$page_pic); 
			$gcms->assign('form_id',$form_id); 
			
			$gcms->assign('childlist_title',$childlist_title); 
			$gcms->assign('childlist_url',$childlist_url); 
			$gcms->assign('childlist_excerpt',$childlist_excerpt); 
			$gcms->assign('childlist_pic',$childlist_pic); 

/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',$menu_active); 
			$gcms->assign('part',"page"); 
			
			$gcms->display("index/index.tpl");
	
	

?>