{if $content}
    <div class="prices-it  " data-parallax="0.2">
        <div class="prices-it__wrap">
            <div class="prices-it__img">
                {if $content->image->id}
                    <img src="{$content->image->getLink()}" alt="{$content->title|escape}" class="prices-it__pic">
                {/if}
            </div>
            
            <div class="prices-it__top">
                <div class="prices-it__name">{$content->title}</div>
                <div class="prices-it__price">{$content->price}</div>
                {if $content->sign}
                    <div class="prices-it__num glass-tag glass-tag--white">{$content->sign}</div>
                {/if}
            </div>
            <div class="prices-it__btm">
                {if $content->list}
                    <ul class="prices-it__list">
                        {foreach from=$content->list item='list_item' name='list'}
                            <li>{$list_item.value}</li>
                        {/foreach}
                    </ul>
                {/if}
                <button class="btn btn--black btn--sm prices-it__btn" data-action="request"><span>Записаться</span>
                </button>
            </div>
        </div>
    </div>
{/if}