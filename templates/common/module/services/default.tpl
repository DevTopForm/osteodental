<div class="top-wrapper">
    {if $content->banner_staff}
        <div class="top-slider container pt-25 {if $content->children}mb-30{/if}  js-main-swiper">
            <div class="top-slide top-slider__slide" style="background-image: url(/htdocs/assets/build/img/bg.jpg);">
                <div class="top-slide__left">
                    <h1 class="top-slide__name">
                        {if $node->h1}
                            {$node->h1}
                        {else}
                            {$content->title|default:$node->title}
                        {/if}
                    </h1>
                    {if $content->banner_list}
                        <div class="top-slide__content">
                            <ul class="top-slide__list">
                                {foreach from=$content->banner_list item='item' name='list_items'}
                                    <li>{$item.value}</li>
                                {/foreach}
                            </ul>
                        </div>
                    {/if}
                    <div class="top-slide__btm">
                        {if $content->price}
                            <div class="top-slide__price">
                                {$content->price}
                            </div>
                        {/if}

                        {if $content->sign}
                            <div class="top-slide__num">{$content->sign}</div>
                        {/if}

                        <button class="btn btn--black btn--lg top-slide__btn" data-action="request"><span>Запись</span>
                        </button>
                    </div>
                </div>
                <div class="top-slide__right">
                    <div class="tag tag--white top-slide__tag">Ваш врач</div>
                    <div class="top-slide__slider js-main-swiper__slider">
                        <div class="top-slide__wrapper swiper-wrapper">
                            {foreach from=$content->banner_staff item='staff' name='staff_list'}
                                <div class="top-slide__slide swiper-slide">
                                    <div class="top-slide__doctor-wrapper">
                                        {if $staff->image->id}
                                            <img class="top-slide__doctor" src="{$staff->image->getLink('banner')}" alt="" width="576" height="619">
                                        {/if}
                                    </div>
                                    <div class="top-slide__info info">
                                        {if $staff->rating}
                                            <div class="info__top">
                                                <img class="info__lic" src="/htdocs/assets/build/img/licences.png" alt="" width="162" height="106">
                                                <div class="info__rating">
                                                    <div class="info__rate">
                                                        <p class="info__rate-rate">{$staff->rating}</p>
                                                        <p>
                                                            <svg class="btn__icon" fill="none" width="17" height="17">
                                                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#star"></use>
                                                            </svg>
                                                        </p>

                                                    </div>
                                                    <div class="info__checked">
                                                        <svg class="btn__icon" fill="none" width="9" height="12">
                                                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#shield"></use>
                                                        </svg>
                                                        Проверено
                                                    </div>
                                                    <img class="info__img" src="/htdocs/assets/build/img/pro-doctorov.png" alt="" width="129" height="20">
                                                </div>
                                            </div>
                                        {/if}
                                        <div class="info__about">
                                            <p class="info__name">{$staff->title}</p>

                                            {if $staff->position}
                                                <p class="info__text">{$staff->position}</p>
                                            {/if}
                                        </div>
                                    </div>
                                </div>
                            {/foreach}
                        </div>
                    </div>
                </div>
            </div>

            {if $content->banner_staff|count > 1}
                <div class="top-slider__controls">
                    <div class="top-slider__dots js-main-swiper__dots"></div>
                    <div class="top-slider__arrs arrs">
                        <button class="btn btn--bordered btn--bordered-white arr arr--left">
                            <svg class="btn__icon" fill="none" width="90" height="46">
                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                            </svg>
                        </button>
                        <button class="btn btn--bordered btn--bordered-white arr arr--right">
                            <svg class="btn__icon" fill="none" width="90" height="46">
                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                            </svg>
                        </button>
                    </div>
                </div>
            {/if}
        </div>
    {/if}

    {if $content->children}
        <div class="overflow pb-60-100 pt-60-100 bg-light">
            <div class="container">
                <div class="services">
                    {foreach from=$content->children item='child' name='children'}
                        {include file='module/services/include/element.tpl' content=$child}
                    {/foreach}
                </div>
            </div>
        </div>
    {/if}

    {if $content->anchors}
        <div class="container">
            <nav class="menu sub-menu">
                <ul class="menu__list">
                    {assign var='delay' value=0.2}

                    {foreach $content->anchors as $key => $value}
                        <li class="anim-popdown anim-block" data-animation="anim-podown-anim" data-delay="{$delay}">
                            <a href="#{$key}" class="menu__it ">
                                <span>{$value}</span>
                            </a>
                        </li>

                        {assign var='delay' value=$delay + 0.2}
                    {/foreach}
                </ul>
            </nav>
        </div>
    {/if}
