<div class="pb-60-100 pt-60-100 container">
    <h1 class="h1 mb-30">{$node->h1|default:$node->title}</h1>

    {if $node->before_text}
        <div class="top-text mb-20-40 text">
            {$node->before_text}
        </div>
    {/if}
    <div class="blog">
        {foreach from=$content item='item' name='items'}
            {$item->getHtml()}
        {/foreach}
{*        <div class="news-it blog__it  anim-block anim-popup" data-animation="anim-popup-anim">*}
{*            <div class="news-it__img">*}
{*                <img src="/img/news1.jpg" alt="20 апреля 2025 года Сергей Лотоцкий выступил в качестве лектора на площадке учебного центра Strauman в Санкт-Петербурге. Доктор ознакомил слушателей с программной “От скана до улыбки. Комплексное протезирование на зубах и имплантатов в полном цифровом протоколе”" width="756" height="501">*}
{*            </div>*}
{*            <div class="news-it__content">*}
{*                <div class="news-it__name">Выступление главного врача клиники в учебном центре Strauman</div>*}
{*                <div class="news-it__text">20 апреля 2025 года Сергей Лотоцкий выступил в качестве лектора на площадке учебного центра Strauman в Санкт-Петербурге. Доктор ознакомил слушателей с программной “От скана до улыбки. Комплексное протезирование на зубах и имплантатов в полном цифровом протоколе”</div>*}
{*                <div class="news-it__info">*}
{*                    <span>12.05.2026</span>*}
{*                    <span>*}
{*          <svg class="btn__icon" fill="none" width="20" height="20">*}
{*            <use xlink:href="img/sprite.svg#eye"></use>*}
{*          </svg>*}
{*          120</span>*}
{*                </div>*}

{*                <div class="btn btn--bordered arr news-it__arr">*}
{*                    <svg class="btn__icon" fill="none" width="90" height="46">*}
{*                        <use xlink:href="img/sprite.svg#arr"></use>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*            <a href="#" class="news-it__link"></a>*}
{*        </div>*}


