<html>
	<head><title>{$subject}</title></head>
	<body>
		<h3>{$subject}</h3>
		<p><strong>Название мероприятия</strong>: {$order->event->title}</p>
		<p><strong>Даты проведения мероприятия</strong>: {$order->event->date|date_format:'%d.%m.%Y'}{if $order->event->dateEnd}-{$order->event->dateEnd|date_format:'%d.%m.%Y'}{/if}</p>
		<p><strong>Пользователь</strong>: {$order->user->title}</p>
		{if $order->payway}<p><strong>Способ оплаты</strong>: {$order->payway->title}</p>{/if}
		<p><strong>Дата регистрации</strong>: {$order->date|date_format:'%d.%m.%Y'}</p>
		<p><strong>Статус заявки</strong>: {$order->status->title}</p>
	</body>
</html>