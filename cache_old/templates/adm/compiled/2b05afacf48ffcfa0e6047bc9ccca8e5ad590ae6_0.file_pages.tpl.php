<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:35
  from 'file:blocks/content/list/pages.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8940f30c2f3_24708634',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2b05afacf48ffcfa0e6047bc9ccca8e5ad590ae6' => 
    array (
      0 => 'blocks/content/list/pages.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8940f30c2f3_24708634 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\blocks\\content\\list';
?><div class="pages <?php if ($_smarty_tpl->getValue('class')) {
echo $_smarty_tpl->getValue('class');
}?>">
    <label class="pages__label">
        <span class="pages__label-name">Показывать на странице:</span>
        <select class="pages__select js_per_page">
            <option value="10" <?php if (!$_smarty_tpl->getValue('count') == 10) {?>selected<?php }?>>10</option>
            <option value="20" <?php if ($_smarty_tpl->getValue('count') == 20) {?>selected<?php }?>>20</option>
            <option value="50" <?php if ($_smarty_tpl->getValue('count') == 50) {?>selected<?php }?>>50</option>
            <option value="100" <?php if ($_smarty_tpl->getValue('count') == 100) {?>selected<?php }?>>100</option>
            <option value="all" <?php if (!$_smarty_tpl->getValue('count')) {?>selected<?php }?>>Все</option>
        </select>
        <span class="pages__svg">
              <svg fill="none" width="12" height="7">
                <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
              </svg>
            </span>
    </label>

    <?php echo $_smarty_tpl->getValue('pager');?>

</div><?php }
}
