<?php
/* Smarty version 5.8.0, created on 2026-03-02 16:38:23
  from 'file:page/404.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a592cff28964_66716674',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '293e83a823cd94e91bf7642a578a5234df826606' => 
    array (
      0 => 'page/404.tpl',
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
function content_69a592cff28964_66716674 (\Smarty\Template $_smarty_tpl) {
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

<main>
    Страница не найдена
</main>

<?php $_smarty_tpl->renderSubTemplate('file:page/blocks/footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
$_smarty_tpl->renderSubTemplate('file:page/blocks/css-js.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</body>
</html><?php }
}
