<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:52:03
  from 'file:content/admin.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a56bd32dfb02_19151793',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6c65ab37c5b1f67203554d8e7338ad97e29ec653' => 
    array (
      0 => 'content/admin.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a56bd32dfb02_19151793 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
if ($_smarty_tpl->getValue('state') == 'list') {?>
    <section class="catalog">
        <h1 class="h1 catalog__h1">Администраторы системы</h1>
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
        <div class="table-wrapper catalog__table">
            <table class="catalog-table">
                <thead>
                <tr>
                    <th class="catalog-table__th"><span>Имя</span></th>
                    <th class="catalog-table__th"><span>Логин</span></th>
                    <th class="catalog-table__th"><span>Последний вход</span></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>

                <?php if ($_smarty_tpl->getValue('list')) {?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'admin');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('admin')->value) {
$foreach0DoElse = false;
?>
                        <tr class="catalog-table__tr js-delete-element">
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('admin')->name;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('admin')->login;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('admin')->lastlogin;?>
</div>
                            </td>
                            <td class="catalog-table__td " data-position="right">
                                <div class="jsFixed">
                                    <div class="ico-btns catalog-item__btns">
                                        <label class="input-elt ico-btn">
                                            <input
                                                    data-id="1"
                                                    data-node="1"
                                                    class="input-elt__input ajax-node-field"
                                                    type="checkbox"
                                                    value="1"
                                                    name="1"
                                                    <?php if ($_smarty_tpl->getValue('admin')->active) {?>checked<?php }?>
                                            >
                                            <span class="input-elt__fake">
                                            <svg fill="none" width="21" height="16">
                                                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#eye"></use>
                                            </svg>
                                        </span>
                                            <span class="input-elt__text">выбрать ...</span>
                                        </label>

                                        <a class="ico-btn" href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/edit/<?php echo $_smarty_tpl->getValue('admin')->id;?>
"
                                           title="Редактировать">
                                            <svg fill="none" width="16" height="16">
                                                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
                                            </svg>
                                        </a>

                                        <?php if ($_smarty_tpl->getValue('admin')->role != 'sadmin' && $_smarty_tpl->getValue('user')->id != $_smarty_tpl->getValue('admin')->id) {?>
                                            <a class="ico-btn js-delete" href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('admin')->id;?>
"
                                               title="Удалить" data-name="<?php echo $_smarty_tpl->getValue('admin')->name;?>
">
                                                <svg fill="none" width="16" height="16">
                                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
                                                </svg>
                                            </a>
                                        <?php }?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                <?php } else { ?>
                    <tr class="catalog-table__tr undefined">
                        <td align="center" colspan="11" class="catalog-table__td">Администаторы не найдены</td>
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

                                                                                                                                                
                        <?php if ($_smarty_tpl->getValue('item')->role != 'sadmin' && $_smarty_tpl->getValue('user')->id != $_smarty_tpl->getValue('item')->id) {?>
                            <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class="btn btn--short js-delete">
                                <svg fill="none" width="16" height="16">
                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#trash"></use>
                                </svg>
                                <span>Удалить раздел</span>
                            </a>
                        <?php }?>
                    </div>
                </div>
                <button name="save" value="Сохранить" type="submit" form="admin-form" class="btn btn--blue btn--lg">
                    <span>Сохранить</span>
                </button>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="admin-form" class="form  form--980">
            <div class="form__fieldset">
                <h2 class="form__h2">Общая информация</h2>
                <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('errors')) > 0) {?>
                    <div class="messages">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('errors'), 'message');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('message')->value) {
$foreach1DoElse = false;
?>
                            <?php echo $_smarty_tpl->getValue('message')->html;?>

                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                <?php }?>
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Имя:</span>
                        </div>
                        <span class="label__wrapper">
                            <input type="text" value="<?php echo $_smarty_tpl->getValue('item')->name ?: $_POST['name'];?>
" class="label__input" name="name" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Логин:</span>
                        </div>

                        <span class="label__wrapper">
                            <input type="text" value="<?php echo $_smarty_tpl->getValue('item')->login ?: $_POST['login'];?>
" class="label__input" name="login" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Новый пароль:</span>
                        </div>

                        <span class="label__wrapper">
                            <input type="text" value="" class="label__input" name="newpass" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Повторите пароль</span>
                        </div>

                        <span class="label__wrapper">
                            <input type="text" value="" class="label__input" name="newpass2" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    <?php if ($_smarty_tpl->getValue('item')->role != 'sadmin' && $_smarty_tpl->getValue('user')->id != $_smarty_tpl->getValue('item')->id) {?>
                        <div class="label form__input-full">
                            <label class="label__name">
                                Доступные действия
                            </label>

                            <div id="multiselect-access" class="js-multiselect">
                                <select id="access" name="access[]" class="select" multiple="multiple">
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['actions'], 'action');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('action')->value) {
$foreach2DoElse = false;
?>
                                        <option <?php if (is_array($_smarty_tpl->getValue('item')->access) && $_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('action')->action,$_smarty_tpl->getValue('item')->access) || $_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('action')->action,$_POST['access'])) {?> selected<?php }?>
                                                value="<?php echo $_smarty_tpl->getValue('action')->action;?>
"><?php if ($_smarty_tpl->getValue('action')->title) {
echo $_smarty_tpl->getValue('action')->title;
} else {
echo $_smarty_tpl->getValue('action')->action;
}?></option>
                                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                </select>
                            </div>
                        </div>
                    <?php }?>

                    <?php if ($_smarty_tpl->getValue('user')->id != $_smarty_tpl->getValue('item')->id) {?>
                        <div class="label form__input-full">
                            <div class="label__content">
                                <span class="label__name">Активен:</span>
                            </div>
                            <span class="label__wrapper">
                                <label class="check ">
                                    <input class="check__input" name="active" <?php if ($_smarty_tpl->getValue('item')->active || $_POST['active']) {?>checked<?php }?> value="1"
                                           type="checkbox">
                                </label>
                            </span>
                        </div>
                    <?php }?>
                </div>
            </div>
        </form>
    </section>
<?php }
}
}
