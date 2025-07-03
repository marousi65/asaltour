<?php
  session_start();  
if ($pluginsetup[product]){

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	//add to basket
	if ($_GET[addtobasket]){

		$_SESSION["countbasket"]= ++$_SESSION["countbasket"];
		$pid = "pid".$_SESSION["countbasket"];
		$pprice = "pprice".$_SESSION["countbasket"];
		$pname = "pname".$_SESSION["countbasket"];		
		$pname = "pname".$_SESSION["countbasket"];		
		$pquantity = "pquantity".$_SESSION["countbasket"];		
		$_SESSION["$pid"] = $_POST[pid];
		$_SESSION["$pprice"] = $_POST[pprice];
		$_SESSION["$pname"] = $_POST[pname];
		$_SESSION["$pquantity"] = "1";

		$message  = "محصول $_POST[pname] با قیمت خرید  $_POST[pprice] $configset[currency] با موفقیت به سبد خرید شما اضافه شد. <br> <a href='?part=basket'>مشاهده سبد خرید</a>  ";
			$gcms->assign('message',$message); 
	}
  

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
		
		$comdate = time();
		$ip = $_SERVER['REMOTE_ADDR'] ;
		$_REQUEST[content] = htmlspecialchars("$_REQUEST[content]", ENT_QUOTES);
		$_REQUEST[name] = htmlspecialchars("$_REQUEST[name]", ENT_QUOTES);
		$_REQUEST[url] = htmlspecialchars("$_REQUEST[url]", ENT_QUOTES);
			//کوئری اضافه کردن به جدول 
			$que_add = "INSERT INTO `gcms_comment` ( `page_id` ,`comment_author` ,`comment_author_email` ,`comment_author_url` ,`comment_author_ip` ,`comment_date` ,`comment_approved` ,`comment_content`, `comment_parent` ) 
			VALUES ('$_REQUEST[id]' ,'$_REQUEST[name]' ,'$_REQUEST[email]' ,'$_REQUEST[url]' ,'$ip' ,'$comdate', '$comment_approved', '$_REQUEST[content]' ,'0' )";
			//انجام کوئری
			
				if ( mysql_db_query($dbname,$que_add,$link) ){
				$message = "نظر شما با موفقیت به ثبت رسید" . $comes;
				}else{
				// در صورت برخورد با مشکل
				$message  = "مشکل در ثبت نظر شما لطفا دوباره تلاش کنید";
				}
////////////ارسال های پیام  ////////////////////////////////////////////////////////			
			$gcms->assign('message',$message); 
		
	}

