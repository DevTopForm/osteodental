{*<div class="center cabinet_page">*}
{*	{if $state=='recovery'}*}
{*	<h1>Восстановление пароля</h1>*}
{*	{if !empty($errors) && $errors|@count > 0}*}
{*		<div class="messages">*}
{*			{foreach from=$errors item='message'}*}
{*				{$message->html}*}
{*			{/foreach}*}
{*		</div>*}
{*	{/if}*}
{*	<div class="feedback_wide_block open">*}
{*		<div class="feedback">*}
{*			<form action="" method="post" enctype="multipart/form-data">*}
{*				<input class="text first" type="text" name="email" value="{$user->name|strip_tags|escape}" placeholder="Введите e-mail адрес, который Вы указали при регистрации"/>*}
{*				<img class="captcha" src="/common/htdocs/captcha?{$smarty.now}&key=recovery" onclick="this.src='/common/htdocs/captcha?'+Math.random()+'&key=recovery'"/>*}
{*				<input class="text captcha" type="text" name="captcha" value="" placeholder="Введите число на рисунке"/><br/>*}
{*				<div class="clear"></div>*}
{*				<input class="button" type="submit" name="save" value="Восстановить" />*}
{*				<div class="clear"></div>*}
{*			</form>*}
{*		</div>*}
{*	</div>*}
{*	{elseif $state=='sended'}*}
{*		<h1>Восстановление пароля</h1>*}
{*		<p>На E-mail, указанный Вами, отправлено письмо с дальнейшими иснтрукциями по восстановлению пароля. Следуйте за белым кроликом, и вскоре получите новый, с иголочки, пароль.</p>*}
{*		<p>Если Вы по какой-то причине не получили письмо, можете попробовать восстановить пароль еще раз либо напишите нам на адрес {mailto address=$params.email encode='javascript'}</p>*}
{*	{elseif $state=='success'}*}
{*		<h1>Восстановление пароля</h1>*}
{*		<p>Новый пароль был успешно сгенерирован, и информация, необходимая для доступа к нам на сайт, отправлена на Ваш e-mail.</p>*}
{*		<p>Если Вы по какой-то причине не получили письмо, пожалуйста напишите нам на адрес {mailto address=$params.email encode='javascript'}</p>*}
{*	{elseif $state=='confirm'}*}
{*		<h1>Восстановление пароля</h1>*}
{*		{if !empty($errors) && $errors|@count > 0}*}
{*			<div class="messages">*}
{*				{foreach from=$errors item='message'}*}
{*					{$message->html}*}
{*				{/foreach}*}
{*			</div>*}
{*		{/if}*}
{*		<div class="feedback_wide_block open">*}
{*			<div class="feedback">*}
{*				<form action="" method="get" enctype="multipart/form-data">*}
{*					<input class="text first" type="text" name="token" value="" placeholder="ВВведите код подтверждения"/>*}
{*					<input class="button" type="submit" name="save" value="Отправить" />*}
{*					<div class="clear"></div>*}
{*				</form>*}
{*			</div>*}
{*		</div>*}
{*	{/if}*}
{*</div>*}


{if $state=='recovery'}
    <div class="personal-enter__top mb30">
        <h1 class="h2">Забыли свой пароль? Укажите свой Email или имя пользователя. Ссылку на создание нового пароля
            вы получите по электронной почте.</h1>
    </div>

    <form  enctype="multipart/form-data" class="form personal-enter__form" method="post">
        <label class="label">
            <input type="text" class="input label__input" name="email" autocomplete="email" required="" aria-required="true">
            <span class="label__name">Имя пользователя или E-mail</span>
        </label>

        <div class="personal-enter__agreed">
            <button type="submit" class="btn btn--black btn--st order__btn" name="save" value="Сброс пароля">
                Сброс пароля
            </button>
        </div>
    </form>
{elseif $state=='sended'}
    <div class="personal-enter__top mb30">
        <h1 class="h2">На E-mail, указанный Вами, отправлено письмо с дальнейшими иснтрукциями по восстановлению пароля. Следуйте за белым кроликом, и вскоре получите новый, с иголочки, пароль.</h1>
    </div>
{elseif $state=='success'}
    <div class="personal-enter__top mb30">
        <h1 class="h2">Новый пароль был успешно сгенерирован, и информация, необходимая для доступа к нам на сайт, отправлена на Ваш e-mail.</h1>
    </div>
    <div class="personal-enter__form">
        <div>
            Если Вы по какой-то причине не получили письмо, пожалуйста напишите нам на адрес {mailto address=$params.email encode='javascript'}
        </div>
    </div>
{/if}
