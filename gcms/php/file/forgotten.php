<?php
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
//
function f_forgotten(){
	
	global $error_message,$success_message,$forgotten_content;
		$trkh = date("Y/m/d");
$form_forgotten = "
	لطفا زبان  سیستم خود را روی EN (انگلیسی) نگه دارید
 و دکمه کنار جعبه های ورود متن را به صورت FA نگاه دارید، در این صورت متن های وارد شده به صورت فارسی وارد می شوند.

<form action='?part=forgotten&forgotten=step2' method='post'  onsubmit='return ValidateRegistration(this);' name='signup' >
<table id='hor-minimalist-a-1' >
<tbody>
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
		<input type='submit' value='ارسال' onMouseDown='initForms()'  >
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
	
	$forgotten_content = "$form_forgotten";
	
}
		
		switch ($_GET['forgotten']){
	
			case "step1":
				f_forgotten();
				$gcms->assign('page_title',"فراموش کردن کلمه عبور"); 
				$gcms->assign('forgotten_content',"$forgotten_content"); 
			break;
		
			case "step2":
				if ($_REQUEST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
				$error_message = "
				کد امنیتی اشتباه وارد شده. <br>
				";
				f_forgotten();
				$gcms->assign('page_title',"فراموش کردن کلممه عبور"); 
				$gcms->assign('forgotten_content',"$forgotten_content"); 
				} else { 

	if (  $_REQUEST['melicode'] and $_REQUEST['email']){
		
		$_REQUEST[melicode] = addslashes($_REQUEST[melicode]);
		$_REQUEST[email] = addslashes($_REQUEST[email]);

		
		$chkcode =  mysql_fetch_array(mysql_query(" SELECT id,email FROM `gcms_login` WHERE `melicode` = '$_REQUEST[melicode]' or `email` = '$_REQUEST[email]'  ",$link));


		if ($chkcode['id'] ){
		//
function generatePassword($length=8,$level=2){

   list($usec, $sec) = explode(' ', microtime());
   srand((float) $sec + ((float) $usec * 100000));

   $validchars[1] = "0123456789abcdfghjkmnpqrstvwxyz";
   $validchars[2] = "0123456789abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $validchars[3] = "0123456789_!@#$%&*()-=+/abcdfghjkmnpqrstvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ_!@#$%&*()-=+/";

   $password  = "";
   $counter   = 0;

   while ($counter < $length) {
     $actChar = substr($validchars[$level], rand(0, strlen($validchars[$level])-1), 1);

     // All character must be different
     if (!strstr($password, $actChar)) {
        $password .= $actChar;
        $counter++;
     }
   }

   return $password;

}		
		$newpass = generatePassword($length=6,$level=2);
		$newpass_hash = crypt($newpass);
		$up_sql = "
		UPDATE `gcms_login` SET `pass` = '$newpass_hash' WHERE `gcms_login`.`id` = '$chkcode[0]'  LIMIT 1 ;
		";

		if ( mysql_query($up_sql,$link) ){
////////////////////////////////////////////////////////////////////////////////////////////////////
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
$subject = "تغییر کلمه عبور" .  $configset[site_address];
$text = "	
		  <p>کلمه عبور شما با موفقیت تغییر یافت :</p>
		  <table>
			<tr>
			  <td align=center dir=rtl  > کلمه عبور جدید  : $newpass </td>
			</tr>
		  </table>
		  <p>$configset[site_address]</p>
";
sendmail($chkcode[1],$configset[email],$text,$subject,$messmail);
////////////////////////////////////////////////////////////////////////////////////////////////////

		$success_message = "کلمه عبور جدید به آدرس ایمیل شما ارسال شد . <br>

		<center>
		<img src='/gcms/images/load.gif' width='60' height='80' >
		</center>
		<script language=\"JavaScript\">setTimeout(\"top.location.href = '?part=page&id=1'\",20000);</script>
		 ";
		}else{
		$error_message = "مشکل در انجام تغییرات لطفا دوباره سعی کنید . ";
		f_forgotten();
		}

		}else{
		$error_message = "آدرس ایمیل و یا کد ملی اشتباه است";
		f_forgotten();
		
		}
	}
				$gcms->assign('page_title',"فراموش کردن کلمه عبور"); 
				$gcms->assign('forgotten_content',"$forgotten_content"); 
	
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
			$gcms->assign('part',"forgotten"); 
			$gcms->display("index/index.tpl");
	
?>