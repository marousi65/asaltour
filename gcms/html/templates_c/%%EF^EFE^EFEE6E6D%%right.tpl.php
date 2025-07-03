<?php /* Smarty version 2.6.7, created on 2024-02-06 06:31:44
         compiled from index/right.tpl */ ?>
		
	<div class="column rightsb">
				<div class="header_R" style="background:url(<?php echo $this->_tpl_vars['gcms_3_pic']; ?>
) no-repeat ;"></div>
				<!--  !-->
				<div class="bg_top_box3"></div>
				<div class="bg_mid_box3">
					<div id="pettabs" class="indentmenu">
                        <ul>
                        <li><a href="#" rel="dog1" class="selected">مسافربری</a></li>
                        <li><a href="#" rel="dog2">لندیگرافت</a></li>
                        </ul>
                        <br style="clear: left" />
                        </div>
                        
                        <div style="border:0px solid #FFFF00; background: #67281f; width:195px; padding: 5px; margin-bottom:0; 						margin-right:5px">
                        
                        <div id="dog1" class="tabcontent">
                        
						<form action="?part=searchtrade&trade=psngr" method="post" >
                        مبدا حرکت&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="slct"  name="mbd">
						<?php echo $this->_tpl_vars['slct_des']; ?>

						</select>
						<br />
                        مقصد حرکت&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="slct"  name="mgh">
						<?php echo $this->_tpl_vars['slct_des']; ?>

						</select>
						<br />
                        نام کشتیرانی&nbsp;&nbsp;
						<select id="slct"  name="sai">
						<?php echo $this->_tpl_vars['slct_sailing']; ?>

						</select>
						<br />
						انتخاب تاریخ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="slct" name="mah">
						<?php echo $this->_tpl_vars['s_trx']; ?>

						</select>
						<div class="clear"></div>
						<input type="submit" value="جستجو" id="s_btt"/>
						</form>
						<br />
						
						<center><a href="?part=page&id=16" >راهنمای استفاده از سایت</a></center>
						<center><a href="?part=page&id=17" >قوانین و مقررات</a></center>
                        </div>
                        
                        <div id="dog2" class="tabcontent">
						<form action="?part=searchtrade&trade=car" method="post" >
                        مبدا حرکت&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="slct" name="mbd">
						<?php echo $this->_tpl_vars['slct_des']; ?>

						</select>
						<br />
                        مقصد حرکت&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="slct" name="mgh">
						<?php echo $this->_tpl_vars['slct_des']; ?>

						</select>
						<br />
                        نام کشتیرانی&nbsp;&nbsp;
						<select id="slct" name="sai">
						<?php echo $this->_tpl_vars['slct_sailing']; ?>

						</select>
						<br />
						انتخاب تاریخ&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
						<select id="slct" name="mah">
						<?php echo $this->_tpl_vars['s_trx']; ?>

						</select>
						<div class="clear"></div>
						<input type="submit" value="جستجو" id="s_btt"/>
						</form>
						<br />
						
						<center><a href="?part=page&id=16" >راهنمای استفاده از سایت</a></center>
						<center><a href="?part=page&id=17" >قوانین و مقررات</a></center>
                            
                        </div>
                        </div>
                        
                        
                        <script type="text/javascript">
                        
                        var mypets=new ddtabcontent("pettabs")
                        mypets.setpersist(true)
                        mypets.setselectedClassTarget("link")
                        mypets.init(1000000)
                        
                        </script>
				</div>
				<div class="bg_dwn_box3"></div>
				<!--  !-->
				 <?php if (! $this->_tpl_vars['g_id_login']): ?>
                <!-- box4 !-->
				<div class="bg_top_box4">
					<div class="title">ورود به سایت</div>
				</div>
				<div class="bg_mid_box4">
					<div class="txt">
					<form  action="?part=signin&signin=true" method="post" >
					ایمیل&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" id="g_username" name="email"  class='email2' /><br />
                    کلمه عبور&nbsp;&nbsp;&nbsp;<input type="password" id="g_username" name="pass"  class='reqd2' /><br />
                    <input type="submit" value="ورود" id="g_btt" onMouseDown='initForms2()'  />
					</form>
					<br />
					<center><a href="?part=signup&signup=step1" >ثبت نام کاربر جدید</a></center>
					<center><a href="?part=forgotten&forgotten=step1" >فراموش کردن رمز عبور</a></center>
					</div>
				</div>
				<div class="bg_dwn_box4"></div>
				<!-- box4 !-->
				<?php else: ?>
				<!-- box4 !-->
				<div class="bg_top_box4">
					<div class="title"> منوی کاربران </div>
				</div>
				<div class="bg_mid_box4">
					<div class="txt">
					<?php if ($this->_tpl_vars['g_t_login'] == 'admin'): ?>
					مدیر کل <?php echo $this->_tpl_vars['g_name_login']; ?>
 خوش آمدید. <br />
					<b>ایجاد</b><br />
					<div class="arr"><a href="?part=admin&admin=new&new=agency">معرفی آژانس جدید</a></div>
					<div class="arr"><a href="?part=admin&admin=new&new=shipman">معرفی مدیر کشتیرانی جدید</a></div>
					<div class="arr"><a href="?part=admin&admin=new&new=portman">معرفی مدیر بندر جدید</a></div>
					<div class="arr"><a href="?part=admin&admin=new&new=des">معرفی مبدا و مقصد جدید</a></div>
					<div class="arr"><a href="?part=admin&admin=new&new=sailing">معرفی کشتی رانی جدید</a></div>
					<b>لیست</b><br />
					<div class="arr"><a href="?part=admin&admin=list&list=free">لیست کاربران</a></div>
					<div class="arr"><a href="?part=admin&admin=list&list=agency">لیست آژانس ها</a></div>
					<div class="arr"><a href="?part=admin&admin=list&list=shipman">لیست مدیران کشتیرانی</a></div>
					<div class="arr"><a href="?part=admin&admin=list&list=portman">لیست مدیران بنادر</a></div>
					<div class="arr"><a href="?part=admin&admin=list&list=des">لیست مبدا و مقصد ها</a></div>
					<div class="arr"><a href="?part=admin&admin=list&list=sailing">لیست کشتیرانی</a></div>
					<div class="arr"><a href="?part=admin&admin=list&list=prdxt">لیست واریزی</a></div>
					<div class="arr"><a href="?part=admin&admin=list&list=cancel">لیست کنسلی ها</a></div>
					<b>گزارشات</b><br />
					<div class="arr"><a href="?part=admin&admin=report&report=zlist">گزارش لیست ظرفیت</a></div>
					<div class="arr"><a href="?part=admin&admin=report&report=nlist">گزارش لیست اسامی مسافرین</a></div>
					<div class="arr"><a href="?part=admin&admin=report&report=cncl">گزارش کنسلی</a></div>
					<div class="arr"><a href="?part=admin&admin=report&report=mcncl">گزارش کنسلی مسیر</a></div>
					<div class="arr"><a href="/gcms/report.php?report=agncy" target="_blank" >گزارش عملکرد آژانس</a></div>
					<div class="arr"><a href="?part=admin&admin=report&report=alist">گزارش لیست فروش آژانس ها</a></div>
					<div class="arr"><a href="?part=admin&admin=report&report=user">گزارش کاربران</a></div>
					<b>پروفایل</b><br />
					<div class="arr"><a href="?part=admin&admin=edit&edit=profile">تغییر اطلاعات شخصی</a></div>
					<div class="arr"><a href="?part=admin&admin=edit&edit=pass">تغییر کلمه عبور</a></div>
					<b>بک آپ</b><br />
					<div class="arr"><a href="http://asaltour.ir/gcms/php/file/phpMyBackup/1saat.php" target="_blank" >بک آپ دیتا بیس</a></div>

					<?php endif; ?>
					<?php if ($this->_tpl_vars['g_t_login'] == 'shipman'): ?>
					مدیر کشتیرانی <?php echo $this->_tpl_vars['g_name_login']; ?>
 <br /> خوش آمدید. <br />
					<b>ایجاد</b><br />
					<div class="arr"><a href="?part=shipman&shipman=new&new=car">معرفی گروه ماشین جدید</a></div>
					<div class="arr"><a href="?part=shipman&shipman=new&new=cartrade">معرفی مسیر لندیگرافت جدید</a></div>
					<div class="arr"><a href="?part=shipman&shipman=new&new=psngrtrade">معرفی مسیر مسافرتی جدید</a></div>
					<b>لیست</b><br />
					<div class="arr"><a href="?part=shipman&shipman=list&list=car">لیست گروه ماشین ها</a></div>
					<div class="arr"><a href="?part=shipman&shipman=list&list=cartrade">لیست مسیرهای لندیگرافت</a></div>
					<div class="arr"><a href="?part=shipman&shipman=list&list=psngrtrade">لیست مسیرهای مسافرتی</a></div>
					<b>گزارشات</b><br />
					<div class="arr"><a href="?part=shipman&shipman=report&report=zlist">گزارش لیست ظرفیت</a></div>
					<div class="arr"><a href="?part=shipman&shipman=report&report=nlist">گزارش لیست اسامی مسافرین</a></div>
					<!-- <div class="arr"><a href="?part=shipman&shipman=report&report=cncl">گزارش کنسلی</a></div>
					<div class="arr"><a href="?part=shipman&shipman=report&report=mcncl">گزارش کنسلی مسیر</a></div> -->

					<b>پروفایل</b><br />
					<div class="arr"><a href="?part=shipman&shipman=edit&edit=profile">تغییر اطلاعات شخصی</a></div>
					<div class="arr"><a href="?part=shipman&shipman=edit&edit=pass">تغییر کلمه عبور</a></div>

					<?php endif; ?>
					<?php if ($this->_tpl_vars['g_t_login'] == 'portman'): ?>
					مدیر بنادر <?php echo $this->_tpl_vars['g_name_login']; ?>
 <br /> خوش آمدید. <br />
					
					<b>گزارشات</b><br />
					<div class="arr"><a href="?part=portman&portman=report&report=zlist">گزارش لیست ظرفیت</a></div>
					<div class="arr"><a href="?part=portman&portman=report&report=nlist">گزارش لیست اسامی مسافرین</a></div>
					 <div class="arr"><a href="?part=portman&portman=report&report=cncl">گزارش کنسلی</a></div>
					<div class="arr"><a href="?part=portman&portman=report&report=mcncl">گزارش کنسلی مسیر</a></div>

					<b>پروفایل</b><br />
					<div class="arr"><a href="?part=portman&portman=edit&edit=profile">تغییر اطلاعات شخصی</a></div>
					<div class="arr"><a href="?part=portman&portman=edit&edit=pass">تغییر کلمه عبور</a></div>

					<?php endif; ?>
					
					<?php if ($this->_tpl_vars['g_t_login'] == 'free'): ?>
					کاربر گرامی <?php echo $this->_tpl_vars['g_name_login']; ?>
 <br /> خوش آمدید. <br />
                    اعتبار شما : <?php echo $this->_tpl_vars['u_amount']; ?>
 ريال<br />
                    <div class="arr"><a href="?part=free&free=retry&retry=amount">افزایش اعتبار</a></div>
                    <br />
					<b>لیست</b><br />
					<div class="arr"><a href="?part=free&free=list&list=psngrtrade	">لیست خریدهای بلیط مسافربری</a></div>
					<div class="arr"><a href="?part=free&free=list&list=cartrade">لیست خریدهای بلیط لندیگرافت</a></div>
					<b>پروفایل</b><br />
					<div class="arr"><a href="?part=free&free=print&print=card">صدور کارت عضویت</a></div>
					<div class="arr"><a href="?part=free&free=edit&edit=profile">تغییر اطلاعات شخصی</a></div>
					<div class="arr"><a href="?part=free&free=edit&edit=pass">تغییر کلمه عبور</a></div>

					<?php endif; ?>
					<?php if ($this->_tpl_vars['g_t_login'] == 'agency'): ?>
					مدیر آژانس  <b><?php echo $this->_tpl_vars['g_agency_name']; ?>
