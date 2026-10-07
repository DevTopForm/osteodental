<section class="catalog">
    <h1 class="h1 catalog__h1">Групповые операции</h1>
    {if !empty($messages) && $messages|@count > 0}
        <div class="messages">
            {foreach from=$messages item='message'}
                {$message->html}
            {/foreach}
        </div>
    {/if}

    <form action="/adm/catalog/" method="GET" id="catalog_search" enctype="text/plain">
        <input type="hidden" name="catalog_filter" value="Y">
        <div class="catalog-controls">
            <div class="catalog-controls__filter js-filter">
                <div class="filter-form">
                    <div class="filter-form__name">Фильтры</div>
                    <div class="filter-form__fieldset">
                        {$filters.node}
                        {$filters.category_advance}

                        <label class="label ">
                            <div class="label__content">
                                <span class="label__name">Поиск по названию, анонсу:</span>
                            </div>

                            <span class="label__wrapper">
                                <input type="text" value="{$smarty.get.title}" class="label__input" name="title"
                                       placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>

                    </div>
                    <div class="filter-form__btns">
                        <button class="btn btn--blue btn--lg" type="submit">
                            <svg fill="none" width="12" height="16">
                                <use xlink:href="/adm/assets/img/sprite.svg#filter"></use>
                            </svg>
                            <span>Применить</span>
                        </button>
                        <button class="btn btn--bd btn--lg" type="reset" onclick="window.location.href = '/adm/catalog'">
                            <svg fill="none" width="16" height="16">
                                <use xlink:href="/adm/assets/img/sprite.svg#redo"></use>
                            </svg>
                            <span>Очистить</span>
                        </button>
                    </div>
                </div>
                <button class="btn btn--square btn--blue catalog-controls__close js-close">
                    <svg fill="none" width="20" height="20">
                        <use xlink:href="/adm/assets/img/sprite.svg#cross"></use>
                    </svg>
                </button>
            </div>
            <button class="btn btn--blue btn--square catalog-controls__filter-btn js-filter-toggler">
                <svg fill="none" width="16" height="16">
                    <use xlink:href="/adm/assets/img/sprite.svg#filter"></use>
                </svg>
            </button>
            <div class="pages pages--flex-end">
                <label class="pages__label">
                    <span class="pages__label-name">Показывать на странице:</span>
                    <select class="pages__select" name="pager">
                        <option value="10" {if !$smarty.get.pager || $smarty.get.pager == 10}selected="selected"{/if}>
                            10
                        </option>
                        <option value="20" {if $smarty.get.pager == 20}selected="selected"{/if}>20</option>
                        <option value="50" {if $smarty.get.pager == 50}selected="selected"{/if}>50</option>
                        <option value="100" {if $smarty.get.pager == 100}selected="selected"{/if}>100</option>
                        <option value="all" {if $smarty.get.pager == all}selected="selected"{/if}>Все</option>
                    </select>
                    <span class="pages__svg">
                      <svg fill="none" width="12" height="7">
                        <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                      </svg>
                    </span>
                </label>
                {$pager}
            </div>
        </div>
    </form>

    {if !empty($list) && $list|@count > 0}
        <form action="" method="post">

            <div class="table-wrapper catalog__table catalog__table--sortable">
                <table class="catalog-table">
                    <thead>
                    <tr>
                        <th class="catalog-table__th">
                            <label class="check catalog-table__input check--light">
                                <input class="check__input" name="выбрать все" value="" type="checkbox">
                                <span class="check__name">выбрать все</span>
                            </label>
                        </th>
                        <th class="catalog-table__th"><span>Название</span></th>
                        <th class="catalog-table__th"><span>Цена</span></th>
                        <th class="catalog-table__th"><span>Бренд</span></th>
                        <th class="catalog-table__th">
                            <div class="catalog-table__th-btns">
                                <span>Управление</span>
                            </div>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$list item='item'}
                        <tr class="catalog-table__tr">
                            <td class="catalog-table__td">
                                <label class="check catalog-table__input">
                                    <input class="check__input" name="list[{$item->id}]" value="{$item->id}"
                                           type="checkbox">
                                    <span class="check__name">выбрать элемент</span>
                                </label>
                            </td>
                            <td class="catalog-table__td">
                                <a href="/adm/content/edit/{$item->node->id}/{$item->id}" class="catalog-item__link"
                                   title="">{$item->title}</a>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">
                                    {$item->price}
                                </div>
                            </td>

                            <td class="catalog-table__td">
                                <div class="catalog-item__name">
                                    {$item->brand->title}
                                </div>
                            </td>

                            <td class="catalog-table__td" data-position="right">
                                <div class="jsFixed">
                                    <div class="catalog-item__controls">
                                        <div class="ico-btns catalog-item__btns">
                                            <label class=" input-elt ico-btn" title="Опубликовать">
                                                <input data-node="{$item->node->id}" data-id="{$item->id}"
                                                       class="input-elt__input ajax-node-field" type="checkbox"
                                                       value="1" name="public" {if $item->public}checked=""{/if}>
                                                <span class="input-elt__fake">
                                                     <svg fill="none" width="21" height="16">
                                                        <use xlink:href="/adm/assets/img/sprite.svg#eye"></use>
                                                    </svg>
                                                </span>
                                                <span class="input-elt__text">выбрать ...</span>
                                            </label>

                                            <a href="/adm/content/edit/{$item->node->id}/{$item->id}" class="ico-btn"
                                               aria-label="Редактировать">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="/adm/assets/img/sprite.svg#pencil"></use>
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
            </div>

            <div class="groups-actions form  form--980">
                <div class="groups-actions__block">
                    <div class="label">
                        <span class="label__name">Все отмеченные:</span>
                        <div class="status-select js-actions">
                            <label class="status-select__select-label" style="display: none">
                                <select name="listaction" class="status-select__select" tabindex="-1">
                                    <option class="status-select__option" value="" selected="">Выберите действие
                                    </option>
{*                                    <option class="status-select__option" value="export">Экспортировать</option>*}
                                    <option class="status-select__option" value="public">Опубликовать</option>
                                    <option class="status-select__option" value="public_clear">Снять с публикации
                                    </option>

                                    {if $data.brands}
                                        <option class="status-select__option" value="brand">Привязать бренд</option>
                                    {/if}

                                    {if $data.analogs}
                                        <option class="status-select__option" value="analogs_block">Привязать аналоги
                                        </option>
                                    {/if}

                                    <option class="status-select__option" value="category">Перенести в категорию
                                    </option>
                                    <option class="status-select__option" value="category_advance">Перенести в сборную
                                    </option>
                                </select>
                                <span class="status-select__select-svg">
                                    <svg fill="none" width="12" height="8">
                                        <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                    </svg>
                                </span>
                            </label>

                            <div class="status-select__fake" tabindex="0">
                                <span>Выберите действие</span>
                                <span class="status-select__select-svg">
                                    <svg fill="none" width="12" height="8">
                                        <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="groups-actions__block">
                    <div class="groups-actions__item opened" data-block="all"></div>
                    {*                    <div class="groups-actions__item" data-block="text">*}
                    {*                        <div class="label ">*}
                    {*                            <div class="label__content">*}
                    {*                                <span class="label__name">Добавьте текст:</span>*}
                    {*                            </div>*}
                    {*                            <div class="label__wrapper label__wrapper--quill">*}
                    {*                                <textarea rows="5" data-role="editor" data-editor="1" name="name">fwe</textarea>*}
                    {*                                <button class="btn btn--blue btn--lg js-save">Сохранить текст</button>*}
                    {*                            </div>*}
                    {*                        </div>*}
                    {*                    </div>*}

                    {if $data.analogs}
                        {$data.analogs}
                    {/if}

                    <div class="groups-actions__item" data-block="brand">
                        <div class="label">
                            <span class="label__name">Выберите бренд:</span>
                            <div class="status-select js-color">
                                <label class="status-select__select-label" style="display: none">
                                    <select name="brand" class="status-select__select" tabindex="-1">
                                        <option class="status-select__option" value="" selected="">Выберите бренд
                                        </option>
                                        {foreach $data.brands as $item}
                                            <option class="status-select__option"
                                                    value="{$item->id}">{$item->title}</option>
                                        {/foreach}
                                    </select>
                                    <span class="status-select__select-svg">
                                        <svg fill="none" width="12" height="8">
                                            <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                        </svg>
                                    </span>
                                </label>
                                <div class="status-select__fake" tabindex="0">
                                    <span></span>
                                    <span class="status-select__select-svg">
                                        <svg fill="none" width="12" height="8">
                                            <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                        </svg>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {if $data.tree}
                        <div class="groups-actions__item" data-block="category">
                            <div class="label">
                                <span class="label__name">Выберите категорию:</span>
                                <div class="status-select js-color">
                                    <label class="status-select__select-label" style="display: none">
                                        <select name="category" class="status-select__select" tabindex="-1">
                                            <option class="status-select__option" value="" selected="">Выберите категорию
                                            </option>
                                            {include file='content/nodetree.tpl' tree=$data.tree spacer="-" cur_pid=$smarty.get.fi_node}
                                        </select>
                                        <span class="status-select__select-svg">
                                        <svg fill="none" width="12" height="8">
                                            <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                        </svg>
                                    </span>
                                    </label>
                                    <div class="status-select__fake" tabindex="0">
                                        <span></span>
                                        <span class="status-select__select-svg">
                                        <svg fill="none" width="12" height="8">
                                            <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                        </svg>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}

                    {if $data.advanced}
                        <div class="groups-actions__item" data-block="category_advance">
                            <div class="label">
                                <span class="label__name">Выберите сборную категорию:</span>
                                <div class="status-select js-color">
                                    <label class="status-select__select-label" style="display: none">
                                        <select name="advanced_category" class="status-select__select" tabindex="-1">
                                            <option class="status-select__option" value="" selected="">- Выберите сборную категорию -</option>
                                            {include file='content/nodetree.tpl' tree=$data.advanced spacer="-" cur_pid=$smarty.get.fi_node}
                                        </select>
                                        <span class="status-select__select-svg">
                                        <svg fill="none" width="12" height="8">
                                            <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                        </svg>
                                    </span>
                                    </label>
                                    <div class="status-select__fake" tabindex="0">
                                        <span></span>
                                        <span class="status-select__select-svg">
                                        <svg fill="none" width="12" height="8">
                                            <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                                        </svg>
                                    </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    {/if}
                </div>
                <div class="label ">
                    <span class="label__name"></span>
                    <button class="btn btn--blue btn--lg groups-actions__btn">
                        <span>Применить</span>
                    </button>
                </div>
            </div>
        </form>
    {else}
        <p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
    {/if}
</section>
