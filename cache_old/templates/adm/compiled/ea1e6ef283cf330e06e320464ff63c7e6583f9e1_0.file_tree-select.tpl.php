<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:52:08
  from 'file:menu/tree-select.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a56bd8d36f61_19751042',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea1e6ef283cf330e06e320464ff63c7e6583f9e1' => 
    array (
      0 => 'menu/tree-select.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/tree-select.tpl' => 2,
  ),
))) {
function content_69a56bd8d36f61_19751042 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\menu';
if (!$_smarty_tpl->getValue('space')) {
$_smarty_tpl->assign('space', $_smarty_tpl->getValue('spacer'), false, NULL);
}
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('tree'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
	<?php if ($_smarty_tpl->getValue('item')->menu) {?>
		<option value="<?php echo $_smarty_tpl->getValue('item')->id;?>
"<?php if ($_smarty_tpl->getValue('item')->id == $_smarty_tpl->getValue('cur_nid') || $_smarty_tpl->getValue('disabled')) {?> disabled="true"<?php }
if ($_smarty_tpl->getValue('item')->id == $_smarty_tpl->getValue('cur_pid')) {?> selected="true"<?php }?>><?php echo $_smarty_tpl->getValue('space');
echo $_smarty_tpl->getValue('item')->title;?>
</option>
		<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('item')->childs) > 0) {?>
		<?php if ($_smarty_tpl->getValue('item')->id == $_smarty_tpl->getValue('cur_nid') || $_smarty_tpl->getValue('disabled')) {
$_smarty_tpl->assign('dis', true, false, NULL);
}?>
		<?php $_smarty_tpl->renderSubTemplate('file:menu/tree-select.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tree'=>$_smarty_tpl->getValue('item')->childs,'space'=>($_smarty_tpl->getValue('space')).($_smarty_tpl->getValue('spacer')),'cur_nid'=>$_smarty_tpl->getValue('cur_nid'),'cur_pid'=>$_smarty_tpl->getValue('cur_pid'),'disabled'=>$_smarty_tpl->getValue('dis')), (int) 0, $_smarty_current_dir);
?>
		<?php $_smarty_tpl->assign('dis', false, false, NULL);?>
		<?php }?>
	<?php }
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
}
}
