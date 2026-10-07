{if $content}
    <div class="sales js-auto-slider {$class}" data-gap="20">
        <div class="sales__slider js-auto-slider__slider">
            <div class="sales__wrapper swiper-wrapper">
                {foreach $content as $item}
                    <a class="sales-it sales__it swiper-slide anim" data-anim-type="transform"
                         data-anim-start="translateY(150px)" data-anim-end="translateY(0)" data-anim-duration="0.3s"
                         data-anim-delay="0.2s" href="{$item->getUrl()}">
                        {if $item->image->id}
                            <img class="sales-it__img" src="{$item->image->getLink()}" alt="{$item->title}" width="760"
                                 height="210">
                        {/if}
                        <div class="sales-it__content">
                            <div class="sales-it__name h2">{$item->title}</div>
                            <div class="sales-it__text">{$item->announce}</div>
                        </div>
                    </a>
                {/foreach}
            </div>
        </div>
        <button class="btn btn--arr btn--white arr-left sales__left">
            <svg fill="none" width="20" height="20">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#chevron"></use>
            </svg>
        </button>
        <button class="btn btn--arr btn--white arr-right sales__right">
            <svg fill="none" width="20" height="20">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#chevron"></use>
            </svg>
        </button>
    </div>
{/if}