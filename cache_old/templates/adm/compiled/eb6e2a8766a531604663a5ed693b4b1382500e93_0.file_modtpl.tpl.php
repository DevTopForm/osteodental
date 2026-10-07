<?php
/* Smarty version 5.8.0, created on 2026-02-25 13:42:19
  from 'file:content/modtpl.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699ed20b8cef01_80681481',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'eb6e2a8766a531604663a5ed693b4b1382500e93' => 
    array (
      0 => 'content/modtpl.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/module-actions.tpl' => 2,
  ),
))) {
function content_699ed20b8cef01_80681481 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
if ($_smarty_tpl->getValue('state') == 'list') {?>
	<section class="catalog">
		<div class="catalog__item-top">
			<?php $_smarty_tpl->renderSubTemplate('file:menu/module-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('type'=>$_smarty_tpl->getValue('module'),'active'=>'template'), (int) 0, $_smarty_current_dir);
?>
		</div>
		<h1 class="h1 catalog__h1">Шаблоны</h1>
		<div class="catalog-controls">
			<div class="catalog-controls__btns">
				<a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/add/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="btn btn--blue btn--shrink">
					<svg fill="none" width="16" height="16">
						<use xlink:href="/adm/assets/img/sprite.svg#add"></use>
					</svg>
					<span>Добавить Поле</span>
				</a>
			</div>
		</div>
		<div class="table-wrapper catalog__table">
			<table class="catalog-table">
				<thead>
				<tr>
					<th class="catalog-table__th"><span>Название</span></th>
					<th class="catalog-table__th"><span>Название файл</span></th>
					<th class="catalog-table__th "><span>Доступен в блоке</span></th>
					<th class="catalog-table__th "></th>
				</tr>
				</thead>
				<tbody>
				<?php if ($_smarty_tpl->getValue('list')) {?>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
						<tr class="catalog-table__tr js-delete-element">
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->title;?>
</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->file;?>
</div>
							</td>
							<td class="catalog-table__td">
								<label class=" input-elt">

									<input
											data-id="1"
											data-node="1"
											class="input-elt__input ajax-node-field"
											type="checkbox"
											value="1"
											name="in_block"
											<?php if ($_smarty_tpl->getValue('item')->in_block) {?>checked<?php }?>
									>
									<span class="input-elt__fake">
                                            <svg fill="none" width="21" height="16">
                                                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
                                            </svg>
                                        </span>
									<span class="input-elt__text">выбрать ...</span>
								</label>
							</td>
							<td class="catalog-table__td" data-position="right">
								<div class="jsFixed">
									<div class="catalog-item__controls">
										<div class="ico-btns catalog-item__btns">
											<a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/edit/<?php echo $_smarty_tpl->getValue('module')->id;?>
/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class="ico-btn" aria-label="Редактировать">
												<svg fill="none" width="21" height="16">
													<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
												</svg>
											</a>

											<a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('module')->id;?>
/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class="ico-btn js-delete" data-name="<?php echo $_smarty_tpl->getValue('item')->title;?>
" aria-label="Удалить">
												<svg fill="none" width="21" height="16">
													<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
												</svg>
											</a>
										</div>
									</div>
								</div>
							</td>
						</tr>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				<?php }?>
				</tbody>
			</table>
		</div>
	</section>
<?php } elseif ($_smarty_tpl->getValue('state') == 'add' || $_smarty_tpl->getValue('state') == 'edit') {?>
	<section class="catalog">
		<div class="catalog__item-top">
			<div class="item-controls js-to-expand">
				<a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/list/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="btn btn--link item-controls__back">
					<svg fill="none" width="12" height="12">
						<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
					</svg>
					<span>В список</span>
				</a>
				<button class="btn btn--link item-controls__more js-expand " aria-label="Открыть кнопки">
					<svg fill="none" width="34" height="8">
						<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#dots"></use>
					</svg>
				</button>
				<div class="item-controls__short">
					<div class="item-controls__group">
					</div>
				</div>
				<button form="form-fields" type="submit" name="save" value="Сохранить" class="btn btn--blue btn--lg">
					<span>Сохранить</span>
				</button>
			</div>
			<?php if ($_smarty_tpl->getValue('item')->type) {
$_smarty_tpl->renderSubTemplate('file:menu/module-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('type'=>$_smarty_tpl->getValue('module'),'active'=>'template'), (int) 0, $_smarty_current_dir);
}?>
		</div>
		<h1 class="h1 catalog__h1">Шаблоны</h1>
		<form id="form-fields" class="form  form--980" action="" method="post" enctype="multipart/form-data">
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['fields'], 'field', false, 'field_key');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field_key')->value => $_smarty_tpl->getVariable('field')->value) {
$foreach1DoElse = false;
?>
						<?php if ($_smarty_tpl->getValue('field')['type'] == 'select') {?>
							<label class="label form__input-full">
								<div class="label__content">
									<span class="label__name"><?php echo $_smarty_tpl->getValue('field')['title'];?>
</span>
								</div>

								<span class="label__wrapper label__wrapper--select">
                            <select class="label__select" name="<?php echo $_smarty_tpl->getValue('field_key');?>
">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('field')['data'], 'option');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('option')->value) {
$foreach2DoElse = false;
?>
									<option value="<?php echo $_smarty_tpl->getValue('option')->id;?>
" <?php if ($_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('field_key')} == $_smarty_tpl->getValue('option')->id) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('option')->title;?>
</option>
								<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </select>
                        </span>
							</label>
						<?php } elseif ($_smarty_tpl->getValue('field')['type'] == 'checkbox') {?>
							<div class="form__check-group label form__input-full">
								<div class="form__check-group-inside">
									<label class="check ">
										<input class="check__input" name="<?php echo $_smarty_tpl->getValue('field_key');?>
"  <?php if ($_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('field_key')}) {?>checked<?php }?> value="1" type="checkbox">
										<span class="check__name"><?php echo $_smarty_tpl->getValue('field')['title'];?>
</span>
									</label>
								</div>
							</div>
						<?php } else { ?>
							<label class="label form__input-full">
								<div class="label__content">
									<span class="label__name"><?php echo $_smarty_tpl->getValue('field')['title'];?>
</span>
								</div>
								<span class="label__wrapper">
                            <input name="<?php echo $_smarty_tpl->getValue('field_key');?>
" type="text" class="label__input" value="<?php if ($_POST[$_smarty_tpl->getValue('field_key')]) {
echo $_POST[$_smarty_tpl->getValue('field_key')];
} else {
echo $_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('field_key')};
}?>" placeholder="">
                        </span>
							</label>
						<?php }?>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				</div>
			</div>
		</form>
	</section>
<?php }
}
}
