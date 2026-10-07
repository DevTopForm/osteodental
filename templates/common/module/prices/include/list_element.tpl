{if $content}
    <div class="other-it bg-white anim-block anim-masked" data-animation="anim-masked-mask">
        <div class="other-it__name">{$content->title}</div>
        {if $content->sign}
            <div class="other-it__descr glass-tag">{$content->sign}</div>
        {/if}
        <div class="other-it__actions">
            <div class="other-it__price">
                {$content->price}
            </div>

            <button class="btn btn--black btn--square other-it__btn" data-action="request">
                <svg class="btn__icon" fill="none" width="22" height="26">
                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#hand"></use>
                </svg>
            </button>
        </div>
    </div>
{/if}