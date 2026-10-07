{if $state == 'list'}
    <section class="catalog">
        <h1 class="h1 catalog__h1">Заказы</h1>
        <div class="catalog-controls">
            <div class="catalog-controls__filter js-filter">
                <form action="{$path_prefix}" class="filter-form" method="get" enctype="multipart/form-data">
                    <div class="filter-form__name">Фильтры</div>
                    <div class="filter-form__fieldset">
                        <label class="label ">
                            <div class="label__content">
                                <span class="label__name">Поиск по №, цене или телефону:</span>
                            </div>

                            <span class="label__wrapper">
                                <input type="text" value="{$smarty.get.search_text}" class="label__input" name="search_text" placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>

                        <div class="label ">
                            <div class="label__content">
                                <span class="label__name">Дата оформления заказа:</span>
                            </div>
                            <div class="time-blocks flatpickr-input" readonly="readonly">
                                <label class="time-blocks__label label">
                                    <input type="text" class="label__input" name="after_date" data-time="start" value="{$smarty.get.after_date|default:$data.dt_start}">
                                    <svg fill="none" width="16" height="16" class="label__svg">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#calendar"></use>
                                    </svg>
                                </label>
                                <label class="time-blocks__label label">
                                    <input type="text" class="label__input" name="before_date" data-time="end" value="{$smarty.get.before_date|default:$data.dt_end}">
                                    <svg fill="none" width="16" height="16" class="label__svg">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#calendar"></use>
                                    </svg>
                                </label>
                                <input type="hidden" data-time="initial-start" value="{$data.dt_start}">
                                <input type="hidden" data-time="initial-end" value="{$data.dt_end}">
                            </div>
                        </div>

                        <label class="label ">
                            <div class="label__content">
                                <span class="label__name">Статус:</span>
                            </div>

                            <span class="label__wrapper label__wrapper--select">
                                <select class="label__select" name="status">
                                    <option value="0" {if !$smarty.get.status}selected{/if}>Все</option>

                                     {foreach from=$data.statuses item='status' name='statuses'}
                                         <option value="{$status->id}" {if $smarty.get.status == $status->id}selected{/if}>{$status->title}</option>
                                     {/foreach}
                                </select>
                            </span>
                        </label>

                    </div>
                    <div class="filter-form__btns">
                        <button class="btn btn--blue btn--lg">
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
            <button class="btn btn--blue btn--square catalog-controls__filter-btn js-filter-toggler">
                <svg fill="none" width="16" height="16">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#filter"></use>
                </svg>
            </button>

            {include file='blocks/content/list/pages.tpl' class="pages--flex-end"}
        </div>

        <div class="table-wrapper catalog__table">
            <table class="catalog-table">
                <thead>
                    <tr>
                        <th class="catalog-table__th">
                            <span>№</span>
                        </th>
                        <th class="catalog-table__th"><span>Дата</span></th>
                        <th class="catalog-table__th">
                            <span>Тип</span>
                        </th>
                        <th class="catalog-table__th"><span>Пользователь</span></th>
                        <th class="catalog-table__th"><span>Кол-во</span></th>
                        <th class="catalog-table__th"><span>Цена</span></th>
                        <th class="catalog-table__th ">
                            <div class="catalog-table__th-btns">
                                <span>Статус</span>
                                <span>Управление</span>
                            </div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {foreach from=$list item='item' name='orders'}
                        <tr class="catalog-table__tr {if $item->isNew()}catalog-table__tr--action{/if}">
                            <td class="catalog-table__td">
                                <a href="{$path_prefix}/edit/{$item->id}" class="catalog-item__link">
                                    {$item->date|date_format:'%d.%m.%Y'}/{$item->id}
                                </a>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->date|date_format:'%d.%m.%Y'}</div>
                            </td>
                            <td class="catalog-table__td catalog-table__td--img" data-position="left">
                                <div class="catalog-item__name">Заказ</div>
                            </td>
                            <td class="catalog-table__td">
                                {if $item->user->id}
                                    <a class="catalog-item__link" href="/adm/client/edit/{$item->user->id}">{$item->user->lastname} {$item->user->firstname} {$item->user->middlename}</a>
                                {else}
                                    {$item->firstname}
                                {/if}
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">
                                    {$item->data|@count}
                                </div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->totalSumm}</div>
                            </td>

                            <td class="catalog-table__td " data-position="right">
                                <div class="jsFixed">
                                    <div class="catalog-item__controls">
                                        <div class="status-select {$item->status->class} js-status">
                                            <label class="status-select__select-label" style="display: none">
                                                <select data-item="order" data-id="{$item->id}" name="status" class="status-select__select ajax-item-field" tabindex="-1">
                                                    {foreach from=$data.statuses item='status' name='statuses'}
                                                        <option class="status-select__option" value="{$status->id}" data-class="{$status->class}" {if $item->status->id == $status->id}selected{/if}>{$status->title}</option>
                                                    {/foreach}
                                                </select>
                                                <span class="status-select__select-svg">
                                                    <svg fill="none" width="12" height="8">
                                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                                                    </svg>
                                                </span>
                                            </label>
                                            <div class="status-select__fake" tabindex="0">
                                                <span>{$item->status->title}</span>
                                                <span class="status-select__select-svg">
                                                    <svg fill="none" width="12" height="8">
                                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                                                    </svg>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ico-btns catalog-item__btns">
                                            <a href="{$path_prefix}/edit/{$item->id}" class="ico-btn" aria-label="Название того, что делает кнопка">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
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
    </section>
{elseif $state == 'add' || $state == 'edit'}
    <section class="catalog">
        <div class="catalog__item-top">
            <div class="item-controls js-to-expand">
                <a href="{$path_prefix}" class="btn btn--link item-controls__back">
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

                        <button onclick="window.print()" class="btn btn--short">
                            <svg fill="none" width="16" height="16">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#print"></use>
                            </svg>
                            <span>Распечатать</span>
                        </button on>

                        <a href="{$path_prefix}/delete/{$item->id}" class="btn btn--short js-delete">
                            <svg fill="none" width="16" height="16">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
                            </svg>
                            <span>Удалить заказ</span>
                        </a>
                    </div>
                </div>
                <button name="save" value="Сохранить" form="order_form" type="submit" class="btn btn--blue btn--lg">
                    <span>Сохранить</span>
                </button>
            </div>
        </div>
        <form id="order_form" action="{$path_prefix}/{$state}/{$item->id}" method="post" enctype="multipart/form-data">
            <h1 class="h1 catalog__h1">{$item->date|date_format:'%d.%m.%Y'}/{$item->id}</h1>
            <div class="catalog__status">
                <span class="catalog__status-name">Статус</span>
                <div class="status-select new js-status">
                    <label class="status-select__select-label" style="display: none">
                        <select name="status" class="status-select__select" tabindex="-1">
                            {foreach from=$data.statuses item='status'}
                                <option class="status-select__option" value="{$status->id}" {if $item->status->id == $status->id}selected{/if}>{$status->title}</option>
                            {/foreach}
                        </select>
                        <span class="status-select__select-svg">
                            <svg fill="none" width="12" height="8">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                            </svg>
                        </span>
                    </label>
                    <div class="status-select__fake" tabindex="0">
                        <span>{$item->status->title}</span>
                        <span class="status-select__select-svg">
                            <svg fill="none" width="12" height="8">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
            <div class="order-info">
                <div class="order-info__row">
                    <div class="order-info__name">Дата</div>
                    <div class="order-info__info">{$item->date|date_format:'%d.%m.%Y'} / {$item->date|date_format:'%H:%M:%S'}</div>
                </div>

                <div class="order-info__row">
                    <div class="order-info__name">Пользователь:</div>
                    <div class="order-info__info">
                        {if $item->user->id}
                            <a class="catalog-item__link" href="/adm/client/edit/{$item->user->id}">{$item->user->lastname} {$item->user->firstname} {$item->user->middlename}</a>
                        {else}
                            {$item->firstname}
                        {/if}
                    </div>
                </div>

                <div class="order-info__row">
                    <div class="order-info__name">Телефон:</div>
                    <div class="order-info__info">{$item->phone}</div>
                </div>

                <div class="order-info__row">
                    <div class="order-info__name">Email:</div>
                    <div class="order-info__info">{$item->email}</div>
                </div>

                <div class="order-info__row">
                    <div class="order-info__name">Логин instagram:</div>
                    <div class="order-info__info">{$item->instagram}</div>
                </div>

                <div class="order-info__row">
                    <div class="order-info__name">Оплата:</div>
                    <div class="order-info__info">{$item->payment_method->getName()}</div>
                </div>

                <div class="order-info__row">
                    <div class="order-info__name">Сумма заказа:</div>
                    <div class="order-info__info">{$item->orderSumm|number_format:2:".":" "}</div>
                </div>

                {if $item->promocode}
                    <div class="order-info__row">
                        <div class="order-info__name">Промокод:</div>
                        <div class="order-info__info">{$item->promocode}</div>
                    </div>
                {/if}

                {if $item->saleSumm}
                    <div class="order-info__row">
                        <div class="order-info__name">Скидка:</div>
                        <div class="order-info__info">{$item->saleSumm|number_format:2:".":" "}</div>
                    </div>
                {/if}

                <div class="order-info__row">
                    <div class="order-info__name">Общая сумма:</div>
                    <div class="order-info__info">{$item->totalSumm|number_format:2:".":" "}</div>
                </div>
            </div>
            <div class="table-wrapper catalog__table mb-36">
                <table class="catalog-table">
                    <thead>
                    <tr>
                        <th class="catalog-table__th">
                            <span>Название</span>
                        </th>
                        <th class="catalog-table__th"><span>Кол-во</span></th>
                        <th class="catalog-table__th"><span>Цена</span></th>
                        <th class="catalog-table__th "><span>Сумма</span></th>
                    </tr>
                    </thead>
                    <tbody>
                        {foreach from=$item->data item='product'}
                            <tr class="catalog-table__tr ">
                                <td class="catalog-table__td">
                                    {if $product->item}
                                        <a href="{$adm_path}/content/edit/{$product->item->node->id}/{$product->itemId}" class="catalog-item__link">{$product->title}</a>
                                    {else}
                                        <div class="catalog-item__name">{$product->title}</div>
                                    {/if}
                                </td>
                                <td class="catalog-table__td">
                                    <div class="catalog-item__name">{$product->count}</div>
                                </td>
                                <td class="catalog-table__td">
                                    <div class="catalog-item__name">{$product->price|number_format:2:".":" "}</div>
                                </td>
                                <td class="catalog-table__td">
                                    <div class="catalog-item__name">{$product->summ|number_format:2:".":" "}</div>
                                </td>
                            </tr>
                        {/foreach}
                    </tbody>
                </table>
            </div>
            <div class="catalog__result">
                <div>Итого:</div>
                <div>{$item->totalSumm|number_format:2:".":" "}</div>
            </div>
        </form>
    </section>
{/if}