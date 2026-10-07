<div class="create-block">
    <a href="{$adm_path}/node/add" class="btn btn--blue btn--lg create-block__btn">
        <svg fill="none" width="16" height="16">
            <use xlink:href="{$adm_path}/assets/img/sprite.svg#add"></use>
        </svg>
        <span>Создать раздел</span>
    </a>

    <a href="{$adm_path}/node/add/{$node->id}" class="btn btn--link">
        <svg fill="none" width="16" height="16">
            <use xlink:href="{$adm_path}/assets/img/sprite.svg#add"></use>
        </svg>
        <span>Создать подраздел</span>
    </a>
    <a href="{$node->getUrl()}" target="_blank" class="btn btn--link">
        <svg fill="none" width="16" height="16">
            <use xlink:href="{$adm_path}/assets/img/sprite.svg#open"></use>
        </svg>
        <span>Открыть на сайте</span>
    </a>

    {if $user->hasAccess('lock')}
        <a href="{$adm_path}/node/lock/{$node->id}" class="btn btn--link">
            <svg fill="none" width="16" height="16">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#lock"></use>
            </svg>
            <span>{if !$node->blocked}За{else}Раз{/if}блокировать</span>
        </a>
    {/if}

    {if $node->type->has_items}
        <a href="{$adm_path}/node/favorite/{$node->id}?value={if App\Item\Favorite::isFavorite("`$adm_path`/content/list/`$node->id`")}0{else}1{/if}" class="btn btn--link">
            <svg fill="none" width="16" height="16">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#{if App\Item\Favorite::isFavorite("`$adm_path`/content/list/`$node->id`")}heart-filled{else}heart{/if}"></use>
            </svg>
            <span>{if App\Item\Favorite::isFavorite("`$adm_path`/content/list/`$node->id`")}Исключить из избранного{else}В избранное{/if}</span>
        </a>
    {/if}

    {if !$node->blocked || $user->hasAccess('lock')}
        <a href="{$adm_path}/node/delete/{$node->id}" class="btn btn--link js-delete" data-name="{$node->title}">
            <svg fill="none" width="16" height="16">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
            </svg>
            <span>Удалить раздел</span>
        </a>
    {/if}
</div>