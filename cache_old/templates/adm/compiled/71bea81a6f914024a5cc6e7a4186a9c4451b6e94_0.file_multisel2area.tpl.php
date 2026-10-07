<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/multisel2area.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6f31f34_88445005',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '71bea81a6f914024a5cc6e7a4186a9c4451b6e94' => 
    array (
      0 => 'content/fields/multisel2area.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6f31f34_88445005 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><div class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <label class="label__name">
        <?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?>
    </label>
    <?php echo $_smarty_tpl->getValue('field')->getHtml();?>

    <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
        <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
    <?php }?>
</div>

<?php }
}
