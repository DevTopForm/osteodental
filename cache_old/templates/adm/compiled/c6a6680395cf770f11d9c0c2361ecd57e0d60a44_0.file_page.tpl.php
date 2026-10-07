<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:06
  from 'file:page/page.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893f2385931_46493851',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'c6a6680395cf770f11d9c0c2361ecd57e0d60a44' => 
    array (
      0 => 'page/page.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/structure.tpl' => 1,
  ),
))) {
function content_69e893f2385931_46493851 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\page';
?><!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>TopForm CMS — <?php echo $_smarty_tpl->getValue('params')['site']['name'];?>
</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="stylesheet" href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/css/new-style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no">
</head>
<body>
<header class="header">
    <div class="header__inside">
        <div class="header__logo-wrap">
            <?php if ($_smarty_tpl->getValue('user')) {?>
                <div class="btn header__logo-toggler js-main-menu-toggler">
                    <svg fill="none" width="12" height="7">
                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
                    </svg>
                </div>
            <?php }?>
            <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
" class="header__logo">
                <svg fill="none" width="94" height="30">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tf-logo"></use>
                </svg>
            </a>
        </div>

        <?php if ($_smarty_tpl->getValue('user')) {?>
            <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/clearcache?page=<?php echo $_SERVER['REQUEST_URI'];?>
"
               class="header__refresh btn btn--bd btn--shrink">
                <svg fill="none" width="12" height="12">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#refresh"></use>
                </svg>
                <span>Сбрость кэш</span>
            </a>
            <div class="header__user user">
                <button class="user__link btn">
                    <span class="user__name"><?php echo $_smarty_tpl->getValue('user')->name;?>
</span>
                    <span class="user__svg">
                        <svg fill="none" width="11" height="12">
                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#user"></use>
                        </svg>
                    </span>
                </button>
                <div class="user__block">
                    <div class="user__block-inside">
                        <a href="/adm/logout" class="user__block-leave" title="Выйти из профиля">
                            <span>Выйти</span>
                            <svg fill="none" width="15" height="15">
                                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#leave"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        <?php }?>
    </div>
</header>
<div class="main-container js-container <?php if ($_smarty_tpl->getValue('isContent')) {?>opened<?php }?> <?php if (!$_smarty_tpl->getValue('user')) {?>main-container--login<?php }?>">
    <?php if ($_smarty_tpl->getValue('user')) {?>
        <div class="aside">
            <?php echo $_smarty_tpl->getValue('main_menu');?>

        </div>
        <div class="content-menu js-menu js-tabindex">
            <div class="content-menu__inside" tabindex="-1">
                <?php if ($_smarty_tpl->getValue('logo')->id) {?>
                    <a href="/" class="content-menu__logo">
                        <img src="<?php echo $_smarty_tpl->getValue('logo')->getLink();?>
" alt="" width="107" height="30">
                    </a>
                <?php } else { ?>
                    <div class="content-menu__logo"></div>
                <?php }?>
                <?php if ($_smarty_tpl->getValue('tree') && $_smarty_tpl->getValue('user')->hasAccess('node')) {?>
                    <nav class="content-menu__menu menu">
                        <ul class="menu__list">
                            <?php $_smarty_tpl->renderSubTemplate('file:menu/structure.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
                        </ul>
                    </nav>
                <?php }?>
            </div>
        </div>
        <div class="main-container__content">
            <?php echo $_smarty_tpl->getValue('content');?>

        </div>
    <?php } else { ?>
        <?php echo $_smarty_tpl->getValue('content');?>

    <?php }?>
</div>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/js/script.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/js/index.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
