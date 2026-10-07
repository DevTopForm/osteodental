<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/complex.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6ed3f24_82837200',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1d51373be05163bc3b71700dce4e47673029e9ae' => 
    array (
      0 => 'content/fields/complex.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6ed3f24_82837200 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?><div class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <div class="label__content">
        <span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>

        <?php if ($_smarty_tpl->getValue('field')->example) {?>
            <span class="label__text"><?php echo $_smarty_tpl->getValue('field')->example;?>
</span>
        <?php }?>
    </div>
    <div class="label__wrapper-labels js-yt-elements" data-field-name="<?php echo $_smarty_tpl->getValue('field')->name;?>
"
         data-field-id="<?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('field')->getSpecValue()) > 0) {
echo $_smarty_tpl->getSmarty()->getModifierCallback('max')($_smarty_tpl->getSmarty()->getModifierCallback('array_keys')($_smarty_tpl->getValue('field')->getSpecValue()));
} else { ?>1<?php }?>">
        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('field')->getSpecValue()) > 0) {?>
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('field')->getSpecValue(), 'row');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('row')->value) {
$foreach1DoElse = false;
?>
                <div class="input-yt input-yt--block">
                    <label class="check input-yt__check">
                        <input class="check__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
_delete[]" value="<?php echo $_smarty_tpl->getValue('row')['rowId'];?>
" type="checkbox">
                        <span class="check__name js-row-id">id: <?php echo $_smarty_tpl->getValue('row')['rowId'];?>
</span>
                    </label>

                    <div class="input-yt__content">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('row')['fields'], 'subfield');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('subfield')->value) {
$foreach2DoElse = false;
?>
                            <?php $_smarty_tpl->assign('name', ((string)$_smarty_tpl->getValue('field')->name)."[".((string)$_smarty_tpl->getValue('row')['rowId'])."][".((string)$_smarty_tpl->getValue('subfield')->id)."]", false, NULL);?>
                            <?php $_smarty_tpl->renderSubTemplate((('content/fields/complex/').($_smarty_tpl->getValue('subfield')->field)).('.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field'=>$_smarty_tpl->getValue('subfield'),'name'=>$_smarty_tpl->getValue('name')), (int) 0, $_smarty_current_dir);
?>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        <?php } else { ?>
            <div class="input-yt input-yt--block">
                <label class="check input-yt__check">
                    <input class="check__input" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
_delete[]" value="<?php echo $_smarty_tpl->getValue('row')['rowId'];?>
" type="checkbox">
                    <span class="check__name js-row-id">id: 1</span>
                </label>

                <div class="input-yt__content">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('field')->subfields, 'subfield');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('subfield')->value) {
$foreach3DoElse = false;
?>
                        <?php $_smarty_tpl->assign('name', ((string)$_smarty_tpl->getValue('field')->name)."[1][".((string)$_smarty_tpl->getValue('subfield')->id)."]", false, NULL);?>
                        <?php $_smarty_tpl->renderSubTemplate((('content/fields/complex/').($_smarty_tpl->getValue('subfield')->field)).('.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('field'=>$_smarty_tpl->getValue('subfield')->node_field,'name'=>$_smarty_tpl->getValue('name')), (int) 0, $_smarty_current_dir);
?>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>
            </div>
        <?php }?>

        <div class="label__wrapper-btns js-place">
            <div class="btn btn--lg btn--light js-yt-elements-add">
                <svg fill="none" width="16" height="16">
                    <use href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#add"></use>
                </svg>
                <span>Добавить элемент</span>
            </div>
            <div class="btn btn--lg btn--bd js-yt-elements-remove">
                <span>Удалить</span>
            </div>

            <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
                <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
            <?php }?>
        </div>
    </div>
</div>
<?php }
}
