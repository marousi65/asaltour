<?php
if ($pluginsetup[gallery]){
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

if ( !$_GET[gallery] ){
		///////// list of gallery
		
		////find gallery
		
			$query_group = "SELECT  term_id,term_name FROM `gcms_term` WHERE term_tax='gallery'   ";

		//نتایج
			$result_group = mysql_query($query_group,$link);
		//سطر ها
			$ing = 0;
			while ($row_group = mysql_fetch_array($result_group)){
			
				$gallery_groupname[$ing]    = $row_group['term_name'];
				$gallery_groupurl[$ing]     = "?part=gallery&gallery=".$row_group['term_id'];
				
				// get rand pic from gallery
				$q_frp = "SELECT gallery_id,source FROM gcms_gallery JOIN gcms_relationships_gallery_term ON gcms_relationships_gallery_term.gallery_id = gcms_gallery.id WHERE gcms_relationships_gallery_term.term_id = $row_group[term_id] AND status = 'publish' ORDER BY RAND() LIMIT 0 , 1";
				
				$r_frp = mysql_fetch_array(mysql_query($q_frp,$link));
				$gallery_rndpicurl[$ing] = $r_frp['source'];
				
				$ing++;
			}
			
////////////ارسال های گروه ها ////////////////////////////////////////////////////////			
			$gcms->assign('gallery_groupname',$gallery_groupname); 
			$gcms->assign('gallery_groupurl',$gallery_groupurl); 
			$gcms->assign('gallery_rndpicurl',$gallery_rndpicurl); 
		
		//\\\end find group
		

	}else{
	
	if ( $_GET[id] ){
	
		// تعریف کوئری
			$query_pic = "SELECT *  FROM `gcms_gallery` JOIN gcms_relationships_gallery_term ON gcms_relationships_gallery_term.gallery_id = gcms_gallery.id JOIN gcms_term ON gcms_term.term_id = gcms_relationships_gallery_term.term_id WHERE gcms_gallery.id='$_GET[id]' AND status = 'publish' ";
		// نتایج کوئری
			$result_pic = mysql_query($query_pic,$link);
				if (!$result_pic){
	echo "
		<script>
		window.location='?part=gallery';
		</script>
	";
	}
		// دریافت نتایج در سطر	
			$row_pic = mysql_fetch_array($result_pic) ;

	if (!$row_pic){
	echo "
		<script>
		window.location='?part=gallery&gallery=$_GET[gallery]';
		</script>	";
	}

	//////////////////////////////////////////////////////////////////////////////////////
		$pic_name   = $row_pic['pic_name'];
		$pic_source   = $row_pic['source'];
		$pic_discription   = $row_pic['discription'];
		$pic_size   = $row_pic['size'];
		$pic_keyword   = $row_pic['keyword'];
		$term_name  = $row_pic['term_name'];
		$pic_gallery_url   = "?part=gallery&gallery=".$row_pic['term_id'];
		
		
	//////////////////////////////////////////////////////////////////////////////////////
			$gcms->assign('pic_name',$pic_name); 
			$gcms->assign('pic_source',$pic_source); 
			$gcms->assign('pic_discription',$pic_discription); 
			$gcms->assign('pic_size',$pic_size); 
			$gcms->assign('pic_keyword',$pic_keyword); 
			
			$gcms->assign('term_name',$term_name); 
			$gcms->assign('pic_gallery_url',$pic_gallery_url); 
			
			
	
	}else{
	
	$query_list = " FROM `gcms_gallery` JOIN gcms_relationships_gallery_term ON gcms_relationships_gallery_term.gallery_id = gcms_gallery.id WHERE term_id=$_REQUEST[gallery] AND status = 'publish'   ";
	
	$termlink = "&gallery=$_REQUEST[gallery]";
	//////////////////////////////////////////////////////////////////////////////////////
	//شمارنده صفحه ها
	if(!isset($_GET['page'])){$page = 1;} else { 
    $page = $_GET['page'];
	 } 
	//تعدادی که در صفحه از دیتا بیس می خواند
	$max_results = $configset[gallerynum];
	$from = (($page * $max_results) - $max_results); 
	//تعداد موجودی کل
	$tt = mysql_query("SELECT COUNT(*) as Num $query_list ");
	if (!$tt){
	echo "
		<script>
		window.location='?part=gallery';
		</script>	";
	}
	$total_results = mysql_result($tt,0); 
	//تعداد صفحات
	$total_pages = ceil($total_results / $max_results); 
	$pagelink = "?part=gallery".$termlink;
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
		
		// تعریف کوئری
			$query_list = "SELECT *  ".$query_list." LIMIT $from, $max_results";
		// نتایج کوئری
			$result_list = mysql_query($query_list,$link);
		// دریافت نتایج در سطر	

			$i = 0;
			while($row_list = mysql_fetch_array($result_list)){
			
				$list_gallery_id[$i]    = $row_list['id'];
				$list_gallery_picname[$i]    = $row_list['pic_name'];
				$list_gallery_source[$i]    = $row_list['source'];
				$list_gallery_discription[$i]    = $row_list['discription'];
				$list_gallery_size[$i]    = $row_list['size'];
				$list_gallery_url[$i]      = "?part=gallery&gallery=$_REQUEST[gallery]&id=".$row_list['id'];

			$i++;
			}
			
				// get gall name
				$q_ggn = "SELECT term_name FROM gcms_term  WHERE term_id = $_REQUEST[gallery]  LIMIT 0 , 1";
				
				$r_ggn = mysql_fetch_array(mysql_query($q_ggn,$link));
				$gallery_ggnane = $r_ggn['term_name'];
				$gcms->assign('gallery_ggnane',$gallery_ggnane); 
	}
	
////////////ارسال های لیست ////////////////////////////////////////////////////////			
			$gcms->assign('list_gallery_id',$list_gallery_id); 
			$gcms->assign('list_gallery_url',$list_gallery_url); 
			$gcms->assign('list_gallery_picname',$list_gallery_picname); 
			$gcms->assign('list_gallery_source',$list_gallery_source); 
			$gcms->assign('list_gallery_discription',$list_gallery_discription); 
			$gcms->assign('list_gallery_size',$list_gallery_size); 


	}
//تعریف منوی فعال
	$menu_active = "?part=gallery";
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',$menu_active); 
			$gcms->assign('part',"gallery"); 
			$gcms->assign('page_title',"گالری عکس"); 
			
			$gcms->display("index/index.tpl");
}else {
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>
	";

}

	

?>