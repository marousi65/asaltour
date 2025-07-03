<?php

//
function f_buy_psn_stage1(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;
	
			//
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			//
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
			$t_roz = jdate2("y-m-d" , strtotime(' -1 day') );
			$q_s = "
			SELECT *
			FROM `gcms_psngrtrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_psngrtrade`.`id` = '$id_pt' AND `gcms_psngrtrade`.`date` >  '$t_roz'
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			//
			$selctnum[$_REQUEST[num]] = " selected='selected' ";
			
			//
			$jam_fee = $row_s[fee]*$_REQUEST[num] + $row_s[fee];
            $jam_feebdon = $row_s[fee]*$_REQUEST[num] + $row_s[fee];
			$jam_fee = number_format($jam_fee);
			$row_s[fee] = number_format($row_s[fee]);
			$row_s[charter_fee] =  number_format($row_s[charter_fee]);
			//
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
				$trtd_hmrh = $trtd_hmrh."
				<tr>
					<td >
					<div  style='width:185px; float:right'>نام همراه <input type='text' name='hm_fname$i'  id='inphmrh' class='reqd'  lang='fa' /></div>
					<div  style='width:225px; float:right'>نام خانوادگی همراه <input type='text' name='hm_lname$i' id='inphmrh' class='reqd' lang='fa' /> </div>
					<div style='width:220px; float:right'>کد ملی همراه <input type='text' name='hm_mcode$i' id='inphmr' class='reqd' onKeyUp='javascript:checkNumber(signup.hm_mcode$i);' />
		<div id='hm_mcode$i-status'></div>
		</div>
					</td>
				</tr>
				";
			}
			//
			if ($_SESSION['g_customer_id_buy']){
			$q_old = "
			SELECT fname,lname,mcode,state,city,address,pcode,tell,cell 
			FROM `$_SESSION[g_customer_type_buy]`
			WHERE `id` = '$_SESSION[g_customer_id_buy]' 
			LIMIT 0 , 1
			 ";
			$row_old = mysql_fetch_array( mysql_query($q_old,$link));
			$_REQUEST[fname] = $row_old[fname];
			$_REQUEST[lname] = $row_old[lname];
			$_REQUEST[mcode] = $row_old[mcode];
			$_REQUEST[state] = $row_old[state];
			$_REQUEST[city] = $row_old[city];
			$_REQUEST[address] = $row_old[address];
			$_REQUEST[pcode] = $row_old[pcode];
			$_REQUEST[tell] = $row_old[tell];
			$_REQUEST[cell] = $row_old[cell];
			}
			//
			if ($_REQUEST[charter] == "true" )
			{
			$charterlink ="
			قیمت بلیط چارتر : $row_s[charter_fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $row_s[charter_fee]	 ریال</b>
			</center>
			<form action='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=$_REQUEST[num]&stage=2&charter=true' method='post' name='signup' >
			<div class='clear' ></div>
			<div style='float:left; overflow:auto; width:350px; margin-top:20px; height:450px;' >
			<b>نام کشتی : </b> $row_s[ship_name]  <br>
			<b>مدت زمان سفر : </b> $row_s[time] دقیقه <br>
			<b>سرعت کشتی : </b> $row_s[speed] مایل دریایی <br>
			
			";
			}else{
			$charternum ="
			تعداد همراه :
			<select name=\"menu1\" onchange=\"MM_jumpMenu('parent',this,0)\" id='slthamrh'>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=0&stage=1' $selctnum[0] >0</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=1&stage=1' $selctnum[1] >1</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=2&stage=1' $selctnum[2] >2</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=3&stage=1' $selctnum[3] >3</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=4&stage=1' $selctnum[4] >4</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=5&stage=1' $selctnum[5] >5</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=6&stage=1' $selctnum[6] >6</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=7&stage=1' $selctnum[7] >7</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=8&stage=1' $selctnum[8] >8</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=9&stage=1' $selctnum[9] >9</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=10&stage=1' $selctnum[10] >10</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=11&stage=1' $selctnum[11] >11</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=12&stage=1' $selctnum[12] >12</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=13&stage=1' $selctnum[13] >13</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=14&stage=1' $selctnum[14] >14</option>
			<option value='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=15&stage=1' $selctnum[15] >15</option>
			</select>
			نفر
			";
			$sql_ch_f = "
			
			";
			$charterlink ="
			قیمت بلیط : $row_s[fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $jam_fee ریال</b> <br />
            در صورت کنسلی بلیط مبلغ
            ". number_format($jam_feebdon-($row_s['darsad_cancel']*$jam_feebdon/100)) ." ريال
            به اعتبار شما واریز می گردد.  
			</center>
			<form action='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=$_REQUEST[num]&stage=2' method='post' name='signup' >
			<div class='clear' ></div>
			<div style='float:left; overflow:auto; width:350px; margin-top:20px; height:450px;' >
			<b>نام کشتی : </b> $row_s[ship_name]  <br>
			<b>مدت زمان سفر : </b> $row_s[time] دقیقه <br>
			<b>سرعت کشتی : </b> $row_s[speed] مایل دریایی <br>
			
			";
				if ( $row_s[8] == $row_s[7]){
				$charterlink = $charterlink . "
			<b>قیمت بلیط چارتر : </b> $row_s[charter_fee] ریال  
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=0&stage=1&charter=true' >خرید بلیط چارتر</a> <br>
				";
				}
			}
			//
			$form_buy_psn_stage1 = "
			<center>
			$charternum
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مبدا : $row_s[23] 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مقصد : $row_s[25]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			تاریخ حرکت: $row_s[date]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			ساعت حرکت : $row_s[hour]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<br>
			$charterlink
			<b>اطلاعات کشتی : </b><br> $row_s[ship_info]  <br>



			</div>
			<div style='float:right' >
			<table id='hor-minimalist-a-1' >
				<tbody>
				<tr>
					<td>
					نام مسافر 
					</td>
					<td>
					<input type='text' name='fname' value='$_REQUEST[fname]' class='reqd'  lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					نام خانوادگی
					</td>
					<td>
					<input type='text' name='lname' value='$_REQUEST[lname]' class='reqd'  lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					کد ملی
					</td>
					<td>
					<input type='text' name='mcode' value='$_REQUEST[mcode]' class='reqd' onKeyUp='javascript:checkNumber(signup.mcode);' />
		<div id='melicode-status'></div>
					</td>
				</tr>
				<tr>
					<td>
					استان
					</td>
					<td>
					<input type='text' name='state' value='$_REQUEST[state]' class='reqd'  lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					شهرستان
					</td>
					<td>
					<input type='text' name='city' value='$_REQUEST[city]' class='reqd'  lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					آدرس
					</td>
					<td>
					<textarea name='address' class='reqd' lang='fa' >$_REQUEST[address]</textarea>
					</td>
				</tr>
				<tr>
					<td>
					کدپستی
					</td>
					<td>
					<input type='text' name='pcode' value='$_REQUEST[pcode]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					تلفن
					</td>
					<td>
					<input type='text' name='tell' value='$_REQUEST[tell]'  onKeyUp='javascript:checkNumber(signup.tell);'  />
		<div id='tell-status'></div>
					</td>
				</tr>
				<tr>
					<td>
					موبایل
					</td>
					<td>
					<input type='text' name='cell' value='$_REQUEST[cell]' class='reqd' onKeyUp='javascript:checkNumber(signup.cell);'   />
		<div id='cell-status'></div>
					</td>
				</tr>
				</tbody>
			</table>
			</div>
			<div class='clear' ></div>
					مشخصات همراهان
			<table id='hor-minimalist-a-3' >
				<tbody>
				$trtd_hmrh
				<tr>
					<td >
					کد امنیتی : <input type='text' name='vercode' id='inphmr' class='reqd' /><img src='/gcms/php/file/captcha.php' >
					<div id='vercode-status'></div>
					</td>
				</tr>
				</tbody>
			</table>
			<input type='submit' value='خرید بلیط' style='float:left;margin-left:100px;margin-bottom:30px; margin-top:20px' onMouseDown='initForms()' >
            	<input type='hidden' name='darsad_cancel' value='".$row_s['darsad_cancel'] . "'  />
            	<input type='hidden' name='cancel_fee' value='".$row_s['darsad_cancel']*$jam_feebdon/100 . "'  />
			</form>
			<script type='text/javascript'>


fieldlimiter.setup({
	thefield: document.signup.mcode,
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
	thefield: document.signup.hm_mcode1,
	maxlength: 10,
	statusids: ['hm_mcode1-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.hm_mcode2,
	maxlength: 10,
	statusids: ['hm_mcode2-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.hm_mcode3,
	maxlength: 10,
	statusids: ['hm_mcode3-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.hm_mcode4,
	maxlength: 10,
	statusids: ['hm_mcode4-status'], 
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
			//
			$buy_content = "$form_buy_psn_stage1";
			}

	
}

//
function f_buy_psn_stage2(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;

	
			//
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			//
			include $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
			$t_roz = jdate2("y-m-d" , strtotime(' -1 day'));
			$q_s = "
			SELECT *
			FROM `gcms_psngrtrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_psngrtrade`.`id` = '$id_pt' AND `gcms_psngrtrade`.`date` >  '$t_roz'
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			
			if ($row_s[free_capacity] < $_REQUEST[num] + 1){
			$error_message = "
			ظرفیت کمتر از درخواست 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{		
			//
			$jam_fee = $row_s[fee]*$_REQUEST[num] + $row_s[fee];
            $injajam_fee = $row_s[fee]*$_REQUEST[num] + $row_s[fee];
			$jam_fee = number_format($jam_fee);
			$row_s[fee] = number_format($row_s[fee]);
			
			//
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
			$hm_fname = "hm_fname".$i;
			$hm_lname = "hm_lname".$i;
			$hm_mcode = "hm_mcode".$i;
			$hm_info = $hm_info .
			"
			$i -  $_REQUEST[$hm_fname]   $_REQUEST[$hm_lname] با کد ملی  $_REQUEST[$hm_mcode]<br>
			";
			$hm_inp_hdn = $hm_inp_hdn."
			<input type='hidden' name='hm_fname$i' value='$_REQUEST[$hm_fname]'  />
			<input type='hidden' name='hm_lname$i' value='$_REQUEST[$hm_lname]'  />
			<input type='hidden' name='hm_mcode$i' value='$_REQUEST[$hm_mcode]'  />
			";
			}
			//
			if ($_REQUEST[charter] == "true" ){
			$add_char_1 = "&charter=true";
			$row_s[charter_fee] = number_format($row_s[charter_fee]);
			$add_char_3 = "
			قیمت بلیط : $row_s[charter_fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $row_s[charter_fee] ریال</b>
			";
			}else{
			$add_char_2 = "
			تعداد همراه :
			$_REQUEST[num]
			نفر
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			";
			$add_char_3 = "
			قیمت بلیط : $row_s[fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $jam_fee ریال</b>
			";
			}

			if ($_SESSION['g_t_login'] == "agency"){
			$form_valid = "<form action='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=$_REQUEST[num]&stage=agency$add_char_1' method='post' >";
			}else{
			$form_valid = "<form action='?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&num=$_REQUEST[num]&stage=3$add_char_1' method='post' >";
			}
			/////
			$fnd_ghann = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '17' ",$link));
			$fnd_ghann[page_content] = strip_tags($fnd_ghann[page_content]);
            
            $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
            if ($injajam_fee <= $row_get_amount[0])
            {
                $text_amount = "
                <input type='radio' value='online' name='shop'  > خرید آنلاین  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' checked='checked' value='amount' name='shop' > خرید با استفاده از اعتبار
                ";
                
            }else{
                $text_amount = "
                <input type='radio' checked='checked'  value='online' name='shop'> خرید آنلاین 
                ";
            }
            
			/////
			$form_buy_psn_stage2 = " 
			<a href='javascript: history.go(-1)' >برگشت</a><br>
			<center>
			$add_char_2
			مبدا : $row_s[22] 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مقصد : $row_s[24]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			تاریخ حرکت: $row_s[date]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			ساعت حرکت : $row_s[hour]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<br>
			$add_char_3
			</center>
			<b>نام مسافر</b> : $_REQUEST[fname] <br><br>
			<b>نام خانوادگی</b> : $_REQUEST[lname] <br><br>
			<b>کد ملی</b> : $_REQUEST[mcode] <br><br>
			<b>استان</b> : $_REQUEST[state] <br><br>
			<b>شهرستان</b> : $_REQUEST[city] <br><br>
			<b>آدرس</b> : $_REQUEST[address] <br><br>
			<b>کدپستی</b> : $_REQUEST[pcode] <br><br>
			<b>تلفن</b> : $_REQUEST[tell] <br><br>
			<b>موبایل</b> : $_REQUEST[cell] <br><br>
			<b>اطلاعات همراهان</b> : <br>
			$hm_info <br>
			$form_valid
			<input type='hidden' name='fname' value='$_REQUEST[fname]'  />
			<input type='hidden' name='lname' value='$_REQUEST[lname]'  />
			<input type='hidden' name='mcode' value='$_REQUEST[mcode]'  />
			<input type='hidden' name='state' value='$_REQUEST[state]'  />
			<input type='hidden' name='city' value='$_REQUEST[city]'  />
			<input type='hidden' name='address' value='$_REQUEST[address]'  />
			<input type='hidden' name='pcode' value='$_REQUEST[pcode]'  />
			<input type='hidden' name='tell' value='$_REQUEST[tell]'  />
			<input type='hidden' name='cell' value='$_REQUEST[cell]'  />
            <input type='hidden' name='darsad_cancel' value='$_REQUEST[darsad_cancel]'  />
            <input type='hidden' name='cancel_fee' value='$_REQUEST[cancel_fee]'  />
			$hm_inp_hdn <br />
            $text_amount <br />
			تایید اطلاعات &raquo;<input type='checkbox' onclick=\"if (this.checked){this.form.tr.disabled=0}else{this.form.tr.disabled=1}\">
			<input name='tr' type='submit' disabled='1' value='اطلاعات فوق مورد تایید می باشد و همچنین قوانین سایت را قبول دارم !' >
            
			</form>
			<br>
			<textarea name='roll' readonly='readonly' id='txarroll'  disabled='disabled' >$fnd_ghann[page_content]</textarea>
			<br>
			
			";
			//
			$buy_content = "$form_buy_psn_stage2";
			}
			}
			
	
}


//
function f_buy_psn_stage3(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;

	
			//
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			//
			$q_s = "
			SELECT *
			FROM `gcms_psngrtrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_psngrtrade`.`id` = '$id_pt' 
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			
			if ($row_s[free_capacity] < $_REQUEST[num] + 1){
			$error_message = "
			ظرفیت کمتر از درخواست 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{		
			//
			$jam_fee = $row_s[fee]*$_REQUEST[num] + $row_s[fee];
			//$jam_fee = number_format($jam_fee);
			//$row_s[fee] = number_format($row_s[fee]);
			
			
			$d_t = date("Y-n-j-G-i-s"); 
			//
			if ($_REQUEST[charter] == "true" ){
			
				if ($row_s[capacity] == $row_s[free_capacity] ){
				$jam_fee = $row_s[charter_fee];
				$fin_charter = "true"; 
				}else{
				die ("مشکل در خرید");
				}
			
			}else{
			
			$fin_charter = "false"; 
			}
			
			$add_sql = "
			INSERT INTO `gcms_buypsngrtrade` (
			`id_login` ,
			`id_psngrtrade` ,
			`fname` ,
			`lname` ,
			`mcode` ,
			`state` ,
			`city` ,
			`address` ,
			`pcode` ,
			`cell` ,
			`tell` ,
			`num` ,
			`fee` ,
			`type` ,
			`charter` ,
			`buy_time`,
            `darsad_cancel`,
            `cancel_fee`
			)
			VALUES (
			'$_SESSION[g_id_login]', 
			'$id_pt', 
			'$_REQUEST[fname]', 
			'$_REQUEST[lname]', 
			'$_REQUEST[mcode]', 
			'$_REQUEST[state]', 
			'$_REQUEST[city]', 
			'$_REQUEST[address]', 
			'$_REQUEST[pcode]', 
			'$_REQUEST[cell]', 
			'$_REQUEST[tell]', 
			'$_REQUEST[num]', 
			'$jam_fee', 
			'pending', 
			'$fin_charter', 
			'$d_t',
            '$_REQUEST[darsad_cancel]', 
            '$_REQUEST[cancel_fee]'
			)
		";
		$add_email_to = "
		<br><br>
		<table border=1  cellpadding=0 cellspacing=0 >
			<tr>
				<td width=100>
				<center><b>ردیف</b></center>
				</td>
				<td width=250>
				<center><b>نام مسافر</b></center>
				</td>
				<td width=100>
				<center><b>تعداد همراه</b></center>
				</td>
				<td width=200>
				<center><b>شماره ملی</b></center>
				</td>
			</tr>
			<tr>
				<td>
				<center>1</center>
				</td>
				<td>
				<center>$_REQUEST[fname] $_REQUEST[lname]</center>
				</td>
				<td>
				<center>$_REQUEST[num]</center>
				</td>
				<td>
				 <center>$_REQUEST[mcode]</center>
				</td>
			</tr>
			";
			if ($_REQUEST[charter] == "true" ){
			$up_cap = $row_s[capacity] ;
			}else{
			$up_cap = $row_s[free_capacity] -  ( $_REQUEST[num] + 1 ) ;
			}
			$up_qu_psngrtrade = "UPDATE `gcms_psngrtrade` SET `free_capacity` = '$up_cap' WHERE `gcms_psngrtrade`.`id` =$id_pt LIMIT 1 ;";
			


			if ( mysql_query($add_sql,$link)   ){
			//
			$_SESSION['rfrsh'] = $_REQUEST[psngrtrade] ;
			//
			$last_inserted_row = mysql_insert_id($link);
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
			$hm_fname = "hm_fname".$i;
			$hm_lname = "hm_lname".$i;
			$hm_mcode = "hm_mcode".$i;
			$add_qu_hm = "
			INSERT INTO `gcms_metabuy` (
			`id_buy` ,
			`type` ,
			`hm_fname` ,
			`hm_lname` ,
			`hm_mcode`
			)
			VALUES (
			'$last_inserted_row', 
			'psngrtrade', 
			'$_REQUEST[$hm_fname]', 
			'$_REQUEST[$hm_lname]', 
			'$_REQUEST[$hm_mcode]'
			)
			";
			mysql_query($add_qu_hm,$link);
			$k = $i+1;
			$add_email_to = $add_email_to . "
			<tr>
				<td>
				<center>$k</center>
				</td>
				<td>
				<center>$_REQUEST[$hm_fname] $_REQUEST[$hm_lname]</center>
				</td>
				<td>
				<center>*</center>
				</td>
				<td>
				<center> $_REQUEST[$hm_mcode] </center>
				</td>
			</tr>
			" ;
			}
			$nff = number_format($jam_fee);
			$add_email_to = $add_email_to . "
			</table>
			<br><br>
			جمع صورتحساب شما : $nff ریال <br>
			";
			//
			mysql_query($up_qu_psngrtrade,$link);
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
			//////////////////////////////////email
		$row_f_c_e = mysql_fetch_array(mysql_query("SELECT  ship_name ,free_capacity,id_login,date,hour,sailing.name,mabd.name , magh.name  FROM `gcms_psngrtrade` 
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id` 
		 WHERE `gcms_psngrtrade`.`id` = '$id_pt' LIMIT 0 , 1",$link)) ;
		if ( $row_f_c_e[1] == "0"){
		$row_f_sh_m = mysql_fetch_array(mysql_query("SELECT email,fname,lname  FROM `gcms_login` WHERE `id` = '$row_f_c_e[2]' LIMIT 0 , 1",$link)) ;
		$subject = " Full Capacity " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 مدیریت محترم    $row_f_sh_m[1]  $row_f_sh_m[2]  کشتیرانی $row_f_c_e[5]<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.شما میتوانید جهت تهیه لیست مسافرین اقدام نمائید
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_sh_m[0]" ,"support@asaltour.ir",$text,$subject,$messmail);
		//$row_f_sh_m[0]
		$row_f_m = mysql_fetch_array(mysql_query("SELECT email FROM `gcms_login` WHERE `type` = 'admin' LIMIT 0 , 1",$link)) ;
		$text2 = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
   مدیر کل محترم<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.
این پیام جهت مدیر کشتیرانی مورد نظر نیز ارسال شده است
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_m[0]" ,"support@asaltour.ir",$text2,$subject,$messmail);
		}
			//////////////////////////////////email



			//////////////////////////////////email

		$subject = "Asaltour.ir | Ticket Reservation  " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 کاربر گرامی  $_SESSION[g_name_login] $_SESSION[g_email_login] <br>

شما یک بلیط به مشخصات زیر رزرو نموده اید.به اطلاع جنابعالی می رسانیم که سیستم به صورت خودکار 24 ساعت به شما زمان خواهد داد که از طریق لینک پرداخت مبلغ صورت حساب را واریز نمائید و بلیط خود را پرینت بگیرید.در غیر این صورت سیستم رزرو شمارا کنسل میکند.
<br>
$add_email_to
<br>
ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$_SESSION[g_email_login]" ,"support@asaltour.ir",$text,$subject,$messmail);
		//$_SESSION[g_email_login]

			//////////////////////////////////email
			
			
    			if ($_REQUEST['shop'] == "online")
                {
        			$form_buy_psn_stage3 = "
        			<center>بلیط شما رزو شده است شما باید مبلغ <b>$nff</b> ریال را بپردازید . </center><br />
        
        			<form name= 'order' action='https://pna.shaparak.ir/CardServices' method='post'>
        			<input type='hidden' id='Amount' name='Amount' value='$jam_fee'>
        			<input type='hidden' id='MID' name='MID' value='00109713-128933'>
        			<input type='hidden' id='ResNum' name='ResNum' value='psngrtrade-$last_inserted_row'>
        			<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&stage=4'>
        			</form>
        			<script type=\"text/javascript\" language=\"JavaScript\">
        			//submit form
        			document.order.submit();
        			</script>
        			<br />
        			در صورت عدم پرداخت مبلغ فوق تا 1 ساعت دیگر رزور شما باطل می گردد.
        			";
                    
                }else{
                    
                    $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
                    if ($row_get_amount[0]<$jam_fee){
                        	$form_buy_psn_stage3 = "
        			<center>بلیط شما رزو شده است شما باید مبلغ <b>$nff</b> ریال را بپردازید . </center><br />
        
        			<form name= 'order' action='https://pna.shaparak.ir/CardServices' method='post'>
        			<input type='hidden' id='Amount' name='Amount' value='$jam_fee'>
        			<input type='hidden' id='MID' name='MID' value='00109713-128933'>
        			<input type='hidden' id='ResNum' name='ResNum' value='psngrtrade-$last_inserted_row'>
        			<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=buy&buy=psngrtrade&psngrtrade=$_REQUEST[psngrtrade]&stage=4'>
        			</form>
        			<script type=\"text/javascript\" language=\"JavaScript\">
        			//submit form
        			document.order.submit();
        			</script>
        			<br />
        			در صورت عدم پرداخت مبلغ فوق تا 1 ساعت دیگر رزور شما باطل می گردد.
        			";
                    }else{
                        
                         $new_amount = ($row_get_amount[0] - $jam_fee) ;

   mysql_query("UPDATE `gcms_login` SET `amount` = '$new_amount' WHERE `id` =$_SESSION[g_id_login] LIMIT 1 ;",$link);
   $up_qu_buypsngrtrade = "UPDATE `gcms_buypsngrtrade` SET `type` = 'active'  WHERE `gcms_buypsngrtrade`.`id` = '$id_pt' AND `gcms_buypsngrtrade`.`id_login` = '$_SESSION[g_id_login]' LIMIT 1 ;";
			
				mysql_query($up_qu_buypsngrtrade,$link);
                       $form_buy_psn_stage3 = "
                       مبلغ 
                       $jam_fee ريال
                       از اعتبار شما کسر گردید .  <br />
                        خرید با استفاده از اعتبار تایید شد.
                        
                   ";
                    }
                    
                }
			}else{
			$error_message = "مشکل در ارسال اطلاعات . ";
			}
			//
			$buy_content = "$form_buy_psn_stage3";
			}
			}
			
	
}

//
function f_buy_psn_stage4(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
	global $error_message,$success_message,$buy_content;

			//
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			
			
			if ( $_REQUEST[ResNum] and $_REQUEST[RefNum]  ){
				//
				$arr_ResNum = explode("-",  $_REQUEST['ResNum'] );
				$ttype = $arr_ResNum[0];
				$tid = $arr_ResNum[1];
				//
				$client = new SoapClient("https://pna.shaparak.ir/ref-payment/jax/merchantAuth?wsdl");
				$result = $client->VerifyTransaction("$_REQUEST[RefNum]", "00109713-128933");
				
				if ( $result <= 0 )
				{
				$err_mess = 'خطا : کد خطا '.$result;
				}

				if ( $_REQUEST[State] == "OK" and $result > 0 ){
				//date_default_timezone_set(UCT);
				$d_t1 = jdate("G:i:s");
				$d_t2 = jdate("Y/n/j");

				$q_a_prdxt = " 
				INSERT INTO `gcms_prdxt` (
				`id_login` ,
				`RefNum` ,
				`fee` ,
				`date`
				)
				VALUES (
				'$_SESSION[g_id_login]', 
				'$_REQUEST[RefNum]',
				'$result', 
				'$d_t2 $d_t1'
				)
				";
				// error on fee
				$q_fee_r = "
				SELECT fee FROM `gcms_buy".$ttype."`  WHERE `gcms_buy".$ttype."`.`id` = '".$tid."' AND `gcms_buy".$ttype."`.`id_login` = '$_SESSION[g_id_login]' LIMIT 1 ;
				";
				$r_fee_r = mysql_fetch_array(mysql_query($q_fee_r,$link));
				if ($r_fee_r[0] != $result)
				{
					
					$subject = "Asaltour.ir | Error On Money " ;
					$text = "query pasnger : $q_fee_r <br/>مبلغ $result  ریال واریز گردید . <br>";
					sendmail("25mordad@gmail.com" ,"support@asaltour.ir",$text,$subject,$messmail);
				}
				// end err on fee
				$up_qu_buypsngrtrade = "UPDATE `gcms_buy".$ttype."` SET `type` = 'active'  WHERE `gcms_buy".$ttype."`.`id` = '".$tid."' AND `gcms_buy".$ttype."`.`id_login` = '$_SESSION[g_id_login]' LIMIT 1 ;";
			
					if ( mysql_query($q_a_prdxt,$link) and mysql_query($up_qu_buypsngrtrade,$link)){
					$success_message =  " مبلغ $result  ریال واریز گردید . <br> با تشکر از شما ";	
					
		
		$subject = "Asaltour.ir | Payment successful " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
کاربر گرامی  $_SESSION[g_name_login] $_SESSION[g_email_login] <br>

با عرض تشکر از جنابعالی ، مبلغ $result ریال طی پرداخت آنلاین به رسید دیجیتالی  $_REQUEST[RefNum] به حساب ما واریز شد.

<br>
	 
	 ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$_SESSION[g_email_login]" ,"support@asaltour.ir",$text,$subject,$messmail);
		sendmail("info@asaltour.ir" ,"support@asaltour.ir",$text,$subject,$messmail);
					
					}else{
					$error_message = "
					مشکل در سیستم :
					حتما اطلاعات زیر را یادداشت کنید و به مدیر سیستم اطلاع دهید :<br>
					شماره ارجاع : $_REQUEST[RefNum] <br>
					مبلغ واریزی : $result ریال<br>
					تاریخ : $d_t2 $d_t1 <br>
					
					";
					}
				}else{
				$error_message = "
				مبلغ واریزی تایید نشد . <br>
				$err_mess 
				";
				}
				//
			}else{
			$error_message = "
			مشکل در دریافت اطلاعات
			";
			}
			
			
			//$buy_content = "";

			
	
}

//
function f_buy_psn_stage_agency(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;

	
			//
			$id_psngrtrade = $_REQUEST[psngrtrade];
			$i=50;
			while (isset($id_psngrtrade[$i])){
			$id_pt = $id_pt.$id_psngrtrade[$i];
			$i++;
			}
			//
			$q_s = "
			SELECT *
			FROM `gcms_psngrtrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_psngrtrade`.`id` = '$id_pt' 
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			
			if ($row_s[free_capacity] < $_REQUEST[num] + 1){
			$error_message = "
			ظرفیت کمتر از درخواست 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			//
		$row_2 = mysql_fetch_array(mysql_query("select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_credit' ",$link));
		$_SESSION['g_agency_credit'] = $row_2[value];
		//
		$row_3 = mysql_fetch_array(mysql_query(" select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_use' ",$link));
		$_SESSION['g_agency_use'] = $row_3[value];
		//
			$jam_fee = $row_s[fee]*$_REQUEST[num] + $row_s[fee];
			//$jam_fee = number_format($jam_fee);
			//$row_s[fee] = number_format($row_s[fee]);
			if ( $_SESSION['g_agency_credit'] < $_SESSION['g_agency_use'] + $jam_fee){
			$jam_fee = number_format($jam_fee);
			$baghimande_poll = number_format($_SESSION[g_agency_credit] - $_SESSION[g_agency_use]) ;
			$error_message = " مبلغ خرید شما ، بیشتر از باقی مانده اعتبار شما می باشد . <br>
			باقی مانده اعتبار شما $baghimande_poll ریال <br>
			مبلغ خرید شما $jam_fee ریال <br>
			 ";
			}else{		
			//
			$find_rddnc = mysql_fetch_array(mysql_query(" select id FROM `gcms_buypsngrtrade` where `mcode`='$_REQUEST[mcode]' AND `id_psngrtrade` = '$id_pt' AND `type` != 'cancel'",$link));
			if ($find_rddnc[0]){
			$error_message = "فردی با کد ملی $_REQUEST[mcode] در این سفر بلیط تهیه کرده است و دوباره نمی تواند بلیط تهیه کند . <br>   <br>  <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			//
			$d_t = date("Y-n-j-G-i-s"); 
			//
			
			if ($_REQUEST[charter] == "true" ){
			
				if ($row_s[capacity] == $row_s[free_capacity] ){
				$jam_fee = $row_s[charter_fee];
				$fin_charter = "true"; 
				}else{
				die ("مشکل در خرید");
				}
			
			}else{
			
			$fin_charter = "false"; 
			}
			
			$add_sql = "
			INSERT INTO `gcms_buypsngrtrade` (
			`id_login` ,
			`id_psngrtrade` ,
			`fname` ,
			`lname` ,
			`mcode` ,
			`state` ,
			`city` ,
			`address` ,
			`pcode` ,
			`cell` ,
			`tell` ,
			`num` ,
			`fee` ,
			`type` ,
			`charter` ,
			`buy_time`
			)
			VALUES (
			'$_SESSION[g_id_login]', 
			'$id_pt', 
			'$_REQUEST[fname]', 
			'$_REQUEST[lname]', 
			'$_REQUEST[mcode]', 
			'$_REQUEST[state]', 
			'$_REQUEST[city]', 
			'$_REQUEST[address]', 
			'$_REQUEST[pcode]', 
			'$_REQUEST[cell]', 
			'$_REQUEST[tell]', 
			'$_REQUEST[num]', 
			'$jam_fee', 
			'active', 
			'$fin_charter', 
			'$d_t'
			)
		";
			if ($_REQUEST[charter] == "true" ){
			$up_cap = 0 ;
			}else{
			$up_cap = $row_s[free_capacity] -  ( $_REQUEST[num] + 1 ) ;
			}
			$up_qu_psngrtrade = "UPDATE `gcms_psngrtrade` SET `free_capacity` = '$up_cap' WHERE `gcms_psngrtrade`.`id` =$id_pt LIMIT 1 ;";
			
			
			if ( mysql_query($add_sql,$link)   ){
			//
			$_SESSION['rfrsh'] = $_REQUEST[psngrtrade] ;
			//
			$last_inserted_row = mysql_insert_id($link);
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
			$hm_fname = "hm_fname".$i;
			$hm_lname = "hm_lname".$i;
			$hm_mcode = "hm_mcode".$i;
			$add_qu_hm = "
			INSERT INTO `gcms_metabuy` (
			`id_buy` ,
			`type` ,
			`hm_fname` ,
			`hm_lname` ,
			`hm_mcode`
			)
			VALUES (
			'$last_inserted_row', 
			'psngrtrade', 
			'$_REQUEST[$hm_fname]', 
			'$_REQUEST[$hm_lname]', 
			'$_REQUEST[$hm_mcode]'
			)
			";
			mysql_query($add_qu_hm,$link);
			}
			//
			mysql_query($up_qu_psngrtrade,$link);
			
			//////////////////////////////////email
		$row_f_c_e = mysql_fetch_array(mysql_query("SELECT  ship_name ,free_capacity,id_login,date,hour,sailing.name,mabd.name , magh.name  FROM `gcms_psngrtrade` 
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_psngrtrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_psngrtrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_psngrtrade`.`id_magh` = `magh`.`id` 
		 WHERE `gcms_psngrtrade`.`id` = '$id_pt' LIMIT 0 , 1",$link)) ;
		if ( $row_f_c_e[1] == "0"){
		$row_f_sh_m = mysql_fetch_array(mysql_query("SELECT email,fname,lname  FROM `gcms_login` WHERE `id` = '$row_f_c_e[2]' LIMIT 0 , 1",$link)) ;
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
		$subject = " Full Capacity " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 مدیریت محترم    $row_f_sh_m[1]  $row_f_sh_m[2]  کشتیرانی $row_f_c_e[5]<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.شما میتوانید جهت تهیه لیست مسافرین اقدام نمائید
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_sh_m[0]" ,"support@asaltour.ir",$text,$subject,$messmail);
		$row_f_m = mysql_fetch_array(mysql_query("SELECT email FROM `gcms_login` WHERE `type` = 'admin' LIMIT 0 , 1",$link)) ;
		$text2 = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
   مدیر کل محترم<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.
این پیام جهت مدیر کشتیرانی مورد نظر نیز ارسال شده است
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_m[0]" ,"support@asaltour.ir",$text2,$subject,$messmail);
		}
			//////////////////////////////////email
			
			
			
			$nff = number_format($jam_fee);
			/////////
		$row_2 = mysql_fetch_array(mysql_query("select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_credit' ",$link));
		$_SESSION['g_agency_credit'] = $row_2[value];
		//
		$row_3 = mysql_fetch_array(mysql_query(" select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_use' ",$link));
		$_SESSION['g_agency_use'] = $row_3[value];
		//
			
			////////
			$_SESSION['g_agency_use'] = $_SESSION['g_agency_use'] + $jam_fee ;
			$bghmnd = $_SESSION['g_agency_credit'] - $_SESSION['g_agency_use'] ;
			
			$upcr_sql = "
			UPDATE `gcms_metalogin` SET `value` = '$_SESSION[g_agency_use]' WHERE `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_use'  LIMIT 1 ; 
			";
			mysql_query($upcr_sql,$link);
			
			
			$codelenght = 50;
			while($newcode_length < $codelenght) {
			$x=1;
			$y=3;
			$part = rand($x,$y);
			if($part==1){$a=48;$b=57;}  // Numbers
			if($part==2){$a=65;$b=90;}  // UpperCase
			if($part==3){$a=97;$b=122;} // LowerCase
			$code_part=chr(rand($a,$b));
			$newcode_length = $newcode_length + 1;
			$newcode = $newcode.$code_part;
			}
			$r_rand = $newcode;
		
			$f_buy_psn_stage_agency = "
			<center>مبلغ  <b>$nff</b> ریال حساب شما کسر شد . <br />
			باقیمانده حساب شما : $bghmnd   ریال می باشد <br>
			<a href='?part=agency&agency=print&print=psngrtrade&psngrtrade=$r_rand$last_inserted_row' >چاپ بلیط</a><br>
			</center>
			";
			}else{
			$error_message = "مشکل در ارسال اطلاعات . ";
			}
			//
			$buy_content = "$f_buy_psn_stage_agency";
			}
			}
			}
			}
	
}

//
function f_buy_car_stage1(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;
	
			//
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			//
			include_once $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
			$t_roz = jdate2("y-m-d");

			$q_s = "
			SELECT *
			FROM `gcms_cartrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_cartrade`.`id` = '$id_pt'  AND `gcms_cartrade`.`date` >  '$t_roz'
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			//
            $wherein = substr($row_s[18], 0, -1);
			$q_s_v = "
			SELECT *
			FROM `gcms_car`
			WHERE `id_login` = '$row_s[id_login]' AND `id` in($wherein)
			 ";

			$r_s_v = mysql_query($q_s_v,$link);
			$ff = 1;
			while ($row_s_v = mysql_fetch_array($r_s_v)){
			if ($_REQUEST[vehicle] == $row_s_v[id] ){$selctvehicle = " selected='selected' ";}else{$selctvehicle = "";}
			$vehicle_name = $vehicle_name."
				<option value='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=0&weigh=0&vehicle=$row_s_v[id]&stage=1' $selctvehicle >$row_s_v[name]</option>
				";
				$frsfnd[$ff] = $row_s_v[id];
				$ff++;
			}
			//
			for ($i = 0; $i < 99; $i++) {
				if ($_REQUEST[weigh] == $i ){$selctweigh = " selected='selected' ";}else{$selctweigh = "";}
				$vehicle_weigh = $vehicle_weigh."
				<option value='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=$_REQUEST[num]&weigh=$i&vehicle=$_REQUEST[vehicle]&stage=1' $selctweigh >$i</option>
				";
			}
			if ($_REQUEST[vehicle] == "0" ){
			$_REQUEST[vehicle] = $frsfnd[1];
			}
			//
			//
			$q_s_v_s = "
			SELECT *
			FROM `gcms_car`
			WHERE `id` = '$_REQUEST[vehicle]' 
			LIMIT 0 , 1
			 ";
			$r_s_v_s = mysql_query($q_s_v_s,$link);
			$row_s_v_s = mysql_fetch_array($r_s_v_s);
						
			//
			$jam_fee = $row_s_v_s[fee] +( $_REQUEST[num] * $row_s_v_s[fee_cap] ) + ($_REQUEST[weigh]*$row_s_v_s[cargo_fee]);
            $injajam_fee = $row_s_v_s[fee] +( $_REQUEST[num] * $row_s_v_s[fee_cap] ) + ($_REQUEST[weigh]*$row_s_v_s[cargo_fee]);
			$jam_fee = number_format($jam_fee);
			$row_s_v_s[fee] = number_format($row_s_v_s[fee]);
			$row_s_v_s[fee_cap] = number_format($row_s_v_s[fee_cap]);
			$row_s_v_s[cargo_fee] = number_format($row_s_v_s[cargo_fee]);
			$row_s[charter_fee] =  number_format($row_s[charter_fee]);
			//
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
				$trtd_hmrh = $trtd_hmrh."
				<tr>
					<td >
					<div  style='width:185px; float:right'>نام همراه <input type='text' name='hm_fname$i'  id='inphmrh' class='reqd'  lang='fa' /></div>
					<div  style='width:225px; float:right'>نام خانوادگی همراه <input type='text' name='hm_lname$i' id='inphmrh' class='reqd' lang='fa' /> </div>
					<div style='width:220px; float:right'>کد ملی همراه <input type='text' name='hm_mcode$i' id='inphmr' class='reqd' onKeyUp='javascript:checkNumber(signup.hm_mcode$i);' />
		<div id='hm_mcode$i-status'></div>
		</div>
					</td>
				</tr>
				";
			}
			//
			for ($i = 0; $i <= $row_s_v_s[max_cap]; $i++) {
				if ($_REQUEST[num] == $i ){$selctnum = " selected='selected' ";}else{$selctnum = "";}
				$num_nafar = $num_nafar."
				<option value='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=$i&weigh=$_REQUEST[weigh]&vehicle=$_REQUEST[vehicle]&stage=1' $selctnum >$i</option>
				";
			}
			//
			//
			if ($_SESSION['g_customer_id_buy']){
				if ($_SESSION[g_customer_type_buy] == "gcms_buycartrade" ){
				$addq_buy = " ,certificate,model,plate,shasi,motor,bdne,moayn,wazn,cargo_name,barnme  "; 
				}else{
				$addq_buy = "";
				}
			$q_old = "
			SELECT fname,lname,mcode,state,city,address,pcode,tell,cell $addq_buy
			FROM `$_SESSION[g_customer_type_buy]`
			WHERE `id` = '$_SESSION[g_customer_id_buy]' 
			LIMIT 0 , 1
			 ";
			$row_old = mysql_fetch_array( mysql_query($q_old,$link));
			$_REQUEST[fname] = $row_old[fname];
			$_REQUEST[lname] = $row_old[lname];
			$_REQUEST[mcode] = $row_old[mcode];
			$_REQUEST[state] = $row_old[state];
			$_REQUEST[city] = $row_old[city];
			$_REQUEST[address] = $row_old[address];
			$_REQUEST[pcode] = $row_old[pcode];
			$_REQUEST[tell] = $row_old[tell];
			$_REQUEST[cell] = $row_old[cell];
				if ($_SESSION[g_customer_type_buy] == "gcms_buycartrade" ){
				$_REQUEST[certificate] = $row_old[certificate];
				$_REQUEST[model] = $row_old[model];
				$_REQUEST[plate] = $row_old[plate];
				$_REQUEST[shasi] = $row_old[shasi];
				$_REQUEST[motor] = $row_old[motor];
				$_REQUEST[bdne] = $row_old[bdne];
				$_REQUEST[moayn] = $row_old[moayn];
				$_REQUEST[wazn] = $row_old[wazn];
				$_REQUEST[cargo_name] = $row_old[cargo_name];
				$_REQUEST[barnme] = $row_old[barnme];
				}
			}
			
			//
			if ($_REQUEST[charter] == "true" )
			{
			$charternum ="
			<center>

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مبدا : $row_s[23] 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مقصد : $row_s[25]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			تاریخ حرکت: $row_s[date]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			ساعت حرکت : $row_s[hour]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<br>

			";
			$charterlink ="
			قیمت بلیط : $row_s[charter_fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			بلیط چارتر
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $row_s[charter_fee] ریال</b>
			</center>
			<form action='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=$_REQUEST[num]&weigh=$_REQUEST[weigh]&vehicle=$_REQUEST[vehicle]&stage=2&charter=true' method='post' name='signup' >
			<div class='clear' ></div>
			<div style='float:left; overflow:auto; width:350px; margin-top:20px; height:450px;' >
			<b>نام کشتی : </b> $row_s[ship_name]  <br>
			<b>مدت زمان سفر : </b> $row_s[time] دقیقه <br>
			<b>سرعت کشتی : </b> $row_s[speed] مایل دریایی <br>
			";
			$add_chrt_form = "
				

					<input   name='certificate' type='hidden' value='charter' />

					<input   name='model'  type='hidden' value='charter' />

					<input   name='plate' type='hidden' value='charter'  />

					<input  name='shasi' type='hidden' value='charter' />

					<input name='motor' type='hidden' value='charter'  />

					<input   name='bdne'  type='hidden' value='charter' />

					<input   name='moayn'  type='hidden' value='charter' />

					<input   name='wazn'  type='hidden' value='charter'  />

					<input  name='cargo_name'  type='hidden' value='charter' />

					<input name='barnme' type='hidden' value='charter'  />

				
			";
			}else{
			$charternum ="
			<center>
			تعداد همراه :
			<select name=\"menu1\" onchange=\"MM_jumpMenu('parent',this,0)\" id='slthamrh'>
			$num_nafar
			</select>
			نفر
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مبدا : $row_s[23] 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مقصد : $row_s[25]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			تاریخ حرکت: $row_s[date]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			ساعت حرکت : $row_s[hour]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<br>
			نوع خودرو : 
			<select name='vehicle' onchange=\"MM_jumpMenu('parent',this,0)\" id='sltvehicle'>
			$vehicle_name
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			وزن بار: 
			<select name='vehicle' onchange=\"MM_jumpMenu('parent',this,0)\" id='slthamrh'>
			$vehicle_weigh
			</select>
			(تن)
			<br>
			";

			$charterlink ="
			قیمت بلیط : $row_s_v_s[fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			قیمت بلیط همراه : $row_s_v_s[fee_cap] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			قیمت بار (تن) : $row_s_v_s[cargo_fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $jam_fee ریال</b> <br />
           	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;		
               در صورت کنسل کردن بلیط 
               ". number_format($injajam_fee-($row_s['darsad_cancel']*$injajam_fee/100)) ."
                 ریال به اعتبار شما در سایت اضافه می شود.
                                                              
			</center>
			<form action='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=$_REQUEST[num]&weigh=$_REQUEST[weigh]&vehicle=$_REQUEST[vehicle]&stage=2' method='post' name='signup' >
			<div class='clear' ></div>
			<div style='float:left; overflow:auto; width:350px; margin-top:20px; height:450px;' >
			<b>نام کشتی : </b> $row_s[ship_name]  <br>
			<b>مدت زمان سفر : </b> $row_s[time] دقیقه <br>
			<b>سرعت کشتی : </b> $row_s[speed] مایل دریایی <br>
			";
				if ( $row_s[8] == $row_s[7]){
				$charterlink = $charterlink . "
			<b>قیمت بلیط چارتر : </b> $row_s[charter_fee] ریال  
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<a href='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=$_REQUEST[num]&weigh=$_REQUEST[weigh]&vehicle=$_REQUEST[vehicle]&stage=1&charter=true' >خرید بلیط چارتر</a> <br>
				";
				}
			$add_chrt_form = "
				
				<tr>
					<td>
					شماره گواهینامه
					</td>
					<td>
					<input type='text' name='certificate' value='$_REQUEST[certificate]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					مدل ماشین
					</td>
					<td>
					<input type='text' name='model' value='$_REQUEST[model]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					شماره پلاک
					</td>
					<td>
					<input type='text' name='plate' value='$_REQUEST[plate]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					شماره شاسی
					</td>
					<td>
					<input type='text' name='shasi' value='$_REQUEST[shasi]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					شماره موتور
					</td>
					<td>
					<input type='text' name='motor' value='$_REQUEST[motor]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					شماره بدنه
					</td>
					<td>
					<input type='text' name='bdne' value='$_REQUEST[bdne]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					شماره معاینه
					</td>
					<td>
					<input type='text' name='moayn' value='$_REQUEST[moayn]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					وزن خودرو (تن)
					</td>
					<td>
					<input type='text' name='wazn' value='$_REQUEST[wazn]'  />
					</td>
				</tr>
				<tr>
					<td>
					نام کالا
					</td>
					<td>
					<input type='text' name='cargo_name' value='$_REQUEST[cargo_name]'  />
					</td>
				</tr>
				<tr>
					<td>
					شماره بارنامه
					</td>
					<td>
					<input type='text' name='barnme' value='$_REQUEST[barnme]'  />
					</td>
				</tr>
				
			";
			}
			
			
			//
			$form_buy_psn_stage1 = "
			$charternum
			$charterlink

			<b>اطلاعات کشتی : </b><br> $row_s[ship_info]  <br>



			</div>
			<div style='float:right' >
			<table id='hor-minimalist-a-1' >
				<tbody>
				<tr>
					<td>
					نام مسافر 
					</td>
					<td>
					<input type='text' name='fname' value='$_REQUEST[fname]' class='reqd'   lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					نام خانوادگی
					</td>
					<td>
					<input type='text' name='lname' value='$_REQUEST[lname]' class='reqd' lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					کد ملی
					</td>
					<td>
					<input type='text' name='mcode' value='$_REQUEST[mcode]'   class='reqd' onKeyUp = 'javascript:checkNumber(signup.mcode);' />
		<div id='melicode-status'></div>
					</td>
				</tr>
				<tr>
					<td>
					استان
					</td>
					<td>
					<input type='text' name='state' value='$_REQUEST[state]' class='reqd' lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					شهرستان
					</td>
					<td>
					<input type='text' name='city' value='$_REQUEST[city]' class='reqd' lang='fa' />
					</td>
				</tr>
				<tr>
					<td>
					آدرس
					</td>
					<td>
					<textarea name='address' class='reqd' lang='fa' >$_REQUEST[address]</textarea>
					</td>
				</tr>
				<tr>
					<td>
					کدپستی
					</td>
					<td>
					<input type='text' name='pcode' value='$_REQUEST[pcode]' class='reqd' />
					</td>
				</tr>
				<tr>
					<td>
					تلفن
					</td>
					<td>
					<input type='text' name='tell' value='$_REQUEST[tell]'  onKeyUp='javascript:checkNumber(signup.tell);'   />
					<div id='tell-status'></div>
					</td>
				</tr>
				<tr>
					<td>
					موبایل
					</td>
					<td>
					<input type='text' name='cell' value='$_REQUEST[cell]' class='reqd' 	onKeyUp='javascript:checkNumber(signup.cell);'   />
					<div id='cell-status'></div>
					</td>
				</tr>
				$add_chrt_form
				</tbody>
			</table>
			</div>
			<div class='clear' ></div>
					مشخصات همراهان
			<table id='hor-minimalist-a-3' >
				<tbody>
				$trtd_hmrh
				<tr>
					<td >
					کد امنیتی : <input type='text' name='vercode' id='inphmr' class='reqd' /><img src='/gcms/php/file/captcha.php' >
					<div id='vercode-status'></div>
					</td>
				</tr>
				</tbody>
			</table>
			<input type='submit' value='خرید بلیط' style='float:left;margin-left:100px;margin-bottom:30px; margin-top:20px' onMouseDown='initForms()' >
            <input   name='darsad_cancel' type='hidden' value='$row_s[darsad_cancel]' />
                 <input   name='cancel_fee' type='hidden' value='". $row_s['darsad_cancel']*$injajam_fee/100 ."' /> 
			</form>
<script type='text/javascript'>


fieldlimiter.setup({
	thefield: document.signup.mcode,
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
	thefield: document.signup.hm_mcode1,
	maxlength: 10,
	statusids: ['hm_mcode1-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.hm_mcode2,
	maxlength: 10,
	statusids: ['hm_mcode2-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.hm_mcode3,
	maxlength: 10,
	statusids: ['hm_mcode3-status'], 
	onkeypress:function(maxlength, curlength){ 
		if (curlength<maxlength) 
			this.style.border='1px solid #BBD6EC' 
		else
			this.style.border='1px solid green'
	}
})

fieldlimiter.setup({
	thefield: document.signup.hm_mcode4,
	maxlength: 10,
	statusids: ['hm_mcode4-status'], 
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
			//
			$buy_content = "$form_buy_psn_stage1";
			}

	
}


//
function f_buy_car_stage2(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;

	
	
			//
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			//
			include $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/jdf.php';
			$t_roz = jdate2("y-m-d");
			$q_s = "
			SELECT *
			FROM `gcms_cartrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_cartrade`.`id` = '$id_pt' AND `gcms_cartrade`.`date` >  '$t_roz'
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{


			//
			$q_s_v_s = "
			SELECT *
			FROM `gcms_car`
			WHERE `id` = '$_REQUEST[vehicle]' 
			LIMIT 0 , 1
			 ";
			$r_s_v_s = mysql_query($q_s_v_s,$link);
			$row_s_v_s = mysql_fetch_array($r_s_v_s);
				
			if ($row_s[free_capacity] < $row_s_v_s[unit] ){
			$error_message = "
			ظرفیت کمتر از درخواست 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{		
						
			//
			$jam_fee = $row_s_v_s[fee] +( $_REQUEST[num] * $row_s_v_s[fee_cap] ) + ($_REQUEST[weigh]*$row_s_v_s[cargo_fee]);
            $injajam_fee  = $row_s_v_s[fee] +( $_REQUEST[num] * $row_s_v_s[fee_cap] ) + ($_REQUEST[weigh]*$row_s_v_s[cargo_fee]);
			$jam_fee = number_format($jam_fee);
            
			$row_s_v_s[fee] = number_format($row_s_v_s[fee]);
            
			$row_s_v_s[fee_cap] = number_format($row_s_v_s[fee_cap]);
			$row_s_v_s[cargo_fee] = number_format($row_s_v_s[cargo_fee]);
			$row_s[charter_fee] =  number_format($row_s[charter_fee]);

			//
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
			$hm_fname = "hm_fname".$i;
			$hm_lname = "hm_lname".$i;
			$hm_mcode = "hm_mcode".$i;
			$hm_info = $hm_info .
			"
			$i -  $_REQUEST[$hm_fname]   $_REQUEST[$hm_lname] با کد ملی  $_REQUEST[$hm_mcode]<br>
			";
			$hm_inp_hdn = $hm_inp_hdn."
			<input type='hidden' name='hm_fname$i' value='$_REQUEST[$hm_fname]'  />
			<input type='hidden' name='hm_lname$i' value='$_REQUEST[$hm_lname]'  />
			<input type='hidden' name='hm_mcode$i' value='$_REQUEST[$hm_mcode]'  />
			";
			}
			//
			
			if ($_REQUEST[charter] == "true" ){
			$add_char_1 = "&charter=true";
			$add_char_2 = "

			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مبدا : $row_s[22] 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مقصد : $row_s[24]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			تاریخ حرکت: $row_s[date]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			ساعت حرکت : $row_s[hour]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

			";
			$add_char_3 = "
			قیمت بلیط : $row_s[charter_fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $row_s[charter_fee] ریال</b> <br />

			";
			}else{
			$add_char_2 = "
			تعداد همراه :
			$_REQUEST[num]
			نفر
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مبدا : $row_s[22] 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			مقصد : $row_s[24]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			تاریخ حرکت: $row_s[date]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			ساعت حرکت : $row_s[hour]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<br>
			نوع خودرو : 
			$row_s_v_s[name]
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			وزن بار: 
			$_REQUEST[weigh]
			(تن)
			";
			$add_char_3 = "
			قیمت بلیط : $row_s_v_s[fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			قیمت بلیط همراه : $row_s_v_s[fee_cap] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			قیمت بار (تن) : $row_s_v_s[cargo_fee] ریال
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<b>جمع کل : $jam_fee ریال</b>
            
			";
			$add_char_4 = "
			<b>شماره گواهینامه </b> : $_REQUEST[certificate] <br><br>
			<b>مدل ماشین </b> : $_REQUEST[model] <br><br>
			<b>شماره پلاک </b> : $_REQUEST[plate] <br><br>
			<b>شماره شاسی </b> : $_REQUEST[shasi] <br><br>
			<b>شماره موتور </b> : $_REQUEST[motor] <br><br>
			<b>شماره بدنه </b> : $_REQUEST[bdne] <br><br>
			<b>شماره معاینه </b> : $_REQUEST[moayn] <br><br>
			<b>وزن خودرو </b> : $_REQUEST[wazn] <br><br>
			<b>نام کالا </b> : $_REQUEST[cargo_name] <br><br>
			<b>شماره بارنامه </b> : $_REQUEST[barnme] <br><br>
			";
			}

			
			if ($_SESSION['g_t_login'] == "agency"){
			$form_valid = "<form action='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=$_REQUEST[num]&weigh=$_REQUEST[weigh]&vehicle=$_REQUEST[vehicle]&stage=agency$add_char_1' method='post' >";
			}else{
			$form_valid = "<form action='?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&num=$_REQUEST[num]&weigh=$_REQUEST[weigh]&vehicle=$_REQUEST[vehicle]&stage=3$add_char_1' method='post' >";
			}
			/////
			$fnd_ghann = mysql_fetch_array( mysql_query("SELECT page_title,page_content,page_pic FROM `gcms_pages`  WHERE id = '17' ",$link));
			$fnd_ghann[page_content] = strip_tags($fnd_ghann[page_content]);
            
            
             $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
            if ($injajam_fee <= $row_get_amount[0])
            {
                $text_amount = "
                <input type='radio' value='online' name='shop'  > خرید آنلاین  
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type='radio' checked='checked' value='amount' name='shop' > خرید با استفاده از اعتبار
                ";
                
            }else{
                $text_amount = "
                <input type='radio' checked='checked'  value='online' name='shop'> خرید آنلاین 
                ";
            }
            
            
			/////
			$form_buy_car_stage2 = " 
			<a href='javascript: history.go(-1)' >برگشت</a><br>
			<center>
			$add_char_2 
			<br>
			$add_char_3
			</center>
			<b>نام مسافر</b> : $_REQUEST[fname] <br><br>
			<b>نام خانوادگی</b> : $_REQUEST[lname] <br><br>
			<b>کد ملی</b> : $_REQUEST[mcode] <br><br>
			<b>استان</b> : $_REQUEST[state] <br><br>
			<b>شهرستان</b> : $_REQUEST[city] <br><br>
			<b>آدرس</b> : $_REQUEST[address] <br><br>
			<b>کدپستی</b> : $_REQUEST[pcode] <br><br>
			<b>تلفن</b> : $_REQUEST[tell] <br><br>
			<b>موبایل</b> : $_REQUEST[cell] <br><br>
			$add_char_4
			<b>اطلاعات همراهان</b> : <br>
			$hm_info <br>
			$form_valid
			<input type='hidden' name='fname' value='$_REQUEST[fname]'  />
			<input type='hidden' name='lname' value='$_REQUEST[lname]'  />
			<input type='hidden' name='mcode' value='$_REQUEST[mcode]'  />
			<input type='hidden' name='state' value='$_REQUEST[state]'  />
			<input type='hidden' name='city' value='$_REQUEST[city]'  />
			<input type='hidden' name='address' value='$_REQUEST[address]'  />
			<input type='hidden' name='pcode' value='$_REQUEST[pcode]'  />
			<input type='hidden' name='tell' value='$_REQUEST[tell]'  />
			<input type='hidden' name='cell' value='$_REQUEST[cell]'  />
			<input type='hidden' name='certificate' value='$_REQUEST[certificate]'  />
			<input type='hidden' name='model' value='$_REQUEST[model]'  />
			<input type='hidden' name='plate' value='$_REQUEST[plate]'  />
			<input type='hidden' name='shasi' value='$_REQUEST[shasi]'  />
			<input type='hidden' name='motor' value='$_REQUEST[motor]'  />
			<input type='hidden' name='bdne' value='$_REQUEST[bdne]'  />
			<input type='hidden' name='moayn' value='$_REQUEST[moayn]'  />
			<input type='hidden' name='wazn' value='$_REQUEST[wazn]'  />
			<input type='hidden' name='cargo_name' value='$_REQUEST[cargo_name]'  />
			<input type='hidden' name='barnme' value='$_REQUEST[barnme]'  />
            <input type='hidden' name='darsad_cancel' value='$_REQUEST[darsad_cancel]'  />
             <input type='hidden' name='cancel_fee' value='$_REQUEST[cancel_fee]'  />

			$hm_inp_hdn <br />
            $text_amount
            <br />
			تایید اطلاعات &raquo;<input type='checkbox' onclick=\"if (this.checked){this.form.tr.disabled=0}else{this.form.tr.disabled=1}\">
			<input name='tr' type='submit' disabled='1' value='اطلاعات فوق مورد تایید می باشد و همچنین قوانین سایت را قبول دارم !' >
			</form>
			<br>
			<textarea name='roll' readonly='readonly' id='txarroll'  disabled='disabled' >$fnd_ghann[page_content]</textarea>
			<br>
			
			";
			//
			$buy_content = "$form_buy_car_stage2";
			}
			}
			
	
}

//
function f_buy_car_stage3(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;

	
			//
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			//
			$q_s = "
			SELECT *
			FROM `gcms_cartrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_cartrade`.`id` = '$id_pt' 
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			
			//
			$q_s_v_s = "
			SELECT *
			FROM `gcms_car`
			WHERE `id` = '$_REQUEST[vehicle]' 
			LIMIT 0 , 1
			 ";
			$r_s_v_s = mysql_query($q_s_v_s,$link);
			$row_s_v_s = mysql_fetch_array($r_s_v_s);
				
			if ($row_s[free_capacity] < $row_s_v_s[unit] ){
			$error_message = "
			ظرفیت کمتر از درخواست 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			
			//
			$jam_fee = $row_s_v_s[fee] +( $_REQUEST[num] * $row_s_v_s[fee_cap] ) + ($_REQUEST[weigh]*$row_s_v_s[cargo_fee]);

			
			
			if ( false){

			}else{		
			//
			$find_rddnc = mysql_fetch_array(mysql_query(" select id FROM `gcms_buycartrade` where `mcode`='$_REQUEST[mcode]' AND `id_cartrade` = '$id_pt'  AND `type` != 'cancel'",$link));
			if ($find_rddnc[0]){
			$error_message = "فردی با کد ملی $_REQUEST[mcode] در این سفر بلیط تهیه کرده است و دوباره نمی تواند بلیط تهیه کند . <br>   <br>  <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			//
			$d_t = date("Y-n-j-G-i-s"); 
			//
			if ($_REQUEST[charter] == "true" ){
			
				if ($row_s[capacity] == $row_s[free_capacity] ){
				$jam_fee = $row_s[charter_fee];
				$fin_charter = "true"; 
				$_REQUEST[vehicle] = "1"; 
				}else{
				die ("مشکل در خرید");
				}
			
			}else{
			
			$fin_charter = "false"; 
			}
			//
			$add_sql = "
			INSERT INTO `gcms_buycartrade` (
			`id_login` ,
			`id_cartrade` ,
			`id_car` ,
			`fname` ,
			`lname` ,
			`mcode` ,
			`state` ,
			`city` ,
			`address` ,
			`pcode` ,
			`cell` ,
			`tell` ,
			`num` ,
			`fee` ,
			`certificate` ,
			`model` ,
			`plate` ,
			`shasi` ,
			`motor` ,
			`bdne` ,
			`moayn` ,
			`wazn` ,
			`weigh` ,
			`cargo_name` ,
			`barnme` ,
			`type` ,
			`charter` ,
			`buy_time`,
            `darsad_cancel`,
            `cancel_fee`
			)
			VALUES (
			'$_SESSION[g_id_login]', 
			'$id_pt', 
			'$_REQUEST[vehicle]', 
			'$_REQUEST[fname]', 
			'$_REQUEST[lname]', 
			'$_REQUEST[mcode]', 
			'$_REQUEST[state]', 
			'$_REQUEST[city]', 
			'$_REQUEST[address]', 
			'$_REQUEST[pcode]', 
			'$_REQUEST[cell]', 
			'$_REQUEST[tell]', 
			'$_REQUEST[num]', 
			'$jam_fee', 
			'$_REQUEST[certificate]', 
			'$_REQUEST[model]', 
			'$_REQUEST[plate]', 
			'$_REQUEST[shasi]', 
			'$_REQUEST[motor]', 
			'$_REQUEST[bdne]', 
			'$_REQUEST[moayn]', 
			'$_REQUEST[wazn]', 
			'$_REQUEST[weigh]', 
			'$_REQUEST[cargo_name]', 
			'$_REQUEST[barnme]', 
			'pending', 
			'$fin_charter', 
			'$d_t',
            '$_REQUEST[darsad_cancel]', 
            '$_REQUEST[cancel_fee]'
			)
		";
		$add_email_to = "
		<br><br>
		<table border=1  cellpadding=0 cellspacing=0 >
			<tr>
				<td width=100>
				<center><b>ردیف</b></center>
				</td>
				<td width=250>
				<center><b>نام مسافر</b></center>
				</td>
				<td width=50>
				<center><b>تعداد همراه</b></center>
				</td>
				<td width=100>
				<center><b>شماره ملی</b></center>
				</td>
				<td width=100>
				<center><b>نوع خودرو</b></center>
				</td>
				<td width=100>
				<center><b>مدل</b></center>
				</td>
				<td width=100>
				<center><b>شماره گواهینامه</b></center>
				</td>
				<td width=100>
				<center><b>شماره پلاک</b></center>
				</td>
				<td width=100>
				<center><b>شماره بدنه</b></center>
				</td>
				<td width=100>
				<center><b>شماره موتور</b></center>
				</td>
				<td width=100>
				<center><b>شماره شاسی</b></center>
				</td>
			</tr>
			<tr>
				<td>
				<center>1</center>
				</td>
				<td>
				<center>$_REQUEST[fname] $_REQUEST[lname]</center>
				</td>
				<td>
				<center>$_REQUEST[num]</center>
				</td>
				<td>
				 <center>$_REQUEST[mcode]</center>
				</td>
				<td>
				 <center>$row_s_v_s[name] </center>
				</td>
				<td>
				 <center>$_REQUEST[model]</center>
				</td>
				<td>
				 <center>$_REQUEST[certificate]</center>
				</td>
				<td>
				 <center>$_REQUEST[plate]</center>
				</td>
				<td>
				 <center>$_REQUEST[bdne]</center>
				</td>
				<td>
				 <center>$_REQUEST[motor]</center>
				</td>
				<td>
				 <center>$_REQUEST[shasi]</center>
				</td>
			</tr>
			";
			if ($_REQUEST[charter] == "true" ){
			$up_cap = 0 ;
			}else{
			$up_cap = $row_s[free_capacity] -  $row_s_v_s[unit] ;
			}
			$up_qu_cartrade = "UPDATE `gcms_cartrade` SET `free_capacity` = '$up_cap' WHERE `gcms_cartrade`.`id` =$id_pt LIMIT 1 ;";
			
			
			if ( mysql_query($add_sql,$link)   ){
			//
			$_SESSION['rfrsh'] = $_REQUEST[cartrade] ;
			//
			$last_inserted_row = mysql_insert_id($link);
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
			$hm_fname = "hm_fname".$i;
			$hm_lname = "hm_lname".$i;
			$hm_mcode = "hm_mcode".$i;
			$add_qu_hm = "
			INSERT INTO `gcms_metabuy` (
			`id_buy` ,
			`type` ,
			`hm_fname` ,
			`hm_lname` ,
			`hm_mcode`
			)
			VALUES (
			'$last_inserted_row', 
			'cartrade', 
			'$_REQUEST[$hm_fname]', 
			'$_REQUEST[$hm_lname]', 
			'$_REQUEST[$hm_mcode]'
			)
			";
			mysql_query($add_qu_hm,$link);
			
			$k = $i+1;
			$add_email_to = $add_email_to . "
			<tr>
				<td>
				<center>$k</center>
				</td>
				<td>
				<center>$_REQUEST[$hm_fname] $_REQUEST[$hm_lname]</center>
				</td>
				<td>
				<center>*</center>
				</td>
				<td>
				<center> $_REQUEST[$hm_mcode] </center>
				</td>
			</tr>
			" ;
			
			}
			//
			mysql_query($up_qu_cartrade,$link);
			$nff = number_format($jam_fee);
			$add_email_to = $add_email_to . "
			</table>
			<br><br>
			جمع صورتحساب شما : $nff ریال <br>
			";
			
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
			//////////////////////////////////email
		$row_f_c_e = mysql_fetch_array(mysql_query("SELECT  ship_name ,free_capacity,id_login,date,hour,sailing.name,mabd.name , magh.name  FROM `gcms_cartrade` 
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id` 
		 WHERE `gcms_cartrade`.`id` = '$id_pt' LIMIT 0 , 1",$link)) ;
		if ( $row_f_c_e[1] == "0"){
		$row_f_sh_m = mysql_fetch_array(mysql_query("SELECT email,fname,lname  FROM `gcms_login` WHERE `id` = '$row_f_c_e[2]' LIMIT 0 , 1",$link)) ;
		$subject = " Full Capacity " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 مدیریت محترم    $row_f_sh_m[1]  $row_f_sh_m[2]  کشتیرانی $row_f_c_e[5]<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.شما میتوانید جهت تهیه لیست مسافرین اقدام نمائید
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_sh_m[0]" ,"support@asaltour.ir",$text,$subject,$messmail);
		//$row_f_sh_m[0]
		$row_f_m = mysql_fetch_array(mysql_query("SELECT email FROM `gcms_login` WHERE `type` = 'admin' LIMIT 0 , 1",$link)) ;
		$text2 = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
   مدیر کل محترم<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.
این پیام جهت مدیر کشتیرانی مورد نظر نیز ارسال شده است
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_m[0]" ,"support@asaltour.ir",$text2,$subject,$messmail);
		}
			//////////////////////////////////email
			
			//////////////////////////////////email

		$subject = "Asaltour.ir | Ticket Reservation  " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 کاربر گرامی  $_SESSION[g_name_login] $_SESSION[g_email_login] <br>

شما یک بلیط به مشخصات زیر رزرو نموده اید.به اطلاع جنابعالی می رسانیم که سیستم به صورت خودکار 24 ساعت به شما زمان خواهد داد که از طریق لینک پرداخت مبلغ صورت حساب را واریز نمائید و بلیط خود را پرینت بگیرید.در غیر این صورت سیستم رزرو شمارا کنسل میکند.
<br>
$add_email_to
<br>
ورود به سایت <a href='http://asaltour.ir' >http://asaltour.ir</a> <br>

<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$_SESSION[g_email_login]" ,"support@asaltour.ir",$text,$subject,$messmail);
		

			//////////////////////////////////email
			
			if ($_REQUEST['shop'] == "online")
                {
        			
			$f_buy_psn_stage_agency = "
			<center>بلیط شما رزو شده است شما باید مبلغ <b>$nff</b> ریال را بپردازید . </center><br />
			
				<form name= 'order' action='https://pna.shaparak.ir/CardServices' method='post'>
			<input type='hidden' id='Amount' name='Amount' value='$jam_fee'>
			<input type='hidden' id='MID' name='MID' value='00109713-128933'>
			<input type='hidden' id='ResNum' name='ResNum' value='cartrade-$last_inserted_row'>
			<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&stage=4'>
			</form>
			<script type=\"text/javascript\" language=\"JavaScript\">
			//submit form
			document.order.submit();
			</script>
			<br />
			در صورت عدم پرداخت مبلغ فوق تا 1 ساعت دیگر رزور شما باطل می گردد.
		";
                    
                }else{
                    
                    $row_get_amount = mysql_fetch_array(mysql_query("SELECT amount FROM `gcms_login` WHERE `id` =$_SESSION[g_id_login] ",$link)) ;
                    if ($row_get_amount[0]<$jam_fee){
                        
			$f_buy_psn_stage_agency = "
			<center>بلیط شما رزو شده است شما باید مبلغ <b>$nff</b> ریال را بپردازید . </center><br />
			
				<form name= 'order' action='https://pna.shaparak.ir/CardServices' method='post'>
			<input type='hidden' id='Amount' name='Amount' value='$jam_fee'>
			<input type='hidden' id='MID' name='MID' value='00109713-128933'>
			<input type='hidden' id='ResNum' name='ResNum' value='cartrade-$last_inserted_row'>
			<input type='hidden' id='RedirectURL' name='RedirectURL' value='http://asaltour.ir/?part=buy&buy=cartrade&cartrade=$_REQUEST[cartrade]&stage=4'>
			</form>
			<script type=\"text/javascript\" language=\"JavaScript\">
			//submit form
			document.order.submit();
			</script>
			<br />
			در صورت عدم پرداخت مبلغ فوق تا 1 ساعت دیگر رزور شما باطل می گردد.
		";
                    }else{
                        
                         $new_amount = ($row_get_amount[0] - $jam_fee) ;

   mysql_query("UPDATE `gcms_login` SET `amount` = '$new_amount' WHERE `id` =$_SESSION[g_id_login] LIMIT 1 ;",$link);
   $up_qu_buypsngrtrade = "UPDATE `gcms_buycartrade` SET `type` = 'active'  WHERE `gcms_buycartrade`.`id` = '$last_inserted_row' AND `gcms_buycartrade`.`id_login` = '$_SESSION[g_id_login]' LIMIT 1 ;";
			
				mysql_query($up_qu_buypsngrtrade,$link);
                       $f_buy_psn_stage_agency = "
                  
                       مبلغ 
                       $jam_fee ريال
                       از اعتبار شما کسر گردید .  <br />
                        خرید با استفاده از اعتبار تایید شد.
                        
                   ";
                    }
                    
                }
			}else{
			$error_message = "مشکل در ارسال اطلاعات . ";
			}
			//
			$buy_content = "$f_buy_psn_stage_agency";
			}
			}
			}
			}
			
	
}

//
function f_buy_car_stage_agency(){
	require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';
	
	global $error_message,$success_message,$buy_content;

	
			//
			$id_cartrade = $_REQUEST[cartrade];
			$i=50;
			while (isset($id_cartrade[$i])){
			$id_pt = $id_pt.$id_cartrade[$i];
			$i++;
			}
			//
			$q_s = "
			SELECT *
			FROM `gcms_cartrade`
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id`
			WHERE `type` = 'active' and `gcms_cartrade`.`id` = '$id_pt' 
			LIMIT 0 , 1
			 ";
			$r_s = mysql_query($q_s,$link);
			$row_s = mysql_fetch_array($r_s);
			if (!$row_s){
			$error_message = "چنین مسیری وجود ندارد .&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			
			//
			$q_s_v_s = "
			SELECT *
			FROM `gcms_car`
			WHERE `id` = '$_REQUEST[vehicle]' 
			LIMIT 0 , 1
			 ";
			$r_s_v_s = mysql_query($q_s_v_s,$link);
			$row_s_v_s = mysql_fetch_array($r_s_v_s);
				
			if ($row_s[free_capacity] < $row_s_v_s[unit] ){
			$error_message = "
			ظرفیت کمتر از درخواست 
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&raquo; <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			
			//
			$jam_fee = $row_s_v_s[fee] +( $_REQUEST[num] * $row_s_v_s[fee_cap] ) + ($_REQUEST[weigh]*$row_s_v_s[cargo_fee]);
		$row_2 = mysql_fetch_array(mysql_query("select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_credit' ",$link));
		$_SESSION['g_agency_credit'] = $row_2[value];
		//
		$row_3 = mysql_fetch_array(mysql_query(" select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_use' ",$link));
		$_SESSION['g_agency_use'] = $row_3[value];
		//

			
			
			if ( $_SESSION['g_agency_credit'] < $_SESSION['g_agency_use'] + $jam_fee){
			$jam_fee = number_format($jam_fee);
			$baghimande_poll = number_format($_SESSION[g_agency_credit] - $_SESSION[g_agency_use]) ;
			$error_message = " مبلغ خرید شما ، بیشتر از باقی مانده اعتبار شما می باشد . <br>
			باقی مانده اعتبار شما $baghimande_poll ریال <br>
			مبلغ خرید شما $jam_fee ریال <br>
			 ";
			}else{		
			//
			$find_rddnc = mysql_fetch_array(mysql_query(" select id FROM `gcms_buycartrade` where `mcode`='$_REQUEST[mcode]' AND `id_cartrade` = '$id_pt' ",$link));
			if ($find_rddnc[0]){
			$error_message = "فردی با کد ملی $_REQUEST[mcode] در این سفر بلیط تهیه کرده است و دوباره نمی تواند بلیط تهیه کند . <br>   <br>  <a href='javascript: history.go(-1)' >برگشت</a>";
			}else{
			//
			$d_t = date("Y-n-j-G-i-s"); 
			//
			if ($_REQUEST[charter] == "true" ){
			
				if ($row_s[capacity] == $row_s[free_capacity] ){
				$jam_fee = $row_s[charter_fee];
				$fin_charter = "true"; 
				$_REQUEST[vehicle] = "1"; 
				}else{
				die ("مشکل در خرید");
				}
			
			}else{
			
			$fin_charter = "false"; 
			}
			
			
			$add_sql = "
			INSERT INTO `gcms_buycartrade` (
			`id_login` ,
			`id_cartrade` ,
			`id_car` ,
			`fname` ,
			`lname` ,
			`mcode` ,
			`state` ,
			`city` ,
			`address` ,
			`pcode` ,
			`cell` ,
			`tell` ,
			`num` ,
			`fee` ,
			`certificate` ,
			`model` ,
			`plate` ,
			`shasi` ,
			`motor` ,
			`bdne` ,
			`moayn` ,
			`wazn` ,
			`weigh` ,
			`cargo_name` ,
			`barnme` ,
			`type` ,
			`charter` ,
			`buy_time`
			)
			VALUES (
			'$_SESSION[g_id_login]', 
			'$id_pt', 
			'$_REQUEST[vehicle]', 
			'$_REQUEST[fname]', 
			'$_REQUEST[lname]', 
			'$_REQUEST[mcode]', 
			'$_REQUEST[state]', 
			'$_REQUEST[city]', 
			'$_REQUEST[address]', 
			'$_REQUEST[pcode]', 
			'$_REQUEST[cell]', 
			'$_REQUEST[tell]', 
			'$_REQUEST[num]', 
			'$jam_fee', 
			'$_REQUEST[certificate]', 
			'$_REQUEST[model]', 
			'$_REQUEST[plate]', 
			'$_REQUEST[shasi]', 
			'$_REQUEST[motor]', 
			'$_REQUEST[bdne]', 
			'$_REQUEST[moayn]', 
			'$_REQUEST[wazn]', 
			'$_REQUEST[weigh]', 
			'$_REQUEST[cargo_name]', 
			'$_REQUEST[barnme]', 
			'active', 
			'$fin_charter', 
			'$d_t'
			)
		";
			if ($_REQUEST[charter] == "true" ){
			$up_cap = 0 ;
			}else{
			$up_cap = $row_s[free_capacity] -  $row_s_v_s[unit] ;
			}
			$up_qu_cartrade = "UPDATE `gcms_cartrade` SET `free_capacity` = '$up_cap' WHERE `gcms_cartrade`.`id` =$id_pt LIMIT 1 ;";
			
			
			if ( mysql_query($add_sql,$link)   ){
			//
			$_SESSION['rfrsh'] = $_REQUEST[cartrade] ;
			//
			$last_inserted_row = mysql_insert_id($link);
			for ($i = 1; $i <= $_REQUEST[num]; $i++) {
			$hm_fname = "hm_fname".$i;
			$hm_lname = "hm_lname".$i;
			$hm_mcode = "hm_mcode".$i;
			$add_qu_hm = "
			INSERT INTO `gcms_metabuy` (
			`id_buy` ,
			`type` ,
			`hm_fname` ,
			`hm_lname` ,
			`hm_mcode`
			)
			VALUES (
			'$last_inserted_row', 
			'cartrade', 
			'$_REQUEST[$hm_fname]', 
			'$_REQUEST[$hm_lname]', 
			'$_REQUEST[$hm_mcode]'
			)
			";
			mysql_query($add_qu_hm,$link);
			}
			//
			mysql_query($up_qu_cartrade,$link);

			//////////////////////////////////email
		$row_f_c_e = mysql_fetch_array(mysql_query("SELECT  ship_name ,free_capacity,id_login,date,hour,sailing.name,mabd.name , magh.name  FROM `gcms_cartrade` 
			INNER JOIN `gcms_sailing` AS sailing ON `gcms_cartrade`.`id_sailing` = `sailing`.`id`
			INNER JOIN `gcms_des` AS mabd ON `gcms_cartrade`.`id_mabd` = `mabd`.`id`
			INNER JOIN `gcms_des` AS magh ON `gcms_cartrade`.`id_magh` = `magh`.`id` 
		 WHERE `gcms_cartrade`.`id` = '$id_pt' LIMIT 0 , 1",$link)) ;
		if ( $row_f_c_e[1] == "0"){
		$row_f_sh_m = mysql_fetch_array(mysql_query("SELECT email,fname,lname  FROM `gcms_login` WHERE `id` = '$row_f_c_e[2]' LIMIT 0 , 1",$link)) ;
		require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
		$subject = " Full Capacity " ;
		$text = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
 مدیریت محترم    $row_f_sh_m[1]  $row_f_sh_m[2]  کشتیرانی $row_f_c_e[5]<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.شما میتوانید جهت تهیه لیست مسافرین اقدام نمائید
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_sh_m[0]" ,"support@asaltour.ir",$text,$subject,$messmail);
		$row_f_m = mysql_fetch_array(mysql_query("SELECT email FROM `gcms_login` WHERE `type` = 'admin' LIMIT 0 , 1",$link)) ;
		$text2 = "	
<div style='direction:rtl; font-family:tahoma; ' >
<img src='http://asaltour.ir/gcms/img/1.gif'  />
<div style='padding:10px; background:#FFFFCC ;width:560px;'>
<br />
   مدیر کل محترم<br />

به اطلاع جنابعالی می رسانیم که ظرفیت کشتی $row_f_c_e[0] در مسیر $row_f_c_e[6] به $row_f_c_e[7] . به تاریخ حرکت  $row_f_c_e[3]  و ساعت  $row_f_c_e[4]  تکمیل شده است.
این پیام جهت مدیر کشتیرانی مورد نظر نیز ارسال شده است
<br /><br />
</div>
<img src='http://asaltour.ir/gcms/img/2.gif'  />
</div>
		";
		sendmail("$row_f_m[0]" ,"support@asaltour.ir",$text2,$subject,$messmail);
		}
			//////////////////////////////////email


			
			$nff = number_format($jam_fee);
			/////////
			
		$row_2 = mysql_fetch_array(mysql_query("select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_credit' ",$link));
		$_SESSION['g_agency_credit'] = $row_2[value];
		//
		$row_3 = mysql_fetch_array(mysql_query(" select value FROM `gcms_metalogin` where `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_use' ",$link));
		$_SESSION['g_agency_use'] = $row_3[value];
		//
			
			////////
			$_SESSION['g_agency_use'] = $_SESSION['g_agency_use'] + $jam_fee ;
			$bghmnd = $_SESSION['g_agency_credit'] - $_SESSION['g_agency_use'] ;
			
			$upcr_sql = "
			UPDATE `gcms_metalogin` SET `value` = '$_SESSION[g_agency_use]' WHERE `login_id`='$_SESSION[g_id_login]' AND `key` = 'agency_use'  LIMIT 1 ; 
			";
			mysql_query($upcr_sql,$link);
			
			$codelenght = 50;
			while($newcode_length < $codelenght) {
			$x=1;
			$y=3;
			$part = rand($x,$y);
			if($part==1){$a=48;$b=57;}  // Numbers
			if($part==2){$a=65;$b=90;}  // UpperCase
			if($part==3){$a=97;$b=122;} // LowerCase
			$code_part=chr(rand($a,$b));
			$newcode_length = $newcode_length + 1;
			$newcode = $newcode.$code_part;
			}
			$r_rand = $newcode;
		
			$f_buy_psn_stage_agency = "
			<center>مبلغ  <b>$nff</b> ریال حساب شما کسر شد . <br />
			باقیمانده حساب شما : $bghmnd   ریال می باشد <br>
			<a href='?part=agency&agency=print&print=cartrade&cartrade=$r_rand$last_inserted_row' >چاپ بلیط</a><br>
			</center>
			";
			}else{
			$error_message = "مشکل در ارسال اطلاعات . ";
			}
			//
			$buy_content = "$f_buy_psn_stage_agency";
			}
			}
			}
			}
	
}




?>