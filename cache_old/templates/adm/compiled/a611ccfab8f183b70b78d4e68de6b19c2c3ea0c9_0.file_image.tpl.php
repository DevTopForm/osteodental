<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:37
  from 'file:content/fields/image.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8941120b2e0_44291424',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a611ccfab8f183b70b78d4e68de6b19c2c3ea0c9' => 
    array (
      0 => 'content/fields/image.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8941120b2e0_44291424 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields';
?>
<div class="label form__input-full <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <label class="label__content">
        <span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>
    </label>

    <div class="label__wrapper-imgs">
        <div class="label__wrapper-btns">
            <label class="btn btn--lg btn--blue label__file-wrapper js-image-wrapper">
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
        <div class="label__imgs imgs">
            <?php $_smarty_tpl->assign('image', $_smarty_tpl->getValue('field')->getSpecValue(), false, NULL);?>

            <?php if ($_smarty_tpl->getValue('image')->id) {?>
                <div class="img" data-rel="<?php echo $_smarty_tpl->getValue('image')->id;?>
">
                    <div class="img__inside">
                        <img class="img__img" src="<?php echo $_smarty_tpl->getValue('image')->getLink('admin');?>
" alt="" width="50" height="50">
                    </div>
                    <div class="img__name"><?php echo $_smarty_tpl->getValue('image')->title;?>
</div>
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
</div>
<?php }
}
