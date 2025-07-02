<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

function search_result($search,$text){
		$text = strip_tags($text);
		$temp = explode($search,$text,2);
		$templen = strlen($temp[0]);
		if ($templen > 150) {$templen = $templen - 50;}
		$temp[0] = substr($temp[0],$templen);
		////
		$temp[0] = substr($temp[0],strpos($temp[0]," "));
		////
		$temp[0] = " ... " . $temp[0];
		$temp[1] = substr($temp[1],0,250);
		////
		$temp[1] = substr($temp[1],0,strrpos($temp[1]," "));
		////
		$temp[1] = $temp[1] . " ... ";
		$final = $temp[0] . "<span style='color:red;background-color:yellow' class='search_result'>" . $search . "</span>" . $temp[1];
	return $final;	
	
	}

if ( $_REQUEST[search] == "page" and $_REQUEST['inputsearch']  ){

	//security////////////////////////
	$sec20time = time()-10;
	if ( $_SESSION['searchformtime'] > $sec20time){
		if ($_SESSION["hacker"] == "searchformtime" and $_SESSION['countersearchform'] > 3 ){
		mysql_query("INSERT INTO `gcms_blocked` ( `ip` ) VALUES ('$_SERVER[REMOTE_ADDR]')",$link);
		}
		$_SESSION['hacker'] = "searchformtime"  ;
	if ( $_SESSION['countersearchform']  >= 1 ) { ++$_SESSION['countersearchform']; }else { $_SESSION['countersearchform']= 1; }
		sleep(8);
		 }else{ $_SESSION['searchformtime'] =  time();}
	
	//security\\\\\\\\\\\\\\\\\\\\\\\
	
	$redsearch = htmlspecialchars("$_REQUEST[inputsearch]", ENT_QUOTES);
	$search = ereg_replace(" ","%",$_REQUEST['inputsearch']);
	
	if ( $_REQUEST[option] == 'page_title' ) {
	$sqlstr = " page_title LIKE  '%$search%' ";
	}
	else  {
	$sqlstr = " page_content LIKE  '%$search%' OR  page_title LIKE  '%$search%'  ";
	}
	
		
	// تعریف کوئری   
		$querysp = "SELECT * FROM `gcms_pages` WHERE  $sqlstr ";
	// نتایج کوئری
		$resultsp = mysql_query($querysp,$link);
	// دریافت نتایج در سطر	
	
				while($rowsp = mysql_fetch_array($resultsp)){
				
				$set = search_result($redsearch,$rset);
				if ( $_REQUEST[option] == 'page_title' ) {
				$rowsp[page_title] =search_result($redsearch,$rowsp[page_title]);
				}
				else{
				$rowsp[page_content] =search_result($redsearch,$rowsp[page_content]);
				}
				
	
				$is++;
				$searchresult = $searchresult ."$is -  <b><a href='?part=pages&id=$rowsp[id]' >$rowsp[page_title] </a> </b> <br> 
				$rowsp[page_content] <br> 
				";
				}
				
				if (!$searchresult){
					$searchresult = "هیچ نتیجه ای برای جستجوی <b>$redsearch</b> در میان صفحات پیدا نشد. $rowsp";
				}
				
			}else{
					$message = " هیچ اطلاعاتی ارسال نکرده اید. " ;
			}

/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('searchresult',$searchresult); 
			$gcms->assign('message',$message); 


/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',"?part=search"); 
			$gcms->assign('part',"search"); 
			
			$gcms->display("index/index.tpl");
	
	

?>