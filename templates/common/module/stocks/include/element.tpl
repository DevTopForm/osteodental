<div class="promo {$class} anim-block anim-popup"
     data-animation="anim-popup-anim" style="--promo-bg: #6BD8DB;">
    <div class="promo__content">
        {if $content->sign}
            <div class="glass-tag glass-tag--white">{$content->sign}</div>
        {/if}
        <div class="promo__name">{$content->title}</div>
        {if $content->price}
            <div class="promo__price">{$content->price}</div>
        {/if}


        {if $content->text}
            <button class="btn btn--bordered btn--bordered-white btn--sm promo__btn"
                    data-action="promo-{$content->id}">
                <span>Подробнее</span>
            </button>
        {/if}
    </div>
    <div class="promo__img">
        {if $content->image->id}
            <img src="{$content->image->getLink()}" alt="{$content->title|escape}"
                 width="527" height="401">
        {/if}
    </div>
    {*                        <a href="#" class="promo__link"></a>*}
</div>
