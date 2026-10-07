{if !empty($content) && $content|@count>0}
    <ul id="menu-footer" class="footer-menu">
        {foreach from=$content item='item' name='menu4'}
            {if $item.public}
                <li class="footer-menu__item">
                    <a class="footer-menu__link" href="{if $item.redirect}{$item.redirect}{else}{$item.url}{/if}"
                       title="{if $item.menutitle}{$item.menutitle}{else}{$item.title}{/if}">
                        {if $item.menutitle}{$item.menutitle}{else}{$item.title}{/if}
                    </a>
                </li>
            {/if}
        {/foreach}
    </ul>
{/if}