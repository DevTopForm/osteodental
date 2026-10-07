<?php
/* Smarty version 5.8.0, created on 2026-03-02 11:36:17
  from 'file:content/settings.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a54c01059899_24767484',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'cbbd2f699480b4c0f3e952dbf8b7034c738065b0' => 
    array (
      0 => 'content/settings.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a54c01059899_24767484 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
?><div class="settings">
	<?php if ($_smarty_tpl->getValue('state') == 'edit' || $_smarty_tpl->getValue('state') == 'images') {?>
		<h1 class="h1 settings__h1">Настройки сайта</h1>
		<form class="form  form--980" action="" method="post" enctype="multipart/form-data" rel="settings">
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('fields'), 'field');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach0DoElse = false;
?>
						<?php $_smarty_tpl->renderSubTemplate((('content/fields/').($_smarty_tpl->getValue('field')->field)).('.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				</div>
			</div>
			<div class="form__check-group label form__input-full">
				<button name="save" value="Сохранить" class="btn btn--blue btn--lg" style="width: fit-content;">
					<span>Сохранить</span>
				</button>
			</div>
		</form>

<?php } elseif ($_smarty_tpl->getValue('state') == 'add') {?>
		<h2 class="h1 settings__h1">Добавить поле</h2>
		<form class="form  form--980" action="" method="post" enctype="multipart/form-data" rel="settings">
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					<label class="label form__input-full ">
						<div class="label__content">
							<span class="label__name">Название</span>
						</div>
						<span class="label__wrapper">
							<input type="text" value="" class="label__input" name="title" placeholder="">
						</span>
					</label>

					<label class="label form__input-full ">
						<div class="label__content">
							<span class="label__name">Имя в таблице</span>
						</div>
						<span class="label__wrapper">
							<input type="text" value="" class="label__input" name="name" placeholder="">
						</span>
					</label>

					<label class="label form__input-full ">
						<div class="label__content">
							<span class="label__name">Тип поля</span>
						</div>
						<span class="label__wrapper label__wrapper--select">
							<select class="label__select" name="field">
								<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['types'], 'type_item', false, 'type', 'types', array (
));
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('type')->value => $_smarty_tpl->getVariable('type_item')->value) {
$foreach1DoElse = false;
?>
									<option value="<?php echo $_smarty_tpl->getValue('type');?>
" rel=""><?php echo $_smarty_tpl->getValue('type');?>
</option>
								<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
							</select>
						</span>
					</label>

					<div class="form__check-group label form__input-full">
						<button name="save" value="Сохранить" class="btn btn--blue btn--lg" style="width: fit-content;">
							<span>Сохранить</span>
						</button>
					</div>
				</div>
			</div>
		</form>
	<?php }?>
</div><?php }
}