if ( !$_GET[id] ){
		///////// list of news
		
		////find group
		
			$query_group = "SELECT * FROM `gcms_pages`  WHERE page_status  = 'publish' AND page_type = 'product' AND   page_parent = '0' ORDER BY `gcms_pages`.`menu_order` DESC ";

		//نتایج
			$result_group = mysql_query($query_group,$link);
		//سطر ها
			$ing = 0;
			while ($row_group = mysql_fetch_array($result_group)){
			
				$product_groupname[$ing]         = $row_group['page_title'];
				$product_groupurl[$ing]          = "?part=product&group=".$row_group['id'];
				$product_grouppage_pic[$ing]     = $row_group['page_pic'];
				$product_grouppage_excerpt[$ing] = $row_group['page_excerpt'];

				$ing++;
			}
			
////////////ارسال های گروه ها ////////////////////////////////////////////////////////			
			$gcms->assign('product_groupname',$product_groupname); 
			$gcms->assign('product_groupurl',$product_groupurl); 
			$gcms->assign('product_grouppage_pic',$product_grouppage_pic); 
			$gcms->assign('product_grouppage_excerpt',$product_grouppage_excerpt); 
		
		//\\\end find group
		
// تعریف کوئری برای لیست 

			//کوئری
			$query_list = " FROM `gcms_pages`  WHERE page_status  = 'publish' AND page_type = 'product' AND page_parent != '0' ORDER BY `gcms_pages`.`menu_order` DESC ";
	$max_results = $configset[last_product_num];
	if ($_REQUEST[group]){
	$query_list = " FROM `gcms_pages`  WHERE page_status  = 'publish' AND page_type = 'product' AND page_parent = '$_REQUEST[group]' ORDER BY `gcms_pages`.`menu_order` DESC";
	
	$grouplink = "&group=$_REQUEST[group]";
	$max_results = $configset[product_num];
	}
		
	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	//$max_results = $configset[product_num];
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$tt = mysql_query("SELECT COUNT(*) as Num $query_list ");
	if (!$tt){
	echo "
		<script>
		window.location='?part=product';
		</script>	";
	}
	$total_results = mysql_result($tt,0); 
	if (!$total_results){
	echo "
		<script>
		window.location='?part=product';
		</script>	";
	}
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=product".$grouplink;
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
			//
			$rowgroup = mysql_fetch_array(mysql_query("SELECT id,page_title FROM gcms_pages WHERE  id='$row_list[page_parent]' ",$link));
			//
			$rowpprice = mysql_fetch_array(mysql_query("SELECT meta_value FROM gcms_metapage WHERE  page_id='$row_list[id]' AND meta_key='product_price' ",$link));
			//
			$rowrpprice = mysql_fetch_array(mysql_query("SELECT meta_value FROM gcms_metapage WHERE  page_id='$row_list[id]' AND meta_key='rebate_product_price' ",$link));
			//
			$rowexpprice = mysql_fetch_array(mysql_query("SELECT meta_value FROM gcms_metapage WHERE  page_id='$row_list[id]' AND meta_key='ex_product_price' ",$link));
			
				$list_page_title[$i]    = $row_list['page_title'];
				$list_page_excerpt[$i]  = $row_list['page_excerpt'];
				$list_page_pic[$i]      = $row_list['page_pic'];
				$list_page_date[$i]     = $date("l j  F  y ",$row_list['page_date']);
				$list_page_url[$i]      = "?part=product&id=".$row_list['id'];
				$list_page_group[$i]    = $rowgroup[1];
				$list_page_groupid[$i]  = "?part=product&group=".$rowgroup[0];
				$list_page_pprice[$i]   = $rowpprice[0];
				$list_page_rpprice[$i]   = $rowrpprice[0];
				$list_page_expprice[$i]   = $rowexpprice[0];
				
		$pprice = $rowpprice[0] - $rowrpprice[0] + $rowexpprice[0];

		//add basket buttom
		$addto_basket[$i] = "
		<form action='?part=product&id=$row_list[id]&addtobasket=true' method='post' >
		<input type='hidden' value='$row_list[id]' name='pid'  />
		<input type='hidden' value='$row_list[page_title]' name='pname'  />
		<input type='hidden' value='$pprice' name='pprice'  />
		<input type='submit' value='&nbsp;' name='submitaddtobasket' id='addto_basket1'  />
		</form>
		";
				
				
				$i++;
			}
			$gcms->assign('addto_basket',$addto_basket); 
