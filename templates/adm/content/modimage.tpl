{if $state == 'list'}
    <section class="catalog">
        <div class="catalog__item-top">
            {include file='menu/module-actions.tpl' type=$module active="image"}
        </div>
        <h1 class="h1 catalog__h1">Изображения</h1>
        <div class="catalog-controls">
            <div class="catalog-controls__btns">
                <a href="{$path_prefix}/add/{$module->id}" class="btn btn--blue btn--shrink">
                    <svg fill="none" width="16" height="16">
                        <use xlink:href="/adm/assets/img/sprite.svg#add"></use>
                    </svg>
                    <span>Добавить Поле</span>
                </a>
            </div>
        </div>
        <div class="table-wrapper catalog__table">
            <table class="catalog-table">
                <thead>
                <tr>
                    <th class="catalog-table__th"><span>Название</span></th>
                    <th class="catalog-table__th"><span>Сервисное имя</span></th>
                    <th class="catalog-table__th"><span>Ширина</span></th>
                    <th class="catalog-table__th"><span>Высота</span></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>
                {if $list}
                    {foreach $list as $item}
                        <tr class="catalog-table__tr js-delete-element">
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->title}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->name}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->width}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$item->height}</div>
                            </td>
                            <td class="catalog-table__td">
                                <label class=" input-elt">
                                    <input
                                        data-id="1"
                                        data-node="1"
                                        class="input-elt__input ajax-node-field"
                                        type="checkbox"
                                        value="1"
                                        name="watermark"
                                        {if $item->watermark}checked{/if}
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

                                            <a href="{$path_prefix}/delete/{$module->id}/{$item->id}" class="ico-btn js-delete" data-name="{$item->title}"  aria-label="Удалить">
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
                <button form="form-image" type="submit" name="save" value="Сохранить" class="btn btn--blue btn--lg">
                    <span>Сохранить</span>
                </button>
            </div>
            {if $item->type}{include file='menu/module-actions.tpl' type=$module active=image}{/if}
        </div>
        <h1 class="h1 catalog__h1">Изображения</h1>
        <form id="form-image" class="form  form--980" action="" method="post" enctype="multipart/form-data">
            <div class="form__fieldset">
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Название</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="title" type="text" class="label__input" value="{if $smarty.post.title}{$smarty.post.title}{else}{$item->title}{/if}" placeholder="">
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Сервисное имя</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="name"
                                   type="text"
                                   class="label__input"
                                   value="{if $smarty.post.name}{$smarty.post.name}{else}{$item->name}{/if}"
                                   placeholder=""
                            >
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Высота</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="height"
                                   type="text"
                                   class="label__input"
                                   value="{if $smarty.post.height}{$smarty.post.height}{else}{$item->height}{/if}"
                                   placeholder=""
                            >
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Ширина</span>
                        </div>
                        <span class="label__wrapper">
                            <input name="width"
                                   type="text"
                                   class="label__input"
                                   value="{if $smarty.post.width}{$smarty.post.width}{else}{$item->width}{/if}"
                                   placeholder=""
                            >
                        </span>
                    </label>

                    <div class="form__check-group label form__input-full">
                        <div class="form__check-group-inside">
                            <label class="check ">
                                <input class="check__input" name="watermark"  {if $item->watermark}checked{/if} value="1" type="checkbox">
                                <span class="check__name">Накладывать watermark</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
{/if}