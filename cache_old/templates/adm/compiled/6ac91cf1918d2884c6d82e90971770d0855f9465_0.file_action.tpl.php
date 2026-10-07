<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:52:05
  from 'file:content/action.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a56bd53a8021_17961030',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6ac91cf1918d2884c6d82e90971770d0855f9465' => 
    array (
      0 => 'content/action.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/tree-select.tpl' => 1,
  ),
))) {
function content_69a56bd53a8021_17961030 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
if ($_smarty_tpl->getValue('state') == 'list') {?>
	<section class="catalog">
		<h1 class="h1 catalog__h1">Действия администраторов</h1>
		<div class="top"></div>
		<div class="catalog-controls">
			<div class="catalog-controls__btns">
				<a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/add" class="btn btn--blue btn--shrink">
					<svg fill="none" width="16" height="16">
						<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#add"></use>
					</svg>
					<span>Добавить элемент</span>
				</a>
			</div>
		</div>
		<div class="table-wrapper catalog__table">
			<table class="catalog-table">
				<thead>
				<tr>
					<th class="catalog-table__th"><span>Сервисное имя</span></th>
					<th class="catalog-table__th"><span>Название</span></th>
					<th class="catalog-table__th"><span>Класс</span></th>
					<th class="catalog-table__th"><span>Ссылка</span></th>
					<th class="catalog-table__th "></th>
					<th class="catalog-table__th "></th>
					<th class="catalog-table__th "></th>
					<th class="catalog-table__th"><span></span></th>
				</tr>
				</thead>
				<tbody>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
						<tr class="catalog-table__tr js-delete-element">
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->action;?>
</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->title;?>
</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->class;?>
</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->link;?>
</div>
							</td>
							<td class="catalog-table__td">
								<label class=" input-elt">
									<input title="Выводить в меню" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" <?php if ($_smarty_tpl->getValue('item')->menu) {?>checked<?php }?>>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
									<span class="input-elt__text">выбрать ...</span>
								</label>
							</td>

							<td class="catalog-table__td">
								<label class=" input-elt">
									<input title="Выводить информацию" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" <?php if ($_smarty_tpl->getValue('item')->info) {?>checked<?php }?>>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
									<span class="input-elt__text">выбрать ...</span>
								</label>
							</td>

							<td class="catalog-table__td">
								<label class=" input-elt">
									<input title="Настройки доступа" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" <?php if ($_smarty_tpl->getValue('item')->access) {?>checked<?php }?>>
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
/edit/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class="ico-btn" aria-label="Редактировать">
												<svg fill="none" width="21" height="16">
													<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
												</svg>
											</a>

											<a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('item')->id;?>
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
				</tbody>
			</table>
		</div>

	</section>
<?php } else { ?>
	<div class="settings">
		<h1 class="h1 settings__h1">Действия администраторов</h1>
		<form action="" method="post" enctype="multipart/form-data" class="form  form--980">
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Сервисное имя</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->action;?>
" class="label__input" name="action" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Название</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->title;?>
" class="label__input" name="title" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Иконка</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->icon;?>
" class="label__input" name="icon" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Название класса</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->class;?>
" class="label__input" name="class" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Ссылка </span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->link;?>
" class="label__input" name="link" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Относится к</span>
						</div>

						<span class="label__wrapper label__wrapper--select">
							<select class="label__select" name="parent">
								<option value="0" rel="">---</option>
								<?php $_smarty_tpl->renderSubTemplate('file:menu/tree-select.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tree'=>$_smarty_tpl->getValue('data')['action'],'cur_nid'=>$_smarty_tpl->getValue('item')->id,'cur_pid'=>$_smarty_tpl->getValue('item')->parent,'spacer'=>' - '), (int) 0, $_smarty_current_dir);
?>
							</select>
						</span>
					</label>

					<div class="form__check-group label form__input-full">
						<div class="form__check-group-inside">
							<label class="check ">
								<input class="check__input" name="menu" value="1" <?php if ($_smarty_tpl->getValue('item')->menu) {?>checked<?php }?> type="checkbox">
								<span class="check__name">Выводить в меню</span>
							</label>
							<label class="check ">
								<input class="check__input" name="info" value="1" <?php if ($_smarty_tpl->getValue('item')->info) {?>checked<?php }?> type="checkbox">
								<span class="check__name">Есть информер</span>
							</label>
							<label class="check ">
								<input class="check__input" name="access" value="1" <?php if ($_smarty_tpl->getValue('item')->access) {?>checked<?php }?> type="checkbox">
								<span class="check__name">Доступно для настройки доступа</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form__check-group label form__input-full">
				<button name="save" value="Сохранить" type="submit" class="btn btn--blue btn--lg" style="width: fit-content;">
					<span>Сохранить</span>
				</button>
			</div>
		</form>
	</div>
<?php }?>

<?php }
}
