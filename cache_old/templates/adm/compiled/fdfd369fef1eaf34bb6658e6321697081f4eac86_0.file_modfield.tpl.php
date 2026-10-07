<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:50
  from 'file:content/modfield.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8941ea928b5_46215131',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fdfd369fef1eaf34bb6658e6321697081f4eac86' => 
    array (
      0 => 'content/modfield.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/module-actions.tpl' => 2,
  ),
))) {
function content_69e8941ea928b5_46215131 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
if ($_smarty_tpl->getValue('state') == 'list' || $_smarty_tpl->getValue('state') == "listcomplex") {?>
    <section class="catalog" data-type="nodefields" data-node="<?php echo $_smarty_tpl->getValue('module')->is_catalog;?>
">
        <div class="catalog__item-top">
            <?php $_smarty_tpl->renderSubTemplate('file:menu/module-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('type'=>$_smarty_tpl->getValue('module'),'active'=>'fields'), (int) 0, $_smarty_current_dir);
?>
        </div>

        <h1 class="h1 catalog__h1"><?php if (!$_smarty_tpl->getValue('field')) {?>Поля<?php } else { ?>Поля комплексного поля <a
                href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/edit/<?php echo $_smarty_tpl->getValue('module')->id;?>
/<?php echo $_smarty_tpl->getValue('field')->id;?>
"><?php echo $_smarty_tpl->getValue('field')->title;?>
</a><?php }?></h1>
        <div class="catalog-controls">
            <div class="catalog-controls__btns">
                <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/add/<?php echo $_smarty_tpl->getValue('module')->id;
if ($_smarty_tpl->getValue('field')) {?>/<?php echo $_smarty_tpl->getValue('field')->id;
}?>"
                   class="btn btn--blue btn--shrink">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="/adm/assets/img/sprite.svg#add"></use>
                    </svg>
                    <span>Добавить Поле</span>
                </a>
            </div>
        </div>
        <div class="table-wrapper catalog__table catalog__table--sortable">
            <table class="catalog-table">
                <thead>
                <tr>
                    <th class="catalog-table__th"></th>
                    <th class="catalog-table__th"><span>Название</span></th>
                    <th class="catalog-table__th"><span>Имя в таблице</span></th>
                    <th class="catalog-table__th"><span>Тип поля</span></th>
                    <th class="catalog-table__th"><span>Required</span></th>
                    <th class="catalog-table__th"><span>В списке в админке</span></th>
                    <th class="catalog-table__th "><span>Сортировать по полю</span></th>
                    <th class="catalog-table__th "><span>В поиске  на сайте</span></th>
                    <th class="catalog-table__th "><span>В&nbsp;списке на&nbsp;сайте</span></th>
                    <th class="catalog-table__th "><span>Отображать&nbsp;в характеристиках</span></th>
                    <th class="catalog-table__th "><span>Отображать в&nbsp;списке товаров</span></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>
                <?php if ($_smarty_tpl->getValue('list')) {?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
                        <tr class="catalog-table__tr js-delete-element" data-order="<?php echo $_smarty_tpl->getValue('item')->id;?>
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
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->title;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->name;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->field;?>
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
                                            name="required"
                                            <?php if ($_smarty_tpl->getValue('item')->required) {?>checked<?php }?>>
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
                                            name="show"
                                            <?php if ($_smarty_tpl->getValue('item')->show) {?>checked<?php }?>>
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
                                            name="sorter"
                                            <?php if ($_smarty_tpl->getValue('item')->sorter) {?>checked<?php }?>>
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
                                            class="input-elt__input
                                                ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="search"
                                            <?php if ($_smarty_tpl->getValue('item')->search) {?>checked<?php }?>
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
                                            name="inlist"
                                            <?php if ($_smarty_tpl->getValue('item')->inlist) {?>checked<?php }?>
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
                                            name="property_show"
                                            <?php if ($_smarty_tpl->getValue('item')->property_show) {?>checked<?php }?>
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
                                            name="property_list_show"
                                            <?php if ($_smarty_tpl->getValue('item')->property_list_show) {?>checked<?php }?>
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
                            <td class="catalog-table__td" data-position="right">
                                <div class="jsFixed">
                                    <div class="catalog-item__controls">
                                        <div class="ico-btns catalog-item__btns">
                                            <?php if ($_smarty_tpl->getValue('item')->field == "complex") {?>
                                                <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/list/<?php echo $_smarty_tpl->getValue('module')->id;
if ($_smarty_tpl->getValue('field')) {?>/<?php echo $_smarty_tpl->getValue('field')->id;
}?>/<?php echo $_smarty_tpl->getValue('item')->id;?>
"
                                                   class="input-elt ico-btn" aria-label="Поля">
                                                    <span class="input-elt__fake" style="color: var(--blue);">
                                                        <svg fill="none" width="21" height="16">
                                                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#eye"></use>
                                                        </svg>
                                                    </span>
                                                    <span class="input-elt__text">выбрать ...</span>
                                                </a>
                                            <?php }?>

                                            <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/edit/<?php echo $_smarty_tpl->getValue('module')->id;
if ($_smarty_tpl->getValue('field')) {?>/<?php echo $_smarty_tpl->getValue('field')->id;
}?>/<?php echo $_smarty_tpl->getValue('item')->id;?>
"
                                               class="ico-btn" aria-label="Редактировать">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>

                                            <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('module')->id;
if ($_smarty_tpl->getValue('field')) {?>/<?php echo $_smarty_tpl->getValue('field')->id;
}?>/<?php echo $_smarty_tpl->getValue('item')->id;?>
"
                                               class="ico-btn js-delete" data-name="<?php echo $_smarty_tpl->getValue('item')->title;?>
"
                                               aria-label="Удалить">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                <?php }?>
                </tbody>
            </table>
        </div>
    </section>
<?php } elseif ($_smarty_tpl->getValue('state') == 'add' || $_smarty_tpl->getValue('state') == 'edit' || $_smarty_tpl->getValue('state') == 'addcomplex' || $_smarty_tpl->getValue('state') == 'editcomplex') {?>
    <section class="catalog">
        <div class="catalog__item-top">
            <div class="item-controls js-to-expand">
                <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/list/<?php echo $_smarty_tpl->getValue('module')->id;
if ($_smarty_tpl->getValue('complex')) {?>/<?php echo $_smarty_tpl->getValue('complex')->id;
}?>"
                   class="btn btn--link item-controls__back">
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
                <button form="form-fields" type="submit" name="save" value="Сохранить" class="btn btn--blue btn--lg">
                    <span>Сохранить</span>
                </button>
            </div>
            <?php if ($_smarty_tpl->getValue('item')->type) {
$_smarty_tpl->renderSubTemplate('file:menu/module-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('type'=>$_smarty_tpl->getValue('module'),'active'=>'fields'), (int) 0, $_smarty_current_dir);
}?>
        </div>
        <h1 class="h1 catalog__h1">Поля</h1>
        <form id="form-fields" class="form  form--980" action="" method="post" enctype="multipart/form-data">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['fields'], 'field', false, 'field_key');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field_key')->value => $_smarty_tpl->getVariable('field')->value) {
$foreach1DoElse = false;
?>
                        <?php if ($_smarty_tpl->getValue('field')['type'] == 'select') {?>
                            <?php if ($_smarty_tpl->getValue('field')['title'] === "Группа" && $_smarty_tpl->getValue('complex')) {
continue 1;
}?>
                            <label class="label form__input-full">
                                <div class="label__content">
                                    <span class="label__name"><?php echo $_smarty_tpl->getValue('field')['title'];?>
</span>
                                </div>

                                <span class="label__wrapper label__wrapper--select">
                                    <select class="label__select" name="<?php echo $_smarty_tpl->getValue('field_key');?>
">
                                        <?php if ($_smarty_tpl->getValue('field')['title'] === "Группа") {?>
                                            <option value="0" <?php if (!$_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('field_key')}) {?>selected="selected"<?php }?>>Не выбрано</option>
                                        <?php }?>
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('field')['data'], 'option');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('option')->value) {
$foreach2DoElse = false;
?>
                                            <option value="<?php echo $_smarty_tpl->getValue('option')->id;?>
"
                                                    <?php if ($_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('field_key')} == $_smarty_tpl->getValue('option')->id) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('option')->title;?>
</option>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </select>
                                </span>
                            </label>
                        <?php } elseif ($_smarty_tpl->getValue('field')['type'] == 'checkbox') {?>
                            <div class="form__check-group label form__input-full">
                                <div class="form__check-group-inside">
                                    <label class="check ">
                                        <input class="check__input" name="<?php echo $_smarty_tpl->getValue('field_key');?>
"
                                               <?php if ($_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('field_key')}) {?>checked<?php }?> value="1" type="checkbox">
                                        <span class="check__name"><?php echo $_smarty_tpl->getValue('field')['title'];?>
</span>
                                    </label>
                                </div>
                            </div>
                        <?php } else { ?>
                            <label class="label form__input-full">
                                <div class="label__content">
                                    <span class="label__name"><?php echo $_smarty_tpl->getValue('field')['title'];?>
</span>
                                </div>
                                <span class="label__wrapper">
                            <input name="<?php echo $_smarty_tpl->getValue('field_key');?>
" type="text" class="label__input"
                                   value="<?php if ($_POST[$_smarty_tpl->getValue('field_key')]) {
echo $_POST[$_smarty_tpl->getValue('field_key')];
} else {
echo $_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('field_key')};
}?>"
                                   placeholder="">
                        </span>
                            </label>
                        <?php }?>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>
            </div>
        </form>
    </section>
<?php }
}
}
