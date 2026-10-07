{if $images}
    <div class="about-slider {$class}">
        <div class="about-slider__slider js-thumb-swiper__slider">
            <div class="about-slider__wrapper swiper-wrapper">
                {foreach from=$images item='image' name='images'}
                    {if $image->id}
                        <div class="about-slider__slide swiper-slide">
                            <img src="{$image->getLink('thumb')}" alt="" width="540" height="540">
                        </div>
                    {/if}
                {/foreach}
            </div>
        </div>
        <div class="about-slider__thumbs js-thumb-swiper__thumbs">
            <div class="about-slider__thumbs-wrapper swiper-wrapper">
                {foreach from=$content->images item='image' name='images'}
                    {if $image->id}
                        <div class="about-slider__thumb swiper-slide">
                            <img src="{$image->getLink('thumb')}" alt="" width="540" height="540">
                        </div>
                    {/if}
                {/foreach}
            </div>
        </div>
    </div>
{/if}