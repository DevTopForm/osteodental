{if $content}
    <section id="stocks" class="overflow">
        <div class="container">
            {if $title}
                <h3 class="h3 mb-30  anim-block anim-masked" data-animation="anim-masked-mask">{$title}</h3>
            {/if}
            <div class="promo-slider js-why">
                <div class="promo-slider__slider js-why__slider">
                    <div class="promo-slider__wrapper swiper-wrapper">
                        {foreach from=$content item='stock' name='stocks'}
                            {include file='module/stocks/include/element.tpl' content=$stock class='promo-slider__it swiper-slide'}
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {foreach from=$content item='stock' name='stocks'}
        {if $stock->text}
            {include file='module/stocks/include/popup.tpl' content=$stock}
        {/if}
    {/foreach}
{/if}