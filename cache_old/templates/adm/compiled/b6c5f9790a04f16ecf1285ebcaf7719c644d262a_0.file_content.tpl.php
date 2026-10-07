<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:35
  from 'file:content/content.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e8940f24eea8_19033386',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'b6c5f9790a04f16ecf1285ebcaf7719c644d262a' => 
    array (
      0 => 'content/content.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/node-actions.tpl' => 1,
    'file:menu/node-menu.tpl' => 2,
    'file:blocks/content/list/controls.tpl' => 1,
  ),
))) {
function content_69e8940f24eea8_19033386 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
if ($_smarty_tpl->getValue('node')->id) {?>
    <?php $_smarty_tpl->renderSubTemplate('file:menu/node-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->getValue('node')), (int) 0, $_smarty_current_dir);
}?>
<section class="catalog" data-node="<?php echo $_smarty_tpl->getValue('node')->id;?>
" data-type="item">
    <?php if ($_smarty_tpl->getValue('state') == 'list') {?>
        <h1 class="h1 catalog__h1"><?php echo $_smarty_tpl->getValue('node')->title;?>
</h1>
        <?php if ($_smarty_tpl->getValue('node')->id) {?>
            <?php $_smarty_tpl->renderSubTemplate('file:menu/node-menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->getValue('node'),'active'=>'content'), (int) 0, $_smarty_current_dir);
?>
        <?php }?>
        <div class="top"></div>
        <?php if (!( !$_smarty_tpl->hasVariable('errors') || empty($_smarty_tpl->getValue('errors'))) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('errors')) > 0) {?>
            <div class="messages">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('errors'), 'message');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('message')->value) {
$foreach0DoElse = false;
?>
                    <?php echo $_smarty_tpl->getValue('message')->html;?>

                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        <?php }?>

        <?php $_smarty_tpl->renderSubTemplate('file:blocks/content/list/controls.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

        <?php if ($_smarty_tpl->getValue('list')) {?>
            <form id="catalog-list-form" method="post"
                  class="table-wrapper catalog__table <?php if ($_smarty_tpl->getValue('node')->type->sortable) {?>catalog__table--sortable<?php }?>">
                <table class="catalog-table">
                    <thead>
                    <tr>
                        <?php if ($_smarty_tpl->getValue('node')->type->sortable) {?>
                            <th class="catalog-table__th"></th>
                        <?php }?>
                        <th class="catalog-table__th">
                            <label class="check catalog-table__input check--light">
                                <input class="check__input" name="selectAll" value="1" type="checkbox">
                                <span class="check__name">выбрать все</span>
                            </label>
                        </th>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('fields')['text'], 'field');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach1DoElse = false;
?>
                            <th class="catalog-table__th"><?php echo $_smarty_tpl->getValue('field')->title;?>
</th>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        <th class="catalog-table__th"></th>
                        <th class="catalog-table__th">Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item', false, NULL, 'list', array (
));
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach2DoElse = false;
?>
                        <tr class="catalog-table__tr" data-order="<?php echo $_smarty_tpl->getValue('item')->id;?>
">
                            <?php if ($_smarty_tpl->getValue('node')->type->sortable) {?>
                                <td class="catalog-table__td">
                                    <div class="js-handle">
                                        <svg fill="none" width="7" height="13">
                                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#dots2"></use>
                                        </svg>
                                    </div>
                                </td>
                            <?php }?>

                            <td class="catalog-table__td">
                                <label class="check catalog-table__input">
                                    <input class="check__input" name="list[<?php echo $_smarty_tpl->getValue('item')->id;?>
]" value="1" type="checkbox">
                                    <span class="check__name">выбрать элемент</span>
                                </label>
                            </td>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('fields')['text'], 'field');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach3DoElse = false;
?>
                                <?php $_smarty_tpl->assign('key', $_smarty_tpl->getValue('field')->name, false, NULL);?>
                                <?php if ($_smarty_tpl->getValue('field')->field == 'image') {?>
                                    <td class="catalog-table__td">
                                        <?php if ($_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('key')}->id) {?>
                                            <span class="catalog-item__img">
                                                <img src="<?php echo $_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('key')}->getLink();?>
" class="" width="49" height="38">
                                            </span>
                                        <?php }?>
                                    </td>
                                <?php } else { ?>
                                    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('in_array')($_smarty_tpl->getValue('field')->field,array("text","textarea","integer"))) {?>
                                        <td class="catalog-table__td" data-edit="true">
                                            <div class="catalog-table__td-inside" data-node="<?php echo $_smarty_tpl->getValue('node')->id;?>
"
                                                 data-itemid="<?php echo $_smarty_tpl->getValue('item')->id;?>
"
                                                 data-field="<?php echo $_smarty_tpl->getValue('key');?>
" tabindex="0">
                                                <div class="catalog-item__name" contenteditable="false">
                                                    <?php echo $_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('key')};?>

                                                </div>
                                            </div>
                                        </td>
                                    <?php } else { ?>
                                        <td class="catalog-table__td">
                                            <span class="catalog-item__name"><?php echo $_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('key')};?>
