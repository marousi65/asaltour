<meta http-equiv="content-type" content="text/html;charset=utf-8"  >
<?php

//تابع ویرایش

function  displaylink($errmes){


	
echo "

<div id='head' >
<div id='mainbody' >
<div class='leftbody' >";
if ($errmes){
echo"
<div id='err-mess' >
$errmes
</div>
";
}
echo "<div id='mytb' >
<h2>
RSS2
</h2>
<div id='bckfile' >
<a href='/gcms/rss2-pages.php' target='_blank' >
لینک فید مطالب سایت RSS2 ( صفحات )
</a>
<br>
<a href='/gcms/rss2-news.php'  target='_blank'>
لینک فید اخبار سایت
</a>
</div>
<div id='dwbckdsh'></div>
</div>
<div id='leftsidb' >
	<div id='leftsidup' >
		<div id='leftsiduptxt' >
تنظیمات RSS
		</div>
	</div>
<div id='leftsidmid' >
	<div id='leftsidmidtxt'>
این قسمت هنوز تکمیل نشده است
	</div>
</div>
	<div id='leftsiddown' >
		<div id='leftsiddowntxt'>

		</div>
	</div>


</div>

</div>


";
}



?>