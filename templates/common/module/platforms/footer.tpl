{foreach from=$content item='item' name='items'}
    <{if $item->link}a href="{$item->link}" target="_blank" rel="nofollow" {else}div{/if} class="footer-fb">
        <div class="footer-fb__img">
            {if $item->image_white->id}
                <img src="{$item->image_white->getLink()}" alt="" height="35" width="205">
            {/if}
        </div>

        <div class="footer-fb__rate">
            <svg fill="none" width="17" height="17">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#star"></use>
            </svg> {$item->rating}
        </div>
    </{if $item->link}a{else}div{/if}>
{/foreach}