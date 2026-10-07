<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:35
  from 'file:menu/node-menu.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8940f2d13b3_96151747',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '749fd77df5cfa61b59bfd9e6c93c8cefb2464513' => 
    array (
      0 => 'menu/node-menu.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8940f2d13b3_96151747 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\menu';
?><div class="catalog__tabs">

    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/content/list/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'content') {?>active<?php }?>" title="Содержимое">
        Содержимое
    </a>

    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/inner/edit/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'inner') {?>active<?php }?>" title="Вводный текст">
        Вводный текст
    </a>

    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/area/list/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'area') {?>active<?php }?>" title="Блоки">
        Блоки
    </a>

    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/node/edit/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'node') {?>active<?php }?>" title="Свойства">
        Свойства
    </a>

    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/params/edit/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'params') {?>active<?php }?>" title="Параметры">
        Параметры
    </a>

    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/seo/edit/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'seo') {?>active<?php }?>" title="Сео">
        Сео
    </a>

</div><?php }
}
