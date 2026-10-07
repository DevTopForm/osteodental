<div class=" pb-60-100 pt-60-100 bg-light">
    <div class="container doctor">
        <div class="doctor__top">
            <h1 class="h1 mb-30">{$content->title}</h1>
            <p class="doctor__position mb-20-40">{$content->position}</p>
            <div class="doctor__contacts">
                <button class="btn btn--black btn--lg" data-action="request"><span>Запись</span></button>
                <div class="contacts doctor__contact">
                    <span>Задать вопрос</span>

                    <div class="contacts__socials">
                        {if $params.link_max}
                            <a rel="nofollow" target="_blank" href="{$params.link_max}" class="contacts__social anim-popdown anim-block" data-animation="anim-podown-anim" data-delay="1" title="связаться с клиникой в Макс">
                                <svg class="btn__icon" fill="none" width="28" height="28">
                                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#max"></use>
                                </svg>
                                <svg class="contacts__social-hover" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M14.3008 27.9201C11.553 27.9201 10.276 27.5172 8.05633 25.9057C6.65232 27.7187 2.2063 29.1355 2.01241 26.7114C2.01241 24.8917 1.61126 23.354 1.15663 21.6753C0.615089 19.6072 0 17.304 0 13.9668C0 5.99631 6.51192 0 14.2273 0C21.9493 0 27.9999 6.29176 27.9999 14.0406C28.0258 21.6697 21.8968 27.8794 14.3008 27.9201ZM14.4145 6.88938C10.6571 6.69465 7.72873 9.3067 7.08021 13.4027C6.54535 16.7937 7.49472 20.9233 8.3037 21.1382C8.69147 21.2322 9.66759 20.4398 10.276 19.8288C11.282 20.5268 12.4535 20.946 13.6724 21.0442C17.5656 21.2322 20.8923 18.2554 21.1537 14.3495C21.3059 10.4354 18.3083 7.12008 14.4145 6.89609L14.4145 6.88938Z" fill="url(#paint0_linear_282_60)"></path>
                                </svg>
                            </a>
                        {/if}

                        {if $params.link_tg}
                            <a rel="nofollow" target="_blank" href="{$params.link_tg}" class="contacts__social  anim-popdown anim-block" data-animation="anim-podown-anim" data-delay="1.2" title="связаться с клиникой в Телеграм">
                                <svg class="btn__icon" fill="none" width="28" height="28">
                                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#tg"></use>
                                </svg>
                                <svg class="contacts__social-hover" width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="27.6" height="27.6" rx="13.8" fill="#009EE1"></rect>
                                    <path d="M19.2747 7.02189C17.064 7.93428 7.58505 11.8469 4.96602 12.9132C3.20959 13.5963 4.23783 14.2367 4.23783 14.2367C4.23783 14.2367 5.73717 14.7489 7.02251 15.1332C8.30768 15.5174 8.99311 15.0905 8.99311 15.0905L15.0336 11.0349C17.1756 9.58342 16.6616 10.7787 16.1473 11.2911C15.0336 12.4012 13.1914 14.1513 11.6491 15.5601C10.9637 16.1578 11.3063 16.67 11.6064 16.9262C12.7201 17.8655 15.7619 19.7865 15.9331 19.9146C16.8382 20.553 18.6183 21.4721 18.8891 19.5303L19.9601 12.828C20.3029 10.5655 20.6455 8.47355 20.6882 7.87591C20.8169 6.42425 19.2747 7.02189 19.2747 7.02189Z" fill="white"></path>
                                </svg>
                            </a>
                        {/if}
                    </div>
                </div>

            </div>
        </div>
        <div class="doctor__left">
            <div class="doctor__picture anim-masked anim-block" data-animation="anim-masked-mask">
                <div class="doctor__img">
                    {if $content->image->id}
                        <div class="doctor__img-wrapper">
                            <img src="{$content->image->getLink()}" alt="{$content->title|escape}" width="478" height="478">
                        </div>
                    {/if}
                </div>
                {if $content->quote_title}
                    <div class="h1"><span>{$content->quote_title}</span></div>
                {/if}

                {if $content->quote}
                    <div class="text">
                        {$content->quote}
                    </div>
                {/if}
            </div>
        </div>
        <div class="doctor__content">
            {if $content->numbers}
                <div class="doctor__nums mb-60-100 column-nums">
                    {foreach $content->numbers as $number}
                        <div class="column-nums__it">
                            <div class="column-nums__num">{$number.value}</div>
                            <div class="column-nums__text">{$number.key}</div>
                        </div>
                    {/foreach}
                </div>
            {/if}
            <div class="tabs mb-60-100 js-tabs">
                <div class="doctor__btns mb-20-40" role="tablist" data-parallax="0.2">
                    {if $content->education}
                        <button class="btn btn--white-blue btn--mid" id="tab-0" type="button" role="tab" aria-controls="tabpanel-0" aria-selected="true"><span>Образование</span></button>
                    {/if}

                    {if $content->certificates}
                        <button class="btn btn--white-blue btn--mid" id="tab-1" type="button" role="tab" aria-controls="tabpanel-1" aria-selected="{empty($content->education)}"><span>сертификаты</span></button>
                    {/if}
                </div>
                <div class="tabs__panels">
                    {if $content->education}
                        <div class="tabs__panel bg-light" id="tabpanel-0" role="tabpanel" tabindex="-1" aria-labelledby="tab-0" aria-selected="true">
                            {$content->education}
                        </div>
                    {/if}

                    {if $content->certificates}
                        <div class="tabs__panel bg-light" id="tabpanel-1" role="tabpanel" tabindex="-1" aria-labelledby="tab-1" aria-selected="{empty($content->education)}">
                            <div class="certificates" data-parallax="0.2">

                                {foreach $content->certificates as $certificate}
                                <div class="certificate bg-white">
                                    <div class="certificate__name">{$certificate.title}</div>
                                    <div class="certificate__text">{$certificate.description}</div>

                                    {if $certificate.image->id}
                                        <a href="{$certificate.image->getLink()}" class="certificate__img glightbox-cert" data-glightbox="cert">
                                            <img src="{$certificate.image->getLink()}" alt="{$certificate.title}" width="255" height="177" loading="lazy" decoding="async">
                                        </a>
                                    {/if}
                                </div>
                                {/foreach}
                            </div>
                        </div>
                    {/if}
                </div>
            </div>

            {if $content->video->id}
                <div id="video" class="video-block doctor__video" style="transform: translate3d(0,0,0);" data-parallax="0.2">
                    <div class="video-block__content anim-block anim-masked" data-animation="anim-masked-mask">
                        {if $content->video_title}
                            <h2 class="h2">{$content->video_title}</h2>
                        {/if}

                        {if $content->video_text}
                            <div class="video-block__text">{$content->video_text}</div>
                        {/if}
                    </div>
                    <div class="video-block__video js-video-block ">
                        <div class="video anim-cliped anim-block" data-animation="anim-cliped-anim" data-video="{$content->video->getLink()}">

                            {if $content->video_cover->id}
                                <img src="{$content->video_cover->getLink()}" alt="" width="820" height="476">
                            {/if}
                            <button class="btn video-btn">
                                <svg class="btn__play" width="30" height="34" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>

                                </svg>
                                <svg class="btn__pause" width="30" height="34" viewBox="0 0 33 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M27.5 75.5L27.5 5.5M5.5 75.5L5.5 5.5" stroke="url(#play)" stroke-width="11" stroke-linecap="round"></path>

                                </svg>
                            </button>
                        </div>

                    </div>
                    <div class="video-block__btn btn">
                        <div class="result-slide__video-btn-inside">

                        </div>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>
{if $content->results}
    {include file='module/results/default.tpl' content=$content->results is_slider=true title=$content->results_title|default:'Результаты пациентов'}
{/if}

{if $content->prices}
    <section id="prices" class="overflow pt-60-100 pb-60-100 bg-light">
        <section class="container">
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask">{$content->prices_title|default:'Цены'}</h3>

            <div class="other">
                {foreach from=$content->prices item='price' name='prices'}
                    {if $price->is_stock}
                        {include file='module/prices/include/list_stock.tpl' content=$price}
                    {else}
                        {include file='module/prices/include/list_element.tpl' content=$price}
                    {/if}
                {/foreach}
            </div>
        </section>
    </section>
{/if}

{if $ld_json}
    <script type="application/ld+json">
        {$ld_json}
    </script>
{/if}
