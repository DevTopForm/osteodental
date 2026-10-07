<html>
<head><title>{$subject}</title></head>
<body>
    <h3>{$subject}</h3>
    <p>Здравствуйте, {$user->firstname}!</p>
    <p>Вы успешно зарегистрировались на сайте <a href="https://{$smarty.server.SERVER_NAME}">{$smarty.server.SERVER_NAME}</a> при оформлении заказа.</p>
    <p>Данные для входа в личный кабинет:</p>
    <p><strong>Логин (Email)</strong>: {$user->email}</p>
    <p><strong>Пароль</strong>: {$password}</p>
    <p>Вы можете войти в личный кабинет по ссылке: <a href="https://{$smarty.server.SERVER_NAME}/cabinet/">https://{$smarty.server.SERVER_NAME}/cabinet/</a></p>
    <p>С уважением, администрация сайта.</p>
</body>
</html>