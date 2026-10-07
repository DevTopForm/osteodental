<?php
/* Smarty version 5.8.0, created on 2026-03-02 16:38:23
  from 'file:page/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a592cf7c54f9_42642068',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'af9f144d2831a14c72920027aff8ab3707b0754a' => 
    array (
      0 => 'page/index.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:page/blocks/meta.tpl' => 1,
    'file:page/blocks/yandex_counter.tpl' => 1,
    'file:page/blocks/google_counter.tpl' => 1,
    'file:page/blocks/header.tpl' => 1,
    'file:page/blocks/footer.tpl' => 1,
    'file:page/blocks/css-js.tpl' => 1,
  ),
))) {
function content_69a592cf7c54f9_42642068 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\page';
?><!DOCTYPE html>
<html lang="ru">
<head>
    <?php $_smarty_tpl->renderSubTemplate('file:page/blocks/meta.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</head>
<body>
<?php $_smarty_tpl->renderSubTemplate('file:page/blocks/yandex_counter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
$_smarty_tpl->renderSubTemplate('file:page/blocks/google_counter.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
$_smarty_tpl->renderSubTemplate('file:page/blocks/header.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<main class="main">
    <?php echo $_smarty_tpl->getValue('content');?>

</main>

<?php $_smarty_tpl->renderSubTemplate('file:page/blocks/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<?php $_smarty_tpl->renderSubTemplate('file:page/blocks/css-js.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</body>
</html><?php }
}
