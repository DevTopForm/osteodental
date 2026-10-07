<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251"/>
		<title>Регистрация на мероприятние «{$order->event->title}»</title>
	</head>
	<body>
		<h3>Уважаемый(ая) {$user->lastname} {$user->firstname}!</h3>	
		<p>Поздравляем! Вы зарегистрировались на сайте {$site}.</p>
		<p>Чтобы активировать аккаунт и подтвердить регистрацию на мероприятие «{$order->event->title}» пройдите по ссылке: <a href="{$confirm_url}">{$confirm_url}</a></p>
	</body>
</html>
