{if $content}
    <div class="results-slider__slide result-sl swiper-slide">
        <div class="result-sl__top">
            <div class="result-sl__person">
                <div class="result-sl__person-img">
                    {if $content->image->id}
                        <img src="{$content->image->getLink()}" alt="{$content->title|escape}"
                             width="88" height="88">
                    {/if}
                </div>
                <div class="result-sl__person-name">{$content->title}</div>
                {if $content->age}
                    <div class="result-sl__person-age">{$content->age}</div>
                {/if}
            </div>
            {if $content->text}
                <div class="result-sl__anam">
                    <h4>Анамнез</h4>
                    {$content->text}
                </div>
            {/if}
        </div>
        <div class="result-sl__center">
            {if $content->solution}
                <div class="result-sl__solution solution">
                    <div class="solution__name">Наше решение</div>
                    <div class="solution__text">
                        {$content->solution}
                    </div>
                </div>
            {/if}
            {if $content->video->id}
                <a href="{$content->video->getLink()}" class="video-play bg-light glightbox-{$content->id}" title="">
                    <div class="video-play__btn">
                        <svg width="30" height="34" viewBox="0 0 12 14" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"></path>
                        </svg>
                    </div>
                    <div class="video-play__text">Смотреть видео</div>
                </a>
            {/if}
            <div class="result-sl__video">
                {if $content->video_cover->id && $content->video_cover_2->id}
                    <div class="before-it js-before">
                        <div class="before-it__img ">
                            <div class="before-it__img-before">
                                <img src="{$content->video_cover_2->getLink()}" alt="" loading="lazy" decoding="async" width="473" height="231">
                            </div>
                            <div class="before-it__img-after  js-before__before">
                                <img src="{$content->video_cover->getLink()}" alt="" loading="lazy" decoding="async" width="473" height="231">
                            </div>
                            <input class="before-it__range  js-before__range" type="range" min="0" max="100" value="30">
                        </div>
                    </div>
                {elseif $content->video_cover->id}

                    <div class="video anim-block anim-cliped" data-animation="anim-cliped-anim">
                            <img src="{$content->video_cover->getLink()}" alt="" width="820"
                                 height="476">

                    </div>
                {/if}
            </div>

            {if $result->images}
                <div class="result-sl__progress progress progress--short">
                    <div class="progress__name">Ход лечения и динамика</div>
                    <div class="progress__imgs" data-glightbox="{$result->id}">
                        {foreach from=$result->images item='image' name='images'}
                            {if $image->id}
                                <a {if $image->title}data-title="{$image->title}"{/if} href="{$image->getLink('view')}"
                                   class="progress__img glightbox-{$result->id}">
                                    <img src="{$image->getLink()}" alt="" width="88"
                                         height="58">
                                </a>
                            {/if}
                        {/foreach}
                    </div>
                </div>
            {/if}
        </div>
    </div>
{/if}