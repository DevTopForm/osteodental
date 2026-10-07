<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:50
  from 'file:menu/module-actions.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8941eac13e4_32221238',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b7d57d2820147df965e8193495a4f05aafffe0f8' => 
    array (
      0 => 'menu/module-actions.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8941eac13e4_32221238 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\menu';
?><div class="catalog__tabs">
    <a class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'module') {?>active<?php }?>" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/module/edit/<?php echo $_smarty_tpl->getValue('type')->id;?>
">Свойства</a>

    <?php if ($_smarty_tpl->getValue('type')->has_content) {?>
        <a class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'fields') {?>active<?php }?>" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modfield/list/<?php echo $_smarty_tpl->getValue('type')->id;?>
">Поля</a>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('type')->has_content) {?>
        <a class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'group') {?>active<?php }?>" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modgroup/list/<?php echo $_smarty_tpl->getValue('type')->id;?>
">Группы полей</a>
    <?php }?>

    <a class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'image') {?>active<?php }?>" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modimage/list/<?php echo $_smarty_tpl->getValue('type')->id;?>
">Изображения</a>
    <a class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'template') {?>active<?php }?>" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modtpl/list/<?php echo $_smarty_tpl->getValue('type')->id;?>
">Шаблоны</a>
    <a class="tab-name <?php if ($_smarty_tpl->getValue('active') == 'param') {?>active<?php }?>" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modparam/list/<?php echo $_smarty_tpl->getValue('type')->id;?>
">Параметры</a>
</div><?php }
}
