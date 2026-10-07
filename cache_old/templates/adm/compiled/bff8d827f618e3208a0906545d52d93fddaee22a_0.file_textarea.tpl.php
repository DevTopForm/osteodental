<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:27:02
  from 'file:content/fields/textarea.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8946625dc61_34333138',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bff8d827f618e3208a0906545d52d93fddaee22a' => 
    array (
      0 => 'content/fields/textarea.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8946625dc61_34333138 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><label class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
	<div class="label__content">
		<span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>

		<?php if ($_smarty_tpl->getValue('field')->example) {?>
			<span class="label__text"><?php echo $_smarty_tpl->getValue('field')->example;?>
</span>
		<?php }?>
	</div>


	<span class="label__wrapper <?php if ($_smarty_tpl->getValue('field')->editor) {?>label__wrapper--quill<?php }?>">
		<textarea <?php if ($_smarty_tpl->getValue('field')->editor) {?>data-role="editor"<?php }?> rows="5" class="label__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
"><?php echo $_smarty_tpl->getValue('field')->getValue();?>
</textarea>
    </span>
	<?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
		<span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
	<?php }?>
</label><?php }
}
