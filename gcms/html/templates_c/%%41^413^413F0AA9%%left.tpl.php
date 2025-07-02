<?php /* Smarty version 2.6.7, created on 2014-02-01 00:32:08
         compiled from index/left.tpl */ ?>
<div class="column leftsb">
            	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "index/menu.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
                
				<?php if (( $this->_tpl_vars['part'] == 'page' && $_GET['id'] == '1' ) || ( $this->_tpl_vars['part'] == 'page' && ! $_GET['id'] )): ?>
				<div class="column" style="margin-left:10px; margin-top:10px;">
                	<div class="bg_top_box1">
                    	<div class="title"><?php echo $this->_tpl_vars['gcms_1_title']; ?>
</div>
                    </div>
                	<div class="bg_mid_box1">
                    	<div class="txt">
						<?php if ($this->_tpl_vars['gcms_1_pic'] != "/gcms/upload/title-images/defultpagepic.jpg"): ?>
						<img src="<?php echo $this->_tpl_vars['gcms_1_pic']; ?>
"  class="left" />
						<?php endif; ?>
                        <?php echo $this->_tpl_vars['gcms_1_content']; ?>

                        <div class="clear"></div>
						</div>
                    </div>
                	<div class="bg_dwn_box1"></div>
                </div>
				<!-- !-->
              	<!-- !-->
				<div class="column" style=" margin-top:10px;">
                	<div class="bg_top_box1">
                    	<div class="title"><?php echo $this->_tpl_vars['gcms_2_title']; ?>
</div>
                    </div>
                	<div class="bg_mid_box1">
                    	<div class="txt">
						<?php if ($this->_tpl_vars['gcms_2_pic'] != "/gcms/upload/title-images/defultpagepic.jpg"): ?>
						<img src="<?php echo $this->_tpl_vars['gcms_2_pic']; ?>
"  class="left" />
						<?php endif; ?>
                        <?php echo $this->_tpl_vars['gcms_2_content']; ?>

                        <div class="clear"></div>
						</div>
                    </div>
                	<div class="bg_dwn_box1"></div>
                </div>
				<!-- !-->
                <div class="clear"></div>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
                <?php if ($this->_tpl_vars['part'] == 'page' && $_GET['id']): ?>
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
					<?php if ($this->_tpl_vars['page_pic'] != "/gcms/upload/title-images/defultpagepic.jpg"): ?>
					<img src="<?php echo $this->_tpl_vars['page_pic']; ?>
"  class="left" />
					<?php endif; ?>
                    <?php echo $this->_tpl_vars['page_content']; ?>

                    <div class="clear"></div>
					<?php if ($this->_tpl_vars['childlist_title']): ?>
                        <?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['childlist_title']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['id']['show'] = true;
$this->_sections['id']['max'] = $this->_sections['id']['loop'];
$this->_sections['id']['step'] = 1;
$this->_sections['id']['start'] = $this->_sections['id']['step'] > 0 ? 0 : $this->_sections['id']['loop']-1;
if ($this->_sections['id']['show']) {
    $this->_sections['id']['total'] = $this->_sections['id']['loop'];
    if ($this->_sections['id']['total'] == 0)
        $this->_sections['id']['show'] = false;
} else
    $this->_sections['id']['total'] = 0;
if ($this->_sections['id']['show']):

            for ($this->_sections['id']['index'] = $this->_sections['id']['start'], $this->_sections['id']['iteration'] = 1;
                 $this->_sections['id']['iteration'] <= $this->_sections['id']['total'];
                 $this->_sections['id']['index'] += $this->_sections['id']['step'], $this->_sections['id']['iteration']++):
$this->_sections['id']['rownum'] = $this->_sections['id']['iteration'];
$this->_sections['id']['index_prev'] = $this->_sections['id']['index'] - $this->_sections['id']['step'];
$this->_sections['id']['index_next'] = $this->_sections['id']['index'] + $this->_sections['id']['step'];
$this->_sections['id']['first']      = ($this->_sections['id']['iteration'] == 1);
$this->_sections['id']['last']       = ($this->_sections['id']['iteration'] == $this->_sections['id']['total']);
?> 
                        <div class="child_page">
                        
                        <img src="<?php echo $this->_tpl_vars['childlist_pic'][$this->_sections['id']['index']]; ?>
"  width="10%" height="10%" class="left" title="<?php echo $this->_tpl_vars['childlist_title'][$this->_sections['id']['index']]; ?>
"/>
                        <b><a href="<?php echo $this->_tpl_vars['childlist_url'][$this->_sections['id']['index']]; ?>
" >
                        <?php echo $this->_tpl_vars['childlist_title'][$this->_sections['id']['index']]; ?>

                        </a></b><br />
                        <?php echo $this->_tpl_vars['childlist_excerpt'][$this->_sections['id']['index']]; ?>
<br />
                        <div style="text-align:left">
                        <a href="<?php echo $this->_tpl_vars['childlist_url'][$this->_sections['id']['index']]; ?>
">ادامه مطلب&hellip;</a>
                        </div>
                        <div class="clear"></div>
                        </div>
                       
                        <?php endfor; endif; ?>  
            
            
             <div id="dpage" ><?php echo $this->_tpl_vars['page']; ?>
