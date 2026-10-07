<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:40:03
  from 'file:../adm/message.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a569030edd06_38035736',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1dc0eafac43c2d57794f364c0bc54f21335035a2' => 
    array (
      0 => '../adm/message.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a569030edd06_38035736 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm';
?><p class="<?php echo $_smarty_tpl->getValue('type');?>
"><?php $_template = new \Smarty\Template('eval:'.$_smarty_tpl->getValue('body'), $_smarty_tpl->getSmarty(), $_smarty_tpl);echo $_template->fetch(); ?></p><?php }
}
