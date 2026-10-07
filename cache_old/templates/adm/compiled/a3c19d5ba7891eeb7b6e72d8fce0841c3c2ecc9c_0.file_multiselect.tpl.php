<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/multiselect.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6e81019_17921325',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a3c19d5ba7891eeb7b6e72d8fce0841c3c2ecc9c' => 
    array (
      0 => 'content/fields/multiselect.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6e81019_17921325 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><div class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <div class="label__name">
        <?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?>
    </div>

    <?php echo $_smarty_tpl->getValue('field')->getHtml();?>

    <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
        <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
    <?php }?>
</div>
<?php }
}
