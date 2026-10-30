{if $list}
    <div class="bread">
        <div class="bread__inside">
            <div class="bread__container container">
                <ul class="bread__list">
                    {foreach from=$list item='item' name='bc'}
                        {if $smarty.foreach.bc.last}
                            <li class="bread__it">
                                <span class="bread__link">
                                    {$item.title}
                                </span>
                            </li>
                        {else}
                            <li class="bread__it">
                                <a href="{$item.url}" class="bread__link">
                                    {$item.title}
                                    <meta content="{$smarty.foreach.bc.iteration}">
                                </a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>
{/if}