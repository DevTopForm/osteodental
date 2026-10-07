<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:40
  from 'file:content/module.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e89414746d42_61044269',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '206f6d7d791e652027d45cefd438b1744e0c8b0a' => 
    array (
      0 => 'content/module.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/module-actions.tpl' => 1,
  ),
))) {
function content_69e89414746d42_61044269 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
if ($_smarty_tpl->getValue('state') == 'list') {?>
    <section class="catalog" data-type="module">
        <h1 class="h1 catalog__h1">Установка модулей</h1>
        <div class="top"></div>
        <div class="catalog-controls">
            <div class="catalog-controls__btns">
                <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/add" class="btn btn--blue btn--shrink">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#add"></use>
                    </svg>
                    <span>Добавить элемент</span>
                </a>
            </div>
        </div>
        <div class="table-wrapper catalog__table catalog__table--sortable">
            <table class="catalog-table">
                <thead>
                <tr>
                    <th class="catalog-table__th"></th>
                    <th class="catalog-table__th"><span>Название</span></th>
                    <th class="catalog-table__th"><span>Сервисное имя</span></th>
                    <th class="catalog-table__th"><span>Доступен в ноде</span></th>
                    <th class="catalog-table__th"><span>Доступен в блоке</span></th>
                    <th class="catalog-table__th"><span>Поиск</span></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>

                <?php if ($_smarty_tpl->getValue('list')) {?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'module');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('module')->value) {
$foreach0DoElse = false;
?>
                        <tr class="catalog-table__tr js-delete-element" data-order="<?php echo $_smarty_tpl->getValue('module')->id;?>
">
                            <td class="catalog-table__td">
                                <div class="js-handle">
                                    <svg fill="none" width="7" height="13">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#dots2"></use>
                                    </svg>
                                </div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('module')->title;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('module')->type;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">
                                    <input
                                            data-id="1"
                                            data-node="1"
                                            class="input-elt__input ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="1"
                                            <?php if ($_smarty_tpl->getValue('module')->in_node) {?>checked<?php }?>
                                    >
                                    <span class="input-elt__fake">
                                <svg fill="none" width="21" height="16">
                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
                                </svg>
                            </span>
                                    <span class="input-elt__text">выбрать ...</span>
                                </label>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">
                                    <input
                                            data-id="1"
                                            data-node="1"
                                            class="input-elt__input ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="1"
                                            <?php if ($_smarty_tpl->getValue('module')->in_block) {?>checked<?php }?>
                                    >
                                    <span class="input-elt__fake">
                                <svg fill="none" width="21" height="16">
                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
                                </svg>
                            </span>
                                    <span class="input-elt__text">выбрать ...</span>
                                </label>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">

                                    <input
                                            data-id="1"
                                            data-node="1"
                                            class="input-elt__input ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="1"
                                            <?php if ($_smarty_tpl->getValue('module')->search) {?>checked<?php }?>
                                    >
                                    <span class="input-elt__fake">
                                <svg fill="none" width="21" height="16">
                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
                                </svg>
                            </span>
                                    <span class="input-elt__text">выбрать ...</span>
                                </label>
                            </td>
                            <td class="catalog-table__td">
                                <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/edit/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="catalog-item__ico"
                                   title="Общие настройки">
                                    <svg fill="none" width="16" height="16">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
                                    </svg>
                                </a>
                            </td>
                            <td class="catalog-table__td">
                                <?php if ($_smarty_tpl->getValue('module')->has_content) {?>
                                    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modfield/list/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="catalog-item__ico"
                                       title="Поля">
                                        <svg fill="none" width="17" height="17">
                                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#fields"></use>
                                        </svg>
                                    </a>
                                <?php }?>
                            </td>

                            <td class="catalog-table__td">
                                <?php if ($_smarty_tpl->getValue('module')->has_content) {?>
                                    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modgroup/list/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="catalog-item__ico"
                                       title="Группы полей">
                                        <svg fill="none" width="17" height="17">
                                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#fields"></use>
                                        </svg>
                                    </a>
                                <?php }?>
                            </td>
                            <td class="catalog-table__td">
                                <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modimage/list/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="catalog-item__ico"
                                   title="Изображения">
                                    <svg fill="none" width="19" height="17">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#imgs"></use>
                                    </svg>
                                </a>
                            </td>
                            <td class="catalog-table__td">
                                <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modtpl/list/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="catalog-item__ico"
                                   title="Шаблоны">
                                    <svg fill="none" width="19" height="17">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#template"></use>
                                    </svg>
                                </a>
                            </td>
                            <td class="catalog-table__td">
                                <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/modparam/list/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="catalog-item__ico"
                                   title="Параметры">
                                    <svg fill="none" width="17" height="17">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#settings2"></use>
                                    </svg>
                                </a>
                            </td>

                            <td class="catalog-table__td">
                                <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="catalog-item__ico js-delete"
                                   title="Удалить">
                                    <svg fill="none" width="17" height="17">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
                                    </svg>
                                </a>
                            </td>
                                                                                                                                                                                                                            </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                <?php } else { ?>
                    <tr class="catalog-table__tr undefined">
                        <td align="center" colspan="11" class="catalog-table__td">Модули не найдены</td>
                    </tr>
                <?php }?>
                </tbody>
            </table>
        </div>
    </section>
<?php } elseif ($_smarty_tpl->getValue('state') == 'add' || $_smarty_tpl->getValue('state') == 'edit') {?>
    <section class="catalog">
        <div class="catalog__item-top">
            <div class="item-controls js-to-expand">
                <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/list/<?php echo $_smarty_tpl->getValue('module')->id;?>
" class="btn btn--link item-controls__back">
                    <svg fill="none" width="12" height="12">
                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
                    </svg>
                    <span>В список</span>
                </a>
                <button class="btn btn--link item-controls__more js-expand " aria-label="Открыть кнопки">
                    <svg fill="none" width="34" height="8">
                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#dots"></use>
                    </svg>
                </button>
                <div class="item-controls__short">
                    <div class="item-controls__group">
                    </div>
                </div>
                <button form="form-module" type="submit" name="save" value="Сохранить" class="btn btn--blue btn--lg">
                    <span>Сохранить</span>
                </button>
            </div>
            <?php if ($_smarty_tpl->getValue('item')->type) {
$_smarty_tpl->renderSubTemplate('file:menu/module-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('type'=>$_smarty_tpl->getValue('item'),'active'=>'module'), (int) 0, $_smarty_current_dir);
}?>
        </div>
        <h1 class="h1 catalog__h1">Свойства</h1>
        <form id="form-module" class="form  form--980" action="" method="post" enctype="multipart/form-data">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Название</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="title" type="text" class="label__input"
                                   value="<?php if ($_POST['title']) {
echo $_POST['title'];
} else {
echo $_smarty_tpl->getValue('item')->title;
}?>"
                                   placeholder="">
                        </span>
                    </label>


                    <label class="label form__input-full <?php if ($_smarty_tpl->getValue('errors')['type']) {?>mistake<?php }?>">
                        <div class="label__content">
                            <span class="label__name">Сервисное имя</span>
                        </div>

                        <span class="label__wrapper">
                                <?php if (!$_smarty_tpl->getValue('item')->id) {?>
                                    <input name="type" type="text" class="label__input"
                                           value="<?php if ($_POST['title']) {
echo $_POST['title'];
}?>" placeholder="">
                                    <span class="label__mistake">Внесите данные</span>
                                <?php } else { ?>
                                    <?php echo $_smarty_tpl->getValue('item')->type;?>

                                <?php }?>
                            </span>
                    </label>

                    <div class="form__check-group label form__input-full">
                        <div class="form__check-group-inside">
                            <label class="check ">
                                <input class="check__input" name="in_node" <?php if ($_smarty_tpl->getValue('item')->in_node) {?>checked<?php }?> value="1"
                                       type="checkbox">
                                <span class="check__name">Доступен в ноде</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="in_block" <?php if ($_smarty_tpl->getValue('item')->in_block) {?>checked<?php }?> value="1"
                                       type="checkbox">
                                <span class="check__name">Доступен в блоке</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="search" <?php if ($_smarty_tpl->getValue('item')->search) {?>checked<?php }?> value="1"
                                       type="checkbox">
                                <span class="check__name">Поиск по элементам разделов данного типа</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_content" <?php if ($_smarty_tpl->getValue('item')->has_content) {?>checked<?php }?>
                                       value="1" type="checkbox">
                                <span class="check__name">Редактируемый контент</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_items" <?php if ($_smarty_tpl->getValue('item')->has_items) {?>checked<?php }?> value="1"
                                       type="checkbox">
                                <span class="check__name">Отдельные элементы контента</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="sortable" <?php if ($_smarty_tpl->getValue('item')->sortable) {?>checked<?php }?> value="1"
                                       type="checkbox">
                                <span class="check__name">Сортировка перетаскиванием</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_filters" value="1"
                                       <?php if ($_smarty_tpl->getValue('item')->has_filters) {?>checked<?php }?> type="checkbox">
                                <span class="check__name">Есть фильтры</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_variants" value="1"
                                       <?php if ($_smarty_tpl->getValue('item')->has_variants) {?>checked<?php }?> type="checkbox">
                                <span class="check__name">Есть варианты</span>
                            </label>

                            <label class="check ">
                                <input class="check__input" <?php if ($_smarty_tpl->getValue('item')->id) {?>onclick="return false;"<?php }?> name="is_catalog"
                                       value="1" <?php if ($_smarty_tpl->getValue('item')->is_catalog) {?>checked<?php }?> type="checkbox">
                                <span class="check__name">Это каталог</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
<?php }
}
}