</span>
                                        </td>
                                    <?php }?>
                                <?php }?>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                            <td class="catalog-table__td">
                                <span class="catalog-item__inside">
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('fields')['checkbox'], 'field', false, NULL, 'fields', array (
));
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach4DoElse = false;
?>
                                        <?php $_smarty_tpl->assign('key', $_smarty_tpl->getValue('field')->name, false, NULL);?>
                                        <label class=" input-elt" title="<?php echo $_smarty_tpl->getValue('field')->title;?>
">
                                            <input data-node="<?php echo $_smarty_tpl->getValue('node')->id;?>
" data-id="<?php echo $_smarty_tpl->getValue('item')->id;?>
"
                                                   class="input-elt__input ajax-node-field" type="checkbox"
                                                   value="1" name="<?php echo $_smarty_tpl->getValue('field')->name;?>
"
                                                   <?php if ($_smarty_tpl->getValue('item')->{$_smarty_tpl->getValue('key')}) {?>checked<?php }?>>
                                            <span class="input-elt__fake">
                                                <svg fill="none" width="21" height="16">
                                                  <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
                                                </svg>
                                            </span>
                                          <span class="input-elt__text">выбрать ...</span>
                                        </label>
                                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                </span>
                            </td>
                            <td class="catalog-table__td" data-position="right">
                                <div class="jsFixed">
                                    <div class="catalog-item__controls">
                                        <div class="ico-btns catalog-item__btns">
                                            <label class=" input-elt ico-btn" title="Опубликовать">
                                                <input data-node="<?php echo $_smarty_tpl->getValue('node')->id;?>
" data-id="<?php echo $_smarty_tpl->getValue('item')->id;?>
"
                                                       class="input-elt__input ajax-node-field" type="checkbox"
                                                       value="1"
                                                       name="public" <?php if ($_smarty_tpl->getValue('item')->public) {?>checked<?php }?>>
                                                <span class="input-elt__fake">
                                                     <svg fill="none" width="21" height="16">
                                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#eye"></use>
                                                    </svg>
                                                </span>
                                                <span class="input-elt__text">выбрать ...</span>
                                            </label>
                                            <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/content/edit/<?php echo $_smarty_tpl->getValue('node')->id;?>
/<?php echo $_smarty_tpl->getValue('item')->id;?>
" class="ico-btn"
                                               aria-label="Название того, что делает кнопка">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>
                                            <a href="<?php echo $_smarty_tpl->getValue('item')->getUrl();?>
