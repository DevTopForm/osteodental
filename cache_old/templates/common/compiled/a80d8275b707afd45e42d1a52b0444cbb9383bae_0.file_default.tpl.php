<?php
/* Smarty version 5.8.0, created on 2026-03-02 12:39:17
  from 'file:module/text/default.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a55ac5b7e761_06755703',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a80d8275b707afd45e42d1a52b0444cbb9383bae' => 
    array (
      0 => 'module/text/default.tpl',
      1 => 1772444346,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a55ac5b7e761_06755703 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\text';
?><div class="pb-60-100 pt-60-100">
    <div class="container">
        <h1 class="h3 mb-30"><?php echo $_smarty_tpl->getValue('node')->h1 ?: $_smarty_tpl->getValue('node')->title;?>
</h1>
        <div>
            <?php echo $_smarty_tpl->getValue('content')->text;?>

        </div>
    </div>
</div><?php }
}
