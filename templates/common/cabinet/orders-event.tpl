<div class="article">
<div class="txt">
	{if $state=='list'}
	<div class="orders">
		<table>
			<tr>
				<th>Название</th>
				<th>Дата</th>
				<th>Стоимость</th>
				<th></th>
				<th>Статус</th>
				<th>Документы</th>
			</tr>
			{if !empty($list) && $list|@count > 0}
				{foreach from=$list item="item"}
				<tr>
					<td><a href="{$item->event->url}">{$item->event->title}</a></td>
					<td>
						{if $item->event->period_samemonth}
							{$item->event->date|date_format:'%d'}&mdash;{$item->event->date_end|date_format:'%d'}&nbsp;{$item->event->date|date_format:'%_M&nbsp;%Y'}
						{elseif $item->event->period_twomonths}
							{$item->event->date|date_format:'%d&nbsp;%_M'}&nbsp;&mdash;<br/>{$item->event->date_end|date_format:'%d&nbsp;%_M'}&nbsp;{$item->event->date|date_format:'%Y'}
						{else}
							{$item->event->date|date_format:'%d&nbsp;%_M&nbsp;%Y'}
						{/if}
					</td>
					<td>{if $item->summ}{$item->summ} р.{else}Бесплатно{/if}</td>
					<td class="icon">
						{foreach from=$item->event->category item=cat}
							{if $cat->image}<img src="{$cat->image->getLink('icon3')}"/>{/if}
						{/foreach}
					</td>
					<td>{$item->status->title}</td>
					<td>
						{if $item->status->id == 2 || $item->event->sendreg  || $item->sended}
						<a href="{$path_prefix}/ticket/{$item->id}">Билет</a><br/>
						{/if}
						{if $item->files|@count > 0}
							{foreach from=$item->files item=file}
							<a href="{$path_prefix}/getfile/{$item->id}/{$file->id}">{if $file->title}{$file->title}{else}{$file->src_name}{/if}</a><br/>
							{/foreach}
						{/if}
					</td>
				</tr>
				{/foreach}
			{/if}
		</table>
	</div>
	{$pager}
	{elseif $state == 'view'}
	<h1><span>Просмотр</span> заказа</h1>
		<div class="subtitle-block">
			<h2><div class="vmiddle">Заказ №{$item->date|date_format:'%Y-%m-%d'}/{$item->num}</div></h2>
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
			{foreach from=$item->data item=prod name=basket}
				<tr>
					<td class="first"></td>
					<td class="img"><a class="image" href="{$prod->url}">{if $prod->image}<img src="{$prod->image->getLink()}" />{/if}</a></td>
					<td><a href="{$prod->url}">{$prod->title}</a></td>
					<td>{$prod->price}&nbsp;р.</td>
					<td>{if $prod->prodsale > 0}{$prod->prodsale}%{/if}</td>
					<td>{if $prod->prodsale > 0}{$prod->realprice}&nbsp;р.{/if}</td>
					<td class="count">{$prod->count}</td>
					<td><span class="summ">{$prod->price*$prod->count-$prod->saleprice*$prod->count}</span>&nbsp;р.</td>
					<td class="last"></td>
				</tr>
			{/foreach}
				<tr class="empty"><td colspan="9"></td></tr>
			</table>
			<table>
				<tr class="total">
					<td class="first"></td>
					{if $item->deliverysumm > 0}
					<td class="full">
						Общая&nbsp;стоимость:&nbsp;<span class="totalsumm">{$item->fullsumm}</span>&nbsp;р.<br/>
						Размер&nbsp;скидки:&nbsp;<span class="salesumm">{$item->salesumm}</span>&nbsp;р.<br/>
					</td>
					<td class="delivery">
						Доставка:&nbsp;<span>{$item->deliverysumm}</span>&nbsp;р.<br/>
					</td>
					{else}
					<td class="full">
						Общая&nbsp;стоимость:&nbsp;<span class="totalsumm">{$item->fullsumm}</span>&nbsp;р.<br/>
						Размер&nbsp;скидки:&nbsp;<span class="salesumm">{$item->salesumm}</span>&nbsp;р.<br/>
					</td>
					{/if}
					<td class="total">Сумма к оплате: <span class="paysumm">{$item->summ}</span> р.</td>
					<td class="last"></td>
				</tr>
				<tr class="empty"><td colspan="5"></td></tr>
			</table>
			<div class="delivery">
				<h2>Доставка</h2>
				<table>
					<tr class="delivery">
						<td class="first"></td>
						<td class="full">{$item->delivery->title}{if $item->deliverysumm>0}<br><strong>{$item->deliverysumm} р.</strong>{/if}</td>
						{if $item->delivery->id == 2}<td class="info-title">Адрес доставки:</td>{/if}
						<td class="info-text">{$item->address}</td>
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
						<td class="full">{if $item->payment == 'bill'}Выставить счет{elseif $item->payment == 'online'}Онлайн оплата{/if}</td>
						{if $item->payment == 'bill'}<td class="info-title">Плательщик:</td>{/if}
						<td class="info-text">{$item->bill}</td>
						<td class="last"></td>
					</tr>
					<tr class="empty"><td colspan="5"></td></tr>
				</table>
			</div>
		</div>
		<form class="default" action="" method="post">
			<input type="hidden" value="1" name="save">
			<div class="basket-button">
				<a class="back-button" href="{$path_prefix}">к списку заказов</a>
				{if $item->status->id != 3 && $item->status->id != 5 && $item->status->id != 6}<a href="{$path_prefix}/pay/{$item->id}" class="button">{if $item->payment == 'bill'}Выставить счет{elseif $item->payment == 'online'}Оплатить{/if}</a>{/if}
			</div>
			<div class="clear">&nbsp;</div>
		</form>
	{elseif $state == 'success'}
		<h1><span>Оплата</span> заказа</h1>
		<div class="subtitle-block">
			<h2><div class="vmiddle">Заказ №{$item->date|date_format:'%Y-%m-%d'}/{$item->num}</div></h2>
			<div class="clear"></div>
		</div>
		<div class="order-total">
			<table>
				<tr>
					<td class="total">
						<p>Общая стоимость: <span>{$item->fullsumm}</span> р.</p>
						<p>Скидка: <span>{$item->salesumm}</span> р.</p>
						{if $item->deliverysumm}<p>Доставка: <span>{$item->deliverysumm}</span> р.</p>{/if}
					</td>
					<td class="topay">
						Сумма к оплате: <span>{$item->summ}</span> р.
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
			<h2><div class="vmiddle">Заказ №{$item->date|date_format:'%Y-%m-%d'}/{$item->num}</div></h2>
			<div class="clear"></div>
		</div>
		<div class="order-total">
			<table>
				<tr>
					<td class="total">
						<p>Общая стоимость: <span>{$item->fullsumm}</span> р.</p>
						<p>Скидка: <span>{$item->salesumm}</span> р.</p>
						{if $item->deliverysumm}<p>Доставка: <span>{$item->deliverysumm}</span> р.</p>{/if}
					</td>
					<td class="topay">
						Сумма к оплате: <span>{$item->summ}</span> р.
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
<div class="clear"></div>
</div>
</div>
