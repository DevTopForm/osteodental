<?php
/* Smarty version 5.8.0, created on 2026-02-25 18:15:02
  from 'file:content/fields/complex/image.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699f11f6f0eac1_54390138',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e31ba4ce5e2a76743d690e687a1bfe57d88934af' => 
    array (
      0 => 'content/fields/complex/image.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_699f11f6f0eac1_54390138 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content\\fields\\complex';
?><div class="label <?php if ($_smarty_tpl->getValue('field')->errorsMessage) {?>mistake<?php }?>">
    <div class="imgs imgs--sortable">
        <label class="btn label__file-wrapper label-file">
            <input type="file" class="label__file" name="<?php echo $_smarty_tpl->getValue('name');?>
" accept="" value="" data-max-length="20">
            <svg fill="none" width="16" height="16">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#plus"></use>
            </svg>
            <span><?php echo $_smarty_tpl->getValue('field')->title;
if ($_smarty_tpl->getValue('field')->required) {?>*<?php }?></span>
            <div class="label__file-uploader uploader">
                <div class="uploader-inside"></div>
            </div>
        </label>


        <?php $_smarty_tpl->assign('attach', $_smarty_tpl->getValue('field')->getAttach(), false, NULL);?>
        <?php if ($_smarty_tpl->getValue('attach')->id) {?>
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
                                <use href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#clear"></use>
                            </svg>
                        </div>
                        <label class="img__label">
                            <input type="checkbox" name="clear_<?php echo $_smarty_tpl->getValue('name');?>
" value="1">
                            <span>Удалить</span>
                        </label>
                    </div>
                <?php }?>
            </div>
        <?php }?>
    </div>
</div><?php }
}
