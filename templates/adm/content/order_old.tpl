<h3 class="action-title">Заказы</h3>
<p class="action-description edit-content">Управление заказами</p>
{if $state == 'list'}
	<form action="" enctype="multipart/form-data" method="POST" class="search_content_form search_orders_form">
		<input type="hidden" name="order_filter" value="Y">
		<div class="filed_block">
			<label>
				<div>Дата оформления закза:</div><br>
				<input type="date" name="after_date" value="{$smarty.post.after_date}">
				<input type="date" name="before_date" value="{$smarty.post.before_date}">
			</label>
		</div>
		<div class="filed_block status">
			<label>
				<div>По статусу:</div><br>
				<select name="status">
					<option value="all">Все</option>
					<option {if $smarty.post.status == 1}selected{/if} value="1">Зарегистрирован</option>
					<option {if $smarty.post.status == 2}selected{/if} value="2">Оплачен</option>
					<option {if $smarty.post.status == 3}selected{/if} value="3">Выдан</option>
					<option {if $smarty.post.status == 4}selected{/if} value="4">Не оплачен</option>
					<option {if $smarty.post.status == 5}selected{/if} value="5">Ожидает оплаты</option>
				</select>
			</label>
		</div>
		<div class="filed_block">
			<label>
				<input type="text" name="search_text" placeholder="Поиск по №, цена, телефон" value="{$smarty.post.search_text}">
			</label>
		</div>
		<div class="filed_block">
			<input class="btn" type="submit" name="search" value="Искать">
		</div>
	</form>
	{if !empty($list)  && $list|@count > 0}
		<table>
			<thead>
			<tr>
				<th>№</th>
				<th>Дата</th>
				<th>Тип</th>
				<th>Пользователь</th>
				<th>Кол-во</th>
				<th>Цена</th>
				<th>Статус</th>
				<th style="width: 20px;"></th>
				<th style="width: 20px;"></th>
			</tr>
			</thead>
			<tbody>
			{foreach from=$list item='item'}
				<tr>
					<td><a href="/adm/order/edit/{$item->id}">{$item->date|date_format:'%d.%m.%Y'}/{$item->id}</a></td>
					<td>{$item->date|date_format:'%d.%m.%Y %H:%M'}</td>
					<td>{if empty($item->type)}Заказ{else}{$item->type}{/if}</td>
					<td>
						{if $item->user->id}
							<a href="/adm/client/edit/{$item->user->id}">{$item->user->lastname} {$item->user->firstname} {$item->user->middlename}</a>
						{else}
							{$item->surname} {$item->name}
						{/if}
					</td>
					<td>{$item->data|@count}</td>
					<td>{$item->orderSumm}</td>
					<td {if $item->status->id == 1}style="font-weight: bold;"{/if}>{$item->status->title}</td>
					<td><a href="/adm/order/edit/{$item->id}" class="icon edit"></a></td>
					<td><a href="/adm/order/delete/{$item->id}" class="icon remove"></a></td>
				</tr>
			{/foreach}
			</tbody>
		</table>

		<div class="list_pager">
			{$pager}
		</div>
		<script>
			{literal}
			$(".remove").click(function(e) {
				e.preventDefault();
				$('.js-delete-form').show();
				$('.js-delete-true').attr('href', $(this).attr('href'));
				$('.js-delete-text').html("Вы уверены что хотите удалить?");
			});
			{/literal}
		</script>
		<div class="clear"></div>
	{else}
		<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
	{/if}
{elseif $state == 'edit' || $state == 'add'}
	{if !empty($errors) && $errors|@count > 0}
		<div class="messages">
			{foreach from=$errors item='message'}
				{$message->html}
			{/foreach}
		</div>
	{/if}
	<form class="action-form" action="" method="post">
		<div style="float: left; width: 100%;">
			<table style="width: 49%;">
				<tbody>
				<tr>
					<td>
						<a class="return-btn" href="/adm/order/list">< Назад к списку</a>
					</td>
				</tr>
				<tr>
					<td>
						<label class="order-number">{$item->date|date_format:'%d.%m.%Y'}/{$item->id}</label>
					</td>
				</tr>
				<tr>
					<td>
						<label>Статус:</label>
						<select name="status">
							{foreach from=$statuses item=status}
								<option value="{$status->id}" {if $status->id == $item->status->id}selected="selected"{/if}>{$status->title}</option>
							{/foreach}
						</select>
					</td>
				</tr>
				</tbody>
			</table>
		</div>

		<div style="float: left; width: 49%;">
			<table class="orders">
				<tbody>
				<tr>
					<td style="width: 40%">Дата:</td>
					<td>{$item->date|date_format:'%d %_M %Y %H:%M'}</td>
				</tr>
				<tr>
					<td style="width: 40%">Пользователь:</td>
					<td><a href="/adm/client/edit/{$item->user->id}">{$item->user->lastname} {$item->user->firstname} {$item->user->middlename}</a></td>
				</tr>
				<tr>
					<td style="width: 40%">Телефон:</td>
					<td>{$item->phone}</td>
				</tr>
				<tr>
					<td style="width: 40%">Адрес:</td>
					<td>{$item->address}</td>
				</tr>
				<tr>
					<td style="width: 40%">Комментарий:</td>
					<td>{$item->comment}</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div style="float: right; width: 49%;">
			<label>&nbsp;</label>
			<table class="orders">
				<tbody>
				<tr>
					<td style="width: 40%">Сумма заказа:</td>
					<td>{$item->orderSumm|number_format:2:".":" "}</td>
				</tr>
				<tr>
					<td style="width: 40%">Доставка:</td>
					<td>{$item->delivery->title}</td>
				</tr>
				<tr>
					<td style="width: 40%">Стоимость доставки:</td>
					<td>{$item->deliverySumm}</td>
				</tr>
				<tr>
					<td style="width: 40%">Оплата:</td>
					<td>{$item->payway->title}</td>
				</tr>
				<tr>
					<td style="width: 40%">Общая сумма:</td>
					<td>{$item->totalSumm}</td>
				</tr>
				</tbody>
			</table>
		</div>
		<div class="clear"></div>
		{if $item->data}
			<label class="action-subtitle">Товары в заказе</label>
			<table>
				<thead>
				<tr>
					<th>Название</th>
					<th>Количество</th>
					<th>Цена</th>
					<th>Сумма</th>
				</tr>
				</thead>
				<tbody>
				{foreach from=$item->data item='order'}
					<tr>
						<td><a href="{$order->url}">{$order->title}</a></td>
						<td>{$order->count}</td>
						<td>{$order->price|number_format:2:".":" "}</td>
						<td>{$order->summ}</td>
					</tr>
				{/foreach}
				<tr>
					<th>Итого:</th>
					<th></th>
					<th></th>
					<th>{$item->orderSumm|number_format:2:".":" "}</th>
				</tr>
				</tbody>
			</table>
		{/if}
		<div class="clear"></div>
		<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
	</form>
	<div class="clear"></div>
{/if}
