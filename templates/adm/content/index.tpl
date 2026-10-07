<section class="dashboard">
    <h1 class="h1 dashboard__h1">Дашборд</h1>
    <div class="board">
        {if $widgets}
            {foreach from=$widgets item='widget'}
                {if $widget->isShow()}
                    {$widget->widget->getHtml()}
                {/if}
            {/foreach}
        {/if}
    </div>
    {if $widgets}
        <div class="d-icos dashboard__icos">
            <div class="d-icos__inside">

                {foreach from=$widgets item='widget'}
                    <div class="d-ico active" aria-label="{$widget->title}" data-block="{$widget->name}" draggable="false" style="">
                        <button class="js-handle d-ico__handle btn">
                            <svg fill="none" width="7" height="13">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
                            </svg>
                        </button>
                        <a href="{$adm_path}/widget/is_show/{$widget->id}" class="btn board-ico">
                            <div class="board-ico__ico">
                                {if $widget->icon}
                                    <svg fill="none" width="15" height="15">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#{$widget->icon}"></use>
                                    </svg>
                                {/if}
                            </div>
                            {if $widget->isShow()}
                                <div class="board-ico__tick">
                                    <svg fill="none" width="8" height="6">
                                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#tick"></use>
                                    </svg>
                                </div>
                            {/if}
                        </a>
                    </div>
                {/foreach}
            </div>
        </div>
    {/if}
</section>