<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:52:13
  from 'file:content/feedback.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a56bdd84fe17_45987499',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd9e98f43651be3e072d7bd71ccab634c740b9bf2' => 
    array (
      0 => 'content/feedback.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a56bdd84fe17_45987499 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
?>











<?php if ($_smarty_tpl->getValue('state') == 'list') {?>
	<section class="catalog">
		<h1 class="h1 catalog__h1">Входящие</h1>

		<div class="table-wrapper catalog__table">
			<table class="catalog-table">
				<thead>
				<tr>
					<th class="catalog-table__th">
						<span>Дата</span>
					</th>
					<th class="catalog-table__th"><span>Раздел</span></th>
					<th class="catalog-table__th">
						<span>Сообщение</span>
					</th>
					<th class="catalog-table__th"><span>IP</span></th>
					<th class="catalog-table__th"></th>
					<th class="catalog-table__th"></th>
					<th class="catalog-table__th"></th>
				</tr>
				</thead>
				<tbody>
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
						<tr class="catalog-table__tr <?php if (!$_smarty_tpl->getValue('item')->public) {?>catalog-table__tr--action<?php }?>">
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('item')->date,'%d.%m.%Y');?>
&nbsp<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('item')->date,'%H:%M');?>
</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->node->title;?>
</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->html;?>
</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->ip;?>
</div>
							</td>
							<td class="catalog-table__td">
								<a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/feedback/public/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class=" input-elt" title="Отметить как просмотренное">
									<input class="input-elt__input hidden" style="display: none" type="checkbox" value="1" name="digital" <?php if ($_smarty_tpl->getValue('item')->public) {?>checked<?php }?>>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="/adm/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
								</a>
							</td>
							<td class="catalog-table__td">
								<a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/feedback/spam/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class=" input-elt" title="Отметить как спам">
									<input class="input-elt__input hidden" style="display: none" type="checkbox" value="1" name="digital" <?php if ($_smarty_tpl->getValue('item')->spam) {?>checked<?php }?>>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="/adm/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
								</a>
							</td>
							<td class="catalog-table__td">
								<a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/feedback/delete/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class=" ico-btn" aria-label="Удалить" title="Удалить">
									<svg fill="black" width="21" height="16">
										<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
									</svg>
								</a>
							</td>
						</tr>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				</tbody>
			</table>

			<?php echo $_smarty_tpl->getValue('pager');?>

		</div>
	</section>
<?php }
}
}