</div>

<section class="overflow" id="service">
    {if $content->text}
        <section class="digital mb-60-100 container">
            {if $content->text_sign}
                <div class="tag  digital__tag">{$content->text_sign}</div>
            {/if}
            <div class="digital__content">
                {if $content->text_title}
                    <h2 class="h2 anim-block anim-masked" data-animation="anim-masked-mask">{$content->text_title}</h2>
                {/if}

                <div class="digital__text  anim-block anim-masked" data-animation="anim-masked-mask">
                    {$content->text}
                </div>
            </div>

            <div class="digital__imgs anim-block">
                <div class="digital__imgs-inside">
                    {if $content->head_1->id || $content->head_2->id || $content->head_3->id}
                        {if $content->head_1->id}
                            <img src="{$content->head_1->getLink()}" alt="" class="digitlal__face">
                        {/if}

                        {if $content->head_2->id}
                            <img src="{$content->head_2->getLink()}" alt="" class="digitlal__face2 anim" data-animation="slide-in">
                        {/if}

                        {if $content->head_3->id}
                            <img src="{$content->head_3->getLink()}" alt="" class="digitlal__face3 anim" data-animation="slide-in2">
                        {/if}
                    {else}
                        <img src="/htdocs/assets/build/img/face3.png" alt="" class="digitlal__face">
                        <img src="/htdocs/assets/build/img/face2.png" alt="" class="digitlal__face2 anim" data-animation="slide-in">
                        <img src="/htdocs/assets/build/img/face.png" alt="" class="digitlal__face3 anim" data-animation="slide-in2">
                    {/if}
                </div>
            </div>
        </section>
    {/if}

    {if $content->advantages}
        <section class="container">
            {if $content->advantages_title}
                <h3 class="h3 mb-30 h3--arr  anim-block anim-masked"  data-animation="anim-masked-mask">{$content->advantages_title}</h3>
            {/if}
            <div class="why js-why">
                <div class="why__slider js-why__slider">
                    <div class="why__wrapper swiper-wrapper">
                        {foreach from=$content->advantages item='advantage' name='advantages'}
                            <article class="why-it bg-gray why__it swiper-slide">
                                <div class="why-it__img">
                                    {if $advantage.image->id}
                                        <img src="{$advantage.image->getLink()}" alt="" width="261" height="270">
                                    {/if}
                                </div>
                                <div class="why-it__content">
                                    <h4 class="why-it__name">{$advantage.title}</h4>
                                    <div>
                                        <p>{$advantage.text}</p>
                                    </div>
                                </div>
                            </article>
                        {/foreach}
                    </div>
                </div>
                <div class="why__arrs arrs">
                    <button class="btn btn--bordered  arr arr--left">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                    <button class="btn btn--bordered arr arr--right">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    {/if}
</section>

{if $content->equipment}
    {include file="module/includes/equipment.tpl" content=$content->equipment title=$content->equipment_title}
{/if}

