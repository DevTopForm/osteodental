{if $content}
    <div class="mb-60 {$class}">
        <h2 class="h2 mb-20-30">{$title ?: "Услуги"}</h2>
        <div class="tags-row  js-auto-slider">
            <div class="tags-row__slider js-auto-slider__slider">
                <div class="tags-row__wrapper swiper-wrapper">
                    {foreach $content as $item}
                        <a href="{$item->getUrl()}" class="tags-row__it tag-it active swiper-slide anim"
                           data-anim-type="transform" data-anim-start="translateY(30px)" data-anim-end="translateY(0)"
                           data-anim-duration="0.3s">{$item->title}</a>
                    {/foreach}
                </div>
            </div>
        </div>
    </div>
{/if}