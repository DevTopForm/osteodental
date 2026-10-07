<div class="board-block  js-to-expand" data-block="{$widget->name}">
    <div class="board-block__top ">
        <button class="btn board-ico board-block__ico">
            <div class="board-ico__ico">
                <svg fill="none" width="15" height="15">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#heart"></use>
                </svg>
            </div>
        </button>
        <h2 class="board-block__name">
            <span>Избранное</span>
        </h2>
        <a href="{$adm_path}/widget/is_show/{$widget->id}" class="btn board-block__close js-close"
           arialabel="Убрать блок">
            <svg fill="none" width="20" height="20">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#cross"></use>
            </svg>
        </a>
        <button class="js-handle board-block__handle btn ">
            <svg fill="none" width="7" height="13">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
            </svg>
        </button>
        <button class="board-block__opener btn js-expand">
            <svg fill="none" width="12" height="7">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
            </svg>
        </button>
    </div>
    <div class="board-block__content ">
        <div class="board-block__inside">
            <div class="history-block">
                {if is_array($list) && count($list)}
                    {foreach $list as $item}
                        <div class="dash-link history-block__it">
                            <a href="{$item->url}" class="dash-link__link" title="{$item->title}"></a>
                            <span class="dash-link__text">{$item->title}</span>
                            <button class="dash-link__close btn js-remove-favorite" data-id="{$item->id}">
                                <svg fill="none" width="12" height="12">
                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#cross"></use>
                                </svg>
                            </button>
                            <svg class="dash-link__arr" fill="none" width="12" height="12">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#arrow"></use>
                            </svg>
                        </div>
                    {/foreach}
                {/if}
            </div>
        </div>
    </div>
</div>