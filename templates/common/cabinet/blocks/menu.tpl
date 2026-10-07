<div class="cabinet-menu">
	<ul>
		{foreach from=$menu item=item name=items}
		<li class="{if $smarty.foreach.items.last}last{/if} {if $item.active}active{/if}"><a href="{$item.link}">{$item.title}</a><div class="fon"></div></li>
		{/foreach}
	</ul>
</div>