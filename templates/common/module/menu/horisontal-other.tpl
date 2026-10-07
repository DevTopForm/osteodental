{if !empty($content) && $content|@count>0}
    <ul class="menu">
        {foreach from=$content item='item' name='items'}
            {if $item.public && !$item.nomenu}
                <li class="menu__it">
                    <a href="{if $item.redirect}{$item.redirect}{else}{$item.url}{/if}"
                       class="menu__link">{$item.title}</a>
                </li>
            {/if}
        {/foreach}
    </ul>
{/if}