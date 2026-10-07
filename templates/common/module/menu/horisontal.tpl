{if $content}
    <nav class="menu header__menu js-menu">
        <ul class="menu__list">
            {foreach from=$content item='item' name='items'}
                {if $item.public && !$item.nomenu}
                    <li class="anim-popdown anim-block" data-animation="anim-podown-anim" data-delay="0">
                        <a href="{if $item.redirect}{$item.redirect}{else}{$item.url}{/if}" class="menu__it ">
                            <span>{$item.menutitle|default:$item.title}</span>
                        </a>
                    </li>
                {/if}
            {/foreach}
        </ul>
    </nav>
{/if}