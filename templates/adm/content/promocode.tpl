{if $state == 'list'}
    <section class="catalog">
        <h1 class="h1 catalog__h1">Промокоды</h1>
        <div class="top"></div>
        <div class="catalog-controls">
            <div class="catalog-controls__btns">
                <a href="{$path_prefix}/add/{$module->id}" class="btn btn--blue btn--shrink">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="/adm/assets/img/sprite.svg#add"></use>
                    </svg>
                    <span>Добавить промокод</span>
                </a>
            </div>
        </div>
        <div class="table-wrapper catalog__table">
            <table class="catalog-table">
                <thead>
                <tr>
                    <th class="catalog-table__th"><span>Наименование</span></th>
                    <th class="catalog-table__th"><span>Код</span></th>
                    <th class="catalog-table__th"><span>Скидка %</span></th>
                    <th class="catalog-table__th "><span>Активность</span></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>
                {if $list|@count > 0}
                    {foreach from=$list item='item'}
                        <tr class="catalog-table__tr js-delete-element">
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->title}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->code}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->sale}</div>
                            </td>

                            <td class="catalog-table__td">
                                <label class=" input-elt">

                                    <input
                                            data-id="1"
                                            data-node="1"
                                            class="input-elt__input ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="active"
                                            {if $item->active}checked{/if}
                                    >
                                    <span class="input-elt__fake">
                                            <svg fill="none" width="21" height="16">
                                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#tick"></use>
                                            </svg>
                                        </span>
                                    <span class="input-elt__text">выбрать ...</span>
                                </label>
                            </td>
                            <td class="catalog-table__td" data-position="right">
                                <div class="jsFixed">
                                    <div class="catalog-item__controls">
                                        <div class="ico-btns catalog-item__btns">
                                            <a href="{$path_prefix}/edit/{$item->id}" class="ico-btn"
                                               aria-label="Редактировать">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>

                                            <a href="{$path_prefix}/delete/{$item->id}" class="ico-btn js-delete"
                                               data-name="{$item->title}" aria-label="Удалить">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
                                                </svg>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                {/if}
                </tbody>
            </table>
        </div>
    </section>
{elseif $state == 'edit' || $state == 'add'}
    <section class="catalog">
        <div class="catalog__item-top">
            <div class="item-controls js-to-expand">
                <a href="{$path_prefix}/list" class="btn btn--link item-controls__back">
                    <svg fill="none" width="12" height="12">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                    </svg>
                    <span>В список</span>
                </a>
                <button class="btn btn--link item-controls__more js-expand " aria-label="Открыть кнопки">
                    <svg fill="none" width="34" height="8">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots"></use>
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
            {if $item->type}{include file='menu/module-actions.tpl' type=$module active=param}{/if}
        </div>

        <h1 class="h1 catalog__h1">Промокоды</h1>

        {if $errors|@count > 0}
            <div class="messages">
                {foreach from=$errors item='message'}
                    {$message->html}
                {/foreach}
            </div>
        {/if}

        <form id="form-fields" class="form  form--980" action="" method="post" enctype="multipart/form-data">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Заголовок:</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="title" type="text" class="label__input"
                                   value="{if $smarty.post.title}{$smarty.post.title}{else}{$item->title}{/if}"
                                   placeholder="">
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Тип</span>
                        </div>

                        <span class="label__wrapper label__wrapper--select">
                            <select class="label__select" name="type">
                                {foreach from=$item->types item='type' key='keyType'}
                                    <option value="{$keyType}" {if $keyType == $item->type}selected="selected"{/if}>{$type}</option>
                                {/foreach}
                            </select>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Код:</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="code" type="text" class="label__input"
                                   value="{if $smarty.post.code}{$smarty.post.code}{else}{$item->code}{/if}"
                                   placeholder="">
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Скидка в %:</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="sale" type="text" class="label__input"
                                   value="{if $smarty.post.sale}{$smarty.post.sale}{else}{$item->sale}{/if}"
                                   placeholder="">
                        </span>
                    </label>

                    <div class="label form__input-full">
                        <label class="label__name">Товары:</label>
                        {$products}
                    </div>

                    <div class="label form__input-full">
                        <label class="label__name">Категории:</label>
                        {$nodes}
                    </div>

                    <div class="form__check-group label form__input-full">
                        <div class="form__check-group-inside">
                            <label class="check ">
                                <input class="check__input" name="active"
                                       {if $item->active || $smarty.post.active}checked{/if} value="1" type="checkbox">
                                <span class="check__name">Активен</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
{/if}
