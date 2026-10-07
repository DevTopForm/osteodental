<div class="filter-container">
	{if $filter_title}<label>{$filter_title}:</label>{/if}
	{foreach from=$binded item=value key=key}
	<input type="hidden" name="{$key}" value="{$value}" />
	{/foreach}
	<input type="text" name="{$filter_name}" value="{$active|escape}">
</div>
