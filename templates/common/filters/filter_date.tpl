<div class="filter-container">
	{if $title}<label>{$title}:</label>{/if}
	<div class="dateFilter">
		<form action="" method="get">
			<table>
			<tr>
				{if $period}
				<td class="period">
					<input type="hidden" name="{$name}" value="{$period.type}" />
					<div class="label">с</div>
					<div class="input"><input type="text" class="text date" name="{$period.start.name}" value="{$period.start.value}"></div>
					<div class="label">до</div>
					<div class="input"><input type="text" class="text date" name="{$period.end.name}" value="{$period.end.value}"></div>
					<input class="button" type="submit" value="ОК" />
					{if $period.binded|@count>0}
						{foreach from=$period.binded item=value key=key}
							<input type="hidden" name="{$key}" value="{$value}" />
						{/foreach}
					{/if}
				</td>
				{/if}
				{foreach from=$data item=filter}
				<td class="dfilter {if $filter.active}active{/if}">
					<a href="?{$name}={$filter.type}{$binded}">{$filter.title}</a>
				</td>
				{/foreach}
			</tr>
			</table>
		</form>
	</div>
</div>