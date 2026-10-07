<?php
/* Smarty version 5.8.0, created on 2026-03-02 13:51:50
  from 'file:content/widget.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a56bc6c4b529_18431012',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f5f516dee268f5bc70d99ea8c0fb71b4e266c04a' => 
    array (
      0 => 'content/widget.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a56bc6c4b529_18431012 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
if ($_smarty_tpl->getValue('state') == 'list') {?>
    <section class="catalog">
        <h1 class="h1 catalog__h1">Виджеты</h1>
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
            <?php if ($_smarty_tpl->getValue('list')) {?>
                <table class="catalog-table">
                    <thead>
                    <tr>
                        <th class="catalog-table__th"><span>Сервисное имя</span></th>
                        <th class="catalog-table__th"><span>Заголовок</span></th>
                        <th class="catalog-table__th"></th>
                        <th class="catalog-table__th"></th>
                        <th class="catalog-table__th"></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
                        <tr class="catalog-table__tr js-delete-element">
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->name;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->title;?>
</div>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">
                                    <input title="Опубликовать" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" <?php if ($_smarty_tpl->getValue('item')->public) {?>checked<?php }?>>
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
                                    <input title="Расскрыть" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" <?php if ($_smarty_tpl->getValue('item')->is_show) {?>checked<?php }?>>
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
                                            <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/edit/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class="ico-btn" aria-label="Редактировать">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>

                                            <a href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class="ico-btn js-delete" aria-label="Удалить" data-name="<?php echo $_smarty_tpl->getValue('item')->title;?>
">
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
                    </tbody>
                </table>
            <?php } else { ?>
                Список элементов пуст
            <?php }?>
        </div>

    </section>
<?php } else { ?>
    <div class="settings">
        <h1 class="h1 settings__h1">Виджеты</h1>
        <form action="" method="post" enctype="multipart/form-data" class="form  form--980">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Сервисное имя</span>
                        </div>

                        <span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->name;?>
" class="label__input" name="name" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Название</span>
                        </div>

                        <span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->title;?>
" class="label__input" name="title" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Иконка</span>
                        </div>

                        <span class="label__wrapper">
							<input type="text" value="<?php echo $_smarty_tpl->getValue('item')->icon;?>
" class="label__input" name="icon" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
                    </label>

                    <?php if ($_smarty_tpl->getValue('item')->name === "metric") {?>
                        <label class="label form__input-full">
                            <div class="label__content">
                                <span class="label__name">ID счётчика</span>
                            </div>

                            <span class="label__wrapper">
                                <input type="text" value="<?php echo $_smarty_tpl->getValue('item')->metric_id;?>
" class="label__input" name="metric_id" placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>

                        <label class="label form__input-full">
                            <div class="label__content">
                                <span class="label__name">Токен (<a href="https://yandex.ru/dev/metrika/ru/intro/authorization#get-oauth-token" target="_blank">Инструкция по получению</a></span>
                            </div>

                            <span class="label__wrapper">
                                <input type="text" value="<?php echo $_smarty_tpl->getValue('item')->metric_token;?>
" class="label__input" name="metric_token" placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>
                    <?php }?>

                    <div class="form__check-group label form__input-full">
                        <div class="form__check-group-inside">
                            <label class="check ">
                                <input class="check__input" name="public" value="1" <?php if ($_smarty_tpl->getValue('item')->public) {?>checked<?php }?> type="checkbox">
                                <span class="check__name">Опубликовать</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="is_show" value="1" <?php if ($_smarty_tpl->getValue('item')->is_show) {?>checked<?php }?> type="checkbox">
                                <span class="check__name">Расскрыть</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__check-group label form__input-full">
                <button name="save" value="Сохранить" type="submit" class="btn btn--blue btn--lg" style="width: fit-content;">
                    <span>Сохранить</span>
                </button>
            </div>
        </form>
    </div>
<?php }?>

<?php }
}
