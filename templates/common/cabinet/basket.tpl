{if $state=='save'}
	<h1><span>Оформление</span> заказа</h1>
	<div class="subtitle-block">
		<h2><div class="vmiddle">Новый заказ</div></h2>
		<div class="clear"></div>
	</div>
	<div class="order-total">
		<table>
			<tr>
				<td class="total">
					<p>Общая стоимость: <span>{$order->fullsumm}</span> р.</p>
					<p>Скидка: <span>{$order->salesumm}</span> р.</p>
					<p id="delivery-info">Доставка: <span>1000</span> р.</p>
				</td>
				<td class="topay">
					Сумма к оплате: <span rel="{$order->summ}">{$order->summ}</span> р.
				</td>
			</tr>
		</table>
	</div>
	<form class="default" action="" method="post">
		<div class="delivery">
			<h2>Варианты доставки</h2>
			<div class="delivery-select">
				{if $errors.delivery}
				<p class="error">Выберите способ доставки</p>
				{/if}
				<div class="clear"></div>
				{foreach from=$data.delivery item=item name=delivery}
				<div class="item">
					<input rel="{$item->price}" type="radio" class="styled" name="delivery" id="delivery-{$item->id}" value="{$item->id}" {if !$order->delivery->id && $smarty.foreach.delivery.first}checked="checked"{elseif $order->delivery->id && $order->delivery->id == $item->id}checked="checked"{/if}/> <label for="delivery-{$item->id}">{$item->title}{if $item->price}<br/><strong>{$item->price} р.</strong>{/if}</label>
				</div>
				{/foreach}
				<div class="clear"></div>
			</div>
			<div class="delivery-select">
				{foreach from=$data.delivery item=item name=delivery}
				<div class="delivery-action" id="delivery-action-{$item->id}">
					<p class="title">{$item->title}:</p>
					<div class="info">
					{$item->text}
					</div>
					{if $item->id == 2}
					{if $errors.address}
					<p class="error">Необходимо заполнить адрес доставки</p>
					{/if}
					<table>	
						<tr>
							<td class="label">Адрес&nbsp;доставки:</td>
							<td><textarea name="address">{if $order->address}{$order->address}{else}{$user->address}{/if}</textarea></td>
						</tr>
					</table>
					{/if}
				</div>
				{/foreach}
				<div class="clear"></div>
			</div>
		</div>
		<div class="delivery">
			<h2>Варианты оплаты</h2>
			<div class="delivery-select">
				{if $errors.payment}
				<p class="error">Выберите вариант оплаты</p>
				{/if}
				<div class="clear"></div>
				<div class="item">
					<input type="radio" class="styled" name="payment" id="payment-1" value="bill" {if $order->payment == 'bill'}checked="checked"{/if}/> <label for="payment-1">Выставить счет</label>
				</div>
				<div class="item">
					<input type="radio" class="styled" name="payment" id="payment-2" value="online" {if $order->payment == 'online' || !$order->payment}checked="checked"{/if}/> <label for="payment-2">Онлайн оплата</label>
				</div>
				<div class="clear"></div>
			</div>
			<div class="delivery-select">
				<div class="payment-action" id="payment-action-bill">
					<p class="title">Выставить счет:</p>
					<div class="info"></div>
					{if $errors.bill}
					<p class="error">Необходимо заполнить плательщика</p>
					{/if}
					<table>	
						<tr>
							<td class="label" style="width: 91px;">Плательщик:</td>
							<td class="field"><input type="text" name="bill" value="{if $order->bill}{$order->bill|escape}{else}{$user->organisation|escape}{/if}"/></td>
							<td></td>
						</tr>
					</table>
				</div>
				<div class="payment-action" id="payment-action-online">
					<p class="title">Онлайн оплата:</p>
					<div class="info"></div>
				</div>
			</div>
		</div>
		<input type="hidden" name="save" value="1"/>
		<div class="basket-button"><a href="#" class="button save">Оформить</a></div>
		<div class="clear">&nbsp;</div>
	</form>
	<script type="text/javascript">
		$(document).ready(function(){ldelim}
			$('.delivery-select input[name=delivery]').change(function(){ldelim}
				var val = $('.delivery-select input[name=delivery]:checked').val();
				var pr = parseInt($('.delivery-select input[name=delivery]:checked').attr('rel'));
				if (pr > 0){ldelim}
					$('#delivery-info span').text(pr);
					$('#delivery-info').show();
					var summ = parseInt($('.order-total .topay span').attr('rel'));
					summ+=pr;
					$('.order-total .topay span').text(summ);
				{rdelim} else {ldelim}
					$('#delivery-info').hide();
					$('.order-total .topay span').text($('.order-total .topay span').attr('rel'));
				{rdelim}
				$('.delivery-action').hide();
				$('#delivery-action-'+val).show();
			{rdelim});
			$('.delivery-select input[name=payment]').change(function(){ldelim}
				var val = $('.delivery-select input[name=payment]:checked').val();
				$('.payment-action').hide();
				$('#payment-action-'+val).show();
			{rdelim});
			$('.delivery-select input[name=delivery]').change();
			$('.delivery-select input[name=payment]').change();
		{rdelim});
	</script>
{elseif $state == 'confirm'}
<h1><span>Подтверждение</span> заказа</h1>
	<div class="subtitle-block">
		<h2><div class="vmiddle">Новый заказ</div></h2>
		<div class="clear"></div>
	</div>
	<div class="basket">
		<table>
			<tr>
				<th class="first"></th>
				<th colspan="2">Наименование товара</th>
				<th class="price">Цена</th>
				<th class="price">Скидка</th>
				<th class="price">Цена со скидкой</th>
				<th>Количество</th>
				<th>Стоимость</th>
				<th class="last"></th>
			</tr>
		{foreach from=$order->data item=item name=basket}
			<tr rel="{$item->id}">
				<td class="first"></td>
				<td class="img"><a class="image" href="{$item->url}">{if $item->image}<img src="{$item->image->getLink()}" />{/if}</a></td>
				<td><a href="{$item->url}">{$item->title}</a></td>
				<td>{$item->price}&nbsp;р.</td>
				<td>{if $item->prodsale > 0}{$item->prodsale}%{/if}</td>
				<td>{if $item->prodsale > 0}{$item->realprice}&nbsp;р.{/if}</td>
				<td class="count">{$item->count}</td>
				<td><span class="summ">{$item->price*$item->count-$item->saleprice*$item->count}</span>&nbsp;р.</td>
				<td class="last"></td>
			</tr>
		{/foreach}
			<tr class="empty"><td colspan="9"></td></tr>
		</table>
		<table>
			<tr class="total">
				<td class="first"></td>
				{if $order->deliverysumm > 0}
				<td class="full">
					Общая&nbsp;стоимость:&nbsp;<span class="totalsumm">{$order->fullsumm}</span>&nbsp;р.<br/>
					Размер&nbsp;скидки:&nbsp;<span class="salesumm">{$order->salesumm}</span>&nbsp;р.<br/>
				</td>
				<td class="delivery">
					Доставка:&nbsp;<span>{$order->deliverysumm}</span>&nbsp;р.<br/>
				</td>
				{else}
				<td class="full" colspan="2">
					Общая&nbsp;стоимость:&nbsp;<span class="totalsumm">{$order->fullsumm}</span>&nbsp;р.<br/>
					Размер&nbsp;скидки:&nbsp;<span class="salesumm">{$order->salesumm}</span>&nbsp;р.<br/>
				</td>
				{/if}
				<td class="total">Сумма к оплате: <span class="paysumm">{$order->summ}</span> р.</td>
				<td class="last"></td>
			</tr>
			<tr class="empty"><td colspan="5"></td></tr>
		</table>
		<div class="delivery">
			<h2>Доставка</h2>
			<table>
				<tr class="delivery">
					<td class="first"></td>
					<td class="full">{$order->delivery->title}{if $order->deliverysumm>0}<br><strong>{$order->deliverysumm} р.</strong>{/if}</td>
					{if $order->delivery->id == 2}<td class="info-title">Адрес доставки:</td>{/if}
					<td class="info-text">{$order->address}</td>
					<td class="last"></td>
				</tr>
				<tr class="empty"><td colspan="5"></td></tr>
			</table>
		</div>
		<div class="delivery">
			<h2>Оплата</h2>
			<table>
				<tr class="delivery">
					<td class="first"></td>
					<td class="full">{if $order->payment == 'bill'}Выставить счет{elseif $order->payment == 'online'}Онлайн оплата{/if}</td>
					{if $order->payment == 'bill'}<td class="info-title">Плательщик:</td>{/if}
					<td class="info-text">{$order->bill}</td>
					<td class="last"></td>
				</tr>
				<tr class="empty"><td colspan="5"></td></tr>
			</table>
		</div>
	</div>
	<form class="default" action="" method="post">
		<input type="hidden" value="1" name="save">
		<div class="basket-button"><a class="back-button" href="{$path_prefix}/save">назад к оформлению</a><a href="#" class="button save">{if $order->payment == 'bill'}Выставить счет{elseif $order->payment == 'online'}Оплатить{/if}</a></div>
		<div class="clear">&nbsp;</div>
	</form>
{/if}