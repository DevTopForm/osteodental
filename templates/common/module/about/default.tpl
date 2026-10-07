<div class="contacts-top overflow pb-60-100 pt-60-100 bg-light">
    <div class="container contacts-top__container">
        <h1 class="h1 mb-30">{$node->h1|default:$node->title}</h1>
        <div class="contacts-top__wright">
            {if $params.email}
                <a rel="nofollow" href="mailto:{$params.email}" class="contacts-top__mail">
                    {$params.email}
                </a>
            {/if}
            {if $params.link_tg}
                <a rel="nofollow" target="_blank" href="{$params.link_tg}" class="contacts-top__soc">Написать в Tелеграм</a>
            {/if}
            {if $params.link_max}
                <a rel="nofollow" target="_blank" href="{$params.link_max}" class="contacts-top__soc">Написать в Мах</a>
            {/if}
        </div>
        <div class="contacts-top__address">
            {if $params.address}
                <div class="contacts-top__addr">{$params.address}</div>
            {/if}
            {if $params.phone}
                <a href="tel:{$params.phone|regex_replace:'/[^0-9|+]/':''}" class="contacts-top__phone">{$params.phone}</a>
            {/if}

            {if $params.phone_2}
                <a href="tel:{$params.phone_2|regex_replace:'/[^0-9|+]/':''}" class="contacts-top__phone">{$params.phone_2}</a>
            {/if}
        </div>
        <div class="contacts-top__socials">
            <button class="btn btn--black btn--lg" data-action="request"><span>Запись</span></button>
            {if $params.link_vk}
                <a href="{$params.link_vk}" class="footer-soc contacts-top__social">
                    <div class="footer-soc__img">
                        <svg class="btn__icon" fill="none" width="29" height="20">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#vk"></use>
                        </svg>
                        <svg class="contacts__social-hover" width="44" height="30" viewBox="0 0 44 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.3025 3.625C10.3025 3.28 10.0202 3 9.67227 3H4.63025C4.28235 3 4 3.28 4 3.625C4 3.625 3.99811 9.6775 6.40756 15.7294C8.85294 21.8731 13.7557 28 23.5378 28C23.8857 28 24.1681 27.72 24.1681 27.375V18.6456C28.8975 18.955 32.6809 22.7188 32.9733 27.4137C32.9941 27.7431 33.2695 28 33.6023 28H38.6639C39.0118 28 39.2941 27.72 39.2941 27.375C39.2941 22.4444 36.7851 18.0894 32.9658 15.5C36.7851 12.9106 39.2941 8.55563 39.2941 3.625C39.2941 3.28 39.0118 3 38.6639 3H33.6023C33.2695 3 32.9941 3.25688 32.9733 3.58625C32.6809 8.28125 28.8975 12.045 24.1681 12.3544V3.625C24.1681 3.28 23.8857 3 23.5378 3H18.4958C18.1479 3 17.8655 3.28 17.8655 3.625V19.0619C16.8496 18.7144 14.9342 17.79 13.2943 15.4669C11.6506 13.1381 10.3025 9.44625 10.3025 3.625Z" fill="#0077FF"></path>
                        </svg>
                    </div>
                </a>
            {/if}
            {if $params.link_inst}
                <a href="{$params.link_inst}" class="footer-soc contacts-top__social">
                    <div class="footer-soc__img">
                        <svg class="btn__icon" fill="none" width="22" height="22">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#inst"></use>
                        </svg>
                        <svg class="contacts__social-hover" width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.9962 9.99787C12.2419 9.99787 9.99412 12.2456 9.99412 15C9.99412 17.7544 12.2419 20.0021 14.9962 20.0021C17.7506 20.0021 19.9984 17.7544 19.9984 15C19.9984 12.2456 17.7506 9.99787 14.9962 9.99787ZM29.9989 15C29.9989 12.9286 30.0177 10.876 29.9013 8.80832C29.785 6.40669 29.2371 4.27525 27.4809 2.51907C25.721 0.759128 23.5933 0.215011 21.1917 0.098682C19.1203 -0.0176466 17.0676 0.00111617 15 0.00111617C12.9286 0.00111617 10.876 -0.0176466 8.80832 0.098682C6.40669 0.215011 4.27525 0.762881 2.51907 2.51907C0.759128 4.27901 0.215011 6.40669 0.098682 8.80832C-0.0176466 10.8797 0.00111617 12.9324 0.00111617 15C0.00111617 17.0676 -0.0176466 19.124 0.098682 21.1917C0.215011 23.5933 0.762881 25.7247 2.51907 27.4809C4.27901 29.2409 6.40669 29.785 8.80832 29.9013C10.8797 30.0176 12.9324 29.9989 15 29.9989C17.0714 29.9989 19.124 30.0176 21.1917 29.9013C23.5933 29.785 25.7247 29.2371 27.4809 27.4809C29.2409 25.721 29.785 23.5933 29.9013 21.1917C30.0214 19.124 29.9989 17.0714 29.9989 15ZM14.9962 22.6964C10.7371 22.6964 7.2998 19.2591 7.2998 15C7.2998 10.7409 10.7371 7.30355 14.9962 7.30355C19.2554 7.30355 22.6927 10.7409 22.6927 15C22.6927 19.2591 19.2554 22.6964 14.9962 22.6964ZM23.0079 8.7858C22.0135 8.7858 21.2104 7.98276 21.2104 6.98834C21.2104 5.99392 22.0135 5.19087 23.0079 5.19087C24.0023 5.19087 24.8054 5.99392 24.8054 6.98834C24.8057 7.22447 24.7594 7.45834 24.6692 7.67655C24.5789 7.89476 24.4465 8.09303 24.2796 8.26C24.1126 8.42697 23.9143 8.55936 23.6961 8.64958C23.4779 8.73981 23.244 8.7861 23.0079 8.7858Z" fill="url(#paint0_linear_763_1512)"></path>
                            <defs>
                                <linearGradient id="paint0_linear_763_1512" x1="26" y1="2.5" x2="4.5" y2="30" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#C1558B"></stop>
                                    <stop offset="0.462327" stop-color="#E56969"></stop>
                                    <stop offset="0.731917" stop-color="#FFC273"></stop>
                                    <stop offset="1" stop-color="#FFDF9E"></stop>
                                </linearGradient>
                            </defs>
                        </svg>
                    </div>
                </a>
            {/if}

            {if $params.link_tg}
                <a href="{$params.link_tg}" class="footer-soc contacts-top__social">
                    <div class="footer-soc__img">
                        <svg class="btn__icon" fill="none" width="30" height="25">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#tg2"></use>
                        </svg>
                        <svg class="contacts__social-hover" fill="none" width="30" height="25">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#tg-blue"></use>
                        </svg>
                    </div>
                </a>
            {/if}
        </div>
    </div>
</div>
<div class="map bg-light">
    <div class="container map__container">
        {if $content->images}
            {include file='module/about/include/slider.tpl' images=$content->images class='js-thumb-swiper'}
        {/if}
    </div>
    {if $params.coords}
        <div class="map__inside" data-coords="{$params.coords}" data-address="{$params.address}" data-api="77738d13-2db6-45e5-b348-0e92b490f417">
            <div id="map"> </div>
        </div>
    {/if}
</div>