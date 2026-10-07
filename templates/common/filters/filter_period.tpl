<div class="filters_item">
	{if $title}<label>{$title}</label>{/if}
	{*
	{foreach from=$data item=filter}
	<a class="dfilter  {if $filter.active}active{/if}" href="?{$name}={$filter.type}{$binded}">{$filter.title}</a>
	{/foreach}
	*}
	{if $period}
	<input type="hidden" name="{$name}" value="{$period.type}" />
	<span class="filter_lbl">с&nbsp;</span>
	<span class="border_inp"><input type="text" class="text date" name="{$period.start.name}" value="{if $period.active}{$period.start.value}{/if}"/></span>
	<span class="filter_lbl">до&nbsp;</span>
	<span class="border_inp"><input type="text" class="text date" name="{$period.end.name}" value="{if $period.active}{$period.end.value}{/if}"/></span>
	{/if}
	<div class="clear"></div>
</div>				