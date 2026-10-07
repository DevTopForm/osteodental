<div class="center cabinet_page">
{if $state=='list'}
	<h1>История заказов</h1>
	<div class="basket_page">
		<table class="basket_table">
			<tr>
				<th>Номер заказа</th>
				<th class="date">Дата</th>
				<th class="status">Статус</th>
				<th class="summ">Стоимость</th>
			</tr>
			{if !empty($list) && $list|@count > 0}
				{foreach from=$list item="item"}
					<tr>
						<td><a href="{$path_prefix}/view/{$item->id}">{$item->date|date_format:'%Y-%m-%d'}/{$item->id}</a></td>
						<td>{$item->date|date_format:'%d %_M %Y'}</td>
						<td>{$item->status->title}</td>
						<td>{$item->totalSumm} р.</td>
					</tr>
				{/foreach}
			{else}
			<tr>
				<td colspan="4">Вы не оформили ни одного заказа</td>
			</tr>
			{/if}
		</table>
	</div>
{$pager}
{elseif $state == 'view'}
	<h1>Просмотр заказа №{$item->date|date_format:'%Y-%m-%d'}/{$item->id}</h1>
	<div class="basket_page">
		<table class="basket_table">
			<tr>
				<th colspan="2">Наименование товара</th>
				<th>Цена</th>
				<th>Скидка</th>
				<th>Цена со скидкой</th>
				<th>Количество</th>
				<th>Стоимость</th>
			</tr>
		{foreach from=$item->data item=prod name=basket}
			<tr>
				<td class="img"><a class="image" href="{$prod->url}">{if $prod->image->id}<img src="{$prod->image->getLink('thumb')}" />{/if}</a></td>
				<td><a href="{$prod->url}">{$prod->title}{if $prod->variant->id} {$prod->variant->title}{/if}</a></td>
				<td>{if $prod->variant->id}{$prod->variant->price}&nbsp;р.{else}{$prod->price}&nbsp;р.{/if}</td>
				<td>{if $prod->prodsale > 0}{$prod->prodsale}%{/if}</td>
				<td>{if $prod->prodsale > 0}{$prod->realprice}&nbsp;р.{/if}</td>
				<td class="count">{$prod->count}</td>
				<td><span class="summ">{if $prod->variant->id}{$prod->variant->price*$prod->count}{else}{$prod->price*$prod->count}{/if}</span>&nbsp;р.</td>
			</tr>
		{/foreach}
		</table>
		<div class="itog">
			<div class="paysumm">
				Итоговая стоимость заказа:<span class="price">{$item->totalSumm} р.</span>
			</div>
		</div>
		<table>
			<tr>
				<td class="title" style="width:150px;">Адрес доставки</td>
				<td class="field">{$item->address}</td>
			</tr>
			<tr>
				<td class="title" style="width:150px;">Вариант оплаты</td>
				<td class="field">{$item->payway->title}</td>
			</tr>
			<tr>
				<td class="title" style="width:150px;">Способ доставки</td>
				<td class="field">{$item->delivery->title}</td>
			</tr>
			<tr>
				<td class="title" style="width:150px;">Ваш комментарий</td>
				<td class="field">{$item->comment}</td>
			</tr>
		</table>
		<br/>
		<a href="{$path_prefix}">к списку заказов</a>
	</div>
{elseif $state == 'success'}
	<h1><span>Оплата</span> заказа</h1>
	<div class="subtitle-block">
		<h2><div class="vmiddle">Заказ №{$item->date|date_format:'%Y-%m-%d'}/{$item->id}</div></h2>
		<div class="clear"></div>
	</div>
	<div class="order-total">
		<table>
			<tr>
				<td class="total">
					<p>Общая стоимость: <span>{$item->orderSumm}</span> р.</p>
					<p>Скидка: <span>{$item->salesumm}</span> р.</p>
					{if $item->deliverySumm}<p>Доставка: <span>{$item->deliverySumm}</span> р.</p>{/if}
				</td>
				<td class="topay">
					Сумма к оплате: <span>{$item->totalSumm}</span> р.
				</td>
			</tr>
		</table>
	</div>
	<div class="order-mess">
		Заказ успешно оплачен
	</div>
{elseif $state == 'error'}
	<h1><span>Оплата</span> заказа</h1>
	<div class="subtitle-block">
		<h2><div class="vmiddle">Заказ №{$item->date|date_format:'%Y-%m-%d'}/{$item->id}</div></h2>
		<div class="clear"></div>
	</div>
	<div class="order-total">
		<table>
			<tr>
				<td class="total">
					<p>Общая стоимость: <span>{$item->orderSumm}</span> р.</p>
					<p>Скидка: <span>{$item->salesumm}</span> р.</p>
					{if $item->deliverySumm}<p>Доставка: <span>{$item->deliverySumm}</span> р.</p>{/if}
				</td>
				<td class="topay">
					Сумма к оплате: <span>{$item->totalSumm}</span> р.
				</td>
			</tr>
		</table>
	</div>
	<div class="order-mess">
		Заказ не оплачен
	</div>
{elseif $state == 'pay'}
	{if $item->payment == 'bill'}
	<h1><span>Оплата</span> заказа</h1>
	<a href="#" class="print-bill">Распечатать счет</a>
	<div class="clear"></div>
	<div id="bill-container">
		<table class="bill-table" border="0" cellspacing="0" cellpadding="0">
			<tbody>
				<tr>
					<td width="1" height="13">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
					<td width="21">&nbsp;</td>
				</tr>
				<tr>
					<td height="23">&nbsp;</td>
					<td class="va-t brd-t brd-l" rowspan="2" colspan="18">ФИЛИАЛ ОПЕРУ ОАО БАНК ВТБ В САНКТ-ПЕТЕРБУРГЕ Г.САНКТ-ПЕТЕРБУРГ</td>
					<td class="va-t brd-t brd-l brd-r" colspan="3">БИК</td>
					<td class="va-t brd-t brd-r" colspan="11">044030704</td>
				</tr>
				<tr>
					<td height="20">&nbsp;</td>
					<td class="va-t brd-t brd-l brd-r" rowspan="2" colspan="3">Сч. №</td>
					<td class="va-t brd-r brd-b" rowspan="2" colspan="11">30101810200000000704</td>
				</tr>
				<tr>
					<td height="12">&nbsp;</td>
					<td class="f-s brd-l brd-b" colspan="18">Банк получателя</td>
				</tr>
				<tr>
					<td height="17">&nbsp;</td>
					<td class="va-t brd-l brd-b" colspan="9">ИНН 7801396029</td>
					<td class="va-t brd-l brd-b" colspan="9">КПП 780101001</td>
					<td class="va-t brd-l brd-t brd-b" rowspan="4" colspan="3">Сч. №</td>
					<td class="va-t brd-l brd-r brd-b" rowspan="4" colspan="11">40702810168000004437</td>
				</tr>
				<tr>
					<td height="16">&nbsp;</td>
					<td class="brd-l" rowspan="2" colspan="18">Общество с ограниченной ответственностью&nbsp; "Торговый дом Гефест"</td>
				</tr>
				<tr>
					<td height="18">&nbsp;</td>
				</tr>
				<tr>
					<td height="12">&nbsp;</td>
					<td class="f-s brd-l brd-b" colspan="18">Получатель</td>
				</tr>
				<tr>
					<td height="55">&nbsp;</td>
					<td class="b f-b va-m brd-b-b" colspan="32">Счет № {$item->id} от {$item->date|date_format:'%d.%m.%y'}</td>
				</tr>
				<tr>
					<td colspan="33" height="9">&nbsp;</td>
				</tr>
				<tr>
					<td height="17">&nbsp;</td>
					<td class="va-m" colspan="4">Поставщик:</td>
					<td class="b va-m" colspan="28" width="588">ИНН 7801396029 КПП 780101001 Общество с ограниченной ответственностью&nbsp; "Торговый дом Гефест" 199106, Санкт-Петербург, Средний пр. В.О. д. 76/18, литера А, пом. 1Н, тел. (812) 655-07-07</td>
				</tr>
				<tr>
					<td colspan="33" height="9">&nbsp;</td>
				</tr>
				<tr>
					<td height="17">&nbsp;</td>
					<td class="va-m" colspan="4">Покупатель:</td>
					<td class="b va-m" colspan="28" width="588">{$item->bill}</td>
				</tr>
				<tr>
					<td colspan="33" height="9">&nbsp;</td>
				</tr>
				<tr>
					<td height="35">&nbsp;</td>
					<td class="b a-c va-m brd-b-t brd-r brd-b-b brd-b-l" colspan="2">№</td>
					<td class="b a-c va-m brd-b-t brd-r brd-b-b brd-l" colspan="17">Товар</td>
					<td class="b a-c va-m brd-b-t brd-r brd-b-b brd-l" colspan="3">Кол-во</td>
					<td class="b a-c va-m brd-b-t brd-r brd-b-b brd-l" colspan="2">Ед.</td>
					<td class="b a-c va-m brd-b-t brd-r brd-b-b brd-l" colspan="4">Цена, руб.</td>
					<td class="b a-c va-m brd-b-t brd-b-r brd-b-b brd-l" colspan="4">Сумма, руб.</td>
				</tr>
				{foreach from=$item->data name=prod item=prod}
				<tr>
					<td height="35">&nbsp;</td>
					<td class="a-c va-m brd" colspan="2">{$smarty.foreach.prod.iteration}</td>
					<td class="	   va-m	brd" colspan="17">{$prod->title}</td>
					<td class="a-c va-m brd" colspan="3">{$prod->count}</td>
					<td class="a-c va-m brd" colspan="2">шт.</td>
					<td class="a-r va-m brd" colspan="4">{if $prod->prodsale > 0}{$prod->realprice|string_format:'%.2f'}{else}{$prod->price|string_format:'%.2f'}{/if}</td>
					<td class="a-r va-m brd" colspan="4">{$prod->price*$prod->count-$prod->saleprice*$prod->count|string_format:'%.2f'}</td>
				</tr>
				{/foreach}
				{assign var=total value=$item->data|@count}
				{if $item->deliverysumm > 0}
					{assign var=total value=$total+1}
					<tr>
						<td height="35">&nbsp;</td>
						<td class="a-c va-m brd" colspan="2">{$total}</td>
						<td class="	   va-m	brd" colspan="17">{$item->delivery->title}</td>
						<td class="a-c va-m brd" colspan="3">1</td>
						<td class="a-c va-m brd" colspan="2">шт.</td>
						<td class="a-r va-m brd" colspan="4">{$item->deliverysumm|string_format:'%.2f'}</td>
						<td class="a-r va-m brd" colspan="4">{$item->deliverysumm|string_format:'%.2f'}</td>
					</tr>
				{/if}
				<tr><td height="9" colspan="33">&nbsp;</td></tr>
				<tr>
					<td colspan="25" height="17">&nbsp;</td>
					<td class="b a-r" colspan="4">Итого:</td>
					<td class="b a-r" colspan="4">{$item->summ|string_format:'%.2f'}</td>
				</tr>
				<tr>
					<td colspan="22" height="17">&nbsp;</td>
					<td class="b a-r" colspan="7">В том числе НДС:</td>
					<td class="b a-r" colspan="4">{$item->ndssumm|string_format:'%.2f'}</td>
				</tr>
				<tr><td colspan="33" height="9">&nbsp;</td></tr>
				<tr>
					<td height="17">&nbsp;</td>
					<td colspan="32">Всего наименований {$total}, на сумму {$item->summ|string_format:'%.2f'} руб.</td>
				</tr>
				<tr>
					<td height="26">&nbsp;</td>
					<td class="b va-m brd-b" colspan="32">{$item->summ|num2str}</td>
				</tr>
				<tr>
					<td colspan="33" height="15">&nbsp;</td>
				</tr>
				<tr>
					<td height="17">&nbsp;</td>
					<td class="b" colspan="5">Руководитель</td>
					<td class="brd-b" colspan="4">&nbsp;</td>
					<td colspan="6">(Карпович В.П.)</td>
					<td>&nbsp;</td>
					<td class="b" colspan="4">Бухгалтер</td>
					<td class="brd-b" colspan="5">&nbsp;</td>
					<td colspan="6">(Карпович В.П.)</td>
					<td>&nbsp;</td>
				</tr>
			</tbody>
		</table>
		<style>
			{literal}
			.bill-table td	{
				padding:0px 2px !important;
				color:#000 !important;
				font-size:13px;
				font-family:Arial, sans-serif !important;
				vertical-align:top;
			}
			.bill-table .b	 {	font-weight: bold;	}
			.bill-table .a-c {	text-align: center;	}
			.bill-table .a-r {	text-align: right;	}
			.bill-table .va-m { vertical-align: middle;	}
			.bill-table .va-t {	vertical-align: top;}
			.bill-table .va-b {	vertical-align: bottom;	}
			.bill-table .brd-bb {border: 2px solid #000;}
			.bill-table .brd-b-l {border-left: 2px solid #000;}
			.bill-table .brd-b-r {border-right: 2px solid #000;}
			.bill-table .brd-b-t {border-top: 2px solid #000;}
			.bill-table .brd-b-b {border-bottom: 2px solid #000;}
			.bill-table .brd {border: 1px solid #000;}
			.bill-table .brd-l {border-left: 1px solid #000;}
			.bill-table .brd-r {border-right: 1px solid #000;}
			.bill-table .brd-t {border-top: 1px solid #000;}
			.bill-table .brd-b {border-bottom: 1px solid #000;}
			.bill-table .f-b {font-size: 19px;}
			.bill-table .f-s {font-size: 11px;}
			{/literal}
		</style>
	</div>
	{/if}
{/if}
</div>
