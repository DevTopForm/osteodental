{if $state=='list'}
    <section class="catalog">
        <h1 class="h1 catalog__h1">Администраторы системы</h1>
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
        <div class="table-wrapper catalog__table">
            <table class="catalog-table">
                <thead>
                <tr>
                    <th class="catalog-table__th"><span>Имя</span></th>
                    <th class="catalog-table__th"><span>Логин</span></th>
                    <th class="catalog-table__th"><span>Последний вход</span></th>
                    <th class="catalog-table__th "></th>
                </tr>
                </thead>
                <tbody>

                {if $list}
                    {foreach $list as $admin}
                        <tr class="catalog-table__tr js-delete-element">
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$admin->name}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$admin->login}</div>
                            </td>
                            <td class="catalog-table__td">
                                <div class="catalog-item__name">{$admin->lastlogin}</div>
                            </td>
                            <td class="catalog-table__td " data-position="right">
                                <div class="jsFixed">
                                    <div class="ico-btns catalog-item__btns">
                                        <label class="input-elt ico-btn">
                                            <input
                                                    data-id="1"
                                                    data-node="1"
                                                    class="input-elt__input ajax-node-field"
                                                    type="checkbox"
                                                    value="1"
                                                    name="1"
                                                    {if $admin->active}checked{/if}
                                            >
                                            <span class="input-elt__fake">
                                            <svg fill="none" width="21" height="16">
                                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#eye"></use>
                                            </svg>
                                        </span>
                                            <span class="input-elt__text">выбрать ...</span>
                                        </label>

                                        <a class="ico-btn" href="{$path_prefix}/edit/{$admin->id}"
                                           title="Редактировать">
                                            <svg fill="none" width="16" height="16">
                                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                            </svg>
                                        </a>

                                        {if $admin->role != 'sadmin' && $user->id != $admin->id}
                                            <a class="ico-btn js-delete" href="{$path_prefix}/delete/{$admin->id}"
                                               title="Удалить" data-name="{$admin->name}">
                                                <svg fill="none" width="16" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
                                                </svg>
                                            </a>
                                        {/if}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    {/foreach}
                {else}
                    <tr class="catalog-table__tr undefined">
                        <td align="center" colspan="11" class="catalog-table__td">Администаторы не найдены</td>
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

                        {*                        <button class="btn btn--short">*}
                        {*                            <svg fill="none" width="16" height="16">*}
                        {*                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#print"></use>*}
                        {*                            </svg>*}
                        {*                            <span>Распечатать</span>*}
                        {*                        </button>*}

                        {if $item->role != 'sadmin' && $user->id != $item->id}
                            <a href="{$path_prefix}/delete/{$item->id}" class="btn btn--short js-delete">
                                <svg fill="none" width="16" height="16">
                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
                                </svg>
                                <span>Удалить раздел</span>
                            </a>
                        {/if}
                    </div>
                </div>
                <button name="save" value="Сохранить" type="submit" form="admin-form" class="btn btn--blue btn--lg">
                    <span>Сохранить</span>
                </button>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" id="admin-form" class="form  form--980">
            <div class="form__fieldset">
                <h2 class="form__h2">Общая информация</h2>
                {if $errors|@count > 0}
                    <div class="messages">
                        {foreach from=$errors item='message'}
                            {$message->html}
                        {/foreach}
                    </div>
                {/if}
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Имя:</span>
                        </div>
                        <span class="label__wrapper">
                            <input type="text" value="{$item->name ?: $smarty.post.name}" class="label__input" name="name" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Логин:</span>
                        </div>

                        <span class="label__wrapper">
                            <input type="text" value="{$item->login ?: $smarty.post.login}" class="label__input" name="login" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Новый пароль:</span>
                        </div>

                        <span class="label__wrapper">
                            <input type="text" value="" class="label__input" name="newpass" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Повторите пароль</span>
                        </div>

                        <span class="label__wrapper">
                            <input type="text" value="" class="label__input" name="newpass2" placeholder="">
                            <span class="label__mistake">Внесите данные</span>
                        </span>
                    </label>

                    {if $item->role != 'sadmin' && $user->id != $item->id}
                        <div class="label form__input-full">
                            <label class="label__name">
                                Доступные действия
                            </label>

                            <div id="multiselect-access" class="js-multiselect">
                                <select id="access" name="access[]" class="select" multiple="multiple">
                                    {foreach from=$data.actions item=action}
                                        <option {if $item->access|is_array && $action->action|in_array:$item->access || in_array($action->action, $smarty.post.access)} selected{/if}
                                                value="{$action->action}">{if $action->title}{$action->title}{else}{$action->action}{/if}</option>
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    {/if}

                    {if $user->id != $item->id}
                        <div class="label form__input-full">
                            <div class="label__content">
                                <span class="label__name">Активен:</span>
                            </div>
                            <span class="label__wrapper">
                                <label class="check ">
                                    <input class="check__input" name="active" {if $item->active || $smarty.post.active}checked{/if} value="1"
                                           type="checkbox">
                                </label>
                            </span>
                        </div>
                    {/if}
                </div>
            </div>
        </form>
    </section>
{/if}
