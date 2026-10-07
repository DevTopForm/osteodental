{if $pager.pages > 1}
    <div class="pagination">
        {if $pager.pages <= 15}
            {section name=pager loop=$pager.pages+1 step=1 start=1}
                <a class="pagination__link{if $smarty.section.pager.index == $pager.page} pagination__link--active{/if}"
                   {if $smarty.section.pager.index < $pager.page}rel="prev"
                   {elseif $smarty.section.pager.index > $pager.page}rel="next"{/if}
                   href="?page={$smarty.section.pager.index}{$filter}"
                   onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
            {/section}
        {else}
            {assign var=second_points value=0}
            {if $pager.page < 6 }
                {if $pager.page==1}
                    {assign var=goto value=3}
                {else}
                    {assign var=goto value=$pager.page+1}
                {/if}
                {section name=pager loop=$pager.pages+1 step=1 start=1 max=$goto}
                    <a class="pagination__link{if $smarty.section.pager.index == $pager.page} pagination__link--active{/if}"
                       {if $smarty.section.pager.index < $pager.page}rel="prev"
                       {elseif $smarty.section.pager.index > $pager.page}rel="next"{/if}
                       href="?page={$smarty.section.pager.index}{$filter}"
                       onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
                {/section}
                <div class="pagination__link">...</div>
                {section name=pager loop=$pager.pages+1 step=1 start=$pager.pages-2 max=3}
                    <a class="pagination__link" rel="next"
                       href="?page={$smarty.section.pager.index}{$filter}"
                       onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
                {/section}
            {elseif $pager.page > $pager.pages-5}
                {if $pager.page==$pager.pages}
                    {assign var=goto value=$pager.pages-2}
                {else}
                    {assign var=goto value=$pager.page-1}
                {/if}
                {section name=pager loop=$pager.pages+1 step=1 start=1 max=3}
                    <a class="pager" rel="prev"
                       href="?page={$smarty.section.pager.index}{$filter}"
                       onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
                {/section}
                <div class="pagination__link">...</div>
                {section name=pager loop=$pager.pages+1 step=1 start=$goto}
                    <a class="pagination__link{if $smarty.section.pager.index == $pager.page} pagination__link--active{/if}"
                       {if $smarty.section.pager.index < $pager.page}rel="prev"
                       {elseif $smarty.section.pager.index > $pager.page}rel="next"{/if}
                       href="?page={$smarty.section.pager.index}{$filter}"
                       onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
                {/section}
            {else}
                {section name=pager loop=$pager.pages+1 step=1 start=1 max=3}
                    <a class="pager" rel="prev"
                       href="?page={$smarty.section.pager.index}{$filter}"
                       onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
                {/section}
                <div class="pagination__link">...</div>
                {section name=pager loop=$pager.pages+1 step=1 start=$pager.page-1 max=3}
                    <a class="pagination__link{if $smarty.section.pager.index == $pager.page} pagination__link--active{/if}"
                       {if $smarty.section.pager.index < $pager.page}rel="prev"
                       {elseif $smarty.section.pager.index > $pager.page}rel="next"{/if}
                       href="?page={$smarty.section.pager.index}{$filter}"
                       onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
                {/section}
                <div class="pagination__link">...</div>
                {section name=pager loop=$pager.pages+1 step=1 start=$pager.pages-2 max=3}
                    <a class="pager" rel="next"
                       href="?page={$smarty.section.pager.index}{$filter}"
                       onclick="pageTo({$smarty.section.pager.index})">{$smarty.section.pager.index}</a>
                {/section}
            {/if}
        {/if}
    </div>
    <script>
        function pageTo(num) {ldelim}
            event.preventDefault()
            let url = new URL(window.location.href)
            url.searchParams.set('page', num)
            window.location = url;
            {rdelim}
    </script>
{/if}