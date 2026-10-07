{if $state == 'list'}
    <section class="catalog" data-type="nodeparams">
        <div class="catalog__item-top">
            {include file='menu/module-actions.tpl' type=$module active=param}
        </div>
        <h1 class="h1 catalog__h1">Параметры</h1>
        <div class="catalog-controls">
            <div class="catalog-controls__btns">
                <a href="{$path_prefix}/add/{$module->id}" class="btn btn--blue btn--shrink">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="/adm/assets/img/sprite.svg#add"></use>
                    </svg>
                    <span>Добавить параметр</span>
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
                    <th class="catalog-table__th "><span>В разделе</span></th>
                    <th class="catalog-table__th "><span>В блоке</span></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>
                {if $list}
                    {foreach $list as $item}
                        <tr class="catalog-table__tr js-delete-element" data-order="{$item->id}">
                            <td class="catalog-table__td">
                                <div class="js-handle">
                                    <svg fill="none" width="7" height="13">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
                                    </svg>
                                </div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->title}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->name}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->field}</div>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">

                                    <input
                                            data-id="1"
                                            data-node="1"
                                            class="input-elt__input ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="edit_in_node"
                                            {if $item->edit_in_node}checked{/if}
                                    >
                                    <span class="input-elt__fake">
                                            <svg fill="none" width="21" height="16">
                                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#tick"></use>
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
                                            name="local"
                                            {if $item->local}checked{/if}
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
                                            <a href="{$path_prefix}/edit/{$module->id}/{$item->id}" class="ico-btn" aria-label="Редактировать">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>

                                            <a href="{$path_prefix}/delete/{$module->id}/{$item->id}" class="ico-btn js-delete" data-name="{$item->title}" aria-label="Удалить">
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
{elseif $state == 'add' || $state == 'edit'}
    <section class="catalog">
        <div class="catalog__item-top">
            <div class="item-controls js-to-expand">
                <a href="{$path_prefix}/list/{$module->id}" class="btn btn--link item-controls__back">
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
        <h1 class="h1 catalog__h1">Параметры</h1>
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