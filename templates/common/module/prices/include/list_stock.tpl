{if $content}
    <div class="other-sale bg-blue anim-block anim-masked"  data-animation="anim-masked-mask"">
        <div class="other-sale__img">
            {if $content->image->id}
                <img src="{$content->image->getLink()}" alt="" width="149" height="103">
            {/if}
        </div>
        <div class="other-sale__name">{$content->title}</div>
        <div class="other-sale__descr glass-tag glass-tag--white">{$content->sign}</div>
        <div class="other-sale__prices">

            {if $content->price_old}
                <div class="other-sale__price">{$content->price}</div>
                <div class="other-sale__old">{$content->price_old}</div>
            {else}
                {$content->price}
            {/if}
        </div>
        <div class="other-sale__salt">Акция</div>

        <button class="btn btn--white btn--sm other-sale__btn" data-action="request">
            Запись
        </button>
    </div>
{/if}