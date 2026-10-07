<form action="" method="get">
<div class="dateFilter">
	<table>
	<tr>
		<td class="period {if $type_period.active}active{/if}">
			<input type="hidden" name="{$filter_name}" value="{$type_period.type}" />
			<div class="label">с</div>
			<div class="input"><input type="text" class="text date" name="start" value="{$type_period.start}"></div>
			<div class="label">до</div>
			<div class="input"><input type="text" class="text date" name="end" value="{$type_period.end}"></div>
			<input class="button" type="submit" value="Показать" />
			{if $type_period.binded_params|@count>0}
				{foreach from=$type_period.binded_params item=value key=key}
					<input type="hidden" name="{$key}" value="{$value}" />
				{/foreach}
			{/if}
		</td>
		{foreach from=$filters item=filter}
		<td class="dfilter {if $filter.active}active{/if}">
			<a href="?{$filter_name}={$filter.type}{$binded_filters}">{$filter.title}</a>
		</td>
		{/foreach}
	</tr>
	</table>
</div>
</form>
