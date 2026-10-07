<h3 class="action-title">Заказы</h3>
<p class="action-description edit-content">Управление заказами</p>
{if $state == 'list'}
		{if !empty($list)  && $list|@count > 0}
			<table>
				<thead>
					<tr>
						<th>№</th>
						<th>Дата</th>
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
						<td><a href="/adm/client/edit/{$item->user->id}">{$item->user->lastname} {$item->user->firstname} {$item->user->middlename}</a></td>
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
				$(function() {
					$(".remove").click(function() {
						return confirm("Вы уверены что хотите удалить?");
					});
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
	<form action="" method="post">
		<div style="float: left; width: 49%;">
			<label>Заказ</label>
			<table class="orders">
				<tbody>
					<tr>
						<td style="width: 40%"><strong>№:</strong></td>
						<td>{$item->date|date_format:'%d.%m.%Y'}/{$item->id}</td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Дата</strong></td>
						<td>{$item->date|date_format:'%d %_M %Y %H:%M'}</td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Пользователь</strong></td>
						<td><a href="/adm/client/edit/{$item->user->id}">{$item->user->lastname} {$item->user->firstname} {$item->user->middlename}</a></td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Телефон</strong></td>
						<td>{$item->phone}</td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Адрес</strong></td>
						<td>{$item->address}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div style="float: right; width: 49%;">
			<label>&nbsp;</label>
			<table class="orders">
				<tbody>
					<tr>
						<td><strong>Статус:</strong></td>
						<td>{$item->status->title}</td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Сумма заказа:</strong></td>
						<td>{$item->orderSumm|number_format:2:".":" "}</td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Доставка:</strong></td>
						<td>{$item->delivery->title}</td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Стоимость доставки:</strong></td>
						<td>{$item->deliverySumm}</td>
					</tr>
					<tr>
						<td style="width: 40%"><strong>Общая сумма:</strong></td>
						<td>{$item->totalSumm}</td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="clear"></div>
		{if $item->data}
			<label>Товары</label>
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
						<th><strong>Итого: {$item->data|@count} шт.</strong></th>
						<th><strong>{$item->orderSumm|number_format:2:".":" "}</strong></th>
						<th></th>
						<th></th>
					</tr>
				</tbody>
			</table>
		{/if}
		<div class="clear"></div>
		<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
		<a href="/adm/order/list">{$_LNG_ADM.BACK}</a>
	</form>
<div class="clear"></div>
{/if}
