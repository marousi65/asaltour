<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
//
function f_newsignup(){
	
	global $error_message,$success_message,$signup_content;
		$trkh = date("Y/m/d");
$form_new_signup = "
	لطفا زبان  سیستم خود را روی EN (انگلیسی) نگه دارید
 و دکمه کنار جعبه های ورود متن را به صورت FA نگاه دارید، در این صورت متن های وارد شده به صورت فارسی وارد می شوند.

<form action='?part=signup&signup=step2' method='post'  onsubmit='return ValidateRegistration(this);' name='signup' >
<table id='hor-minimalist-a-1' >
<tbody>
	<tr>
		<td>
		نام
		</td>
		<td>
		<input type='text' name='fname' value='$_REQUEST[fname]'  class='reqd'  lang='fa' />
		</td>
	</tr>
	<tr>
		<td>
		نام خانوادگی
		</td>
		<td>
		<input type='text' name='lname' value='$_REQUEST[lname]'  class='reqd'  lang='fa' />
		</td>
	</tr>
	<tr>
		<td>
		کد ملی
		</td>
		<td>
		<input type='text' name='melicode' value='$_REQUEST[melicode]'  class='reqd' onKeyUp='javascript:checkNumber(signup.melicode);' />
		<div id='melicode-status'></div>
		</td>
	</tr>
	<tr>
		<td>
		ایمیل
		</td>
		<td>
		<input type='text' name='email' value='$_REQUEST[email]'  class='email' />
		</td>
	</tr>
	<tr>
		<td>
		رمز عبور
		</td>
		<td>
		<input type='password' name='pass'   class='reqd' />
		</td>
	</tr>
	<tr>
		<td>
		آدرس
		</td>
		<td>
		<textarea name='address'  class='reqd'   lang='fa'  >$_REQUEST[address]</textarea>
		</td>
	</tr>
	<tr>
		<td>
		تلفن
		</td>
		<td>
		<input type='text' name='tell' value='$_REQUEST[tell]' onKeyUp='javascript:checkNumber(signup.tell);'  />
		<div id='tell-status'></div>
		</td>
	</tr>
	<tr>
		<td>
		موبایل
		</td>
		<td>
		<input type='text' name='cell' value='$_REQUEST[cell]' onKeyUp='javascript:checkNumber(signup.cell);'   />
		<div id='cell-status'></div>
		</td>
	</tr>
	<tr>
		<td>
		تاریخ عضویت 
		</td>
		<td>
		$trkh
		</td>
	</tr>
	<tr>
		<td>
		کد امنیتی
		</td>
		<td>
		<input type='text' name='vercode'  class='reqd' />
		<div id='vercode-status'></div>
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<img src='/gcms/php/file/captcha.php' align='absmiddle'>
		</td>
	</tr>
	<tr>
		<td>
		
		</td>
		<td>
		<input type='submit' value='ایجاد' onMouseDown='initForms()'  >
		</td>
	</tr>
</tbody>
</table>
</form>




<script type='text/javascript'>


fieldlimiter.setup({
	thefield: document.signup.melicode,
	maxlength: 10,
	statusids: ['melicode-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.tell,
	maxlength: 20,
	statusids: ['tell-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.cell,
	maxlength: 11,
	statusids: ['cell-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.vercode,
	maxlength: 5,
	statusids: ['vercode-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

</script>






";
	
	$signup_content = "$form_new_signup";
	
}
		
		switch ($_GET['signup']){
	
			case "step1":
				f_newsignup();
				$gcms->assign('page_title',"ثبت نام کاربر جدید"); 
				$gcms->assign('signup_content',"$signup_content"); 
			break;
		
			case "step2":
				if ($_REQUEST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
				$error_message = "
				کد امنیتی اشتباه وارد شده. <br>
				";
				f_newsignup();
				$gcms->assign('page_title',"ثبت نام کاربر جدید"); 
				$gcms->assign('signup_content',"$signup_content"); 
				} else { 
		$trkh = date("Y/m/d");
	if ( $_REQUEST['fname'] and $_REQUEST['lname'] and $_REQUEST['melicode'] and $_REQUEST['email'] and $_REQUEST['pass']){
		
		$chkcode =  mysql_fetch_array(mysql_query(" SELECT id FROM `gcms_login` WHERE `melicode` = '$_REQUEST[melicode]' or `email` = '$_REQUEST[email]'  ",$link));


		if ($chkcode['id'] ){
		$error_message = "تکرار در کد ملی و یا ایمیل کاربر  و یا مشکل در آدرس ایمیل";
		f_newsignup();
		}else{

		$_REQUEST[fname] = addslashes($_REQUEST[fname]);
		$_REQUEST[lname] = addslashes($_REQUEST[lname]);
		$_REQUEST[melicode] = addslashes($_REQUEST[melicode]);
		$_REQUEST[email] = addslashes($_REQUEST[email]);
		$_REQUEST[address] = addslashes($_REQUEST[address]);
		$_REQUEST[tell] = addslashes($_REQUEST[tell]);
		$_REQUEST[cell] = addslashes($_REQUEST[cell]);
		
		$password = crypt($_REQUEST[pass]);
		$add_sql = "
		INSERT INTO `gcms_login` (
		`fname`,
		`lname`,
		`melicode`,
		`email`,
		`pass`,
		`address`,
		`tell`,
		`cell`,
		`type`,
		`active`,
		`regdate`
		)
		VALUES (
		'$_REQUEST[fname]',
		'$_REQUEST[lname]',
		'$_REQUEST[melicode]',
		'$_REQUEST[email]',
		'$password',
		'$_REQUEST[address]',
		'$_REQUEST[tell]',
		'$_REQUEST[cell]',
		'free',
		'true',
		'$trkh'
		)
		";

		if ( mysql_query($add_sql,$link) ){

		$success_message = "کاربر گرامی ، اطلاعات زیر در سیستم ثبت شد. <br>
		نام : $_REQUEST[fname] <br>
		نام خانوادگی : $_REQUEST[lname] <br>
		کدملی : $_REQUEST[melicode] <br>
		ایمیل : $_REQUEST[email] <br>
		کلمه عبور : $_REQUEST[pass] <br>
		آدرس : $_REQUEST[address] <br>
		تلفن : $_REQUEST[tell] <br>
		موبایل : $_REQUEST[cell] <br>
		تاریخ ایجاد : $trkh <br>
		<center>
		<img src='/gcms/images/load.gif' width='60' height='80' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=page&id=1'\",20000);</script>
		 ";
		 
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
		$subject = "Asaltour.ir | new user " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 کاربر گرامی   $_REQUEST[fname] $_REQUEST[lname] <br />

به اولین سیستم رزرواسیون بلیط کشتی مسافربری و لندیگرافت خوش آمدید.شما میتوانید با مشخصات زیر وارد سامانه شوید و جهت مشتریان خود بلیط صادر فرمائید. <br />
نام کاربری : $_REQUEST[email] <br />
کلمه عبور :  $_REQUEST[pass] <br />
خواهشمندیم جهت آشنایی بهتر با سیستم رزرواسیون با مراجعه به آدرس های زیر آموزش های لازم را جهت فعالیت در سامانه مشاهده فرمائید.<br />
<a href='http://asaltour.ir/?part=page&id=27' > آموزش رزرو بلیط کشتی </a> | 
<a href='http://asaltour.ir/?part=page&id=28' >آموزش رزرو بلیط آنلاین</a> |  
<a href='http://asaltour.ir/?part=page&id=17' > قوانین  سایت </a> | 
<a href='http://asaltour.ir/' > ورود به سایت </a> |
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$_REQUEST[email]" ,"support@asaltour.ir",$text,$subject,$messmail);
		 //$_REQUEST[email]
		 
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		f_newsignup();
		}
		
		}
	}
				$gcms->assign('page_title',"ثبت نام کاربر جدید"); 
				$gcms->assign('signup_content',"$signup_content"); 
	
				}
			break;
	
			default:
			echo "<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=signup&signup=step1'\",1);</script>";
		}
	
	
			mysql_close($link);
/////////////////////////////////////////////////////////////////////////////////////////			
			$gcms->assign('error_message', $error_message ); 
			$gcms->assign('success_message', $success_message ); 

			$gcms->assign('menu_active',"?part=signup"); 
			$gcms->assign('part',"signup"); 
			$gcms->display("index/index.tpl");
	
?>