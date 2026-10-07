<?php
/* Smarty version 5.8.0, created on 2026-02-25 13:42:03
  from 'file:content/node.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_699ed1fb7ef877_05131577',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'aa26e3af97fa1fc45ac2c579c1e8b98e489281e0' => 
    array (
      0 => 'content/node.tpl',
      1 => 1771942631,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:menu/node-actions.tpl' => 1,
    'file:menu/node-menu.tpl' => 1,
    'file:menu/parent-select.tpl' => 2,
  ),
))) {
function content_699ed1fb7ef877_05131577 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
?><section class="catalog">
    <?php if ($_smarty_tpl->getValue('item')->id) {?>
        <?php $_smarty_tpl->renderSubTemplate('file:menu/node-actions.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->getValue('item')), (int) 0, $_smarty_current_dir);
?>
    <?php }?>

    <h1 class="h1 catalog__h1"><?php echo (($tmp = $_smarty_tpl->getValue('item')->title ?? null)===null||$tmp==='' ? "Новый раздел" ?? null : $tmp);?>
</h1>

    <?php if ($_smarty_tpl->getValue('item')->id) {?>
        <?php $_smarty_tpl->renderSubTemplate('file:menu/node-menu.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('node'=>$_smarty_tpl->getValue('item'),'active'=>'node'), (int) 0, $_smarty_current_dir);
?>
    <?php }?>

    <form action="" method="post" enctype="multipart/form-data" class="form">
        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->getValue('item')->id;?>
"/>
        <div class="form__fieldset">
            <div class="form__fieldset-wrap">
                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">Название раздела</span>
                    </div>
                    <span class="label__wrapper">
                        <input type="text" value="<?php echo $_smarty_tpl->getValue('item')->title;?>
" class="label__input" name="title" placeholder="">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">Название в меню</span>
                    </div>
                    <span class="label__wrapper">
                        <input type="text" value="<?php echo $_smarty_tpl->getValue('item')->menutitle;?>
" class="label__input" name="menutitle" placeholder="Введите название">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>

                <?php if (!$_smarty_tpl->getValue('item')->blocked || $_smarty_tpl->getValue('user')->hasAccess('lock')) {?>
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Относится к разделу</span>
                        </div>

                        <span class="label__wrapper label__wrapper--select">
                          <select id="node-parent" name="parent" class="label__select">
                            <option value="0" rel=""><?php echo $_smarty_tpl->getValue('_LNG_ADM')['ROOT_NODE'];?>
</option>
                            <?php $_smarty_tpl->renderSubTemplate('file:menu/parent-select.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tree'=>$_smarty_tpl->getValue('data')['nodes'],'cur_nid'=>$_smarty_tpl->getValue('item')->id,'cur_pid'=>$_smarty_tpl->getValue('item')->parent,'spacer'=>' - '), (int) 0, $_smarty_current_dir);
?>
                          </select>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name"><?php echo $_smarty_tpl->getValue('_LNG_ADM')['COPY_BLOCKS'];?>
</span>
                        </div>

                        <span class="label__wrapper label__wrapper--select">
                          <select name="blocks_from" class="label__select">
                            <option value="">--<?php echo $_smarty_tpl->getValue('_LNG_ADM')['DONT_COPY'];?>
--</option>
                            <option disabled></option>
                            <?php $_smarty_tpl->renderSubTemplate('file:menu/parent-select.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('tree'=>$_smarty_tpl->getValue('data')['nodes'],'cur_pid'=>$_smarty_tpl->getValue('item')->parent,'spacer'=>' - '), (int) 0, $_smarty_current_dir);
?>
                          </select>
                        </span>
                    </label>
                <?php }?>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name"><?php echo $_smarty_tpl->getValue('_LNG_ADM')['ALIAS'];?>
</span>

                        <span class="label__text"><?php echo $_smarty_tpl->getValue('_LNG_ADM')['ALIAS_EXAMPLE'];?>
</span>
                    </div>
                    <span class="label__wrapper">
                        <input type="text" class="label__input" id="node-alias" name="alias" value="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('item')->alias, ENT_QUOTES, 'UTF-8', true);?>
">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>
            </div>
        </div>
        <div class="form__fieldset">
            <div class="form__fieldset-wrap">
                <?php if (!$_smarty_tpl->getValue('item')->blocked || $_smarty_tpl->getValue('user')->hasAccess('lock')) {?>
                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name"><?php echo $_smarty_tpl->getValue('_LNG_ADM')['NODE_TEMPLATE'];?>
</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="template">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['templates'], 'template');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('template')->value) {
$foreach0DoElse = false;
?>
                                <option value="<?php echo $_smarty_tpl->getValue('template')->id;?>
"<?php if ($_smarty_tpl->getValue('template')->id == $_smarty_tpl->getValue('item')->template->id) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('template')->title;?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>
                </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name"><?php echo $_smarty_tpl->getValue('_LNG_ADM')['NODE_TYPE'];?>
</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="type" id="type">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['types'], 'type');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('type')->value) {
$foreach1DoElse = false;
?>
                                <option value="<?php echo $_smarty_tpl->getValue('type')->type;?>
"<?php if ($_smarty_tpl->getValue('type')->type == $_smarty_tpl->getValue('item')->type->type) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('type')->title;?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name"><?php echo $_smarty_tpl->getValue('_LNG_ADM')['CONTENT_TEMPLATE'];?>
</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="content_template" id="content_template">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['content'], 'template');
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('template')->value) {
$foreach2DoElse = false;
?>
                                <?php if (($_smarty_tpl->getValue('item')->type->type && $_smarty_tpl->getValue('item')->type->type == $_smarty_tpl->getValue('template')->type) || (!$_smarty_tpl->getValue('item')->type->type && $_smarty_tpl->getValue('template')->type == 'text')) {?>
                                <option
                                        value="<?php echo $_smarty_tpl->getValue('template')->id;?>
"<?php if ($_smarty_tpl->getValue('template')->id == $_smarty_tpl->getValue('item')->content_template->id) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('template')->title;?>
</option>
                                <?php }?>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>

                        <select class="hidden" id="content-template-storage" style="display: none;">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('data')['content'], 'template');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('template')->value) {
$foreach3DoElse = false;
?>
                                <option data-type="<?php echo $_smarty_tpl->getValue('template')->type;?>
"
                                        value="<?php echo $_smarty_tpl->getValue('template')->id;?>
"<?php if ($_smarty_tpl->getValue('template')->id == $_smarty_tpl->getValue('item')->content_template->id) {?> selected="selected"<?php }?>><?php echo $_smarty_tpl->getValue('template')->title;?>
</option>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </select>
                    </span>
                </label>
                <?php }?>
                <div class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">Изображение раздела</span>
                    </div>
                    <div class="label__wrapper-imgs">
                        <div class="label__wrapper-btns">
                            <label class="btn btn--lg btn--blue label__file-wrapper">
                                <input type="file" class="label__file" id="img" name="image" accept="image/*"
                                       value="">
                                <svg fill="none" width="16" height="16">
                                    <use xlink:href="/adm/assets/img/sprite.svg#"></use>
                                </svg>
                                <span>Загрузить с компьютера</span>
                                <div class="label__file-uploader uploader"><div class="uploader-inside"></div></div>
                            </label>
                        </div>

                        <div class="label__imgs imgs imgs--sortable">
                            <?php if ($_smarty_tpl->getValue('item')->image->id) {?>
                                <div class="img" data-rel="<?php echo $_smarty_tpl->getValue('item')->image->id;?>
">
                                    <div class="img__inside">
                                        <img class="img__img" src="<?php echo $_smarty_tpl->getValue('item')->image->getLink('admin');?>
" alt="" width="50" height="50">
                                    </div>
                                    <div class="img__name"><?php echo $_smarty_tpl->getValue('item')->image->title;?>
</div>
                                    <div class="btn img__close">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#clear"></use>
                                        </svg>
                                    </div>
                                    <label class="img__label">
                                        <input type="checkbox" name="clear_image" value="<?php echo $_smarty_tpl->getValue('item')->image->id;?>
">
                                        <span>Удалить</span>
                                    </label>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="form__fieldset">
            <div class="form__fieldset-wrap">
                <div class="form__check-group label form__input-full">
                    <div class="form__check-group-inside">
                        <label class="check ">
                            <input class="check__input" name="public" <?php if ($_smarty_tpl->getValue('item')->public) {?>checked<?php }?> value="1" type="checkbox">
                            <span class="check__name">Опубликовать раздел</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="sitemap" <?php if ($_smarty_tpl->getValue('item')->sitemap) {?>checked<?php }?> value="1" type="checkbox">
                            <span class="check__name">Отображать в карте сайта</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="nomenu" <?php if ($_smarty_tpl->getValue('item')->nomenu) {?>checked<?php }?> value="1" type="checkbox">
                            <span class="check__name">Скрыть в меню</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="nosearch" <?php if ($_smarty_tpl->getValue('item')->nosearch) {?>checked<?php }?> value="1" type="checkbox">
                            <span class="check__name">Скрыть в поиске</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="passworded" <?php if ($_smarty_tpl->getValue('item')->passworded) {?>checked<?php }?> value="1" type="checkbox">
                            <span class="check__name">Только для пользователей</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="selection" <?php if ($_smarty_tpl->getValue('item')->selection) {?>checked<?php }?> value="1" type="checkbox">
                            <span class="check__name">Сборная страница</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="sadmin" <?php if ($_smarty_tpl->getValue('item')->sadmin) {?>checked<?php }?> value="1" type="checkbox">
                            <span class="check__name">Выводить в списке только у разработчика</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form__check-group label form__input-full">
            <button type="submit" name="save" value="1" class="btn btn--blue btn--lg" style="width: fit-content;">
                <span>Сохранить</span>
            </button>
        </div>
    </form>
</section><?php }
}
