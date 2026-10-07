<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:37
  from 'file:content/fields/checkbox.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8941122c635_36957829',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '978bfc6fb065ae7d1f3f9a577caee23ff65b0c72' => 
    array (
      0 => 'content/fields/checkbox.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8941122c635_36957829 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><div class="form__check-group label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
	<label class="check">
		<input class="check__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
" value="1" type="checkbox" <?php if ($_smarty_tpl->getValue('field')->getValue()) {?>checked<?php }?>>
		<?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
			<span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
		<?php }?>
		<span class="check__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>
	</label>
</div><?php }
}
