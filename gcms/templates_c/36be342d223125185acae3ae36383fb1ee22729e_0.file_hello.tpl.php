<?php
/* Smarty version 5.5.1, created on 2025-07-05 12:09:45
  from 'file:hello.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.5.1',
  'unifunc' => 'content_68691609c87a31_31685131',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '36be342d223125185acae3ae36383fb1ee22729e' => 
    array (
      0 => 'hello.tpl',
      1 => 1751717385,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_68691609c87a31_31685131 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = '/home/asaltour/public_html/templates';
?>Hello <?php echo $_smarty_tpl->getValue('foo');?>
!<?php }
}
