<?php

require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	if ($_REQUEST[poll] AND $_REQUEST[submitbtt] AND $_REQUEST[poll_answer_id]){
		
		
		$polldate = time();
		$ip = $_SERVER['REMOTE_ADDR'] ;

		// تعریف کوئری برای پیدا کردن آی پی
			$query_ip = "SELECT id FROM `gcms_poll_ip` WHERE ip = '$ip' AND question_id = '$_REQUEST[poll]' ";
		// دریافت نتایج در سطر	
			$row_ip = mysql_fetch_array(mysql_query($query_ip,$link));

			if ( !$row_ip[0] ){
			//کوئری اضافه کردن به جدول 
			$que_add = "INSERT INTO `gcms_poll_ip` ( `date` ,`question_id` ,`answer_id` ,`ip` ) 
			VALUES ('$polldate' ,'$_REQUEST[poll]' ,'$_REQUEST[poll_answer_id]' ,'$ip' )";
			//انجام کوئری
			
				if ( mysql_query($que_add,$link) ){
				$pollmessage = "نظر شما با موفقیت به ثبت رسید " . $comes;
				}else{
				// در صورت برخورد با مشکل
				$pollmessage  = "مشکل در ثبت نظر شما لطفا دوباره تلاش کنید";
				}
			}else{
				$pollmessage  = "شما یک بار در این نظرسنجی شرکت کرده اید.";
				}
////////////ارسال های پیام  ////////////////////////////////////////////////////////			
			$gcms->assign('pollmessage',$pollmessage); 
		
	}

if (!$_REQUEST[id]){
	
	$_REQUEST[id] = $configset[first_page];
	
	}

// پیدا کردن محتوای صفحه نظر سنجی///////////////////////////////////

//تعریف منوی فعال
	$menu_active = "?part=poll";

///////////////////////////////////////////////////////////

//کوئری
	$query_poll = "SELECT * FROM `gcms_poll_question` WHERE poll_status ='publish' ";
//نتایج
	$result_poll = mysql_query($query_poll,$link);
//سطر ها
	$row_poll = mysql_fetch_array($result_poll);
	
		$poll_id        = $row_poll['poll_question_id'];
		$poll_question  = $row_poll['poll_question'];
		
		$poll_form = "<form  method='post' action='?part=poll&poll=$poll_id'>
		<b> $row_poll[poll_question] </b><br>";
			
		// تعریف کوئری برای لیست 
			$query_answer = "SELECT * FROM `gcms_poll_answer` WHERE poll_question_id = '$poll_id' ";
		// نتایج کوئری
			$result_answer = mysql_query($query_answer,$link);
		// دریافت نتایج در سطر	
		
		$poll_statistics_horizontal = "<b>نتایج نظر سنجی </b><br>";
		$poll_statistics_vertical = "<div style=' height: 200px;' ><b>نتایج نظر سنجی</b> <br>";
		while($row_answer = mysql_fetch_array($result_answer)){
		
		$poll_form = $poll_form . "<input type='radio' name='poll_answer_id'  value='$row_answer[poll_answer_id]' id='radiopoll'  /> $row_answer[poll_answer] <br> ";
		
		// تعریف کوئری برای آمار
			$query_statistics = "SELECT COUNT(*) FROM `gcms_poll_ip` WHERE question_id = '$poll_id' AND answer_id ='$row_answer[poll_answer_id]' ";
		// دریافت نتایج در سطر	
			$row_statistics = mysql_fetch_array(mysql_query($query_statistics,$link));
		
		// تعریف کوئری برای آمار کل
			$query_statistics_total = "SELECT COUNT(*) FROM `gcms_poll_ip` WHERE question_id = '$poll_id' ";
		// دریافت نتایج در سطر	
			$row_statistics_total = mysql_fetch_array(mysql_query($query_statistics_total,$link));
		// محاسبه درصد
		if ($row_statistics_total[0] != 0){
			$statistics_percent = $english_format_number = number_format(($row_statistics[0]/$row_statistics_total[0] *100), 0, '.', '') ;
				}
				if ($statistics_percent == "100" ){$statistics_percenttable="95";}
			$poll_statistics_horizontal = $poll_statistics_horizontal . "$row_answer[poll_answer] <div style='float:right; width:$statistics_percenttable% ; height:20px ; background:#6699CC' > $statistics_percent% </div>  $row_statistics[0] رای <br><div style='clear:both;' ></div>";
			
			$poll_statistics_vertical = $poll_statistics_vertical . "<div style='float:right; width:60px ; margin-right:10px; ' > $row_answer[poll_answer] : $row_statistics[0] رای</div><div style='float:right; width:25px ; margin-right:20px; height:$statistics_percent% ; background: #6699CC; #top: -50%;' >$statistics_percent%</div>
 ";
		}
			$poll_statistics_vertical = $poll_statistics_vertical . "</div> ";
		
		$poll_form = $poll_form . "  <input type='submit' value='ارسال نظر' name='submitbtt' id = 'pollsubmit' /> </form>";

////////////  ارسال فرم نظرسنجی و آمار های مربوطه /////////////////////////////////			
		
			$gcms->assign('poll_form',$poll_form); 
			$gcms->assign('poll_statistics_horizontal',$poll_statistics_horizontal); 
			$gcms->assign('poll_statistics_vertical',$poll_statistics_vertical); 
			
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('menu_active',$menu_active); 
			$gcms->assign('part',"poll"); 
			
	
	

?>	
	
