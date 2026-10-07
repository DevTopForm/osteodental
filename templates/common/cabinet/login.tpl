{*<div class="center cabinet_page">*}
{*	<h1>Авторизация</h1>*}
{*	<p>Для доступа к этой странице Вам необходимо авторизоваться на сайте. Если у Вас уже есть аккаунт - введите ниже e-mail и пароль иначе - необходимо пройти процедуру <a href="{$cabinet_path}/register">регистрации</a> на сайте</p>*}
{*	{if $query.login_error}<p class="error">Неверно указан e-mail или пароль, или ваш аккаунт еще не активирован</p>{/if}*}

{*	<div class="feedback_wide_block open">*}
{*		<div class="feedback">*}
{*			<form action="{$cabinet_path}/login" method="post">*}
{*				<input class="text first" type="text" name="email_" value="{$email|strip_tags|escape}" placeholder="Логин (E-mail)"/><br/>*}
{*				<input class="text first" type="password" name="password_" value="" placeholder="Пароль"/><br/>*}
{*				*}{*<input  id="remember" class="styled" type="checkbox" name="remember" value="1"/><label for="remember">Запомнить меня</label>*}
{*				<a class="button button-save save" href="#"><span>Войти</span></a><br/>*}
{*				<a class="small-link register" href="{$cabinet_path}/register" >Регистрация</a>*}
{*				<a class="small-link recovery" href="{$cabinet_path}/recovery" >Забыли пароль?</a>*}
{*				<!--div class="social-auth">*}
{*					<p>Так же вы можете авторизироваться с помощью соц. сетей.</p>*}
{*					<a class="link vk first" href="http://oauth.vk.com/authorize?client_id={$params.auth.vk.id}&scope=&response_type=code&redirect_uri={$params.auth.vk.return}">ВКонтакте</a>*}
{*					<a class="link fb" href="https://www.facebook.com/dialog/oauth?client_id={$params.auth.fb.id}&response_type=code&redirect_uri={$params.auth.fb.return}">Facebook</a>*}
{*					<a class="link ok" href="http://www.odnoklassniki.ru/oauth/authorize?client_id={$params.auth.ok.id}&scope=&response_type=code&redirect_uri={$params.auth.ok.return}">Одноклассники</a>*}
{*				</div-->*}
{*				<div class="clear"></div>*}
{*			</form>*}
{*		</div>*}
{*	</div>*}
{*</div>*}


{if $error}
    <p style="color: red" class="error">{$error}</p>
{/if}
<div class="personal-enter__top mb30">
    <h1 class="h2">Мой аккаунт</h1>
    <a class="personal-enter__forgot" href="{$cabinet_path}/recovery">Забыли пароль?</a>
</div>
<form action="{$cabinet_path}/login" method="post" class="form personal-enter__form">
    <label class="label">
        <input type="text" class="input label__input" name="email_" value="" placeholder="">
        <span class="label__name">Имя пользователя или E-mail</span>
    </label>
    <label class="label">
        <input type="password" class="input label__input" name="password_" value="" placeholder="">
        <span class="label__name">Пароль</span>
    </label>
    <div class="personal-enter__agreed">
        <label class="check-label order__check">
            <input name="policy" class="check" type="checkbox" value="1">
            <span>Подтверждаю, что ознакомлен и согласен с Политикой конфиденциальности</span>
        </label>
        <button class="btn btn--black btn--st order__btn">Войти</button>
    </div>
</form>