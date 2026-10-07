<table style="border: 2px solid #7278B8; border-collapse: collapse; font-family: Tahoma, Verdana, Arial; font-size: 12px;">
	<tr>
		<td style="width: 30%;padding: 10px;"><a href="http://{$smarty.server.HTTP_HOST}/"><img src="/common/htdocs/images/logo.png"/></a></td>
		<td style="padding: 30px 10px 10px; vertical-align: top; font-size: 14px;" rowspan="2">
			<h2 style="text-align: center; color: #7278B8; padding-bottom: 25px;">Пригласительный билет</h2>
			<p>&nbsp;</p>
			<h3 style="padding-bottom: 25px;">Уважаемый(ая): {$user->lastname} {$user->firstname} {$user->middlename}!</h3>
			<p>&nbsp;</p>
			<p>Приглашаем Вас на семинар:</p>
			<p><a style="font-weight: bold; color: #7278B8;" href="http://{$smarty.server.HTTP_HOST}{$event->url}">{$event->title}</a></p>
			<p>&nbsp;</p>
			<p><strong>Даты и время проведения:</strong> {$event->date|date_format:"%d %_M %Y"}{if $event->date_end} - $event->date_end|date_format:"%d %_M %Y"{/if}{if $event->time}, {$event->time}{/if}</p>
			<p>&nbsp;</p>
			{if $event->lektor|@count>0}
				<p><strong>Лектор:</strong>
				{foreach from=$event->lektor item=lektor name=lektors}
					<a href="http://{$smarty.server.HTTP_HOST}{$lektor->url}" style="color: #7278B8;" >{$lektor->title}</a>{if !$smarty.foreach.lektors.last}, {/if}
				{/foreach}
				</p>
				<p>&nbsp;</p>
			{/if}
			{if $event->place->id}
			<p><strong>Место проведения:</strong> {$event->place->title}, {$event->place->address}</p>
			<p>&nbsp;</p>
			{/if}
			<p><strong>Ваш регистрационный номер:</strong> {$order->id}</p>
			<p>&nbsp;</p>
			{if $order->status->id != 2 && $event->sendreg}
			<p>Билет действителен при оплате счета. В течение 2 дней на вашу почту будет отправлен счет на оплату</p>
			<p>&nbsp;</p>
			{/if}
			<p>Для участия в мероприятии распечатайте электронный билет и возьмите с собой на мероприятие</p>
			<p>&nbsp;</p>
			<p>Остались вопросы? звоните (812)703-3834 в ЦПР АСКОН.</p>
		</td>
	</tr>
	<tr>
		<td style="padding: 10px;">
			<img src="{$qr}"/>
		</td>
	</tr>
</table>