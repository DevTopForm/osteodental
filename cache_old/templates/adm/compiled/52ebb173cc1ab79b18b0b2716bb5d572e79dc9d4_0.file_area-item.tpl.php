<?php
/* Smarty version 5.8.0, created on 2026-03-02 12:11:02
  from 'file:scheme/area-item.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a554266eb604_21577321',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '52ebb173cc1ab79b18b0b2716bb5d572e79dc9d4' => 
    array (
      0 => 'scheme/area-item.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a554266eb604_21577321 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\scheme';
?>
<div class="blocks-item blocks__item <?php if ($_smarty_tpl->getValue('area')->blocked) {?>blocks-item--locked<?php }?>">
	<div class="blocks-item__row">
		<span class="blocks-item__name"><?php echo (($tmp = $_smarty_tpl->getValue('area')->title ?? null)===null||$tmp==='' ? "Блока не существует" ?? null : $tmp);?>
</span>
		<?php if ($_smarty_tpl->getValue('area')) {?>
			<span class="blocks-item__place">(<?php echo $_smarty_tpl->getValue('area')->alias;?>
)</span>
			-
			<?php if ($_smarty_tpl->getValue('area')->data->object) {?>
				<span class="blocks-item__name-colored"><?php echo $_smarty_tpl->getValue('area')->data->object->title;?>
</span>
				<span class="blocks-item__place">(<?php echo $_smarty_tpl->getValue('area')->data->object->type->type;?>
)</span>
			<?php } else { ?>
				Раздел не назначен
			<?php }?>
		<?php }?>
	</div>
	<?php if ($_smarty_tpl->getValue('area')) {?>
		<div class="blocks-item__btns">
			<?php if ($_smarty_tpl->getValue('user')->hasAccess('lock')) {?>
				<a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/lock/<?php echo $_smarty_tpl->getValue('node')->id;?>
/<?php echo $_smarty_tpl->getValue('area')->id;?>
" class="btn  blocks-item__lock" aria-label="элемент заблокирован" data-tooltip="заблокировать содержимое">
					<svg fill="none" width="16" height="16">
						<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#lock"></use>
					</svg>
				</a>
			<?php }?>

			<button class="btn  blocks-item__settings2" aria-label="Настройки элемента" data-tooltip="Настройки" data-block-action="edit" data-area="<?php echo $_smarty_tpl->getValue('area')->id;?>
" data-list="<?php echo $_smarty_tpl->getValue('node')->id;?>
">
				<svg fill="none" width="16" height="16">
					<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#settings2"></use>
				</svg>
			</button>

			<?php if ($_smarty_tpl->getValue('area')->data->object && $_smarty_tpl->getValue('area')->data->object->type->has_content) {?>
				<a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/content/list/<?php echo $_smarty_tpl->getValue('area')->data->object->id;?>
" class="btn  blocks-item__pencil" data-tooltip="Редактировать содержимое">
					<svg fill="none" width="16" height="16">
						<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
					</svg>
				</a>
			<?php }?>

			<button class="btn  blocks-item__params" aria-label="Редактировать параметры блока" data-tooltip="Редактировать параметры блока" data-block-action="params" data-area="<?php echo $_smarty_tpl->getValue('area')->id;?>
" data-list="<?php echo $_smarty_tpl->getValue('node')->id;?>
">
				<svg fill="none" width="16" height="16">
					<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#params"></use>
				</svg>
			</button>
		</div>
	<?php }?>
</div>
<?php }
}
