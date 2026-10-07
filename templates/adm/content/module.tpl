{if $state=='list'}
    <section class="catalog" data-type="module">
        <h1 class="h1 catalog__h1">Установка модулей</h1>
        <div class="top"></div>
        <div class="catalog-controls">
            <div class="catalog-controls__btns">
                <a href="{$path_prefix}/add" class="btn btn--blue btn--shrink">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#add"></use>
                    </svg>
                    <span>Добавить элемент</span>
                </a>
            </div>
        </div>
        <div class="table-wrapper catalog__table catalog__table--sortable">
            <table class="catalog-table">
                <thead>
                <tr>
                    <th class="catalog-table__th"></th>
                    <th class="catalog-table__th"><span>Название</span></th>
                    <th class="catalog-table__th"><span>Сервисное имя</span></th>
                    <th class="catalog-table__th"><span>Доступен в ноде</span></th>
                    <th class="catalog-table__th"><span>Доступен в блоке</span></th>
                    <th class="catalog-table__th"><span>Поиск</span></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>

                {if $list}
                    {foreach $list as $module}
                        <tr class="catalog-table__tr js-delete-element" data-order="{$module->id}">
                            <td class="catalog-table__td">
                                <div class="js-handle">
                                    <svg fill="none" width="7" height="13">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
                                    </svg>
                                </div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$module->title}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$module->type}</div>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">
                                    <input
                                            data-id="1"
                                            data-node="1"
                                            class="input-elt__input ajax-node-field"
                                            type="checkbox"
                                            value="1"
                                            name="1"
                                            {if $module->in_node}checked{/if}
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
                                            name="1"
                                            {if $module->in_block}checked{/if}
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
                                            name="1"
                                            {if $module->search}checked{/if}
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
                                <a href="{$path_prefix}/edit/{$module->id}" class="catalog-item__ico"
                                   title="Общие настройки">
                                    <svg fill="none" width="16" height="16">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                    </svg>
                                </a>
                            </td>
                            <td class="catalog-table__td">
                                {if $module->has_content}
                                    <a href="{$adm_path}/modfield/list/{$module->id}" class="catalog-item__ico"
                                       title="Поля">
                                        <svg fill="none" width="17" height="17">
                                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#fields"></use>
                                        </svg>
                                    </a>
                                {/if}
                            </td>

                            <td class="catalog-table__td">
                                {if $module->has_content}
                                    <a href="{$adm_path}/modgroup/list/{$module->id}" class="catalog-item__ico"
                                       title="Группы полей">
                                        <svg fill="none" width="17" height="17">
                                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#fields"></use>
                                        </svg>
                                    </a>
                                {/if}
                            </td>
                            <td class="catalog-table__td">
                                <a href="{$adm_path}/modimage/list/{$module->id}" class="catalog-item__ico"
                                   title="Изображения">
                                    <svg fill="none" width="19" height="17">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#imgs"></use>
                                    </svg>
                                </a>
                            </td>
                            <td class="catalog-table__td">
                                <a href="{$adm_path}/modtpl/list/{$module->id}" class="catalog-item__ico"
                                   title="Шаблоны">
                                    <svg fill="none" width="19" height="17">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#template"></use>
                                    </svg>
                                </a>
                            </td>
                            <td class="catalog-table__td">
                                <a href="{$adm_path}/modparam/list/{$module->id}" class="catalog-item__ico"
                                   title="Параметры">
                                    <svg fill="none" width="17" height="17">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#settings2"></use>
                                    </svg>
                                </a>
                            </td>

                            <td class="catalog-table__td">
                                <a href="{$path_prefix}/delete/{$module->id}" class="catalog-item__ico js-delete"
                                   title="Удалить">
                                    <svg fill="none" width="17" height="17">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
                                    </svg>
                                </a>
                            </td>
                            {*                    <td class="catalog-table__td">*}
                            {*                        <a href="{$adm_path}/modvalue/edit/{$module->id}" class="catalog-item__ico" title="Значения параметров">*}
                            {*                            <svg fill="none" width="17" height="17">*}
                            {*                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#settings3"></use>*}
                            {*                            </svg>*}
                            {*                        </a>*}
                            {*                    </td>*}
                        </tr>
                    {/foreach}
                {else}
                    <tr class="catalog-table__tr undefined">
                        <td align="center" colspan="11" class="catalog-table__td">Модули не найдены</td>
                    </tr>
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
                <button form="form-module" type="submit" name="save" value="Сохранить" class="btn btn--blue btn--lg">
                    <span>Сохранить</span>
                </button>
            </div>
            {if $item->type}{include file='menu/module-actions.tpl' type=$item active=module}{/if}
        </div>
        <h1 class="h1 catalog__h1">Свойства</h1>
        <form id="form-module" class="form  form--980" action="" method="post" enctype="multipart/form-data">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Название</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="title" type="text" class="label__input"
                                   value="{if $smarty.post.title}{$smarty.post.title}{else}{$item->title}{/if}"
                                   placeholder="">
                        </span>
                    </label>


                    <label class="label form__input-full {if $errors.type}mistake{/if}">
                        <div class="label__content">
                            <span class="label__name">Сервисное имя</span>
                        </div>

                        <span class="label__wrapper">
                                {if !$item->id}
                                    <input name="type" type="text" class="label__input"
                                           value="{if $smarty.post.title}{$smarty.post.title}{/if}" placeholder="">
                                    <span class="label__mistake">Внесите данные</span>
                                {else}
                                    {$item->type}
                                {/if}
                            </span>
                    </label>

                    <div class="form__check-group label form__input-full">
                        <div class="form__check-group-inside">
                            <label class="check ">
                                <input class="check__input" name="in_node" {if $item->in_node}checked{/if} value="1"
                                       type="checkbox">
                                <span class="check__name">Доступен в ноде</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="in_block" {if $item->in_block}checked{/if} value="1"
                                       type="checkbox">
                                <span class="check__name">Доступен в блоке</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="search" {if $item->search}checked{/if} value="1"
                                       type="checkbox">
                                <span class="check__name">Поиск по элементам разделов данного типа</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_content" {if $item->has_content}checked{/if}
                                       value="1" type="checkbox">
                                <span class="check__name">Редактируемый контент</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_items" {if $item->has_items}checked{/if} value="1"
                                       type="checkbox">
                                <span class="check__name">Отдельные элементы контента</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="sortable" {if $item->sortable}checked{/if} value="1"
                                       type="checkbox">
                                <span class="check__name">Сортировка перетаскиванием</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_filters" value="1"
                                       {if $item->has_filters}checked{/if} type="checkbox">
                                <span class="check__name">Есть фильтры</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="has_variants" value="1"
                                       {if $item->has_variants}checked{/if} type="checkbox">
                                <span class="check__name">Есть варианты</span>
                            </label>

                            <label class="check ">
                                <input class="check__input" {if $item->id}onclick="return false;"{/if} name="is_catalog"
                                       value="1" {if $item->is_catalog}checked{/if} type="checkbox">
                                <span class="check__name">Это каталог</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
{/if}