" class="ico-btn"
                                               alt="Перейти на страницу товара">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#open"></use>
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
            </form>
        <?php } else { ?>
            Элементы не найдены
        <?php }?>
    <?php } elseif ($_smarty_tpl->getValue('state') == 'edit' || $_smarty_tpl->getValue('state') == 'add') {?>
        <h1 class="h1 catalog__h1"><?php echo $_smarty_tpl->getValue('node')->title;?>
</h1>
        <?php if ($_smarty_tpl->getValue('node')->id && !$_smarty_tpl->getValue('node')->type->has_items) {?>
            <?php $_smarty_tpl->renderSubTemplate('file:menu/node-menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->getValue('node'),'active'=>'content'), (int) 0, $_smarty_current_dir);
?>
        <?php }?>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="catalog__item-top">
                <div class="item-controls js-to-expand">
                    <?php if ($_smarty_tpl->getValue('node')->type->has_items) {?>
                        <a href="/adm/content/list/<?php echo $_smarty_tpl->getValue('node')->id;?>
" class="btn btn--link item-controls__back">
                            <svg fill="none" width="12" height="12">
                                <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                            </svg>
                            <span>В список</span>
                        </a>
                    <?php }?>
                    <div class="btn btn--link item-controls__more js-expand " aria-label="Открыть кнопки">
                        <svg fill="none" width="34" height="8">
                            <use xlink:href="/adm/assets/img/sprite.svg#dots"></use>
                        </svg>
                    </div>
                    <div class="item-controls__short">
                        <div class="item-controls__group">
                            <button name="save_item" value="Применить" class="btn btn--bd btn--lg item-controls__btn">
                                <span>Применить</span>
                            </button>
                            <button class="btn btn--blue btn--lg item-controls__btn" disabled="">
                                <span>Вернуть данные</span>
                            </button>
                            <button class="btn btn--blue btn--lg item-controls__btn" disabled="">
                                <span>Отменить</span>
                            </button>
                        </div>
                        <?php if ($_smarty_tpl->getValue('item')->id) {?>
                            <div class="item-controls__group">
                                <button type="submit" name="favorite"
                                        value="<?php if (App\Item\Favorite::isFavorite($_SERVER['REQUEST_URI'])) {?>0<?php } else { ?>1<?php }?>"
                                        class="btn btn--short">
                                    <svg fill="none" width="16" height="16">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#<?php if (App\Item\Favorite::isFavorite($_SERVER['REQUEST_URI'])) {?>heart-filled<?php } else { ?>heart<?php }?>"></use>
                                    </svg>
                                    <span><?php if (App\Item\Favorite::isFavorite($_SERVER['REQUEST_URI'])) {?>Удалить из избранного<?php } else { ?>В избранное<?php }?></span>
                                </button>

                                <?php if ($_smarty_tpl->getValue('node')->type->has_items) {?>
                                    <button type="submit" name="copy_item" value="Копировать" class="btn btn--short">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="/adm/assets/img/sprite.svg#copy"></use>
                                        </svg>
                                        <span>Копировать</span>
                                    </button>
                                <?php }?>

                                <?php if ($_smarty_tpl->getValue('node')->type->has_items) {?>
                                    <a href="<?php echo $_smarty_tpl->getValue('item')->getUrl();?>
" target="_blank" class="btn btn--short">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="/adm/assets/img/sprite.svg#open"></use>
                                        </svg>
                                        <span>Открыть на сайте</span>
                                    </a>
                                    <a type="submit" href="<?php echo $_smarty_tpl->getValue('path_prefix');?>
/delete/<?php echo $_smarty_tpl->getValue('node')->id;?>
/<?php echo $_smarty_tpl->getValue('item')->id;?>
"
                                       class="btn btn--short js-delete" data-name="<?php echo $_smarty_tpl->getValue('item')->title;?>
">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="/adm/assets/img/sprite.svg#trash"></use>
                                        </svg>
                                        <span>Удалить</span>
                                    </a>
                                <?php }?>
                            </div>
                        <?php }?>
                    </div>
                    <button name="save" value="Применить" class="btn btn--blue btn--lg">
                        <span>Сохранить</span>
                    </button>
                </div>

                <div class="catalog__tabs">

                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('groups'), 'group', false, 'key', 'head_groups', array (
  'first' => true,
  'index' => true,
));
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('key')->value => $_smarty_tpl->getVariable('group')->value) {
$foreach5DoElse = false;
$_smarty_tpl->tpl_vars['__smarty_foreach_head_groups']->value['index']++;
$_smarty_tpl->tpl_vars['__smarty_foreach_head_groups']->value['first'] = !$_smarty_tpl->tpl_vars['__smarty_foreach_head_groups']->value['index'];
?>
                        <a href="#tab<?php echo $_smarty_tpl->getValue('key');?>
" class="tab-name <?php if (($_smarty_tpl->getValue('__smarty_foreach_head_groups')['first'] ?? null)) {?>active<?php }?>"
                           title="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('group')['title'], ENT_QUOTES, 'UTF-8', true);?>
">
                            <?php echo $_smarty_tpl->getValue('group')['title'];?>

                        </a>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>
            </div>
            <div class="form">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('groups'), 'group', false, 'key', 'body_groups', array (
));
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('key')->value => $_smarty_tpl->getVariable('group')->value) {
$foreach6DoElse = false;
?>
                    <div class="form__fieldset">
                        <h2 class="form__h2" id="tab<?php echo $_smarty_tpl->getValue('key');?>
"><?php echo $_smarty_tpl->getValue('group')['title'];?>
</h2>
                        <div class="form__fieldset-wrap">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('group')['fields'], 'field');
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach7DoElse = false;
?>
                                <?php $_smarty_tpl->renderSubTemplate((('content/fields/').($_smarty_tpl->getValue('field')->field)).('.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </div>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        </form>
    <?php }?>
</section><?php }
}
