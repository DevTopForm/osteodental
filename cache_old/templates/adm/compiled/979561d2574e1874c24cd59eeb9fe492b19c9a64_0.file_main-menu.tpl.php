<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:18
  from 'file:menu/main-menu.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893fe4f3139_54652365',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '979561d2574e1874c24cd59eeb9fe492b19c9a64' => 
    array (
      0 => 'menu/main-menu.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e893fe4f3139_54652365 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\menu';
?><ul class="top-menu">
	<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('menu'), 'item', false, NULL, 'menu', array (
  'first' => true,
  'index' => true,
));
$foreach8DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach8DoElse = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_menu']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_menu']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_menu']->value['index'];
?>
		<li class="top-menu__item <?php if ($_smarty_tpl->getValue('item')->active) {?>active<?php }?>">
			<a href="<?php echo $_smarty_tpl->getValue('adm_path');
echo $_smarty_tpl->getValue('item')->link;?>
" class="top-menu__link" title="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')->title, ENT_QUOTES, 'UTF-8', true);?>
">
				<svg fill="none" width="16" height="16">
					<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#<?php echo $_smarty_tpl->getValue('item')->icon;?>
"></use>
				</svg>
				<span class="top-menu__name"><?php echo $_smarty_tpl->getValue('item')->title;?>
</span>

				<?php if ($_smarty_tpl->getValue('item')->infodata) {?>
					<span class="top-menu__num">
						<?php echo $_smarty_tpl->getValue('item')->infodata;?>

					</span>
				<?php }?>
			</a>

			<?php if ($_smarty_tpl->getValue('item')->childs) {?>
				<ul class="top-menu__subs">
					<?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('item')->childs, 'child', false, NULL, 'children', array (
));
$foreach9DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('child')->value) {
$foreach9DoElse = false;
?>
						<li class="top-menu__sub <?php if ($_smarty_tpl->getValue('child')->active) {?>active<?php }?>">
							<a href="<?php echo $_smarty_tpl->getValue('adm_path');
echo $_smarty_tpl->getValue('child')->link;?>
" class="top-menu__sub-link" title="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('child')->title, ENT_QUOTES, 'UTF-8', true);?>
">
								<svg fill="none" width="16" height="16">
									<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#<?php echo $_smarty_tpl->getValue('child')->icon;?>
"></use>
								</svg>
								<span class="top-menu__name"><?php echo $_smarty_tpl->getValue('child')->title;?>
</span>

							</a>
						</li>
					<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
				</ul>
			<?php }?>
		</li>

		<?php if (($_smarty_tpl->getValue('__smarty_foreach_menu')['first'] ?? null)) {?>
			<li class="top-menu__item js-content-toggler <?php if ($_smarty_tpl->getValue('content')) {?>active opened<?php }?>">
				<div class="top-menu__link" title="Контент">
					<svg fill="none" width="16" height="16">
						<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#content"></use>
					</svg>
					<span class="top-menu__name">Контент</span>
					<div class="btn top-menu__toggler">
						<svg fill="none" width="12" height="7">
							<use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
						</svg>
					</div>
				</div>
			</li>
		<?php }?>
	<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
</ul><?php }
}
