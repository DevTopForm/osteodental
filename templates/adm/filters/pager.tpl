<div class="pages__pages">
	{if $pager.pages <= 15}
		{section name=pager loop=$pager.pages+1 step=1 start=1}
			<a class="pages__page {if $smarty.section.pager.index == $pager.page} active{/if}" {if $smarty.section.pager.index < $pager.page}rel="prev"{elseif $smarty.section.pager.index > $pager.page}rel="next"{/if} href="{$pager.requestUrl}page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
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
				<a class="pages__page {if $smarty.section.pager.index == $pager.page} active{/if}" {if $smarty.section.pager.index < $pager.page}rel="prev"{elseif $smarty.section.pager.index > $pager.page}rel="next"{/if} href="{$pager.requestUrl}page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
			{/section}
			...
			{section name=pager loop=$pager.pages+1 step=1 start=$pager.pages-2 max=3}
				<a class="pages__page" rel="next" href="{$pager.requestUrl}page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
			{/section}
		{elseif $pager.page > $pager.pages-5}
			{if $pager.page==$pager.pages}
				{assign var=goto value=$pager.pages-2}
			{else}
				{assign var=goto value=$pager.page-1}
			{/if}
			{section name=pager loop=$pager.pages+1 step=1 start=1 max=3}
				<a class="pages__page" rel="prev" href="{$pager.requestUrl}page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
			{/section}
			...
			{section name=pager loop=$pager.pages+1 step=1 start=$goto}
				<a class="pages__page {if $smarty.section.pager.index == $pager.page} active{/if}" {if $smarty.section.pager.index < $pager.page}rel="prev"{elseif $smarty.section.pager.index > $pager.page}rel="next"{/if} href="{$pager.requestUrl}page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
			{/section}
		{else}
			{section name=pager loop=$pager.pages+1 step=1 start=1 max=3}
				<a class="pages__page" rel="prev" href="?page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
			{/section}
			...
			{section name=pager loop=$pager.pages+1 step=1 start=$pager.page-1 max=3}
				<a class="pages__page {if $smarty.section.pager.index == $pager.page} active{/if}" {if $smarty.section.pager.index < $pager.page}rel="prev"{elseif $smarty.section.pager.index > $pager.page}rel="next"{/if} href={$pager.requestUrl}"?page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
			{/section}
			...
			{section name=pager loop=$pager.pages+1 step=1 start=$pager.pages-2 max=3}
				<a class="pages__page" rel="next" href="{$pager.requestUrl}page={$smarty.section.pager.index}{$filter}">{$smarty.section.pager.index}</a>
			{/section}
		{/if}
	{/if}
</div>
