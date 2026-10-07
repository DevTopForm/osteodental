{if $content}
    <div class="specialist  bg-light">
        <div class="specialist__wrap">
            <div class="specialist__img">
                {if $content->image->id}
                    <img src="{$content->image->getLink()}" alt="" width="200" height="200">
                {/if}
            </div>
            {if $content->video}
                <a href="{$content->getUrl()}#video" class="specialist__play ">
                    <div class="specialist__play-inside">
                        <div class="btn btn--play">
                            <svg width="18" height="21" viewBox="0 0 18 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M17.3159 9.06029C18.171 9.55399 18.171 10.7882 17.3159 11.2819L1.92399 20.1685C1.06888 20.6621 5.39504e-08 20.045 9.71107e-08 19.0576L8.73996e-07 1.28458C9.17156e-07 0.297183 1.06888 -0.319937 1.92399 0.173759L17.3159 9.06029Z" fill="url(#paint0_linear_1491_2095)"></path>
                                <defs>
                                    <linearGradient id="paint0_linear_1491_2095" x1="9.61995" y1="-0.937057" x2="3.44575e-06" y2="21.3812" gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#7BFAD5"></stop>
                                        <stop offset="1" stop-color="white"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>
                </a>
            {/if}
        </div>
        <div class="specialist__info">
            <div class="specialist__name">{$content->title}</div>
            <div class="specialist__list">
                {$content->position}
            </div>
            <button class="btn btn--black specialist__btn" data-action="request">Запись</button>
        </div>
        {if $content->numbers}
            <div class="specialist__nums column-nums">
                {foreach $content->numbers as $number}
                    <div class="column-nums__it">
                        <div class="column-nums__num">{$number.value}</div>
                        <div class="column-nums__text">{$number.key}</div>
                    </div>
                {/foreach}
            </div>
        {/if}
        <a href="{$content->getUrl()}" title="{$content->title|escape}" class="specialist__link"></a>
    </div>
{/if}