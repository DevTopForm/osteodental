{if $content}
    {$product_link = $content->getUrl()}
    <article class="short-item items-slider__it swiper-slide">
        {$favClass = ($content->isFavorite()) ? " active" : ""}
        {include file='page/includes/product/fav-btn.tpl' id=$content->id class="short-item__fav $favClass"}

        {include file='page/includes/product/tags.tpl' tags=$content->tags containerClass="short-item__tags" tagClass="tag--new"}

        <div class="short-item__imgs-wrap">
            <div class="short-item__imgs js-short-item-swiper">
                <div class="short-item__imgs-slider js-short-item-swiper__slider">
                    <div class="short-item__imgs-wrapper swiper-wrapper">
                        <div class="short-item__img swiper-slide {if $content->video_announce->id}js-video{/if}"
                                {if $content->video_announce->id}
                                    data-video="{$content->video_announce->getLink()}"
                                    data-video-view="inView"
                                {/if}
                        >
                            <div class="img-left" tabindex="0"></div>
                            <div class="img-right" tabindex="0"></div>
                            <a href="{$product_link}" title="{$content->title}">
                                {if $content->image->id}
                                    <img src="{$content->image->getLink()}" alt="{$content->title}" width="550"
                                         height="835" loading="lazy" decoding="async">
                                {/if}
                            </a>
                        </div>

                        {if $content->gallery}
                            {foreach $content->gallery as $img}
                                <div class="short-item__img swiper-slide">
                                    <div class="img-left" tabindex="0"></div>
                                    <div class="img-right" tabindex="0"></div>
                                    <a href="{$product_link}" title="{$content->title}">
                                        <img src="{$img->getLink()}" alt="{$content->title}" width="550" height="835"
                                             loading="lazy" decoding="async">
                                    </a>
                                </div>
                            {/foreach}
                        {/if}
                    </div>
                </div>
                <div class="short-item__dots dots dots--short js-short-item-swiper__dots"></div>
            </div>

            {$sizes = $content->getVariantAttributes("size")}
            {$heights = $content->getVariantAttributes("height")}

            {if $sizes && $heights && is_array($sizes) && is_array($heights) && count($sizes) && count($heights)}
                <div class="short-item__choose">
                    <form class="size-chooser short-item__sizes js-size-chooser" method="post"
                          enctype="multipart/form-data" data-product-id="{$content->id}">
                        <button type="submit" class="btn btn--lg btn--white short-item__btn js-cart-btn">
                            <span class="cart-btn__add">В корзину</span>
                            <span class="cart-btn__in">В корзинe</span>
                        </button>

                        {include file='page/includes/product/chooser.tpl' values=$sizes isSlider=true name="size"}
                        {include file='page/includes/product/chooser.tpl' values=$heights isSlider=true name="height"}
                    </form>
                </div>
            {/if}
        </div>

        <a href="{$product_link}" class="short-item__content">
            <div class="short-item__name">{$content->title}</div>
            <div class="short-item__price">{$content->price} руб.</div>
        </a>
    </article>
{/if}