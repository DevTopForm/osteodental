<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:16:48
  from 'file:content/fields/alias.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f1260423ad6_30014065',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ff5ddab225da57cbbe8e5c1ec4b5c1f892e36108' => 
    array (
      0 => 'content/fields/alias.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f1260423ad6_30014065 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><label class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
	<div class="label__content">
		<span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>
		<span class="label__text">(Если поле оставить пустым, ЧПУ сгенерируется автоматически)</span>
	</div>


	<span class="label__wrapper label__wrapper--alias">
		<input type="text" value="<?php echo $_smarty_tpl->getValue('field')->getValue();?>
" class="label__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
" placeholder="<?php echo $_smarty_tpl->getValue('field')->default;?>
">
		<?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
			<span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
		<?php }?>
		<span class="label__text"><?php echo $_smarty_tpl->getValue('node')->url;?>
/<span class="label__alias"><?php echo $_smarty_tpl->getValue('field')->getValue();?>
</span></span>
    </span>
</label><?php }
}
