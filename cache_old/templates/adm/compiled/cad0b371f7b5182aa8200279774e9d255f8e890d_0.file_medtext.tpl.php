<?php
/* Smarty version 5.8.0, created on 2026-03-02 11:36:17
  from 'file:content/fields/medtext.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a54c0108dba6_30568884',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cad0b371f7b5182aa8200279774e9d255f8e890d' => 
    array (
      0 => 'content/fields/medtext.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a54c0108dba6_30568884 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><label class="label form__input-half <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
	<div class="label__content">
		<span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>

		<?php if ($_smarty_tpl->getValue('field')->example) {?>
			<span class="label__text"><?php echo $_smarty_tpl->getValue('field')->example;?>
</span>
		<?php }?>
	</div>


	<span class="label__wrapper">
      <input type="text" value="<?php echo $_smarty_tpl->getValue('field')->getValue();?>
" class="label__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
" placeholder="<?php echo $_smarty_tpl->getValue('field')->default;?>
">
		<?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
			<span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
		<?php }?>
    </span>
</label><?php }
}
