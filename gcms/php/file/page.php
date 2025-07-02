<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
		
	if ($_GET[opinion] AND $_REQUEST[submitbtt] AND $_REQUEST[email]){
		
	//security////////////////////////
	$sec30time = time()-15;
	if (mysql_fetch_array(mysql_query("SELECT * FROM `gcms_comment` WHERE comment_date > '$sec30time' AND comment_author_ip = '$_SERVER[REMOTE_ADDR]' ",$link))){
	if ($_SESSION["hacker"] == "page" and $_SESSION['counterpage'] > 2 ){mysql_query("INSERT INTO `gcms_blocked` ( `ip` ) VALUES ('$_SERVER[REMOTE_ADDR]')",$link);}
	$_SESSION['hacker'] = "page";
	if ( $_SESSION['counterpage'] >= 1 ) {++$_SESSION['counterpage'];}else {$_SESSION['counterpage']= 1;}
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
				if ($configset[comment_email]){
				require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
				$subject = "Comment From " .  $configset[site_address];
				$text = "	
						  <p>تماس از $configset[site_address] - بخش نظرات</p>
						  <table>
							<tr>
							  <td align=center dir=rtl  > نام نظر دهنده : $_POST[name] </td>
							</tr>
							<tr>
							  <td align=center dir=rtl > ایمیل نظر دهنده : $_POST[email]</td>
							</tr>
							<tr>
							  <td align=center dir=rtl > نظر فرستاده شده : $_POST[content] </td>
							</tr>
						
						  </table>
				";
				sendmail($configset[comment_email],$_POST[email],$text,$subject,$messmail);
				
				}
				}else{
				// در صورت برخورد با مشکل
				$message  = "مشکل در ثبت نظر شما لطفا دوباره تلاش کنید";
				}
			}
////////////ارسال های پیام  ////////////////////////////////////////////////////////			
			$gcms->assign('message',$message); 
			
		
	}

if (!$_REQUEST[id]){
	
	$_REQUEST[id] = $configset[first_page];
	
	}

// پیدا کردن محتوای صفحه اصلی///////////////////////////////////

//تعریف منوی فعال
	$menu_active = "?part=page&id=$_REQUEST[id]";

///////////////////////////////////////////////////////////

//کوئری
	$query_page = "SELECT * FROM `gcms_pages` JOIN gcms_metauser ON gcms_metauser.user_id = gcms_pages.page_author WHERE id = '$_REQUEST[id]' AND metauser_key = 'first_name' ";
//نتایج
	$result_page = mysql_query($query_page,$link);
	
	if (!$result_page){
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>	";
	}
	
//سطر ها
	$row_page = mysql_fetch_array($result_page);
	
	if (!$row_page){
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>	";
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
		$parent_id    = $row_page['page_parent'];


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
		
// زیر مجموعه ی صفحه //////////////////////////

	if ( $parent_id != 0 ){
//کوئری
	$query_parent = "SELECT id,page_title FROM `gcms_pages`  WHERE id = $parent_id ";
//سطر ها
	$row_parent = mysql_fetch_array(mysql_query($query_parent,$link));
	
	//////find next child page
	//کوئری
		$query_next = "SELECT id,page_title FROM `gcms_pages`  WHERE page_parent = '$parent_id' AND page_status = 'publish'  ORDER BY `gcms_pages`.`menu_order` ASC  ";
		$result_next = mysql_query($query_next,$link);
	//سطر ها
		$row_next44 = mysql_fetch_array(mysql_query($query_next,$link));
		$chprevid    =  $row_next44[0];
		$chprevtitle =  $row_next44[1];

		while ( $row_next = mysql_fetch_array($result_next)){

			if ($row_next[0] != $page_id ){

				$chprevid    =  $row_next[0];
				$chprevtitle =  $row_next[1];
				
				if($nn == 1 ){
				$child_nextid    = "$row_next[0]";
				$child_nexttitle = "$row_next[1]";
				
				$nn = 0 ;
				}
				
			}else{
			
			$nn = 1 ;
			$child_previd =  $chprevid ;
			$child_prevtitle =  $chprevtitle ;
			
			} 
			
		}
		
		if ( $child_previd == $page_id){
			$child_previd =  "" ;
			$child_prevtitle =  "" ;
		}
		

	
////////////ارسال های محتوای صفحه ////////////////////////////////////////////////////////
			$gcms->assign('parent_id',$row_parent[0]); 
			$gcms->assign('parent_title',$row_parent[1]); 
			
			$gcms->assign('child_previd',"?part=page&id=".$child_previd); 
			$gcms->assign('child_prevtitle',$child_prevtitle); 
			
			$gcms->assign('child_nextid',"?part=page&id=".$child_nextid); 
			$gcms->assign('child_nexttitle',$child_nexttitle); 
			
			
	}else{

	$query_child = " FROM `gcms_pages`  WHERE page_parent = $row_page[id] AND page_status = 'publish' ORDER BY `gcms_pages`.`menu_order` ASC ";

	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = $configset[childpagenum]; 
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
////////////ارسال های محتوای صفحه ////////////////////////////////////////////////////////			
			$gcms->assign('childlist_title',$childlist_title); 
			$gcms->assign('childlist_url',$childlist_url); 
			$gcms->assign('childlist_excerpt',$childlist_excerpt); 
			$gcms->assign('childlist_pic',$childlist_pic); 
			
	
	}
	
// زیر مجموعه ی صفحه //////////////////////////

// پیدا کردن محتوای صفحه اصلی///////////////////////////////////

// آمار سایت///////////////////////////////////

$hours = date("H:i");
$date = date("Y,m,d");
$ip = $_SERVER['REMOTE_ADDR'] ;

//کوئری
	$query_statistics = "INSERT INTO `gcms_statistics` (  `ip` , `second` , `page_id` , `hours` , `date`  )
VALUES ( '$ip', '0', '$_REQUEST[id]', '$hours', '$date')";
//سطر ها
	mysql_query($query_statistics,$link);


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
			
			

/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',$menu_active); 
			$gcms->assign('part',"page"); 
			
			$gcms->display("index/index.tpl");
			
	

?>