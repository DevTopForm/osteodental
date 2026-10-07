<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:37
  from 'file:content/fields/text.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e894111e2411_46936231',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '04e4eeb6e1ff7f48580e3834bab4fe06e5ad6571' => 
    array (
      0 => 'content/fields/text.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e894111e2411_46936231 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><label class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <div class="label__content">
        <span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>

        <?php if ($_smarty_tpl->getValue('field')->example) {?>
            <span class="label__text"><?php echo $_smarty_tpl->getValue('field')->example;?>
</span>
        <?php }?>
    </div>


    <span class="label__wrapper">
      <input type="text" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('field')->getValue(), ENT_QUOTES, 'UTF-8', true);?>
" class="label__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
" placeholder="<?php echo $_smarty_tpl->getValue('field')->default;?>
">
        <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
            <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
        <?php }?>
    </span>
</label><?php }
}
