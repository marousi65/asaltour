<?php
if ($pluginsetup[product]){
session_start(); 
require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/gconfig.php';

	if($_REQUEST[stage]){


		switch ($_REQUEST[stage]){

			case "1":
			if ($_REQUEST[oldcustomer]){
				$row = mysql_fetch_array(mysql_query("SELECT * FROM `gcms_customer`  WHERE email  = '$_REQUEST[email]' AND zip = '$_REQUEST[zip]' ",$link));
				if($row){$disable = " disabled='disabled' ";}
			}
			if(!$row){
			$basketpart = $basketpart . 
			"
<div id='basketoldcustomer' >
<b>مشتری قبلی هستم!</b><br>
در صورتی که قبلا از فروشگاه خرید کرده اید فقط کافی است که ایمیل و کدپستی خود را وارد کنید. <br />
    <form method='post' action='?part=basket&stage=1&oldcustomer=true' >
    	ایمیل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='email' class='email1' id='basket_oc_input'  /><br />
        کدپستی&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='zip' class='reqd1' id='basket_oc_input'  /><br />
		<input type='hidden' name='rand'  value='$rand'  />
		<input type='hidden' name='rebate_bpp'  value='$_REQUEST[rebate_bpp_amount]'  />
		<input type='hidden' name='cost_bpp'  value='$_REQUEST[cost_bpp]'  />
		<input type='hidden' name='payment_type'  value='$_REQUEST[payment_type] $_REQUEST[bank] $_REQUEST[fish]'  />
		<input type='submit' id='basket_oc_submit' value='ارسال'  onMouseDown='initForms1()'/>
    </form>
</div>
";}
			if($row){$basketpart = $basketpart . "<div id='basketnewcustomer' >
لطفا اطلاعات خود را به روز کنید. <br />
    <form method='post' action='?part=basket&stage=2&customer=old' >
	<input type='hidden' name='id'  value='$row[customer_id]'  />
";}else{$basketpart = $basketpart ."<div id='basketnewcustomer' >
<b>مشتری جدید هستم!</b><br>
در صورتی که اولین بار است از این فروشگاه خرید می کنید ؛ اطلاعات زیر را تکمیل نمایید. <br />
    <form method='post' action='?part=basket&stage=2' >
";}
			$basketpart = $basketpart . 
			"        نام&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='first_name' class='reqd' id='basket_oc_input' value='$row[first_name]'  /><br />
        نام خانوادگی&nbsp;&nbsp;<input type='text' name='last_name' class='reqd' id='basket_oc_input' value='$row[last_name]'  /><br />
    	ایمیل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='email' class='email' id='basket_oc_input' value='$row[email]' $disable /><br />
        استان&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='state' class='reqd' id='basket_oc_input' value='$row[state]' /><br />
        شهر&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='city' class='reqd' id='basket_oc_input' value='$row[city]' /><br />
        آدرس پستی&nbsp;&nbsp;<textarea name='address' class='reqd' id='basket_oc_txtar' >$row[address]</textarea><br />
        کدپستی&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='zip' class='reqd' id='basket_oc_input' value='$row[zip]' /><br />
        تلفن&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='text' name='tel' class='reqd' id='basket_oc_input' value='$row[tel]'  /><br />
        لطفا کد تصوری را وارد کنید <br />
        <img src='/gcms/php/file/captcha.php' align='absmiddle'><input type='text' name='vercode'  class='reqd' id='commentinputsecur' />
		<br>
		<input type='submit' id='basket_oc_submit' value='ارسال'  onMouseDown='initForms()'/>
		<input type='hidden' name='rand'  value='$rand'  />
		<input type='hidden' name='rebate_bpp'  value='$_REQUEST[rebate_bpp_amount]'  />
		<input type='hidden' name='cost_bpp'  value='$_REQUEST[cost_bpp]'  />
		<input type='hidden' name='payment_type'  value='$_REQUEST[payment_type] $_REQUEST[bank] $_REQUEST[fish]'  />
    </form>
</div>
			";
			break;
	
			case "2":
			if ($_REQUEST["vercode"] != $_SESSION["vercode"] OR $_SESSION["vercode"]=='')  { 
			echo "
			<script type=\"text/javascript\">
			<!--
			window.location = \"?part=basket\"
			//-->
			</script>
			";
			} else { 

			$registerd = time();
			if ($_REQUEST[customer]){
			$query = "UPDATE `gcms_demo`.`gcms_customer` SET
			`first_name` = '$_REQUEST[first_name]',
			`last_name`  = '$_REQUEST[last_name]',
			`state`      = '$_REQUEST[state]',
			`city`       = '$_REQUEST[city]',
			`address`    = '$_REQUEST[address]',
			`zip`        = '$_REQUEST[zip]',
			`tel`        = '$_REQUEST[tel]'
			 WHERE `customer_id` ='$_REQUEST[id]'";
			}else{
			$query = "INSERT INTO `gcms_customer` (
			 `first_name` ,
			 `last_name` ,
			 `email` ,
			 `state` ,
			 `city` ,
			 `address` ,
			 `zip` ,
			 `tel`,
			 `registerd` ) VALUES (
			  '$_REQUEST[first_name]' ,
			  '$_REQUEST[last_name]' ,
			  '$_REQUEST[email]' ,
			  '$_REQUEST[state]' ,
			  '$_REQUEST[city]' ,
			  '$_REQUEST[address]' ,
			  '$_REQUEST[zip]' ,
			  '$_REQUEST[tel]' ,
			  '$registerd' )";
			}
				if ( mysql_query($query,$link) ){
					if ($_REQUEST[customer]){
					$customer_id = $_REQUEST[id];
					}else{
					$row = mysql_fetch_array(mysql_query("SELECT customer_id FROM `gcms_customer` WHERE `registerd` = '$registerd' ",$link));
					$customer_id = $row[0];
					}
					$quer = "INSERT INTO `gcms_orders` (`order_num` ,`payment_type` ,`id_customer` ,`cost_bpp` ,`rebate_bpp`,`id_coupon`,`order_status` ) VALUES ( '$registerd' ,'$_REQUEST[payment_type]' ,'$customer_id' , '$_REQUEST[cost_bpp]' , '$_REQUEST[rebate_bpp]' , '0' , 'pending' )";
					if (mysql_query($quer,$link)){
						for ($i = 1; $i <= $_SESSION["countbasket"]; $i++) {
							$pid = "pid".$i;
							if ($_SESSION["$pid"]){
							$rowp = mysql_fetch_array(mysql_query("SELECT id_order FROM `gcms_orders` WHERE `order_num` = '$registerd' ",$link));
							$pprice = "pprice".$i;
							$pquantity = "pquantity".$i;
							$querycart = "INSERT INTO `gcms_order_carts` (`id_order` ,`id_product`,`p_price` ,`quantity`  ) VALUES ('$rowp[0]' , '$_SESSION[$pid]', '$_SESSION[$pprice]', '$_SESSION[$pquantity]' )";
							if(mysql_query($querycart,$link)){$ok = true;}else{$ok = false;}
							}
						}
						if ($ok){
						// send mail
						require $_SERVER['DOCUMENT_ROOT'].'/gcms/php/file/mail.php';
				
						$subject = "New SHOP Perances" ;
						$text = "
						<div style='font=tahoma' >
						یک خرید در فروشگاه انجام شد
						</div>
						";
						sendmail("$configset[product_email]","sales@perances.com",$text,$subject,$messmail);
						//
						$subject = "Shop Perances.com" ;
						$text = "
						<div style='font=tahoma' >
						سلام $_REQUEST[first_name] $_REQUEST[last_name] <br><br>
						شماره فاکتور  $registerd <br><br>
						$facpr <br><br>
						بسته پستی شما به آدرس زیر ارسال می گردد : <br>
						$addpr <br>

						از خرید شما متشکریم <br>
						<a href='http://Perances.com' >Perances.com</a>
						</div>
						";

						sleep(5);
						sendmail("$_REQUEST[email]","sales@perances.com",$text,$subject,$messmail);
						// end send mail
						for ($i = 1; $i <= $_SESSION["countbasket"]; $i++) {
						$id = "pid".$i;
						$price = "pprice".$i;
						$name = "pname".$i;
						$quantity = "pquantity".$i;
						unset($_SESSION["$id"]);
						unset($_SESSION["$price"]);
						unset($_SESSION["$name"]);
						unset($_SESSION["$quantity"]);
						}
						unset($_SESSION["$countbasket"]);
						$basketpart = "<center><b>اطلاعات شما با موفقیت ارسال شد.فاکتور شما به آدرس ایمیل شما ارسال شده است.<br>با تشکر از خرید شما</b></center>";
						}
					}else{
					// در صورت برخورد با مشکل
					$basketpart = " مشکل در ثبت اطلاعات .... لطفا دوباره تلاش کنید ";
					}
				}else{
				// در صورت برخورد با مشکل
					$basketpart = " مشکل در ثبت اطلاعات .... لطفا دوباره تلاش کنید ";
				}
				
				}
			break;
				
			default:
			echo "<script>window.location='?part=basket';</script>";
		}
	}else{
		if($_REQUEST[pdel]){
			$id = "pid".$_REQUEST[pdel];
			$price = "pprice".$_REQUEST[pdel];
			$name = "pname".$_REQUEST[pdel];
			$quantity = "pquantity".$_REQUEST[pdel];
			unset($_SESSION["$id"]);
			unset($_SESSION["$price"]);
			unset($_SESSION["$name"]);
			unset($_SESSION["$quantity"]);
			
	echo "<script>window.location='?part=basket';</script>";
		}
		if($_REQUEST[apply]){
			for ($i = 1; $i <= $_SESSION["countbasket"]; $i++) {
				$pid = "pid".$i;
				if ($_SESSION["$pid"]){
					$pquantity = "pquantity".$i;
					$p="p".$i;
					if ($_SESSION["$pquantity"] == $_REQUEST[$p] ){
					// do nothing
					}else{
					$_SESSION["$pquantity"]  = $_REQUEST[$p] ;
					}
				}
			}
			
		}
		$basketpart = $basketpart . 
		"
<form  method='post' action='?part=basket&apply=true'>		
<div id='basketdiv' >
	<table >
    	<thead>
        	<th>
            حذف
            </th>
        	<th>
            نام محصول
            </th>
        	<th>
            قیمت واحد
            </th>
        	<th>
            تعداد
            </th>
        	<th>
            قیمت کل
            </th>
        </thead>
		";
		for ($i = 1; $i <= $_SESSION["countbasket"]; $i++) {
		$pid = "pid".$i;
			if ($_SESSION["$pid"]){
			$pprice = "pprice".$i;
			$pname = "pname".$i;
			$pquantity = "pquantity".$i;
			$basketpart = $basketpart . 
			"
			<tr>
				<td>
				<a href='?part=basket&pdel=$i'><div class='basketdel'>&times;</div></a>
				</td>
				<td>
				".$_SESSION["$pname"]."
				</td>
				<td>
				".$_SESSION["$pprice"]."
				</td>
				<td>
				<input type='text' value='".$_SESSION["$pquantity"]."' name='p".$i."' class='basketquantity'  />
				</td>
				<td>
				".$_SESSION["$pquantity"]*$_SESSION["$pprice"]."
				</td>
			</tr>
			";
			$finsum = $finsum + $_SESSION["$pquantity"]*$_SESSION["$pprice"];
			}
		}
		$finalfactor = $finsum - $configset[rebate_bpp_amount] + $configset[cost_bpp] ;
		$basketpart = $basketpart . 
		"
		
    	<tr>
        	<td colspan='3'>
			<input type='submit' value='اعمال تغییرات' class='basketsubmitapply'  />
			</form>
			<form  method='post' action='?part=basket&stage=1'>		
            </td>
        	<td>
            قیمت نهایی
            </td>
        	<td>
            $finsum
            </td>
        </tr>
    	<tr>
        	<td colspan='3'>
			<b>روش پرداخت : </b><br>
			  <select name='payment_type' class='basketselect'>
			  <option  >هنگام دریافت محصول</option>
			  <option  >واریز به بانک</option>
			  </select>
            </td>
        	<td>
            تخفیف نهایی
            </td>
        	<td>
			<input type='hidden' name='rebate_bpp_amount'  value='$configset[rebate_bpp_amount]'  />
            $configset[rebate_bpp_amount] -
            </td>
        </tr>
    	<tr>
        	<td colspan='3'>
			  <select name='bank' class='basketselect'>
			  <option  >صادرات</option>
			  <option  >ملی</option>
			  <option  >سامان</option>
			  <option  >پارسیان</option>
			  <option  >کشاورزی</option>
			  <option  >مسکن</option>
			  <option  >ملت</option>
			  <option  >رفاه</option>
			  <option  >تجارت</option>
			  <option  >سپه</option>
			  </select>
            </td>
        	<td>
            کوپن تخفیف
            </td>
        	<td>
            0 
            </td>
        </tr>
    	<tr>
        	<td colspan='3'>
				<input type='text' value='شماره فیش پرداختی' name='fish' class='basketinput' onFocus=\"if (this.value == 'شماره فیش پرداختی') this.value = '';\"  />
            </td>
        	<td>
			اضافه هزینه
            </td>
        	<td>
			<input type='hidden' name='cost_bpp'  value='$configset[cost_bpp]'  />
			$configset[cost_bpp] +
            </td>
        </tr>
    	<tfoot>
        	<th colspan='3'>
			<input type='submit' value='' class='basketsubmitfinal'  />
			</form>
            </th>
        	<th>
			جمع کل
            </th>
        	<th>
			$finalfactor $configset[currency] 
            </th>
        </tfoot>
     </table>
</div>
		";
	}
/////////////////////////////////////////////////////////////////////////////////////////			
////////////ارسال های محتوای  ////////////////////////////////////////////////////////			
			$gcms->assign('basketpart',$basketpart); 
 ////////////ارسال های محتوای  ////////////////////////////////////////////////////////			
//تعریف منوی فعال
			$menu_active = "?part=product";
			$gcms->assign('menu_active',$menu_active); 
			$gcms->assign('part',"basket"); 
			$gcms->assign('page_title',"سبد خرید"); 
			$gcms->display("index/index.tpl");
}else {
	echo "
		<script>
		window.location='?part=page&id=$configset[first_page]';
		</script>
	";

}


	
	

?>