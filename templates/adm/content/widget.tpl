{if $state == 'list'}
    <section class="catalog">
        <h1 class="h1 catalog__h1">Виджеты</h1>
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
        <div class="table-wrapper catalog__table">
            {if $list}
                <table class="catalog-table">
                    <thead>
                    <tr>
                        <th class="catalog-table__th"><span>Сервисное имя</span></th>
                        <th class="catalog-table__th"><span>Заголовок</span></th>
                        <th class="catalog-table__th"></th>
                        <th class="catalog-table__th"></th>
                        <th class="catalog-table__th"></th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$list item='item'}
                        <tr class="catalog-table__tr js-delete-element">
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->name}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->title}</div>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">
                                    <input title="Опубликовать" data-id="{$item->id}" data-node="widget" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="public" {if $item->public}checked{/if}>
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
                                    <input title="Расскрыть" data-id="{$item->id}" data-node="widget" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="is_show" {if $item->is_show}checked{/if}>
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
                                            <a href="{$path_prefix}/edit/{$item->id}" class="ico-btn" aria-label="Редактировать">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>

                                            <a href="{$path_prefix}/delete/{$item->id}" class="ico-btn js-delete" aria-label="Удалить" data-name="{$item->title}">
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
            {else}
                Список элементов пуст
            {/if}
        </div>

    </section>
{else}
    <div class="settings">
        <h1 class="h1 settings__h1">Виджеты</h1>
        <form action="" method="post" enctype="multipart/form-data" class="form  form--980">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Сервисное имя</span>
                        </div>

                        <span class="label__wrapper">
							<input type="text" value="{$item->name}" class="label__input" name="name" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Название</span>
                        </div>

                        <span class="label__wrapper">
							<input type="text" value="{$item->title}" class="label__input" name="title" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Иконка</span>
                        </div>

                        <span class="label__wrapper">
							<input type="text" value="{$item->icon}" class="label__input" name="icon" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
                    </label>

                    {if $item->name === "metric"}
                        <label class="label form__input-full">
                            <div class="label__content">
                                <span class="label__name">ID счётчика</span>
                            </div>

                            <span class="label__wrapper">
                                <input type="text" value="{$item->metric_id}" class="label__input" name="metric_id" placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>

                        <label class="label form__input-full">
                            <div class="label__content">
                                <span class="label__name">Токен (<a href="https://yandex.ru/dev/metrika/ru/intro/authorization#get-oauth-token" target="_blank">Инструкция по получению</a></span>
                            </div>

                            <span class="label__wrapper">
                                <input type="text" value="{$item->metric_token}" class="label__input" name="metric_token" placeholder="">
                                <span class="label__mistake">Внесите данные</span>
                            </span>
                        </label>
                    {/if}

                    <div class="form__check-group label form__input-full">
                        <div class="form__check-group-inside">
                            <label class="check ">
                                <input class="check__input" name="public" value="1" {if $item->public}checked{/if} type="checkbox">
                                <span class="check__name">Опубликовать</span>
                            </label>
                            <label class="check ">
                                <input class="check__input" name="is_show" value="1" {if $item->is_show}checked{/if} type="checkbox">
                                <span class="check__name">Расскрыть</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form__check-group label form__input-full">
                <button name="save" value="Сохранить" type="submit" class="btn btn--blue btn--lg" style="width: fit-content;">
                    <span>Сохранить</span>
                </button>
            </div>
        </form>
    </div>
{/if}

