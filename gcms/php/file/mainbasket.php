<?php
//session_start(); 
		$mainbasketpart = $mainbasketpart . 
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
			$mainbasketpart = $mainbasketpart . 
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
		$mainbasketpart = $mainbasketpart . 
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
			  <option  >پرسیان</option>
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
			<input type='submit' value='خرید نهایی' class='basketsubmitfinal'  />
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
/////////////////////////////////////////////////////////////////////////////////////////			
////////////ارسال های محتوای  ////////////////////////////////////////////////////////			
			$gcms->assign('mainbasketpart',$mainbasketpart); 
 ////////////ارسال های محتوای  ////////////////////////////////////////////////////////			

?>