</div>
                   <?php endif; ?> 
				 
					<div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
                <?php endif; ?>
				<?php endif; ?>
				<?php if ($this->_tpl_vars['part'] == 'page' && $_GET['id'] != '1'): ?>
				<?php if (! $_GET['id']): ?>
				<script language="JavaScript">setTimeout("top.location.href = '?part=page&id=1	'",0);</script>
				<?php endif; ?>
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
					<?php if ($this->_tpl_vars['page_pic'] != "/gcms/upload/title-images/defultpagepic.jpg"): ?>
					<img src="<?php echo $this->_tpl_vars['page_pic']; ?>
"  class="left" />
					<?php endif; ?>
                    <?php echo $this->_tpl_vars['page_content']; ?>

                    <div class="clear"></div>
                    
					<?php if ($this->_tpl_vars['childlist_title']): ?>
                        <?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['childlist_title']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['id']['show'] = true;
$this->_sections['id']['max'] = $this->_sections['id']['loop'];
$this->_sections['id']['step'] = 1;
$this->_sections['id']['start'] = $this->_sections['id']['step'] > 0 ? 0 : $this->_sections['id']['loop']-1;
if ($this->_sections['id']['show']) {
    $this->_sections['id']['total'] = $this->_sections['id']['loop'];
    if ($this->_sections['id']['total'] == 0)
        $this->_sections['id']['show'] = false;
} else
    $this->_sections['id']['total'] = 0;
if ($this->_sections['id']['show']):

            for ($this->_sections['id']['index'] = $this->_sections['id']['start'], $this->_sections['id']['iteration'] = 1;
                 $this->_sections['id']['iteration'] <= $this->_sections['id']['total'];
                 $this->_sections['id']['index'] += $this->_sections['id']['step'], $this->_sections['id']['iteration']++):
$this->_sections['id']['rownum'] = $this->_sections['id']['iteration'];
$this->_sections['id']['index_prev'] = $this->_sections['id']['index'] - $this->_sections['id']['step'];
$this->_sections['id']['index_next'] = $this->_sections['id']['index'] + $this->_sections['id']['step'];
$this->_sections['id']['first']      = ($this->_sections['id']['iteration'] == 1);
$this->_sections['id']['last']       = ($this->_sections['id']['iteration'] == $this->_sections['id']['total']);
?> 
                        <div class="child_page">
                        <?php if ($this->_tpl_vars['childlist_pic'][$this->_sections['id']['index']] != "/gcms/upload/title-images/defultpagepic.jpg"): ?>
                        <img src="<?php echo $this->_tpl_vars['childlist_pic'][$this->_sections['id']['index']]; ?>
"  width="10%" height="10%" class="left" title="<?php echo $this->_tpl_vars['childlist_title'][$this->_sections['id']['index']]; ?>
"/>
						<?php endif; ?>
                        <b><a href="<?php echo $this->_tpl_vars['childlist_url'][$this->_sections['id']['index']]; ?>
" >
                        <?php echo $this->_tpl_vars['childlist_title'][$this->_sections['id']['index']]; ?>

                        </a></b><br />
                        <?php echo $this->_tpl_vars['childlist_excerpt'][$this->_sections['id']['index']]; ?>
<br />
                        <div style="text-align:left">
                        <a href="<?php echo $this->_tpl_vars['childlist_url'][$this->_sections['id']['index']]; ?>
">ادامه مطلب&hellip;</a>
                        </div>
                        <div class="clear"></div>
                        </div>
                       
                        <?php endfor; endif; ?>  
            
            
             <div id="dpage" ><?php echo $this->_tpl_vars['page']; ?>
</div>
                   <?php endif; ?>
				 
					<div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
                <?php endif; ?>
				<?php if ($this->_tpl_vars['part'] == 'signin'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div>
					<br /><br /><br /><br /><br /><br /><br /><br /><br />
                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
				<?php if ($this->_tpl_vars['part'] == 'admin'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['admin_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
                
				<?php if ($this->_tpl_vars['part'] == 'shipman'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['shipman_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
                
								<?php if ($this->_tpl_vars['part'] == 'portman'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['portman_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
                
								<?php if ($this->_tpl_vars['part'] == 'free'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['free_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
                
				<?php if ($this->_tpl_vars['part'] == 'agency'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['agency_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
                
				<?php if ($this->_tpl_vars['part'] == 'signup'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['signup_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
                
                
				<?php if ($this->_tpl_vars['part'] == 'forgotten'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['forgotten_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
                
                
				<?php if ($this->_tpl_vars['part'] == 'searchtrade'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title">جستجو</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['searchtrade_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2" style="margin-top:-5px" ></div>
				 <!-- !-->
				<?php endif; ?>
                
                
				<?php if ($this->_tpl_vars['part'] == 'buy'): ?>
				
				<div class="header" style="background:url(<?php echo $this->_tpl_vars['gcms_4_pic']; ?>
) no-repeat ;"></div>
				<div class="clear"></div>
				<!-- !-->
               <div class="bg_top_box2">
					<div class="title"><?php echo $this->_tpl_vars['page_title']; ?>
</div>
                </div>
                <div class="bg_mid_box2">
					<div class="txt">
                    <?php if ($this->_tpl_vars['error_message']): ?><div class="error"><?php echo $this->_tpl_vars['error_message']; ?>
</div><?php endif; ?>
                    <?php if ($this->_tpl_vars['success_message']): ?><div class="success"><?php echo $this->_tpl_vars['success_message']; ?>
</div><?php endif; ?>
					<?php echo $this->_tpl_vars['buy_content']; ?>

                    <div class="clear"></div>
					</div>
                 </div>
                 <div class="bg_dwn_box2"></div>
				 <!-- !-->
				<?php endif; ?>
            </div>