{if $content}
    <div class="news-it news-slider__it {$class} anim-block anim-popup"
         data-animation="anim-popup-anim">
        {if $content->image->id}
            <div class="news-it__img">
                <img src="{$content->image->getLink()}" alt="{$content->title}" width="756"
                     height="501">
            </div>
        {/if}

        <div class="news-it__content">
            <div class="news-it__name">{$content->title}</div>
            <div class="news-it__text">{$content->announce}</div>
            <div class="news-it__info">
                <span>{$content->date}</span>
                <span>
                                                <svg class="btn__icon" fill="none" width="20" height="20">
                                                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#eye"></use>
                                                </svg>
                                                {$content->counter}
                                            </span>
            </div>

            {*                                    <div class="btn btn--bordered arr news-it__arr">*}
            {*                                        <svg class="btn__icon" fill="none" width="90" height="46">*}
            {*                                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>*}
            {*                                        </svg>*}
            {*                                    </div>*}
        </div>

        {*                                <a href="#" class="news-it__link"></a>*}
    </div>
{/if}