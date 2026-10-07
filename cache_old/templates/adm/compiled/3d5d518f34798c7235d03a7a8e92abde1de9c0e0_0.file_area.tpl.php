<?php
/* Smarty version 5.8.0, created on 2026-03-02 12:11:04
  from 'file:ajax/area.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a55428a393e1_04765235',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3d5d518f34798c7235d03a7a8e92abde1de9c0e0' => 
    array (
      0 => 'ajax/area.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a55428a393e1_04765235 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\ajax';
if ($_smarty_tpl->getValue('state') == 'edit') {?>
	<div class="panel">
		<div class="panel__name">Свойства области</div>
		<form class="form" action="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/edit/<?php echo $_smarty_tpl->getValue('node')->id;?>
/<?php echo $_smarty_tpl->getValue('area')->id;?>
" method="post">
			<div class="form__fieldset-column login-block__fieldset">
				<label class="label form__input-column">
					<div class="label__content">
						<span class="label__name">Тип раздела</span>
					</div>
					<span class="label__wrapper label__wrapper--select">
						<select class="label__select" name="node_type">
							<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['type'], 'type');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('type')->value) {
$foreach0DoElse = false;
?>
								<?php $_smarty_tpl->assign('itemType', $_smarty_tpl->getValue('type')->type, false, NULL);?>
								<?php if ($_smarty_tpl->getValue('data')['template'][$_smarty_tpl->getValue('itemType')]) {?>
									<option value="<?php echo $_smarty_tpl->getValue('type')->type;?>
"<?php if ($_smarty_tpl->getValue('type')->type == $_smarty_tpl->getValue('nodeArea')->object->type->type) {?> selected="selected"<?php }?> ><?php echo $_smarty_tpl->getValue('type')->title;?>
</option>
								<?php }?>
							<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
						</select>
        			</span>
				</label>
				<label class="label form__input-column">
					<div class="label__content">
						<span class="label__name">Раздел</span>
					</div>
					<span class="label__wrapper label__wrapper--select">
						<select class="label__select" name="node_id">
							<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['nodes'], 'node');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('node')->value) {
$foreach1DoElse = false;
?>
								<option <?php if (!$_smarty_tpl->getValue('nodeArea') || $_smarty_tpl->getValue('nodeArea')->object->type->type != $_smarty_tpl->getValue('node')->type->type) {?>disabled<?php }?> class="<?php echo $_smarty_tpl->getValue('node')->type->type;?>
" value="<?php echo $_smarty_tpl->getValue('node')->id;?>
" <?php if ($_smarty_tpl->getValue('nodeArea') && $_smarty_tpl->getValue('node')->id == $_smarty_tpl->getValue('nodeArea')->object->id) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('node')->title;?>
</option>
							<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
						</select>
					</span>
				</label>
				<label class="label form__input-column">
					<div class="label__content">
						<span class="label__name">Шаблон в блок</span>
					</div>
					<span class="label__wrapper label__wrapper--select">
						<select class="label__select" name="node_template">
							 <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['template'], 'templates', false, 'tpl_key');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('tpl_key')->value => $_smarty_tpl->getVariable('templates')->value) {
$foreach2DoElse = false;
?>
								 <optgroup label="<?php echo $_smarty_tpl->getValue('tpl_key');?>
">
									 <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('templates'), 'tpl');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('tpl')->value) {
$foreach3DoElse = false;
?>
										 <option <?php if (!$_smarty_tpl->getValue('nodeArea') || $_smarty_tpl->getValue('nodeArea')->object->type->type != $_smarty_tpl->getValue('tpl')->type) {?>disabled<?php }?> class="<?php echo $_smarty_tpl->getValue('tpl')->type;?>
" value="<?php echo $_smarty_tpl->getValue('tpl')->id;?>
" <?php if ($_smarty_tpl->getValue('nodeArea') && $_smarty_tpl->getValue('tpl')->id == $_smarty_tpl->getValue('nodeArea')->template) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('tpl')->title;?>
</option>
									 <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
								 </optgroup>
							 <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
	  					</select>
        			</span>
				</label>
			</div>
			<div class="form__fieldset-inputs">
				<label class="check form__check">
					<input class="check__input" name="allsub" value="1" type="checkbox">
					<span class="check__name">Применить ко всем подразделам</span>
				</label>
				<label class="check form__check">
					<input class="check__input" name="all" value="1" type="checkbox">
					<span class="check__name">Применить на всем сайте</span>
				</label>
			</div>
			<div class="form__add-btns">
				<a class="form__add-link" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/delete/<?php echo $_smarty_tpl->getValue('nodeArea')->id;?>
" rel="Поиск">Отвязать</a>
				<a class="form__add-link" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/deletesub/<?php echo $_smarty_tpl->getValue('nodeArea')->id;?>
">Отвязать в подразделах</a>
				<a class="form__add-link" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/deleteall/<?php echo $_smarty_tpl->getValue('nodeArea')->id;?>
">Отвязать на всем сайте</a>
			</div>
			<button name="save" value="Сохранить" class="btn btn--blue btn--lg ">
				<span>Сохранить</span>
			</button>
		</form>
	</div>
<?php } elseif ($_smarty_tpl->getValue('state') == 'params') {?>
	<div class="panel">
		<h3><?php echo $_smarty_tpl->getValue('_LNG_ADM')['BLOCK_PARAMS'];?>
</h3>

		<?php if ($_smarty_tpl->getValue('messages')) {?>
			<div class="messages">
				<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('messages'), 'message');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('message')->value) {
$foreach4DoElse = false;
?>
					<?php echo $_smarty_tpl->getValue('message')->html;?>

				<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
			</div>
		<?php }?>
		<?php if ($_smarty_tpl->getValue('fields')) {?>
			<form id="block-properties" action="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/params/<?php echo $_smarty_tpl->getValue('nodeArea')->id;?>
" method="post" enctype="multipart/form-data">
				<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('fields'), 'field');
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach5DoElse = false;
?>
					<?php $_smarty_tpl->renderSubTemplate((('content/fields/').($_smarty_tpl->getValue('field')->field)).('.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
				<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				<p></p>
				<div id="area-actions">
					<button name="save" value="<?php echo $_smarty_tpl->getValue('_LNG_ADM')['SAVE'];?>
" class="btn btn--blue btn--lg ">
						<span><?php echo $_smarty_tpl->getValue('_LNG_ADM')['SAVE'];?>
</span>
					</button>
				</div>
			</form>
		<?php } else { ?>
			<p><?php echo $_smarty_tpl->getValue('_LNG_ADM')['EMPTY_SETTINGS_LIST'];?>
</p>
		<?php }?>
	</div>
<?php }
}
}
