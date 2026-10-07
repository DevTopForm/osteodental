<div class="sorter_container">
{if $sorters|@count > 0}
    <div class="sorter_item"><strong>Сортировать:</strong>&nbsp;</div>
    {foreach from=$sorters item='sorter'}
		<div class="sorter_item">{$sorter.title}</div>	
		<div class="arrows">
			<div class="up">{if $sorter.order != 'd' && $sorter.active}<span></span>{else}<a href="?sorter={$sorter.name}&amp;order=a{$sorter.binded}"></a>{/if}</div>
			<div class="down">{if $sorter.order == 'd' && $sorter.active}<span></span>{else}<a href="?sorter={$sorter.name}&amp;order=d{$sorter.binded}"></a>{/if}</div>
		</div>
    {/foreach}
    <div class="clear"></div>
{/if}
</div>
