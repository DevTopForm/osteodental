{if $node->id}
    {include file='menu/node-actions.tpl' node=$node}
{/if}
<section class="catalog" data-node="{$node->id}" data-type="item">
    {if $state == 'list'}
        <h1 class="h1 catalog__h1">{$node->title}</h1>
        {if $node->id}
            {include file='menu/node-menu.tpl' node=$node active=content}
        {/if}
        <div class="top"></div>
        {if !empty($errors) && $errors|@count > 0}
            <div class="messages">
                {foreach from=$errors item='message'}
                    {$message->html}
                {/foreach}
            </div>
        {/if}

        {include file='blocks/content/list/controls.tpl'}

        {if $list}
            <form id="catalog-list-form" method="post"
                  class="table-wrapper catalog__table {if $node->type->sortable}catalog__table--sortable{/if}">
                <table class="catalog-table">
                    <thead>
                    <tr>
                        {if $node->type->sortable}
                            <th class="catalog-table__th"></th>
                        {/if}
                        <th class="catalog-table__th">
                            <label class="check catalog-table__input check--light">
                                <input class="check__input" name="selectAll" value="1" type="checkbox">
                                <span class="check__name">выбрать все</span>
                            </label>
                        </th>
                        {foreach from=$fields.text item='field'}
                            <th class="catalog-table__th">{$field->title}</th>
                        {/foreach}
                        <th class="catalog-table__th"></th>
                        <th class="catalog-table__th">Управление</th>
                    </tr>
                    </thead>
                    <tbody>
                    {foreach from=$list item='item' name='list'}
                        <tr class="catalog-table__tr" data-order="{$item->id}">
                            {if $node->type->sortable}
                                <td class="catalog-table__td">
                                    <div class="js-handle">
                                        <svg fill="none" width="7" height="13">
                                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
                                        </svg>
                                    </div>
                                </td>
                            {/if}

                            <td class="catalog-table__td">
                                <label class="check catalog-table__input">
                                    <input class="check__input" name="list[{$item->id}]" value="1" type="checkbox">
                                    <span class="check__name">выбрать элемент</span>
                                </label>
                            </td>
                            {foreach from=$fields.text item='field'}
                                {assign var=key value=$field->name}
                                {if $field->field == 'image'}
                                    <td class="catalog-table__td">
                                        {if $item->$key->id}
                                            <span class="catalog-item__img">
                                                <img src="{$item->$key->getLink()}" class="" width="49" height="38">
                                            </span>
                                        {/if}
                                    </td>
                                {else}
                                    {if in_array($field->field, ["text", "textarea", "integer"])}
                                        <td class="catalog-table__td" data-edit="true">
                                            <div class="catalog-table__td-inside" data-node="{$node->id}"
                                                 data-itemid="{$item->id}"
                                                 data-field="{$key}" tabindex="0">
                                                <div class="catalog-item__name" contenteditable="false">
                                                    {$item->$key}
                                                </div>
                                            </div>
                                        </td>
                                    {else}
                                        <td class="catalog-table__td">
                                            <span class="catalog-item__name">{$item->$key}</span>
                                        </td>
                                    {/if}
                                {/if}
                            {/foreach}

                            <td class="catalog-table__td">
                                <span class="catalog-item__inside">
                                    {foreach from=$fields.checkbox item='field' name='fields'}
                                        {assign var=key value=$field->name}
                                        <label class=" input-elt" title="{$field->title}">
                                            <input data-node="{$node->id}" data-id="{$item->id}"
                                                   class="input-elt__input ajax-node-field" type="checkbox"
                                                   value="1" name="{$field->name}"
                                                   {if $item->$key}checked{/if}>
                                            <span class="input-elt__fake">
                                                <svg fill="none" width="21" height="16">
                                                  <use xlink:href="{$adm_path}/assets/img/sprite.svg#tick"></use>
                                                </svg>
                                            </span>
                                          <span class="input-elt__text">выбрать ...</span>
                                        </label>
                                    {/foreach}
                                </span>
                            </td>
                            <td class="catalog-table__td" data-position="right">
                                <div class="jsFixed">
                                    <div class="catalog-item__controls">
                                        <div class="ico-btns catalog-item__btns">
                                            <label class=" input-elt ico-btn" title="Опубликовать">
                                                <input data-node="{$node->id}" data-id="{$item->id}"
                                                       class="input-elt__input ajax-node-field" type="checkbox"
                                                       value="1"
                                                       name="public" {if $item->public}checked{/if}>
                                                <span class="input-elt__fake">
                                                     <svg fill="none" width="21" height="16">
                                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#eye"></use>
                                                    </svg>
                                                </span>
                                                <span class="input-elt__text">выбрать ...</span>
                                            </label>
                                            <a href="{$adm_path}/content/edit/{$node->id}/{$item->id}" class="ico-btn"
                                               aria-label="Название того, что делает кнопка">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
                                                </svg>
                                            </a>
                                            <a href="{$item->getUrl()}" class="ico-btn"
                                               alt="Перейти на страницу товара">
                                                <svg fill="none" width="21" height="16">
                                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#open"></use>
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
            Элементы не найдены
        {/if}
    {elseif $state == 'edit' || $state == 'add'}
        <h1 class="h1 catalog__h1">{$node->title}</h1>
        {if $node->id && !$node->type->has_items}
            {include file='menu/node-menu.tpl' node=$node active=content}
        {/if}
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="not_copy" value="1">
            <div class="catalog__item-top">
                <div class="item-controls js-to-expand">
                    {if $node->type->has_items}
                        <a href="/adm/content/list/{$node->id}" class="btn btn--link item-controls__back">
                            <svg fill="none" width="12" height="12">
                                <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
                            </svg>
                            <span>В список</span>
                        </a>
                    {/if}
                    <div class="btn btn--link item-controls__more js-expand " aria-label="Открыть кнопки">
                        <svg fill="none" width="34" height="8">
                            <use xlink:href="/adm/assets/img/sprite.svg#dots"></use>
                        </svg>
                    </div>
                    <div class="item-controls__short">
                        <div class="item-controls__group">
                            <button name="save_item" value="Применить" class="btn btn--bd btn--lg item-controls__btn">
                                <span>Применить</span>
                            </button>
                            <button class="btn btn--blue btn--lg item-controls__btn" disabled="">
                                <span>Вернуть данные</span>
                            </button>
                            <button class="btn btn--blue btn--lg item-controls__btn" disabled="">
                                <span>Отменить</span>
                            </button>
                        </div>
                        {if $item->id}
                            <div class="item-controls__group">
                                <button type="submit" name="favorite"
                                        value="{if App\Item\Favorite::isFavorite($smarty.server.REQUEST_URI)}0{else}1{/if}"
                                        class="btn btn--short">
                                    <svg fill="none" width="16" height="16">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#{if App\Item\Favorite::isFavorite($smarty.server.REQUEST_URI)}heart-filled{else}heart{/if}"></use>
                                    </svg>
                                    <span>{if App\Item\Favorite::isFavorite($smarty.server.REQUEST_URI)}Удалить из избранного{else}В избранное{/if}</span>
                                </button>

                                {if $node->type->has_items}
                                    <button type="submit" name="copy_item" value="Копировать" class="btn btn--short">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="/adm/assets/img/sprite.svg#copy"></use>
                                        </svg>
                                        <span>Копировать</span>
                                    </button>
                                {/if}

                                {if $node->type->has_items}
                                    <a href="{$item->getUrl()}" target="_blank" class="btn btn--short">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="/adm/assets/img/sprite.svg#open"></use>
                                        </svg>
                                        <span>Открыть на сайте</span>
                                    </a>
                                    <a type="submit" href="{$path_prefix}/delete/{$node->id}/{$item->id}"
                                       class="btn btn--short js-delete" data-name="{$item->title}">
                                        <svg fill="none" width="16" height="16">
                                            <use xlink:href="/adm/assets/img/sprite.svg#trash"></use>
                                        </svg>
                                        <span>Удалить</span>
                                    </a>
                                {/if}
                            </div>
                        {/if}
                    </div>
                    <button name="save" value="Применить" class="btn btn--blue btn--lg">
                        <span>Сохранить</span>
                    </button>
                </div>

                <div class="catalog__tabs">

                    {foreach from=$groups item='group' key='key' name='head_groups'}
                        <a href="#tab{$key}" class="tab-name {if $smarty.foreach.head_groups.first}active{/if}"
                           title="{$group.title|escape}">
                            {$group.title}
                        </a>
                    {/foreach}
                </div>
            </div>
            <div class="form">
                {foreach from=$groups item='group' key='key' name='body_groups'}
                    <div class="form__fieldset">
                        <h2 class="form__h2" id="tab{$key}">{$group.title}</h2>
                        <div class="form__fieldset-wrap">
                            {foreach from=$group.fields item='field'}
                                {include file='content/fields/'|cat:$field->field|cat:'.tpl'}
                            {/foreach}
                        </div>
                    </div>
                {/foreach}
            </div>
        </form>
    {/if}
</section>