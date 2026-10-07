<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/complex/textarea.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6efc239_75584256',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'efe7ee6f83b27544b9e10c270e6126e5970ccc6c' => 
    array (
      0 => 'content/fields/complex/textarea.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6efc239_75584256 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields\\complex';
?><label class="label input-yt__textarea <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
	<div class="label__content">
		<span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>

		<?php if ($_smarty_tpl->getValue('field')->example) {?>
			<span class="label__text"><?php echo $_smarty_tpl->getValue('field')->example;?>
</span>
		<?php }?>
	</div>


	<span class="label__wrapper js-webspeech <?php if ($_smarty_tpl->getValue('field')->editor) {?>label__wrapper--quill<?php }?>">
		<textarea <?php if ($_smarty_tpl->getValue('field')->editor) {?>data-role="editor"<?php }?> rows="5" class="label__input" name="<?php echo $_smarty_tpl->getValue('name');?>
"><?php echo $_smarty_tpl->getValue('field')->getValue();?>
</textarea>
		<button class="js-webspeech-btn"></button>
    </span>
	<?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
		<span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
	<?php }?>
</label><?php }
}