{if $content->video->id || $content->video_cover->id}
    <div class="video-block  {if $content->video_block_short}video-block--short{/if} container" style="transform: translate3d(0,0,0);" data-parallax="0.2">
        <div class="video-block__content anim-block anim-masked" data-animation="anim-masked-mask">
            {if $content->video_title}
                <h2 class="h2">{$content->video_title}</h2>
            {/if}

            {if $content->video_text}
                <div class="video-block__text">{$content->video_text}</div>
            {/if}
        </div>
        <div class="video-block__video js-video-block">
            <div class="video anim-cliped anim-block" data-animation="anim-cliped-anim"  {if $content->video->id}data-video="{$content->video->getLink()}"{/if}>
                {if $content->video_cover->id}
                    <img src="{$content->video_cover->getLink()}" alt="" width="820" height="476">
                {/if}
                {if $content->video->id}
                    <button class="btn video-btn">
                        <svg class="btn__play" width="30" height="34" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>

                        </svg>
                        <svg class="btn__pause" width="30" height="34" viewBox="0 0 33 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.5 75.5L27.5 5.5M5.5 75.5L5.5 5.5" stroke="url(#play)" stroke-width="11" stroke-linecap="round"></path>

                        </svg>
                    </button>
                {/if}
            </div>
        </div>
        {if $content->video->id}
            <div class="video-block__btn">
                <div class="result-slide__video-btn-inside">
                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"
                              fill="url(#paint0_linear_750_782)"></path>
                        <defs>
                            <linearGradient id="paint0_linear_750_782" x1="6.5" y1="-0.72998" x2="0.00811087" y2="14.3424"
                                            gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7BFAD5"></stop>
                                <stop offset="1" stop-color="white"></stop>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        {/if}
    </div>
{/if}


<section class="overflow">
    {if $content->advantages_2}
        <div class="container {if $content->bottom_slider}mb-60-100{/if}">
            <div class="advs" data-parallax="0.2">
                {foreach $content->advantages_2 as $adv}
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

    {if $content->bottom_slider}
        <section class="container">
            {if $content->bottom_slider_title}
                <h3 class="h3 mb-30 h3--arr  anim-block anim-masked"  data-animation="anim-masked-mask">{$content->bottom_slider_title}</h3>
            {/if}
            <div class="why js-why">
                <div class="why__slider js-why__slider">
                    <div class="why__wrapper swiper-wrapper">
                        {foreach from=$content->bottom_slider item='advantage' name='advantages'}
                            <article class="why-it bg-gray why__it swiper-slide">
                                <div class="why-it__img">
                                    {if $advantage.image->id}
                                        <img src="{$advantage.image->getLink()}" alt="" width="261" height="270">
                                    {/if}
                                </div>
                                <div class="why-it__content">
                                    <h4 class="why-it__name">{$advantage.title}</h4>
                                    <div>
                                        <p>{$advantage.text}</p>
                                    </div>
                                </div>
                            </article>
                        {/foreach}
                    </div>
                </div>
                <div class="why__arrs arrs">
                    <button class="btn btn--bordered  arr arr--left">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                    <button class="btn btn--bordered arr arr--right">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    {/if}
</section>

{if $content->under_video_text}
    <div class="results pt-60-100  container" data-parallax="0.2">
        {if $content->under_video_title}
            <h3 class="h3 results__h3 anim-block anim-masked" data-animation="anim-masked-mask">
                {$content->under_video_title}
            </h3>
        {/if}
        <div class="results__img">
            {if $content->under_video_image->id}
                <img src="{$content->under_video_image->getLink()}" alt="{$content->under_video_title|escape}" width="748" height="571">
            {/if}
        </div>
        <div class="results__content">
            <div class="results__text">
                {$content->under_video_text}
            </div>
            <button class="btn btn--blue btn--lg top-slide__btn" data-action="request"><span>Запись</span></button>
        </div>

    </div>
{/if}

