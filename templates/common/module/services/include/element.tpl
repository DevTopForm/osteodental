{if $content}
    <a href="{$content->getUrl()}" class="service-it bg-white {$class}" {if $animation}data-animation="{$animation}"{/if} {if $delay}data-delay="{$delay}"{/if}>
        <div class="service-it__img">
            {if $content->image->id}
                <img src="{$content->image->getLink()}" alt="">
            {/if}
        </div>
        <div class="service-it__content">
            {if $content->item->sign}
                <div class="service-it__num glass-tag glass-tag--blue">{$content->item->sign}</div>
            {/if}
            <div class="service-it__name">{$content->title}</div>

            {if $content->item->price}
                <div class="service-it__price">{$content->item->price}</div>
            {/if}
        </div>
    </a>
{/if}