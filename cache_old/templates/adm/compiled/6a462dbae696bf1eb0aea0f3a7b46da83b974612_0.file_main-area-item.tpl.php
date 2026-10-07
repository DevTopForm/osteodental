<?php
/* Smarty version 5.8.0, created on 2026-03-02 12:11:02
  from 'file:scheme/main-area-item.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a554266c67e4_40145355',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6a462dbae696bf1eb0aea0f3a7b46da83b974612' => 
    array (
      0 => 'scheme/main-area-item.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a554266c67e4_40145355 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\scheme';
?><div class="blocks-item blocks__item">
	<div class="blocks-item__row">
		<span class="blocks-item__name">Основной контент</span>
	</div>

	<?php if ($_smarty_tpl->getValue('node')->type->has_content) {?>
		<div class="blocks-item__btns">
			<a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/content/list/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="btn  blocks-item__pencil" data-tooltip="Редактировать содержимое">
				<svg fill="none" width="16" height="16">
					<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
				</svg>
			</a>
		</div>
	<?php }?>
</div><?php }
}
