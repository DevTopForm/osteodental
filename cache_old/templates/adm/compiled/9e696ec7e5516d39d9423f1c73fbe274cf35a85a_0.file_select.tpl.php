<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:05:37
  from 'file:content/fields/select.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a560f1aa5d38_04973692',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9e696ec7e5516d39d9423f1c73fbe274cf35a85a' => 
    array (
      0 => 'content/fields/select.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a560f1aa5d38_04973692 (\Smarty\Template $_smarty_tpl) {
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


    <span class="label__wrapper label__wrapper--select">
      <select class="label__select" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
">
        <option value="0" <?php if (!$_smarty_tpl->getValue('field')->getValue()) {?>selected<?php }?>>Не выбрано</option>

          <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('field')->options_data, 'option');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('option')->value) {
$foreach0DoElse = false;
?>
              <option value="<?php echo $_smarty_tpl->getValue('option')['value'];?>
" <?php if ($_smarty_tpl->getValue('field')->getValue() == $_smarty_tpl->getValue('option')['value']) {?>selected<?php }?>><?php echo $_smarty_tpl->getValue('option')['title'];?>
</option>
          <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
      </select>
    </span>
    <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
        <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
    <?php }?>
</label><?php }
}
