{if $state == 'list'}
    <section class="catalog">
        <h1 class="h1 catalog__h1">Редиректы</h1>
        <div class="catalog-controls">
            <div class="catalog-controls__filter js-filter">
                <form class="filter-form">
                    <div class="filter-form__name">Фильтры</div>
                    <div class="filter-form__fieldset">
                        <label class="label ">
                            <div class="label__content">
                                <span class="label__name">Откуда:</span>
                            </div>

                            <span class="label__wrapper">
                                <input type="input" value="{$smarty.get.filter.from}" class="label__input" name="filter[from]" placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>

                        <label class="label ">
                            <div class="label__content">
                                <span class="label__name">Куда:</span>
                            </div>

                            <span class="label__wrapper">
                                <input type="input" value="{$smarty.get.filter.to}" class="label__input" name="filter[to]" placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>

                    </div>
                    <div class="filter-form__btns">
                        <button type="submit" class="btn btn--blue btn--lg">
                            <svg fill="none" width="12" height="16">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#filter"></use>
                            </svg>
                            <span>Применить</span>
                        </button>
                        <a href="{$path_prefix}" class="btn btn--bd btn--lg">
                            <svg fill="none" width="16" height="16">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#redo"></use>
                            </svg>
                            <span>Очистить</span>
                        </a>
                    </div>
                </form>
                <button class="btn btn--square btn--blue catalog-controls__close js-close">
                    <svg fill="none" width="20" height="20">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#cross"></use>
                    </svg>
                </button>
            </div>
            <div class="catalog-controls__btns catalog-controls__btns--full">
                <a href="{$path_prefix}/add" class="btn btn--blue btn--shrink">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#add"></use>
                    </svg>
                    <span>Добавить элемент</span>
                </a>
                <button type="submit" form="items-form" name="remove" value="1" class="btn btn--bd btn--shrink" data-name="Название раздела/элемента">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
                    </svg>
                    <span> Удалить </span>
                </button>
                <button class="btn btn--blue btn--square catalog-controls__filter-btn js-filter-toggler">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#filter"></use>
                    </svg>
                </button>
            </div>

            {include file='blocks/content/list/pages.tpl'}
        </div>
        {if $list}
            <form method="post" action="{$prefix_path}" enctype="multipart/form-data" id="items-form" class="table-wrapper catalog__table">
                <table class="catalog-table">
                    <thead>
                    <tr>
                        <th class="catalog-table__th">
                            <label class="check catalog-table__input check--light">
                                <input class="check__input" name="выбрать все" value="" type="checkbox">
                                <span class="check__name">выбрать все</span>
                            </label>
                        </th>
                        <th class="catalog-table__th">
                            <span>Откуда</span>
                        </th>
                        <th class="catalog-table__th"><span>Куда</span></th>
                        <th class="catalog-table__th ">
                            <div class="catalog-table__th-btns">
                                <span>Управление</span>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        {foreach from=$list item='item' name='items'}
                            <tr class="catalog-table__tr catalog-table__tr--redirect js-delete-element">
                                <td class="catalog-table__td">
                                    <label class="check catalog-table__input">
                                        <input class="check__input" name="list[{$item->id}]" value="1" type="checkbox">
                                        <span class="check__name">выбрать элемент</span>
                                    </label>
                                </td>
                                <td class="catalog-table__td">
                                    <a href="{$item->from}" class="catalog-item__link">{$item->from}</a>
                                </td>
                                <td class="catalog-table__td">
                                    <a href="{$item->to}" class="catalog-item__link">{$item->to}</a>
                                </td>

                                <td class="catalog-table__td " data-position="right">
                                    <div class="jsFixed">
                                        <div class="catalog-item__controls">
                                            <div class="ico-btns catalog-item__btns">
                                                <a href="{$path_prefix}/edit/{$item->id}" class="ico-btn" aria-label="Название того, что делает кнопка">
                                                    <svg fill="none" width="21" height="16">
                                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                                    </svg>
                                                </a>
                                                <a href="{$path_prefix}/delete/{$item->id}" class="ico-btn js-delete" aria-label="Название того, что делает кнопка" data-name="редирект с {$item->from} на {$item->to}">
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
                    </tbody>
                </table>
            </form>
        {else}
            Редиректы не найдены
        {/if}
    </section>
{elseif $state == 'add' || $state == 'edit'}
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
        <h1 class="h1 catalog__h1">Редиректы</h1>
        <form id="form-fields" class="form  form--980" action="" method="post" enctype="multipart/form-data">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    {foreach $data.fields as $field_key => $field}
                        {if $field.type == 'select'}
                            <label class="label form__input-full">
                                <div class="label__content">
                                    <span class="label__name">{$field.title}</span>
                                </div>

                                <span class="label__wrapper label__wrapper--select">
                            <select class="label__select" name="{$field_key}">
                                {foreach $field.data as $option}
                                    <option value="{$option->id}" {if $item->{$field_key} == $option->id}selected="selected"{/if}>{$option->title}</option>
                                {/foreach}
                            </select>
                        </span>
                            </label>
                        {elseif $field.type == 'checkbox'}
                            <div class="form__check-group label form__input-full">
                                <div class="form__check-group-inside">
                                    <label class="check ">
                                        <input class="check__input" name="{$field_key}"  {if $item->{$field_key}}checked{/if} value="1" type="checkbox">
                                        <span class="check__name">{$field.title}</span>
                                    </label>
                                </div>
                            </div>
                        {elseif $field.type == 'table_filters'}
                            <label class="label form__input-full">
                                <div class="label__content">
                                    <span class="label__name">{$field.title}</span>
                                </div>
                                <span class="label__wrapper label__wrapper--row">
                                    {assign var='row' value=$item->$field_key}
                                    <input name="{$field_key}[field][]" type="text" class="label__input" value="{if $row[0].field}{$row[0].field}{/if}" placeholder="Поле">

                                    <span class="label__wrapper label__wrapper--select">
                                        <select class="label__select" name="{$field_key}[operation][]">
                                            <option {if $row[0].operation && $row[0].operation == "="}selected{/if} value="=">=</option>
                                            <option {if $row[0].operation && $row[0].operation == ">"}selected{/if} value=">">&gt;</option>
                                            <option {if $row[0].operation && $row[0].operation == "="}selected{/if} value="<">&lt;</option>
                                            <option {if $row[0].operation && $row[0].operation == ">="}selected{/if} value=">=">&gt;=</option>
                                            <option {if $row[0].operation && $row[0].operation == "<="}selected{/if} value="<=">&lt;=</option>
                                            <option {if $row[0].operation && $row[0].operation == "<>"}selected{/if} value="<>">!=</option>
                                        </select>
                                    </span>

                                    <input name="{$field_key}[value][]" type="text" class="label__input" value="{if $row[0].value}{$row[0].value}{/if}" placeholder="Значение">
                                </span>
                            </label>
                        {else}
                            <label class="label form__input-full">
                                <div class="label__content">
                                    <span class="label__name">{$field.title}</span>
                                </div>
                                <span class="label__wrapper">
                                    <input name="{$field_key}" type="text" class="label__input" value="{if $smarty.post.$field_key}{$smarty.post.$field_key}{else}{$item->$field_key}{/if}" placeholder="">
                                </span>
                            </label>
                        {/if}
                    {/foreach}
                </div>
            </div>
        </form>
    </section>
{/if}