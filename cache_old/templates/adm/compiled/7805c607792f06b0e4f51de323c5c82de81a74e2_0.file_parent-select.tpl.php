<?php
/* Smarty version 5.8.0, created on 2026-02-25 13:42:03
  from 'file:menu/parent-select.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699ed1fb80d9b1_43017194',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7805c607792f06b0e4f51de323c5c82de81a74e2' => 
    array (
      0 => 'menu/parent-select.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/parent-select.tpl' => 2,
  ),
))) {
function content_699ed1fb80d9b1_43017194 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\menu';
if (!$_smarty_tpl->getValue('space')) {
$_smarty_tpl->assign('space', $_smarty_tpl->getValue('spacer'), false, NULL);
}
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('tree'), 'node');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('node')->value) {
$foreach4DoElse = false;
?>
<option value="<?php echo $_smarty_tpl->getValue('node')['id'];?>
"<?php if ($_smarty_tpl->getValue('node')['id'] == $_smarty_tpl->getValue('cur_nid') || $_smarty_tpl->getValue('disabled')) {?> disabled="true"<?php }
if ($_smarty_tpl->getValue('node')['id'] == $_smarty_tpl->getValue('cur_pid')) {?> selected="true"<?php }?> rel="<?php echo $_smarty_tpl->getValue('node')['url'];?>
"><?php echo $_smarty_tpl->getValue('space');
echo $_smarty_tpl->getValue('node')['title'];?>
</option>
<?php if ($_smarty_tpl->getValue('node')['childs']) {
if ($_smarty_tpl->getValue('node')['id'] == $_smarty_tpl->getValue('cur_nid') || $_smarty_tpl->getValue('disabled')) {
$_smarty_tpl->assign('dis', true, false, NULL);
}
$_smarty_tpl->renderSubTemplate('file:menu/parent-select.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tree'=>$_smarty_tpl->getValue('node')['childs'],'space'=>($_smarty_tpl->getValue('space')).($_smarty_tpl->getValue('spacer')),'cur_nid'=>$_smarty_tpl->getValue('cur_nid'),'cur_pid'=>$_smarty_tpl->getValue('cur_pid'),'disabled'=>$_smarty_tpl->getValue('dis')), (int) 0, $_smarty_current_dir);
$_smarty_tpl->assign('dis', false, false, NULL);
}
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
}
}
