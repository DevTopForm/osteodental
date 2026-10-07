{if $content}
    <div class="bg-light pt-60-100 pb-60-100 fb-wrapper">
        <div class="container">
            <h3 class="h3 mb-30">{$node->title}</h3>
            <div class="fbs js-auto-swiper" data-gap="20">
                <div class="fbs__slider js-auto-swiper__slider">
                    <div class="fbs__wrapper swiper-wrapper">
                        {foreach from=$content item='platform' name='platforms'}
                            <{if $platform->link}a href="{$platform->link}" target="_blank" rel="nofollow" {else}div{/if} class="fbs__it fbs-it swiper-slide">
                                <div class="fbs-it__img">
                                    {if $platform->image->id}
                                        <img src="{$platform->image->getLink()}" alt="" height="35" width="205">
                                    {/if}
                                </div>
                                <div class="fbs-it__content">
                                    {if $platform->rating}
                                        <div class="fbs-it__rate">
                                            <svg class="btn__icon" fill="none" width="17" height="17">
                                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#star"></use>
                                            </svg>
                                            {$platform->rating}
                                        </div>
                                    {/if}
                                    <div>{$platform->title}</div>
                                </div>
                            </{if $platform->link}a{else}div{/if}>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </div>
{/if}