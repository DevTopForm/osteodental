<h1><span>Личный</span> кабинет</h1>
{if $state=='list'}
<div class="subtitle-block">
	<h2><div class="vmiddle">Информация о скидках</div></h2>
	<div class="clear"></div>
</div>
<div class="gray-block profile-info">
	<div class="gray-top"></div>
	<div class="gray-bg">
		<div class="user-name">	
			<p class="name">{$user->lastname} {$user->firstname}</p>
			
		</div>
		<div class="user-info">
			{if $user->sale}<p class="sale">Скидка: <span>{$user->sale}%</span></p>{/if}
		</div>
		<div class="clear"></div>
	</div>
	<div class="gray-bot"></div>
</div>
{if !empty($list) && $list|@count > 0}
{foreach from=$list item="item"}
	{if $user->sale < $item->sale}
	<div class="sale-up">
		<p>Для получения <span>{$item->sale}%</span> скидки<br/>{$item->text}</p>
	</div>
	{php}break;{/php}
	{/if}
{/foreach}
<div class="sale-list">	
	{foreach from=$list item="item"}
	<div class="sale-item {if $user->sale == $item->sale}active{/if}">
		<div class="size">{$item->sale}%</div>
		<div class="comment">{$item->text}</div>
		<div class="clear"></div>
	</div>
	{/foreach}
</div>
{/if}
{/if}