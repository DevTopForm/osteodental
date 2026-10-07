<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:35
  from 'file:filters/pager.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8940f1c4bf0_66613190',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9d2d345a1c9d73d9c74496a40d999ce106abf853' => 
    array (
      0 => 'filters/pager.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8940f1c4bf0_66613190 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\filters';
?><div class="pages__pages">
	<?php if ($_smarty_tpl->getValue('pager')['pages'] <= 15) {?>
		<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = min(1, $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), $__section_pager_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
			<a class="pages__page <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) == $_smarty_tpl->getValue('pager')['page']) {?> active<?php }?>" <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) < $_smarty_tpl->getValue('pager')['page']) {?>rel="prev"<?php } elseif (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) > $_smarty_tpl->getValue('pager')['page']) {?>rel="next"<?php }?> href="<?php echo $_smarty_tpl->getValue('pager')['requestUrl'];?>
page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
		<?php
}
}
?>
	<?php } else { ?>
		<?php $_smarty_tpl->assign('second_points', 0, false, NULL);?>
		<?php if ($_smarty_tpl->getValue('pager')['page'] < 6) {?>
			<?php if ($_smarty_tpl->getValue('pager')['page'] == 1) {?>
				<?php $_smarty_tpl->assign('goto', 3, false, NULL);?>
			<?php } else { ?>
				<?php $_smarty_tpl->assign('goto', $_smarty_tpl->getValue('pager')['page']+1, false, NULL);?>
			<?php }?>
			<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = min(1, $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), (int)@$_smarty_tpl->getValue('goto') < 0 ? $__section_pager_0_loop : (int)@$_smarty_tpl->getValue('goto'));
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
				<a class="pages__page <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) == $_smarty_tpl->getValue('pager')['page']) {?> active<?php }?>" <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) < $_smarty_tpl->getValue('pager')['page']) {?>rel="prev"<?php } elseif (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) > $_smarty_tpl->getValue('pager')['page']) {?>rel="next"<?php }?> href="<?php echo $_smarty_tpl->getValue('pager')['requestUrl'];?>
page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
			<?php
}
}
?>
			...
			<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = (int)@$_smarty_tpl->getValue('pager')['pages']-2 < 0 ? max(0, (int)@$_smarty_tpl->getValue('pager')['pages']-2 + $__section_pager_0_loop) : min((int)@$_smarty_tpl->getValue('pager')['pages']-2, $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), 3);
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
				<a class="pages__page" rel="next" href="<?php echo $_smarty_tpl->getValue('pager')['requestUrl'];?>
page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
			<?php
}
}
?>
		<?php } elseif ($_smarty_tpl->getValue('pager')['page'] > $_smarty_tpl->getValue('pager')['pages']-5) {?>
			<?php if ($_smarty_tpl->getValue('pager')['page'] == $_smarty_tpl->getValue('pager')['pages']) {?>
				<?php $_smarty_tpl->assign('goto', $_smarty_tpl->getValue('pager')['pages']-2, false, NULL);?>
			<?php } else { ?>
				<?php $_smarty_tpl->assign('goto', $_smarty_tpl->getValue('pager')['page']-1, false, NULL);?>
			<?php }?>
			<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = min(1, $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), 3);
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
				<a class="pages__page" rel="prev" href="<?php echo $_smarty_tpl->getValue('pager')['requestUrl'];?>
page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
			<?php
}
}
?>
			...
			<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = (int)@$_smarty_tpl->getValue('goto') < 0 ? max(0, (int)@$_smarty_tpl->getValue('goto') + $__section_pager_0_loop) : min((int)@$_smarty_tpl->getValue('goto'), $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), $__section_pager_0_loop);
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
				<a class="pages__page <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) == $_smarty_tpl->getValue('pager')['page']) {?> active<?php }?>" <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) < $_smarty_tpl->getValue('pager')['page']) {?>rel="prev"<?php } elseif (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) > $_smarty_tpl->getValue('pager')['page']) {?>rel="next"<?php }?> href="<?php echo $_smarty_tpl->getValue('pager')['requestUrl'];?>
page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
			<?php
}
}
?>
		<?php } else { ?>
			<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = min(1, $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), 3);
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
				<a class="pages__page" rel="prev" href="?page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
			<?php
}
}
?>
			...
			<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = (int)@$_smarty_tpl->getValue('pager')['page']-1 < 0 ? max(0, (int)@$_smarty_tpl->getValue('pager')['page']-1 + $__section_pager_0_loop) : min((int)@$_smarty_tpl->getValue('pager')['page']-1, $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), 3);
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
				<a class="pages__page <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) == $_smarty_tpl->getValue('pager')['page']) {?> active<?php }?>" <?php if (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) < $_smarty_tpl->getValue('pager')['page']) {?>rel="prev"<?php } elseif (($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null) > $_smarty_tpl->getValue('pager')['page']) {?>rel="next"<?php }?> href=<?php echo $_smarty_tpl->getValue('pager')['requestUrl'];?>
"?page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
			<?php
}
}
?>
			...
			<?php
$__section_pager_0_loop = (is_array(@$_loop=$_smarty_tpl->getValue('pager')['pages']+1) ? count($_loop) : max(0, (int) $_loop));
$__section_pager_0_start = (int)@$_smarty_tpl->getValue('pager')['pages']-2 < 0 ? max(0, (int)@$_smarty_tpl->getValue('pager')['pages']-2 + $__section_pager_0_loop) : min((int)@$_smarty_tpl->getValue('pager')['pages']-2, $__section_pager_0_loop);
$__section_pager_0_total = min(($__section_pager_0_loop - $__section_pager_0_start), 3);
$_smarty_tpl->tpl_vars['__smarty_section_pager'] = new \Smarty\Variable(array());
if ($__section_pager_0_total !== 0) {
for ($__section_pager_0_iteration = 1, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index'] = $__section_pager_0_start; $__section_pager_0_iteration <= $__section_pager_0_total; $__section_pager_0_iteration++, $_smarty_tpl->tpl_vars['__smarty_section_pager']->value['index']++){
?>
				<a class="pages__page" rel="next" href="<?php echo $_smarty_tpl->getValue('pager')['requestUrl'];?>
page=<?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);
echo $_smarty_tpl->getValue('filter');?>
"><?php echo ($_smarty_tpl->getValue('__smarty_section_pager')['index'] ?? null);?>
</a>
			<?php
}
}
?>
		<?php }?>
	<?php }?>
</div>
<?php }
}