<section id="prices" class="overflow pb-60-100 pt-60-100 bg-light" data-parallax="0.2">
    {if $content->prices}
        <section class="container mb-60-100">
            {if $content->prices_title}
                <h3 class="h3 mb-30" data-parallax="0.2">{$content->prices_title}</h3>
            {/if}
            <div class="prices">
                {foreach from=$content->prices item='price' name='prices'}
                    {include file='module/prices/include/element.tpl' content=$price}
                {/foreach}
            </div>
        </section>
    {/if}

    {if $content->prices_list}
        <section class="container">
            {if $content->prices_list_title}
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask">{$content->prices_list_title}</h3>
            {/if}

            <div class="other">
                {foreach from=$content->prices_list item='price' name='prices'}
                    {if $price->is_stock}
                        {include file='module/prices/include/list_stock.tpl' content=$price}
                    {else}
                        {include file='module/prices/include/list_element.tpl' content=$price}
                    {/if}
                {/foreach}
            </div>
        </section>
    {/if}
</section>
{if $content->numbers}
    <section>
        {if $content->numbers_title}
            <div class="container">
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask">{$content->numbers_title}</h3>
            </div>
        {/if}

        <div class="history ">
            <div class="container history__arrs">
                <div class="arrs">
                    <button class="btn btn--bordered  arr arr--left">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                    <button class="btn btn--bordered arr arr--right">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="overflow">
                <div class="history__slider container">
                    <div class="history__wrapper swiper-wrapper">
                        {foreach from=$content->numbers item='number' name='numbers'}
                            {if !isset($history_delay)}
                                {assign var="history_delay" value=0.2}
                            {else}
                                {assign var="history_delay" value=$history_delay + 0.2}
                            {/if}

                            <div class="history-it history__it swiper-slide anim-block anim-popup" data-animation="anim-popup-anim" data-delay="{$history_delay}">
                                <div class="history-it__num">
                                    <div class="history-it__round">
                                    </div>
                                </div>
                                <div class="history-it__content">
                                    <div class="history-it__content-inside">
                                        {$number.value}
                                    </div>
                                </div>
                            </div>
                        {/foreach}
                        <div class="history-it history__it swiper-slide"></div>
                        <div class="history-it history__it swiper-slide"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
{/if}

<section class="overflow pb-60-100 pt-60-100">
    {if $content->text_2_title}
        <section class="digital {if $content->video_2->id || $content->video_2_cover->id || $content->under_video_2_title}mb-60-100{/if} container">
            {if $content->text_2_sign}
                <div class="tag  digital__tag">{$content->text_2_sign}</div>
            {/if}
            <div class="digital__content">
                {if $content->text_2_title}
                    <h2 class="h2 anim-block anim-masked" data-animation="anim-masked-mask">{$content->text_2_title}</h2>
                {/if}

                <div class="digital__text  anim-block anim-masked" data-animation="anim-masked-mask">
                    {$content->text_2}
                </div>
            </div>

            <div class="digital__imgs anim-block">
                <div class="digital__imgs-inside">
                    {if $content->text_2_image->id}
                        <img src="{$content->text_2_image->getLink()}" alt="" class="digitlal__face">
                    {/if}
                </div>
            </div>
        </section>
    {/if}

    {if $content->video_2->id || $content->video_2_cover->id}
        <div class="video-block  {if $content->video_2_short}video-block--short{/if} container" style="transform: translate3d(0,0,0);" data-parallax="0.2">
            <div class="video-block__content anim-block anim-masked" data-animation="anim-masked-mask">
                {if $content->video_2_title}
                    <h2 class="h2">{$content->video_2_title}</h2>
                {/if}

                {if $content->video_2_text}
                    <div class="video-block__text">{$content->video_2_text}</div>
                {/if}
            </div>
            <div class="video-block__video js-video-block">
                <div class="video anim-cliped anim-block" data-animation="anim-cliped-anim"  {if $content->video_2->id}data-video="{$content->video_2->getLink()}"{/if}>
                    {if $content->video_2_cover->id}
                        <img src="{$content->video_2_cover->getLink()}" alt="" width="820" height="476">
                    {/if}
                    {if $content->video_2->id}
                        <button class="btn video-btn">
                            <svg class="btn__play" width="30" height="34" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>

                            </svg>
                            <svg class="btn__pause" width="30" height="34" viewBox="0 0 33 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M27.5 75.5L27.5 5.5M5.5 75.5L5.5 5.5" stroke="url(#play)" stroke-width="11" stroke-linecap="round"></path>

                            </svg>
                        </button>
                    {/if}
                </div>
            </div>
            {if $content->video_2->id}
                <div class="video-block__btn">
                    <div class="result-slide__video-btn-inside">
                        <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"
                                  fill="url(#paint0_linear_750_782)"></path>
                            <defs>
                                <linearGradient id="paint0_linear_750_782" x1="6.5" y1="-0.72998" x2="0.00811087" y2="14.3424"
                                                gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#7BFAD5"></stop>
                                    <stop offset="1" stop-color="white"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </div>
            {/if}
        </div>
    {/if}

    {if $content->under_video_2_title}
        <div class="results  container" data-parallax="0.2">
            <h3 class="h3 results__h3 anim-block anim-masked" data-animation="anim-masked-mask">
                {$content->under_video_2_title}
            </h3>
            <div class="results__img">
                {if $content->under_video_2_image->id}
                    <img src="{$content->under_video_2_image->getLink()}" alt="{$content->under_video_2_title|escape}" width="748" height="571">
                {/if}
            </div>
            <div class="results__content">
                <div class="results__text">
                    {$content->under_video_2_text}
                </div>
                <button class="btn btn--blue btn--lg top-slide__btn" data-action="request"><span>Запись</span></button>
            </div>

        </div>
    {/if}
