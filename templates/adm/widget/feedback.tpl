<div class="board-block  js-to-expand" data-block="{$widget->name}">
    <div class="board-block__top ">
        <button class="btn board-ico board-block__ico">
            <div class="board-ico__ico">
                <svg fill="none" width="15" height="15">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#email"></use>
                </svg>
            </div>

            {if $new_count}
                <div class="board-ico__tick">
                    {$new_count}
                </div>
            {/if}
        </button>
        <h2 class="board-block__name">
            <span>Входящие</span>
        </h2>
        <a href="{$adm_path}/widget/is_show/{$widget->id}" class="btn board-block__close js-close" arialabel="Убрать блок">
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

            <div class="mails-block">

                <div class="dashblock-top mails-block__top ">
                    <form onsubmit="return false" action="" method="get" enctype="multipart/form-data" class="dashblock-top__dates">
                        <input id="widget-{$widget->name}-datepicker-hidden" type="hidden" name="{$filter_name}" value="{$interval}">
                        <span class="dashblock-top__dates-text">Всего за</span>
                        <button id="widget-{$widget->name}-datepicker" name="{$filter_name}" class="btn btn--lighter btn--small js-dates-block">{$interval}</button>
                        <div class="dashblock-top__total total-info">
                            <span class="total-info__name">{$count.all}</span>
                            <div class="total-info__info" data-tooltip="content" data-tooltip-style="light">
                                <div class="js-tooltip-content">
                                    <p>Всего: {$count.all}</p>
                                    <p>Спам: {$count.spam}</p>
                                </div>
                                i
                            </div>
                        </div>

                    </form>
                    <a href="{$adm_path}/feedback" class="btn btn--lighter btn--small">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 4" width="12" height="4">
                            <path fill="#4159D2" d="M1.392 3.382c-.384 0-.714-.134-.99-.403A1.33 1.33 0 0 1 0 1.99c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.339 1.339 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184ZM5.767 3.382c-.384 0-.714-.134-.99-.403a1.33 1.33 0 0 1-.402-.989c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.339 1.339 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184ZM10.142 3.382c-.384 0-.714-.134-.99-.403a1.33 1.33 0 0 1-.402-.989c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.34 1.34 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184Z"></path>
                        </svg>
                        <span>Все сообщения</span>
                    </a>
                </div>

                <div class="mails-block__list">
                    {if $list}
                        {foreach from=$list item='item'}
                            <div class="mail-item {if !$item->public}new{/if}">
                                <div class="mail-item__info">
                                    <div class="mail-item__info-date">{$item->date|date_format:"%d.%m.%Y %H:%M:%S"}</div>
                                    <div class="mail-item__info-form">{$item->node->title}</div>
                                </div>
                                <div class="mail-item__contacts">
                                    {foreach from=$item->data item='value'}
                                        {$value.title}: {$value.value} <br>
                                    {/foreach}
                                </div>
                            </div>
                        {/foreach}
                    {else}
                        Ничего не найдено
                    {/if}
                </div>
            </div>
        </div>
    </div>
</div>