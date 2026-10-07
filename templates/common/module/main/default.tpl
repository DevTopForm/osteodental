<section class="bg-light pt-60-100 index-top-wrap">
    <div class="index-top-wrap__inside">
        <div class="container">
            <img src="/htdocs/assets/build/img/osteo.svg" alt="" width="1177" height="685" data-parallax="0.2">
        </div>
    </div>
    <div class="container index-top">
        <div class="index-top__left">
            <div class="index-top__name">{$node->h1 ?: $content->title}</div>

            {if $content->main_links}
                <div class="index-top__tags">
                    {foreach $content->main_links as $item}
                        <a href="{$item.link}" class="more-tag btn btn--blue">
                            <span>{$item.text}</span>
                            <svg class="btn__icon" fill="none" width="25" height="17">
                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr2"></use>
                            </svg>
                        </a>
                    {/foreach}
                </div>
                <div class="index-top__btns">
                    <a href="/listing" class="btn btn--bordered-black btn--lg"><span>все услуги</span></a>
                    <button class="btn btn--black btn--lg" data-action="request"><span>Запись</span></button>
                </div>
            {/if}
        </div>

        <div class="index-top__right">
            {if $content->partner1_title && $content->partner1_img->id}
                <div class="index-top__block bg-white anim-block" data-animation="anim-popup-anim" data-delay="0">
                    {if $content->partner1_img->id}
                        <img src="{$content->partner1_img->getLink()}" alt="{$content->partner1_title}" width="96"
                             height="24">
                    {/if}
                    <p>{$content->partner1_title}</p>
                </div>
            {/if}

            {if $content->partner2_title && $content->partner2_img->id}
                <div class="index-top__block bg-gray anim-block" data-animation="anim-popup-anim" data-delay="0.2">
                    {if $content->partner2_img->id}
                        <img src="{$content->partner2_img->getLink()}" alt="{$content->partner2_title}" width="96"
                             height="24">
                    {/if}
                    <p>{$content->partner2_title}</p>
                </div>
            {/if}

            {if $content->subtitle}
                <div class="index-top-long bg-white anim-block" data-animation="anim-popup-anim" data-delay="0.2">
                    <div class="digital-imgs anim-block">
                        <div class="digital__imgs-inside">
                            <img src="/htdocs/assets/build/img/face3.png" alt="" class="digitlal__face">
                            <img src="/htdocs/assets/build/img/face2.png" alt=""
                                 class="digitlal__face2 anim slide-in animated"
                                 data-animation="slide-in">
                            <img src="/htdocs/assets/build/img/face.png" alt=""
                                 class="digitlal__face3 anim slide-in2 animated"
                                 data-animation="slide-in2">
                        </div>
                    </div>
                    <p>{$content->subtitle}</p>
                </div>
            {/if}
        </div>
    </div>
</section>

{if $content->stocks}
    {include file="module/includes/stocks.tpl" content=$content->stocks title=$content->stocks_title}
{/if}


    <div class="video-block {if $content->video_block_short}video-block--short{/if} container" style="transform: translate3d(0,0,0);" data-parallax="0.2">
        <div class="video-block__content anim-block anim-masked" data-animation="anim-masked-mask">
            {if $content->video_block_title}
                <h2 class="h2">{$content->video_block_title}</h2>
            {/if}

            {if $content->video_block_text}
                <div class="video-block__text">{$content->video_block_text}</div>
            {/if}
        </div>

        {if $content->video_block_video->id}
            <div class="video-block__video js-video-block">
                <div class="video anim-cliped anim-block" data-animation="anim-cliped-anim"
                     data-video="{$content->video_block_video->getLink()}">

                    {if $content->video_block_preview->id}
                        <img src="{$content->video_block_preview->getLink()}" alt="" width="820" height="476">
                    {/if}

                    <button class="btn video-btn">
                        <svg class="btn__play" width="30" height="34" viewBox="0 0 12 14" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"
                                  fill="url(#play)"></path>
                        </svg>
                        <svg class="btn__pause" width="30" height="34" viewBox="0 0 33 81" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.5 75.5L27.5 5.5M5.5 75.5L5.5 5.5" stroke="url(#play)" stroke-width="11"
                                  stroke-linecap="round"></path>
                        </svg>
                    </button>
                </div>
            </div>
        {/if}

        <div class="video-block__btn btn">
            <div class="result-slide__video-btn-inside">

            </div>
        </div>
    </div>

<div class="overflow">
    {$blocks.about}
    {$blocks.rating}
</div>

{if $content->video_reviews}
    <section class="overflow" data-parallax="0.2">
        <div class="container">
            {if $content->video_reviews_title}
                <h3 class="h3 mb-30 anim-masked anim-block" data-animation="anim-masked-mask">
                    {$content->video_reviews_title}
                </h3>
            {/if}
            <div class="videos js-mobile-swiper js-video-block" data-clicked="true">
                <div class="videos__slider js-mobile-swiper__slider">
                    <div class="videos__wrapper swiper-wrapper">
                        {foreach from=$content->video_reviews item='review' name='reviews'}
                            <div class="videos__it swiper-slide  {if $review->is_short}videos__it--short{else}videos__it--long{/if}" data-video="{$review->video->getLink()}">
                                {if $review->cover->id}
                                    <img width="2413" height="11357" loading="lazy" decoding="async" src="{$review->cover->getLink()}" alt="">
                                {/if}

                                <div class="rotate-btn btn videos__it-btn">
                                    <div class="rotate-btn__inside">
                                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}

{if $content->advantages}
    <div class="container">
        <div class="advs" data-parallax="0.2">
            {foreach $content->advantages as $adv}
                <div class="advs-it anim-block" data-animation="anim-popup-anim" data-delay="0.0">
                    <div class="advs-it__ico">
                        {if $adv.image->id}
                            <img class="btn__icon" src="{$adv.image->getLink()}" alt="{$adv.title}" width="27"
                                 height="27">
                        {/if}
                    </div>
                    <div class="advs-it__name">{$adv.title}</div>
                    <div class="advs-it__text">{$adv.text}</div>
                </div>
            {/foreach}
        </div>
    </div>
{/if}

{if $content->equipment}
    {include file="module/includes/equipment.tpl" content=$content->equipment title=$content->equipment_title}
{/if}

{if $content->news}
    <section class="overflow pb-60-100 mt-minus">
        <div class="container">
            <h3 class="h3 mb-30 anim-masked anim-block" data-animation="anim-masked-mask">{$content->news_title}</h3>
            <div class="news-slider js-why" data-gap="20">
                <div class="news-slider__slider js-why__slider">
                    <div class="news-slider__wrapper swiper-wrapper">
                        {foreach $content->news as $news}
                            {include file='module/news/include/element.tpl' content=$news class='active swiper-slide'}
                        {/foreach}
                    </div>
                </div>
                <div class="more-container">
                    <a href="/news" class="more-link news-slider__more">
                        <span>Все новости</span>
                        <svg class="btn__icon" fill="none" width="25" height="17">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr2"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </section>
{/if}