</section>

<div class="overflow">
    {$blocks.about}
    {$blocks.rating}
</div>

{if $content->results}
    {include file='module/results/default.tpl' content=$content->results is_slider=true title=$content->results_title}
{/if}


{if $content->stocks}
    {include file="module/includes/stocks.tpl" content=$content->stocks title=$content->stocks_title}
{/if}

{if $content->faq}
    <section id="faq" class="container questions-block overflow">
        {if $content->faq_title}
            <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask">{$content->faq_title}</h3>
        {/if}
        <div class="questions-block__content">
            {foreach from=$content->faq item='question' name='questions'}
                <details class="faq-it anim-block anim-popup" data-animation="anim-popup-anim">
                    <summary class="faq-it__btn">
                        <span class="faq-it__btn-text">{$question.title}</span>
                        <div class="faq-it__btn-svg btn">

                            <svg class="btn__icon" fill="none" width="18" height="18">
                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#plus"></use>
                            </svg>
                        </div>
                    </summary>
                    <div class="faq-it__content">
                        <div class="faq-it__content-inside">
                            {$question.answer}
                        </div>
                    </div>
                </details>
            {/foreach}
        </div>
    </section>
{/if}


{if $content->services}
    <section class="overflow pb-60-100 pt-60-100 bg-light">
        <div class="container">
            {if $content->services_title}
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask">{$content->services_title}</h3>
            {/if}
            <div class="services-slider js-auto-swiper" data-gap="20">
                <div class="services-slider__slider js-auto-swiper__slider">
                    <div class="services-slider__wrapper swiper-wrapper">
                        {foreach from=$content->services item='service' name='services'}
                            {if !isset($service_delay)}
                                {assign var="service_delay" value=0.2}
                            {else}
                                {assign var="service_delay" value=$service_delay + 0.2}
                            {/if}

                            {include file='module/services/include/element.tpl' content=$service class='services-slider__it swiper-slide anim-block anim-popup' animation='anim-popup-anim' delay=$service_delay}

                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}

{if $ld_json}
    <script type="application/ld+json">
        {$ld_json}
    </script>
{/if}

{if $ld_json_faq}
    <script type="application/ld+json">
        {$ld_json_faq}
    </script>
{/if}