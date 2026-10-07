<div class="filter-container radio-group">
	{if $title}<label class="title">{$title}:</label>{/if}
	{foreach from=$filters item=filter}
		<input type="radio" class="styled" name="{$name}" id="{$name}-{$filter.value}-rbt" {if $active == $filter.value}checked="checked"{/if} value="{$filter.value}"/> <label for="{$name}-{$filter.value}-rbt">{$filter.title}</label>
	{/foreach}
	<div class="clear"></div>
</div>