</b> ،
					<em><?php echo $this->_tpl_vars['g_name_login']; ?>
 </em>،
					 خوش آمدید. <br />
					<b>جستجو</b><br />
					<div class="arr"><a href="?part=agency&agency=old">جستجوی مسافر</a></div>
					<b>لیست</b><br />
					<div class="arr"><a href="?part=agency&agency=list&list=psngrtrade	">لیست خریدهای بلیط مسافربری</a></div>
					<div class="arr"><a href="?part=agency&agency=list&list=cartrade">لیست خریدهای بلیط لندیگرافت</a></div>
					<b>گزارشات</b><br />
					<div class="arr"><a href="?part=agency&agency=report&report=zlist">گزارش لیست ظرفیت</a></div>
					<!-- <div class="arr"><a href="?part=agency&agency=report&report=cncl">گزارش کنسلی</a></div>
					<div class="arr"><a href="?part=agency&agency=report&report=mcncl">گزارش کنسلی مسیر</a></div> -->
					<div class="arr"><a href="?part=agency&agency=report&report=alist">گزارش لیست فروش آژانس ها</a></div>
					<b>پروفایل</b><br />
					<div class="arr"><a href="?part=agency&agency=prdxt">پرداخت بدهی آنلاین</a></div>
					<div class="arr"><a href="?part=agency&agency=edit&edit=profile">تغییر اطلاعات شخصی</a></div>
					<div class="arr"><a href="?part=agency&agency=edit&edit=pass">تغییر کلمه عبور</a></div>
					<br />
					<?php if ($this->_tpl_vars['g_customer_name_buy']): ?>
					خرید برای مشتری قبلی : <br />
					 <?php echo $this->_tpl_vars['g_customer_name_buy']; ?>
 - <a href="?part=agency&agency=old&del=true">حذف از لیست خرید</a>
					<br />
					<?php endif; ?>
					<br />
					کل اعتبار&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $this->_tpl_vars['g_agency_credit']; ?>
 ریال  <br />
					اعتبار مصرفی&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <?php echo $this->_tpl_vars['g_agency_use']; ?>
 ریال  <br />
					باقی مانده اعتبار&nbsp;: <?php echo $this->_tpl_vars['baghimande_poll']; ?>
 ریال
					<?php endif; ?>
					<br />
					<div class="arr"><a href="?part=signin&signout=true">خروج</a></div>
					
					<div class="clear"></div>
					</div>
				</div>
				<div class="bg_dwn_box4"></div>
				<!-- box4 !-->
				<?php endif; ?>
				

                <!-- box4 !-->
				<div class="bg_top_box4">
					<div class="title"><?php echo $this->_tpl_vars['gcms_5_title']; ?>
</div>
				</div>
				<div class="bg_mid_box4">
					<div class="txt">
					<?php echo $this->_tpl_vars['gcms_5_content']; ?>

					<div class="clear"></div>
					</div>
				</div>
				<div class="bg_dwn_box4">
				</div>
				<!-- box4 !-->

                <!-- box4 !-->
				<div class="bg_top_box4">
					<div class="title">نماد اعتماد الکترونیک</div>
				</div>
				<div class="bg_mid_box4">
					<div class="txt">
					    	            <a referrerpolicy='origin' target='_blank' href='https://trustseal.enamad.ir/?id=460043&Code=jhkwXLLCYM0opXDAdx5Dw1JxqjHkwCoV'><img referrerpolicy='origin' src='https://trustseal.enamad.ir/logo.aspx?id=460043&Code=jhkwXLLCYM0opXDAdx5Dw1JxqjHkwCoV' alt='' style='cursor:pointer' Code='jhkwXLLCYM0opXDAdx5Dw1JxqjHkwCoV'></a>
					<div class="clear"></div>
					</div>
				</div>
				<div class="bg_dwn_box4">
				</div>


            </div>
            
            
            
            
            
            
            <div class="clear"></div>
        </div>