{*        <a href="#" class="blog-ban blog__it" target="_blank">*}
{*            <img class="blog-ban__img" src="/img/bg-ban.png" alt="" loading="lazy" decoding="async" width="3357" height="1175">*}
{*            <svg fill="none" width="40" height="40">*}
{*                <use xlink:href="img/sprite.svg#download"></use>*}
{*            </svg>*}
{*            <div class="blog-ban__txt">*}
{*                Чек-лист «Как выбрать клинику для лечения ВНЧС»*}
{*            </div>*}
{*        </a>*}
{*        <div class="videos-it videos-it--short blog__it" data-video="/img/video.mp4">*}
{*            <img width="870" height="1548" loading="lazy" decoding="async" src="/img/vid1.jpg" alt="">*}
{*            <div class="rotate-btn btn  videos-it__btn">*}
{*                <div class="rotate-btn__inside">*}
{*                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">*}
{*                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}
{*        <div class="videos-it videos-it--short blog__it" data-video="/img/video.mp4">*}
{*            <img width="870" height="1548" loading="lazy" decoding="async" src="/img/vid1.jpg" alt="">*}
{*            <div class="rotate-btn btn  videos-it__btn">*}
{*                <div class="rotate-btn__inside">*}
{*                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">*}
{*                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}
{*        <div class="videos-it videos-it--short blog__it" data-video="/img/video.mp4">*}
{*            <img loading="lazy" width="870" height="1548" decoding="async" src="/img/vid1.jpg" alt="">*}
{*            <div class="rotate-btn btn  videos-it__btn">*}
{*                <div class="rotate-btn__inside">*}
{*                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">*}
{*                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}
{*        <div class="videos-it videos-it--long blog__it" data-video="/img/video.mp4">*}
{*            <img width="2413" height="11357" loading="lazy" decoding="async" src="/img/vid2.jpg" alt="">*}
{*            <div class="rotate-btn btn  videos-it__btn">*}
{*                <div class="rotate-btn__inside">*}
{*                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">*}
{*                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}


{*        <div class="videos-it videos-it--long blog__it" data-video="/img/video.mp4">*}
{*            <img width="2413" height="11357" loading="lazy" decoding="async" src="/img/vid2.jpg" alt="">*}
{*            <div class="rotate-btn btn  videos-it__btn">*}
{*                <div class="rotate-btn__inside">*}
{*                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">*}
{*                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*        </div>*}

{*        <div class="news-it blog__it  anim-block anim-popup" data-animation="anim-popup-anim">*}
{*            <div class="news-it__img">*}
{*                <img src="/img/news1.jpg" alt="20 апреля 2025 года Сергей Лотоцкий выступил в качестве лектора на площадке учебного центра Strauman в Санкт-Петербурге. Доктор ознакомил слушателей с программной “От скана до улыбки. Комплексное протезирование на зубах и имплантатов в полном цифровом протоколе”" width="756" height="501">*}
{*            </div>*}
{*            <div class="news-it__content">*}
{*                <div class="news-it__name">Выступление главного врача клиники в учебном центре Strauman</div>*}
{*                <div class="news-it__text">20 апреля 2025 года Сергей Лотоцкий выступил в качестве лектора на площадке учебного центра Strauman в Санкт-Петербурге. Доктор ознакомил слушателей с программной “От скана до улыбки. Комплексное протезирование на зубах и имплантатов в полном цифровом протоколе”</div>*}
{*                <div class="news-it__info">*}
{*                    <span>12.05.2026</span>*}
{*                    <span>*}
{*          <svg class="btn__icon" fill="none" width="20" height="20">*}
{*            <use xlink:href="img/sprite.svg#eye"></use>*}
{*          </svg>*}
{*          120</span>*}
{*                </div>*}

{*                <div class="btn btn--bordered arr news-it__arr">*}
{*                    <svg class="btn__icon" fill="none" width="90" height="46">*}
{*                        <use xlink:href="img/sprite.svg#arr"></use>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*            <a href="#" class="news-it__link"></a>*}
{*        </div>*}

{*        <div class="news-it blog__it  anim-block anim-popup" data-animation="anim-popup-anim">*}
{*            <div class="news-it__img">*}
{*                <img src="/img/img27.jpg" alt="20 апреля 2025 года Сергей Лотоцкий выступил в качестве лектора на площадке учебного центра Strauman в Санкт-Петербурге. Доктор ознакомил слушателей с программной “От скана до улыбки. Комплексное протезирование на зубах и имплантатов в полном цифровом протоколе”" width="756" height="501">*}
{*            </div>*}
{*            <div class="news-it__content">*}
{*                <div class="news-it__name">Выступление главного врача клиники в учебном центре Strauman</div>*}
{*                <div class="news-it__text">20 апреля 2025 года Сергей Лотоцкий выступил в качестве лектора на площадке учебного центра Strauman в Санкт-Петербурге. Доктор ознакомил слушателей с программной “От скана до улыбки. Комплексное протезирование на зубах и имплантатов в полном цифровом протоколе”</div>*}
{*                <div class="news-it__info">*}
{*                    <span>10.05.2026</span>*}
{*                    <span>*}
{*          <svg class="btn__icon" fill="none" width="20" height="20">*}
{*            <use xlink:href="img/sprite.svg#eye"></use>*}
{*          </svg>*}
{*          10</span>*}
{*                </div>*}

{*                <div class="btn btn--bordered arr news-it__arr">*}
{*                    <svg class="btn__icon" fill="none" width="90" height="46">*}
{*                        <use xlink:href="img/sprite.svg#arr"></use>*}
{*                    </svg>*}
{*                </div>*}
{*            </div>*}
{*            <a href="#" class="news-it__link"></a>*}
{*        </div>*}

    </div>
</div>