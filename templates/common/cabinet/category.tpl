{if $state == 'list'}
<div class="content-title">
	<div class="title-container">
		<span class="title-page2">Категории ссылок</span>
		<a href="{$path_prefix}/add" class="local" id="add-category" h="220"></a>
		<form action="" method="get" class="sorting-form">
			<span class="sorting">Сортировать по:</span>
			  <div class="lineForm">
				  <select id="jqueryOnchange" style="width:242px;">
					  <option value="?sorter=date&order=d" {if $smarty.get.sorter == 'date' && $smarty.get.order == 'd'}selected="selected"{/if}>дате добавления (новые сверху)</option>
						<option value="?sorter=date&order=a"{if $smarty.get.sorter == 'date' && $smarty.get.order == 'a'}selected="selected"{/if}>дате добавления (новые снизу)</option>
						<option value="?sorter=title&order=a"{if $smarty.get.sorter == 'title' && $smarty.get.order == 'a'}selected="selected"{/if}>названию (по возрастанию)</option>
						<option value="?sorter=title&order=d"{if $smarty.get.sorter == 'title' && $smarty.get.order == 'd'}selected="selected"{/if}>названию (по убыванию)</option>
				  </select>
			  </div>
		</form>
		<div class="clear"></div>
	</div>
</div>
<div id="example">
	{if !empty($list) && $list|@count>0}
	<div id="slides">
		<div class="slides_container">
			<div class="slide">
				<div class="list-category">
					{foreach from=$list item='item' name='items'}
					<span class="type-category">
						<a class="inf-category" href="{$path_prefix}/view/{$item->id}">
							<span class="title-category">{$item->title|strip_tags}</span>
							<span class="summ-link">{$item->count} ссыл{$item->getLinkPrefix()}</span>
						</a>
						<a href="{$path_prefix}/edit/{$item->id}" class="edit local" h="220"></a>
						<a href="{$path_prefix}/delete/{$item->id}" class="close local" h="220"></a>
					</span>
					{if $smarty.foreach.items.iteration % 21 == 0 && !$smarty.foreach.items.last}
					<div class="clear"></div>
				</div>
			</div>	
			
			<div class="slide">
				<div class="list-category">
					{/if}
					{/foreach}
					<div class="clear"></div>
				</div>
			</div>
			
		</div>
		<a href="#" class="next"><img src="/common/images/dalee.png" width="33" height="57" alt="Вперед"></a>
		<a href="#" class="prev"><img src="/common/images/prev.png" width="33" height="57" alt="Назад"></a>
	</div>
	{else}
	<div class="welcome-cat">
		<h2>Добро пожаловать в BIGBAGBOOK</h2>
		<p>Здравствуйте, {$user->name}!</p>
		<p>Чтобы Вам было удобнее сохранять и использовать ссылки на интересные сайты мы разделим их на категории. Категории - это созданные Вами рубрики, в которых будут располагаться ссылки на веб-сайты. Вы можете называть категории как угодно и создавать их столько, сколько захотите.</p>
		<p>Создайте свою первую категорию нажав на жёлтую кнопку<br/>«Добавить категорию»</p>
	</div>
	{/if}
 </div>
<div class="clear"></div>
{elseif $state=='add' || $state == 'edit'}

{elseif $state=='view'}
<div class="content-title">
	<div class="title-container">
		<a href="{$path_prefix}" class="back"></a>
		<span class="title5">
			<span class="title-page2">{$item->title|strip_tags}</span>
			<span class="clear"></span>
		</span>
		<a href="/cabinet/link/add/{$item->id}" class="local" id="add-link"></a>
		<form action="" method="get" class="sorting-form" id="sorting-form">
			<span class="sorting">Сортировать по:</span>
			  <div class="lineForm">
				  <select id="jqueryOnchange" style="width:242px;">
						<option value="?sorter=date&order=d" {if $smarty.get.sorter == 'date' && $smarty.get.order == 'd'}selected="selected"{/if}>дате добавления (новые сверху)</option>
						<option value="?sorter=date&order=a"{if $smarty.get.sorter == 'date' && $smarty.get.order == 'a'}selected="selected"{/if}>дате добавления (новые снизу)</option>
						<option value="?sorter=title&order=a"{if $smarty.get.sorter == 'title' && $smarty.get.order == 'a'}selected="selected"{/if}>названию (по возрастанию)</option>
						<option value="?sorter=title&order=d"{if $smarty.get.sorter == 'title' && $smarty.get.order == 'd'}selected="selected"{/if}>названию (по убыванию)</option>
				  </select>
			  </div>
		</form>
		
		<div class="clear"></div>
	</div>
</div>
<div id="example">
	{if $item->links|@count>0}
	<div id="slides">
		<div class="slides_container">
			<div class="slide">
				<div class="link">
					{foreach from=$item->links item='link' name='links'}
					<span class="type-link {if $smarty.foreach.links.iteration%3 == 0}last{/if}">
						<a class="inf-link" href="{$link->url}"  target="_blank">
							<span class="name-link" {if $link->icon}style="background-image: url('{$link->icon}')"{/if}>{if $link->title}{$link->title|strip_tags}{else}{$link->url}{/if}</span>
							<span class="text-link">{$link->comment|strip_tags|truncate:150}</span>
							<span class="link-site">{$link->url}</span>
						</a>
						<a href="/cabinet/link/edit/{$link->id}" class="edit local"></a>
						<a href="/cabinet/link/delete/{$link->id}" class="close local" h="220"></a>
					</span>
					{if $smarty.foreach.links.iteration % 21 == 0 && !$smarty.foreach.links.last}
					<div class="clear"></div>
				</div>
			</div>	
			<div class="slide">
				<div class="list-category">
					{/if}
					{/foreach}
					<div class="clear"></div>
				</div>
				<div class="clear"></div>
			</div>
		</div>
		<a href="#" class="next"><img src="/common/images/dalee.png" width="33" height="57" alt="Вперед"></a>
		<a href="#" class="prev"><img src="/common/images/prev.png" width="33" height="57" alt="Назад"></a>
	</div>
	{else}
	<div class="welcome-link">
		<h2>Добавьте ссылки</h2>
		<p>Это очень просто!</p>
		<p>Нажмите на кнопку «Добавть ссылку» в верхней части окна. В появившемя диалоговом окне Вы найдёте поле «Адрес ссылки» скопируйте из адресной строки вашего браузера адресс сылки и вставьте его в соответсвующее поле.</p>
		<p>Также Вы можете изменить название ссылки и коментарий.<br/>Удачной работы!</p>
	</div>
	{/if}
</div>
<div class="clear"></div>
{/if}