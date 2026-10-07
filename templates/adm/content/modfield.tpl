{if $state == 'list' || $state == "listcomplex"}
    <section class="catalog" data-type="nodefields" data-node="{$module->is_catalog}">
        <div class="catalog__item-top">
            {include file='menu/module-actions.tpl' type=$module active=fields}
        </div>

        <h1 class="h1 catalog__h1">{if !$field}Поля{else}Поля комплексного поля <a
                href="{$path_prefix}/edit/{$module->id}/{$field->id}">{$field->title}</a>{/if}</h1>
        <div class="catalog-controls">
            <div class="catalog-controls__btns">
                <a href="{$path_prefix}/add/{$module->id}{if $field}/{$field->id}{/if}"
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
                                            name="required"
                                            {if $item->required}checked{/if}>
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
                                            name="show"
                                            {if $item->show}checked{/if}>
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
                                            name="sorter"
                                            {if $item->sorter}checked{/if}>
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
                                            class="input-elt__input
                                                ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="search"
                                            {if $item->search}checked{/if}
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
                                            name="inlist"
                                            {if $item->inlist}checked{/if}
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
                                            name="property_show"
                                            {if $item->property_show}checked{/if}
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
                                            name="property_list_show"
                                            {if $item->property_list_show}checked{/if}
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
                                            {if $item->field == "complex"}
                                                <a href="{$path_prefix}/list/{$module->id}{if $field}/{$field->id}{/if}/{$item->id}"
                                                   class="input-elt ico-btn" aria-label="Поля">
                                                    <span class="input-elt__fake" style="color: var(--blue);">
                                                        <svg fill="none" width="21" height="16">
                                                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#eye"></use>
                                                        </svg>
                                                    </span>
                                                    <span class="input-elt__text">выбрать ...</span>
                                                </a>
                                            {/if}

                                            <a href="{$path_prefix}/edit/{$module->id}{if $field}/{$field->id}{/if}/{$item->id}"
                                               class="ico-btn" aria-label="Редактировать">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>

                                            <a href="{$path_prefix}/delete/{$module->id}{if $field}/{$field->id}{/if}/{$item->id}"
                                               class="ico-btn js-delete" data-name="{$item->title}"
                                               aria-label="Удалить">
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
{elseif $state == 'add' || $state == 'edit' || $state == 'addcomplex' || $state == 'editcomplex'}
    <section class="catalog">
        <div class="catalog__item-top">
            <div class="item-controls js-to-expand">
                <a href="{$path_prefix}/list/{$module->id}{if $complex}/{$complex->id}{/if}"
                   class="btn btn--link item-controls__back">
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
            {if $item->type}{include file='menu/module-actions.tpl' type=$module active=fields}{/if}
        </div>
        <h1 class="h1 catalog__h1">Поля</h1>
        <form id="form-fields" class="form  form--980" action="" method="post" enctype="multipart/form-data">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    {foreach $data.fields as $field_key => $field}
                        {if $field.type == 'select'}
                            {if $field.title === "Группа" && $complex}{continue}{/if}
                            <label class="label form__input-full">
                                <div class="label__content">
                                    <span class="label__name">{$field.title}</span>
                                </div>

                                <span class="label__wrapper label__wrapper--select">
                                    <select class="label__select" name="{$field_key}">
                                        {if $field.title === "Группа"}
                                            <option value="0" {if !$item->{$field_key} }selected="selected"{/if}>Не выбрано</option>
                                        {/if}
                                        {foreach $field.data as $option}
                                            <option value="{$option->id}"
                                                    {if $item->{$field_key} == $option->id}selected="selected"{/if}>{$option->title}</option>
                                        {/foreach}
                                    </select>
                                </span>
                            </label>
                        {elseif $field.type == 'checkbox'}
                            <div class="form__check-group label form__input-full">
                                <div class="form__check-group-inside">
                                    <label class="check ">
                                        <input class="check__input" name="{$field_key}"
                                               {if $item->{$field_key}}checked{/if} value="1" type="checkbox">
                                        <span class="check__name">{$field.title}</span>
                                    </label>
                                </div>
                            </div>
                        {else}
                            <label class="label form__input-full">
                                <div class="label__content">
                                    <span class="label__name">{$field.title}</span>
                                </div>
                                <span class="label__wrapper">
                            <input name="{$field_key}" type="text" class="label__input"
                                   value="{if $smarty.post.$field_key}{$smarty.post.$field_key}{else}{$item->$field_key}{/if}"
                                   placeholder="">
                        </span>
                            </label>
                        {/if}
                    {/foreach}
                </div>
            </div>
        </form>
    </section>
{/if}