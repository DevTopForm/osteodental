<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:35
  from 'file:menu/node-actions.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8940f28dd30_29218480',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '73235ebaaf4cf75973053f0f2e84b5b48eee45c8' => 
    array (
      0 => 'menu/node-actions.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e8940f28dd30_29218480 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\menu';
?><div class="create-block">
    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/node/add" class="btn btn--blue btn--lg create-block__btn">
        <svg fill="none" width="16" height="16">
            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#add"></use>
        </svg>
        <span>Создать раздел</span>
    </a>

    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/node/add/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="btn btn--link">
        <svg fill="none" width="16" height="16">
            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#add"></use>
        </svg>
        <span>Создать подраздел</span>
    </a>
    <a href="<?php echo $_smarty_tpl->getValue('node')->getUrl();?>
" target="_blank" class="btn btn--link">
        <svg fill="none" width="16" height="16">
            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#open"></use>
        </svg>
        <span>Открыть на сайте</span>
    </a>

    <?php if ($_smarty_tpl->getValue('user')->hasAccess('lock')) {?>
        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/node/lock/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="btn btn--link">
            <svg fill="none" width="16" height="16">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#lock"></use>
            </svg>
            <span><?php if (!$_smarty_tpl->getValue('node')->blocked) {?>За<?php } else { ?>Раз<?php }?>блокировать</span>
        </a>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('node')->type->has_items) {?>
        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/node/favorite/<?php echo $_smarty_tpl->getValue('node')->id;?>
?value=<?php if (App\Item\Favorite::isFavorite(((string)$_smarty_tpl->getValue('adm_path'))."/content/list/".((string)$_smarty_tpl->getValue('node')->id))) {?>0<?php } else { ?>1<?php }?>" class="btn btn--link">
            <svg fill="none" width="16" height="16">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#<?php if (App\Item\Favorite::isFavorite(((string)$_smarty_tpl->getValue('adm_path'))."/content/list/".((string)$_smarty_tpl->getValue('node')->id))) {?>heart-filled<?php } else { ?>heart<?php }?>"></use>
            </svg>
            <span><?php if (App\Item\Favorite::isFavorite(((string)$_smarty_tpl->getValue('adm_path'))."/content/list/".((string)$_smarty_tpl->getValue('node')->id))) {?>Исключить из избранного<?php } else { ?>В избранное<?php }?></span>
        </a>
    <?php }?>

    <?php if (!$_smarty_tpl->getValue('node')->blocked || $_smarty_tpl->getValue('user')->hasAccess('lock')) {?>
        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/node/delete/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="btn btn--link js-delete" data-name="<?php echo $_smarty_tpl->getValue('node')->title;?>
">
            <svg fill="none" width="16" height="16">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
            </svg>
            <span>Удалить раздел</span>
        </a>
    <?php }?>
</div><?php }
}