////////////ارسال های لیست ////////////////////////////////////////////////////////			
			$gcms->assign('list_product_title',$list_page_title); 
			$gcms->assign('list_product_excerpt',$list_page_excerpt); 
			$gcms->assign('list_product_pic',$list_page_pic); 
			$gcms->assign('list_product_date',$list_page_date); 
			$gcms->assign('list_product_url',$list_page_url); 
			$gcms->assign('list_product_group',$list_page_group); 
			$gcms->assign('list_product_groupid',$list_page_groupid); 
			$gcms->assign('list_product_pprice',$list_page_pprice); 
			$gcms->assign('list_product_rpprice',$list_page_rpprice); 
			$gcms->assign('list_product_expprice',$list_page_expprice); 

	}else{

// پیدا کردن محتوای صفحه اصلی///////////////////////////////////


///////////////////////////////////////////////////////////
//کوئری
	$query_page = "SELECT * FROM `gcms_pages`  WHERE gcms_pages.id = '$_REQUEST[id]' AND page_status = 'publish' ";
//نتایج
	$result_page = mysql_query($query_page,$link);
	
	
//سطر ها
	$row_page = mysql_fetch_array($result_page);
	
	if (!$row_page){
	echo "
		<script>
		window.location='?part=product';
		</script>
	";
	}
			//
			$rowgroup = mysql_fetch_array(mysql_query("SELECT id,page_title FROM gcms_pages WHERE  id='$row_page[page_parent]' ",$link));
			//
			$rowpprice = mysql_fetch_array(mysql_query("SELECT meta_value FROM gcms_metapage WHERE  page_id='$row_page[id]' AND meta_key='product_price' ",$link));
			//
			$rowrpprice = mysql_fetch_array(mysql_query("SELECT meta_value FROM gcms_metapage WHERE  page_id='$row_page[id]' AND meta_key='rebate_product_price' ",$link));
			//
			$rowexpprice = mysql_fetch_array(mysql_query("SELECT meta_value FROM gcms_metapage WHERE  page_id='$row_page[id]' AND meta_key='ex_product_price' ",$link));
		
		$page_title   = $row_page['page_title'];
		$page_author  = $row_page['metauser_value'];
		$page_date    = $date("l j  F  y ",$row_page['page_date']);
		$page_content = $row_page['page_content'];
		$page_excerpt = $row_page['page_excerpt'] . "...";
		$page_costus  = $row_page['comment_status'];
		$page_pic     = $row_page['page_pic'];
		$form_id      = $row_page['form_id'];
		$page_id       = $row_page['id'];
		$page_pprice   = $rowpprice[0];
		$page_rpprice  = $rowrpprice[0];
		$page_expprice = $rowexpprice[0];
		//
		$pprice = $page_pprice - $page_rpprice + $page_expprice;
		//
		$product_group   = $rowgroup[1];
		$product_groupid = "?part=product&term=".$rowgroup[0];
		
		//add basket buttom
		$addto_basket = "
		<form action='?part=product&id=$_REQUEST[id]&addtobasket=true' method='post' >
		<input type='hidden' value='$page_id' name='pid'  />
		<input type='hidden' value='$page_title' name='pname'  />
		<input type='hidden' value='$pprice' name='pprice'  />
		<input type='submit' value='' name='submitaddtobasket' id='addto_basket'  />
		</form>
		";
		/////// کامنت 
		if ($page_costus == "open"){
		
		$commentform = "
			<form method='post' action='?part=product&id=$row_page[id]&opinion=true' >
			نام &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <input type='text' name='name'  id='commentinput' /><br />
			ایمیل &nbsp;&nbsp;<input type='text' name='email' id='commentinput' class='email' /><br />
			 وب &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='url'  id='commentinput' /><br />
			<textarea name='content' id='commenttextarea' class='reqd' ></textarea><br />
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
	$menu_active = "?part=product";

////////////ارسال های محتوای صفحه ////////////////////////////////////////////////////////			

			$gcms->assign('page_title',$page_title); 
			$gcms->assign('page_author',$page_author); 
			$gcms->assign('page_date',$page_date); 
			$gcms->assign('page_content',$page_content); 
			$gcms->assign('page_excerpt',$page_excerpt); 
			$gcms->assign('commentform',$commentform); 
			$gcms->assign('page_pic',$page_pic); 
			$gcms->assign('form_id',$form_id); 
			$gcms->assign('product_pprice',$page_pprice); 
			$gcms->assign('product_rpprice',$page_rpprice); 
			$gcms->assign('product_expprice',$page_expprice); 
			
			$gcms->assign('product_group',$product_group); 
			$gcms->assign('product_groupid',$product_groupid); 

			$gcms->assign('addto_basket',$addto_basket); 
			$gcms->assign('finalprice',$pprice); 
			$gcms->assign('currency',$configset[currency]); 

/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',$menu_active); 
			$gcms->assign('part',"product"); 
			$gcms->assign('page_title',"فروشگاه"); 
			$gcms->display("index/index.tpl");
}else {
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>
	";

}


	
	

?>