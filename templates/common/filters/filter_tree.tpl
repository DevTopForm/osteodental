<div class="filter-container">
	{if $title}<label>{$title}:</label>{/if}
	<select class="select_filters" name="{$name}">
	{foreach from=$filters item=filter}
		<option {if $active == $filter.value}selected="selected"{/if} value="{$filter.value}">{$filter.space}{$filter.title}</option>
	{/foreach}
	</select>
</div>