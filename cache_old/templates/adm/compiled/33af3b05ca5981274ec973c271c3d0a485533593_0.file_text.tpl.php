<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/complex/text.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6eec001_79528646',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '33af3b05ca5981274ec973c271c3d0a485533593' => 
    array (
      0 => 'content/fields/complex/text.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6eec001_79528646 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields\\complex';
?><label class="label input-yt__label <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <div class="label__content">
        <span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>

        <?php if ($_smarty_tpl->getValue('field')->example) {?>
            <span class="label__text"><?php echo $_smarty_tpl->getValue('field')->example;?>
</span>
        <?php }?>
    </div>


    <span class="label__wrapper">
        <input type="text" value="<?php echo $_smarty_tpl->getValue('field')->getValue();?>
" class="label__input" name="<?php echo $_smarty_tpl->getValue('name');?>
" placeholder="<?php echo $_smarty_tpl->getValue('field')->default ?: "Не заполнено";?>
">
        <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
            <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
        <?php }?>
    </span>
</label><?php }
}
