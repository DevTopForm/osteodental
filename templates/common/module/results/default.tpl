{if $content}
    <div id="results" class="overflow result-block {if !$title && $no_h1}pt-60-100{/if}">
       
        {if $title}
            <div class="result-block__top container  mb-30">
                <h2 class="h3">{$title}</h2>
            </div>
        {elseif !$no_h1}
            <div class="result-block__top container pt-60-100 mb-30">
                <h1 class="h1">{$node->h1|default:$node->title}</h1>
            </div>
        {/if}
       
        <div class="results-slider {if $is_slider}js-auto-swiper{/if}" data-allowTouchMove="no">
            {if $is_slider && count($content) > 1}
                <div class="container results-slider__arrs ">
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
            {/if}

            <div class="{if $is_slider}results-slider__slider js-auto-swiper__slider{else}results-slider__list{/if}">
                {if $is_slider}
                    <div class="results-slider__wrapper swiper-wrapper">
                {/if}

                    {foreach from=$content item='result' name='results'}
                        {if $alter}
                            {include file='module/results/include/alter.tpl' content=$result}
                        {else}
                        <div class="results-slider__slide result-slide swiper-slide">
                            <div class="container result-slide__container">
                                <div class="result-slide__person">
                                    <div class="result-slide__person-img">
                                        {if $result->image->id}
                                            <img src="{$result->image->getLink()}" alt="{$result->title|escape}"
                                                 width="88" height="88">
                                        {/if}
                                    </div>
                                    <div class="result-slide__person-name">{$result->title}</div>
                                    {if $result->age}
                                        <div class="result-slide__person-age">{$result->age}</div>
                                    {/if}
                                </div>
                                {if $result->text}
                                    <div class="result-slide__anam">
                                        <h3>Анамнез</h3>
                                        {$result->text}
                                    </div>
                                {/if}

                                <div class="result-slide__video " data-glightbox="{$result->id}">
                                    {if $result->video_cover->id && $result->video_cover_2->id}
                                        <div class="before-it js-before">
                                            <div class="before-it__img ">
                                                <div class="before-it__img-before">
                                                    <img src="{$result->video_cover_2->getLink()}" alt="{$result->video_cover_2->alt|escape}" loading="lazy" decoding="async" width="473" height="231">
                                                </div>
                                                <div class="before-it__img-after  js-before__before">
                                                    <img src="{$result->video_cover->getLink()}" alt="{$result->video_cover->alt|escape}" loading="lazy" decoding="async" width="473" height="231">
                                                </div>
                                                <input class="before-it__range  js-before__range" type="range" min="0" max="100" value="30">
                                            </div>
                                        </div>
                                    {elseif $result->video_cover->id}

                                        <div class="video anim-block anim-cliped" data-animation="anim-cliped-anim">

{*                                                {if $result->video_cover->id}*}
                                                <img src="{$result->video_cover->getLink()}" alt="{$result->video_cover->alt|escape}" width="820"
                                                     height="476">
{*                                                {/if}*}

                                            {if false}
                                                <button class="btn video-btn">
                                                    <svg class="btn__play" width="30" height="34" viewBox="0 0 12 14"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"
                                                              fill="url(#play)"></path>

                                                    </svg>
                                                    <svg class="btn__pause" width="30" height="34" viewBox="0 0 33 81"
                                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M27.5 75.5L27.5 5.5M5.5 75.5L5.5 5.5"
                                                              stroke="url(#play)" stroke-width="11"
                                                              stroke-linecap="round"></path>

                                                    </svg>
                                                </button>
                                            {/if}
                                        </div>

                                        {if false}
                                            <div class="result-slide__video-btn">
                                                <div class="result-slide__video-btn-inside">
                                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"
                                                              fill="url(#paint0_linear_750_782)"></path>
                                                        <defs>
                                                            <linearGradient id="paint0_linear_750_782" x1="6.5"
                                                                            y1="-0.72998"
                                                                            x2="0.00811087" y2="14.3424"
                                                                            gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#7BFAD5"></stop>
                                                                <stop offset="1" stop-color="white"></stop>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </div>
                                            </div>
                                        {/if}
                                    {/if}

                                    {if $result->video->id}
                                        <a href="{$result->video->getLink()}" class="video-play bg-light glightbox-{$result->id}" title="">
                                            <div class="video-play__btn">
                                                <svg width="30" height="34" viewBox="0 0 12 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"></path>
                                                </svg>
                                            </div>
                                            <div class="video-play__text">Смотреть видео</div>
                                        </a>
                                    {/if}
                                </div>
                                <div class="result-slide__solution solution">
                                    {if $result->solution}
                                        <div class="solution__name">Наше решение</div>
                                        <div class="solution__text">
                                            {$result->solution}
                                        </div>
                                    {/if}
                                    {if $result->staff}
                                        <div class="solution__slider">
{*                                            <div class="solution__slider-name">Команда</div>*}
                                            <div class="doctors solution__slider-doctors js-why">
                                                <div class="doctors__hide"></div>
                                                <div class="doctors__slider js-why__slider">
                                                    <div class="doctors__wrapper swiper-wrapper">

                                                        {foreach from=$result->staff item='doctor' name='doctors'}
                                                            {if !isset($delay)}
                                                                {assign var="delay" value=0}
                                                            {else}
                                                                {assign var="delay" value=$delay+0.2}
                                                            {/if}

                                                            {include file="module/staff/include/slide.tpl" class="doctor-slide--sm swiper-slide" delay=$delay}
                                                        {/foreach}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    {/if}

                                    {if $result->images}
                                        <div class="solution__progress progress">
                                            <div class="progress__name">Ход лечения и динамика</div>
                                            <div class="progress__imgs" data-glightbox="{$result->id}">
                                                {foreach from=$result->images item='image' name='images'}
                                                    {if $image->id}
                                                        <a {if $image->title}data-title="{$image->title}"{/if} href="{$image->getLink('view')}"
                                                           class="progress__img glightbox-{$result->id}">
                                                            <img src="{$image->getLink()}" alt="{$image->alt|escape}" width="88"
                                                                 height="58">
                                                        </a>
                                                    {/if}
                                                {/foreach}
                                            </div>
                                        </div>
                                    {/if}
                                </div>
                            </div>
                        </div>
                        {/if}
                    {/foreach}

                {if $is_slider}
                    </div>
                {/if}
            </div>
        </div>

        {if $more}
            <div class="more-container">
                <a href="/results" class="more-link result-block__more">
                    <span>Все результаты</span>
                    <svg class="btn__icon" fill="none" width="25" height="17">
                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr2"></use>
                    </svg>
                </a>
            </div>
        {/if}
    </div>
{/if}