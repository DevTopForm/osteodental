{if $content}
    <h2 class="h2 mb-20-30" id="prices">Цены</h2>

    {foreach $content as $group}
        {include file="page/includes/price_block.tpl" content=$group class="mb-60"}
    {/foreach}
{/if}