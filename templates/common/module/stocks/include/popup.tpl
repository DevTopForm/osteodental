{if $content}
    <div class="popup" data-target="promo-{$content->id}">
        <div class="popup__inside">
            <button class="btn popup__close js-close">
                <svg fill="none" width="30" height="30">
                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#cross"></use>
                </svg>
            </button>
            <div class="popup__name">{$content->title}</div>
            <div class="popup__content text">
                {$content->text}
            </div>

            <div class="form__btns">
                <button class="btn btn--sm btn--black" data-action="request">Оставить заявку</button>
            </div>
        </div>
    </div>
{/if}