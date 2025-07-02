<?php /* Smarty version 2.6.7, created on 2010-03-05 01:03:04
         compiled from index/top.tpl */ ?>
	<div id="bgmenu" >
		<div id="myslidemenu" class="jqueryslidemenu">
		<ul>
		<?php unset($this->_sections['id']);
$this->_sections['id']['name'] = 'id';
$this->_sections['id']['loop'] = is_array($_loop=$this->_tpl_vars['menu_title']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
		<li><a href="<?php echo $this->_tpl_vars['menu_url'][$this->_sections['id']['index']]; ?>
" ><?php echo $this->_tpl_vars['menu_title'][$this->_sections['id']['index']]; ?>
</a>
		<?php if ($this->_tpl_vars['menu_child_title'][$this->_sections['id']['index']][0]): ?>
		  <ul>
			<?php unset($this->_sections['kd']);
$this->_sections['kd']['name'] = 'kd';
$this->_sections['kd']['loop'] = is_array($_loop=10) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['kd']['show'] = true;
$this->_sections['kd']['max'] = $this->_sections['kd']['loop'];
$this->_sections['kd']['step'] = 1;
$this->_sections['kd']['start'] = $this->_sections['kd']['step'] > 0 ? 0 : $this->_sections['kd']['loop']-1;
if ($this->_sections['kd']['show']) {
    $this->_sections['kd']['total'] = $this->_sections['kd']['loop'];
    if ($this->_sections['kd']['total'] == 0)
        $this->_sections['kd']['show'] = false;
} else
    $this->_sections['kd']['total'] = 0;
if ($this->_sections['kd']['show']):

            for ($this->_sections['kd']['index'] = $this->_sections['kd']['start'], $this->_sections['kd']['iteration'] = 1;
                 $this->_sections['kd']['iteration'] <= $this->_sections['kd']['total'];
                 $this->_sections['kd']['index'] += $this->_sections['kd']['step'], $this->_sections['kd']['iteration']++):
$this->_sections['kd']['rownum'] = $this->_sections['kd']['iteration'];
$this->_sections['kd']['index_prev'] = $this->_sections['kd']['index'] - $this->_sections['kd']['step'];
$this->_sections['kd']['index_next'] = $this->_sections['kd']['index'] + $this->_sections['kd']['step'];
$this->_sections['kd']['first']      = ($this->_sections['kd']['iteration'] == 1);
$this->_sections['kd']['last']       = ($this->_sections['kd']['iteration'] == $this->_sections['kd']['total']);
?> 
			<?php if ($this->_tpl_vars['menu_child_title'][$this->_sections['id']['index']][$this->_sections['kd']['index']]): ?>
			<li>
			<a href="<?php echo $this->_tpl_vars['menu_child_url'][$this->_sections['id']['index']][$this->_sections['kd']['index']]; ?>
" >
			<?php echo $this->_tpl_vars['menu_child_title'][$this->_sections['id']['index']][$this->_sections['kd']['index']]; ?>

			</a>
			</li>
			<?php endif; ?>
			<?php endfor; endif; ?> 
		  </ul>
		  <?php endif; ?>
		  </li>
		<?php endfor; endif; ?>
		</ul>
		<br style="clear: left" />
		</div>
	</div>
	<div id="header" >
	
	</div>
	<div id="bgmenu" >
	<div class="mrq"><marquee  onmouseover=this.stop() onmouseout=this.start() scrollAmount=3 direction="right" >سبد خرید شما</marquee>
</div>
	</div>