<div class="center">
	<h1>Избранные товары</h1>
</div>
{if $node->before_title || $node->before_text}
<div class="cat_items_inner active">
	<div class="center">
		{if $node->before_title}<h2>{$node->before_title}</h2>{/if}
		{if $node->before_text}<div>{$node->before_text}</div>{/if}
	</div>
</div>
{/if}
{if $favorite|@count > 0}
	<div class="center">
		<div class="cat_items_list_wrap clearfix">
			{foreach from=$favorite item='item' name="items" name=favorite}
				<div class="cat_items_list clearfix{if $smarty.foreach.deferrer.iteration%4==0} last{/if}">
					<a href="{$item->url}">
						{if $item->image->id}<img src="{$item->image->getLink('thumb')}" alt="{$item->title|escape}" />{/if}
					</a>
					{if !empty($item->variants)}
						{foreach from=$item->variants item='variant' name="variants"}
						<div class="cat_items_list_info" style="bottom: {$smarty.foreach.variants.iteration*26-26+2}px;">
							<span>{$variant->title} <span class="price">{if $variant->price}{$variant->price} р.{/if}</span></span>
						</div>
						{/foreach}
					{else}
					<div class="cat_items_list_info">
						<span>{$item->title} <span class="price">{if $item->price}{$item->price} р.{/if}</span></span>
					</div>
					{/if}
					{if $item->sale}
					<div class="label sale">Скидка</div>
					{elseif $item->novelty}
					<div class="label new">Новинка</div>
					{elseif $item->hit}
					<div class="label hit">HIT</div>
					{/if}
					<a class="favorite_delete to-favorite favorite-page" style="right:-3px;" href="/favorite/add?item={$item->id}"></a>
				</div>
			{/foreach}
			<div class="clear"></div>
		</div>
		{$pager}
		{if $node->after_title}<h2>{$node->after_title}</h2>{/if}
		{if $node->after_text}<div class="outer-text">{$node->after_text}</div>{/if}
	</div>
{/if}
