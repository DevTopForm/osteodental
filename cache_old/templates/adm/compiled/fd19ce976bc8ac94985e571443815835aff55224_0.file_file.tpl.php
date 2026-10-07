<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/file.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6f1f162_73796356',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fd19ce976bc8ac94985e571443815835aff55224' => 
    array (
      0 => 'content/fields/file.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6f1f162_73796356 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?>

<div class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <label class="label__content">
        <span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>
    </label>

    <div class="label__wrapper-imgs">
        <div class="label__wrapper-btns">
            <label class="btn btn--lg btn--blue label__file-wrapper">
                <?php echo $_smarty_tpl->getValue('field')->getHtml();?>

                <svg fill="none" width="16" height="16">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#"></use>
                </svg>
                <span>Загрузить с компьютера</span>
                <div class="label__file-uploader uploader">
                    <div class="uploader-inside"></div>
                </div>
                <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>
                    <span class="label__mistake"><?php echo $_smarty_tpl->getValue('field')->errorsMessage;?>
</span>
                <?php }?>
            </label>
        </div>

        <?php $_smarty_tpl->assign('attach', $_smarty_tpl->getValue('field')->getAttach(), false, NULL);?>
        <div class="label__imgs imgs">
            <?php if ($_smarty_tpl->getValue('attach')->id) {?>
                <div class="img" data-rel="<?php echo $_smarty_tpl->getValue('field')->id;?>
">
                    <div class="img__inside">
                        <svg fill="none" width="50" height="50">
                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#file"></use>
                        </svg>
                    </div>
                    <a target="_blank" href="<?php echo $_smarty_tpl->getValue('attach')->getLink();?>
" class="img__name"><?php echo $_smarty_tpl->getValue('attach')->src_name;?>
</a>
                    <div class="btn img__close">
                        <svg fill="none" width="16" height="16">
                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#clear"></use>
                        </svg>
                    </div>
                    <label class="img__label">
                        <input type="checkbox" name="clear_<?php echo $_smarty_tpl->getValue('field')->name;?>
" value="1">
                        <span>Удалить</span>
                    </label>
                </div>
            <?php }?>
        </div>
    </div>
</div><?php }
}
