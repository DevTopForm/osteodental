<div class="article">
<div class="txt">
	{if $state=='list'}
	<div class="orders">
	{if !empty($list) && $list|@count > 0}
	<table>
		<tr>
			<th>Товар</th>
			<th>Стоимость</th>
		</tr>
		{foreach from=$list item="item"}
		<tr>
			<td><a href="{$item->getUrl()}">{$item->title}</a></td>
			<td>{$item->price} р.</td>
		</tr>
		{/foreach}
	</table>
	{/if}
	</div>
	{$pager}
	{/if}
<div class="clear"></div>
</div>
</div>
