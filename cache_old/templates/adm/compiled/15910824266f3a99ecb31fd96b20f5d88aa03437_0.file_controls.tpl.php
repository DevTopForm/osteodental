<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:35
  from 'file:blocks/content/list/controls.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8940f2ed494_58166009',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '15910824266f3a99ecb31fd96b20f5d88aa03437' => 
    array (
      0 => 'blocks/content/list/controls.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:blocks/content/list/pages.tpl' => 1,
  ),
))) {
function content_69e8940f2ed494_58166009 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\blocks\\content\\list';
?><div class="catalog-controls">
    <div class="catalog-controls__btns">
        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/content/add/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="btn btn--blue btn--shrink">
            <svg fill="none" width="16" height="16">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#add"></use>
            </svg>
            <span>Добавить элемент</span>
        </a>
        <button form="catalog-list-form" type="submit" name="delete" value="1" class="btn btn--bd btn--lg btn--shrink js-delete-multiple">
            <svg fill="none" width="16" height="16">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
            </svg>

            <span>Удалить</span>
        </button>
        <button form="catalog-list-form" type="submit" name="copy" value="1" class="btn btn--bd btn--lg btn--shrink js-item-multiple">
            <svg fill="none" width="16" height="16">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#copy"></use>
            </svg>

            <span>Копировать</span>
        </button>

        <div class="catalog-controls__search-block js-to-expand-close">
            <form method="get" enctype="multipart/form-data" class="search-block catalog-controls__search">
                <label class="search-block__label">
                    <input type="search" name="search_text" value="<?php echo $_GET['search_text'];?>
" class="search-block__input">
                </label>
                <button type="submit" name="search" value="Искать" class="btn btn--blue search-block__btn" aria-label="начать поиск">
                    <svg fill="none" width="14" height="14">
                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#search"></use>
                    </svg>
                </button>
            </form>
            <button type="submit" class="btn btn--blue btn--square js-expand-close" aria-label="начать поиск">
                <svg fill="none" width="14" height="14">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#search"></use>
                </svg>
            </button>
        </div>
    </div>

    <?php $_smarty_tpl->renderSubTemplate('file:blocks/content/list/pages.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
</div><?php }
}
