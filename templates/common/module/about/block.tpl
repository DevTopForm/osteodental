
    <div id="about" class="container">
        <h3 class="h3 mb-30 anim-block anim-masked"  data-animation="anim-masked-mask">{$node->title}</h3>
        <div class="about">
            <div class="clinick-block about__slider js-thumb-swiper">
                {if $content->images}
                    {include file='module/about/include/slider.tpl' images=$content->images}

                    <div class="address">
                        <div class="address__inside">
                            {if $params.address}
                                <div class="address__row">
                                    <svg class="address__row-icon" fill="none" width="20" height="20">
                                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#pin"></use>
                                    </svg>
                                        <div class="address__row-text address__row-text--addr">
                                            <p>{$params.address}</p>

                                            {if $params.map_link}
                                                <a href="{$params.map_link}" class="more-link address__more">
                                                    <span>На карте</span>
                                                    <svg class="btn__icon" fill="none" width="25" height="17">
                                                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr2"></use>
                                                    </svg>
                                                </a>
                                            {/if}
                                        </div>
                                </div>
                            {/if}
                            <div class="address__row">
                                <svg class="address__row-icon" fill="none" width="20" height="20">
                                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#phone"></use>
                                </svg>
                                <div class="address__row-text">
                                    {if $params.phone}
                                        <a href="tel:{$params.phone|regex_replace:'/[^0-9|+]/':''}" class="phone">{$params.phone}</a>
                                    {/if}

                                    {if $params.phone_2}
                                        <a href="tel:{$params.phone_2|regex_replace:'/[^0-9|+]/':''}" class="phone">{$params.phone_2}</a>
                                    {/if}
                                </div>
                            </div>
                            {if $params.email}
                                <div class="address__row">
                                    <svg class="address__row-icon" fill="none" width="20" height="20">
                                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#mail"></use>
                                    </svg>
                                    <div class="address__row-text">
                                        <a href="mailto:{$params.email}" class="phone">{$params.email}</a>
                                    </div>
                                </div>
                            {/if}
                        </div>
                    </div>
                {/if}
            </div>
            <div class="about-content about__text">
                <div class="about-content__text anim-block anim-masked"  data-animation="anim-masked-mask">
                    {$content->text}
                </div>
                {if $content->files}
                    <div class="about-content__links">
                        {foreach from=$content->files item='file' name='files'}
                            <a target="_blank" rel="nofollow" href="{$file.file->getLink()}" class="more-link">
                                <span>{$file.title}</span>
                                <svg class="btn__icon" fill="none" width="25" height="17">
                                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr2"></use>
                                </svg>
                            </a>
                        {/foreach}
                    </div>
                {/if}
            </div>
            {if $content->staff}
                <div class="doctors about__doctors js-why">
                    <div class="doctors__hide"></div>
                    <div class="doctors__slider js-why__slider">
                        <div class="doctors__wrapper swiper-wrapper">
                            {foreach from=$content->staff item='doctor' name='doctors'}
                                {if !isset($doctors_delay)}
                                    {assign var="doctors_delay" value=0}
                                {else}
                                    {assign var="doctors_delay" value=$doctors_delay+0.2}
                                {/if}
                                <div class="doctor-slide  doctors__slide swiper-slide  doctors__slide swiper-slide anim-block anim-popup" data-animation="anim-popup-anim" data-delay="{$doctors_delay}">
                                    <div class="doctor-slide__img">
                                        {if $doctor->image->id}
                                            <img src="{$doctor->image->getLink()}" alt="" width="212" height="212">
                                        {/if}
                                    </div>
                                    <div class="doctor-slide__content">
                                        <div class="doctor-slide__name">{$doctor->title}</div>
                                        <div class="doctor-slide__pos">{$doctor->position}</div>

                                        {if $doctor->experience}
                                            <div class="doctor-slide__exp">{$doctor->experience}</div>
                                        {/if}
                                    </div>
                                </div>
                            {/foreach}

                        </div>
                    </div>
                    <div class="doctors__arrs arrs">
                        <button class="btn btn--bordered arr arr--left swiper-button-disabled" disabled="">
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

        </div>
    </div>