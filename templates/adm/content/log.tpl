{if $state == 'list'}
    <section class="catalog">
        <h1 class="h1 catalog__h1">Логи</h1>
        <div class="table-wrapper catalog__table">
            {if $list}
                <table class="catalog-table">
                    <thead>
                    <tr>
                        <th class="catalog-table__th"><span>Заголовок</span></th>
                        <th class="catalog-table__th"></th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$list item='item'}
                        <tr class="catalog-table__tr undefined">
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->title}</div>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">
                                    <input title="Активность" data-id="1" data-node="1"
                                           class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1"
                                           {if $item->active}checked{/if}>
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
                                               aria-label="Просмотр">
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
            {else}
                Список элементов пуст
            {/if}
        </div>

    </section>
{else}
    <div class="settings">
        <h1 class="h1 settings__h1">{$item->title}</h1>

        {$item->object->getHtml()}

        <form action="" method="post" enctype="multipart/form-data" class="form  form--980">
            <div class="form__fieldset">
                <div class="label form__input-full">
                    <div class="form__check-group-inside">
                        <label class="check ">
                            <input class="check__input" name="active" value="1" {if $item->active}checked{/if}
                                   type="checkbox">
                            <span class="check__name">Активный</span>
                        </label>
                    </div>
                </div>
            </div>

            <div class="form__fieldset">
                <div class="label form__input-full">
                    <button name="save" value="Сохранить" type="submit" class="btn btn--blue btn--lg"
                            style="width: fit-content;">
                        <span>Сохранить</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
{/if}

