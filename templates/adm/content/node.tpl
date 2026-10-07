<section class="catalog">
    {if $item->id}
        {include file='menu/node-actions.tpl' node=$item}
    {/if}

    <h1 class="h1 catalog__h1">{$item->title|default:"Новый раздел"}</h1>

    {if $item->id}
        {include file='menu/node-menu.tpl' node=$item active=node}
    {/if}

    <form action="" method="post" enctype="multipart/form-data" class="form">
        <input type="hidden" name="id" value="{$item->id}"/>
        <div class="form__fieldset">
            <div class="form__fieldset-wrap">
                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">Название раздела</span>
                    </div>
                    <span class="label__wrapper">
                        <input type="text" value="{$item->title}" class="label__input" name="title" placeholder="">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">Название в меню</span>
                    </div>
                    <span class="label__wrapper">
                        <input type="text" value="{$item->menutitle}" class="label__input" name="menutitle" placeholder="Введите название">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>

                {if !$item->blocked || $user->hasAccess('lock')}
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Относится к разделу</span>
                        </div>

                        <span class="label__wrapper label__wrapper--select">
                          <select id="node-parent" name="parent" class="label__select">
                            <option value="0" rel="">{$_LNG_ADM.ROOT_NODE}</option>
                            {include file='menu/parent-select.tpl' tree=$data.nodes cur_nid=$item->id cur_pid=$item->parent spacer=' - '}
                          </select>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">{$_LNG_ADM.COPY_BLOCKS}</span>
                        </div>

                        <span class="label__wrapper label__wrapper--select">
                          <select name="blocks_from" class="label__select">
                            <option value="">--{$_LNG_ADM.DONT_COPY}--</option>
                            <option disabled></option>
                            {include file='menu/parent-select.tpl' tree=$data.nodes cur_pid=$item->parent spacer=' - '}
                          </select>
                        </span>
                    </label>
                {/if}

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.ALIAS}</span>

                        <span class="label__text">{$_LNG_ADM.ALIAS_EXAMPLE}</span>
                    </div>
                    <span class="label__wrapper">
                        <input type="text" class="label__input" id="node-alias" name="alias" value="{$item->alias|escape}">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>
            </div>
        </div>
        <div class="form__fieldset">
            <div class="form__fieldset-wrap">
                {if !$item->blocked || $user->hasAccess('lock')}
                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.NODE_TEMPLATE}</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="template">
                            {foreach from=$data.templates item='template'}
                                <option value="{$template->id}"{if $template->id == $item->template->id} selected="selected"{/if}>{$template->title}</option>
                            {/foreach}
                        </select>
                </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.NODE_TYPE}</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="type" id="type">
                            {foreach from=$data.types item='type'}
                                <option value="{$type->type}"{if $type->type == $item->type->type} selected="selected"{/if}>{$type->title}</option>
                            {/foreach}
                        </select>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.CONTENT_TEMPLATE}</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="content_template" id="content_template">
                            {foreach from=$data.content item='template'}
                                {if
                                ($item->type->type && $item->type->type == $template->type)
                                || (!$item->type->type && $template->type == 'text')
                                }
                                <option
                                        value="{$template->id}"{if $template->id == $item->content_template->id} selected="selected"{/if}>{$template->title}</option>
                                {/if}
                            {/foreach}
                        </select>

                        <select class="hidden" id="content-template-storage" style="display: none;">
                            {foreach from=$data.content item='template'}
                                <option data-type="{$template->type}"
                                        value="{$template->id}"{if $template->id == $item->content_template->id} selected="selected"{/if}>{$template->title}</option>
                            {/foreach}
                        </select>
                    </span>
                </label>
                {/if}
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
                            {if $item->image->id}
                                <div class="img" data-rel="{$item->image->id}">
                                    <div class="img__inside">
                                        <img class="img__img" src="{$item->image->getLink('admin')}" alt="" width="50" height="50">
                                    </div>
                                    <div class="img__name">{$item->image->title}</div>
                                    <div class="btn img__close">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#clear"></use>
                                        </svg>
                                    </div>
                                    <label class="img__label">
                                        <input type="checkbox" name="clear_image" value="{$item->image->id}">
                                        <span>Удалить</span>
                                    </label>
                                </div>
                            {/if}
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
                            <input class="check__input" name="public" {if $item->public}checked{/if} value="1" type="checkbox">
                            <span class="check__name">Опубликовать раздел</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="sitemap" {if $item->sitemap}checked{/if} value="1" type="checkbox">
                            <span class="check__name">Отображать в карте сайта</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="nomenu" {if $item->nomenu}checked{/if} value="1" type="checkbox">
                            <span class="check__name">Скрыть в меню</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="nosearch" {if $item->nosearch}checked{/if} value="1" type="checkbox">
                            <span class="check__name">Скрыть в поиске</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="passworded" {if $item->passworded}checked{/if} value="1" type="checkbox">
                            <span class="check__name">Только для пользователей</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="selection" {if $item->selection}checked{/if} value="1" type="checkbox">
                            <span class="check__name">Сборная страница</span>
                        </label>
                        <label class="check ">
                            <input class="check__input" name="sadmin" {if $item->sadmin}checked{/if} value="1" type="checkbox">
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
</section>