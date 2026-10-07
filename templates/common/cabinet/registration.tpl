<div class="center cabinet_page">
	{if $state=='register'}
	<form action="" method="post" enctype="multipart/form-data" autocomplete="off">
		<h1>Регистрация нового пользователя</h1>
		<div class="feedback_wide_block open">
			<div class="feedback">
				{*<label>Вход через соц.сеть</label>
				<a href="/cabinet/login/vk?frompage=/cabinet"><img src="/common/htdocs/images/icons/vk.png"></a>
				<a href="/cabinet/login/fb?frompage=/cabinet"><img src="/common/htdocs/images/icons/fb.png"></a>
				<a href="/cabinet/login/ok?frompage=/cabinet"><img src="/common/htdocs/images/icons/ok.png"></a>
				<br/><br/>*}
				{if !empty($errors) && $errors|@count > 0}
					<div class="messages">
						{foreach from=$errors item='message'}
							{$message->html}
						{/foreach}
					</div>
				{/if}
				<div><span class="required">*</span> - <span class="example">Поля, обязательные для заполнения</span></div>
				<input class="text first" type="text" name="lastname" value="{$user->lastname|strip_tags|escape}" placeholder="Фамилия*"/>
				<input class="text first" type="text" name="firstname" value="{$user->firstname|strip_tags|escape}" placeholder="Ваше имя*"/>
				<input class="text first" type="text" name="middlename" value="{$user->middlename|strip_tags|escape}" placeholder="Отчество*"/>
				<input class="text first" type="text" name="email" value="{$user->email|strip_tags|escape}" placeholder="Электронная почта*"/>
				<input class="text first" type="password" name="pass" value="" placeholder="Пароль*"/>
				<input class="text first" type="password" name="pass_2" value="" placeholder="Повторите пароль*"/><br/>
				<img class="captcha" style="margin-right: 10px;" onclick="this.src='/common/htdocs/captcha?'+Math.random()+'&key=register'" src="/common/htdocs/captcha?{$smarty.now}&key=register">
				<input class="text captcha" type="text" value="" name="captcha" placeholder="Введите число на рисунке"><br/>
				<a class="save button" href="#">Зарегистрироваться</a>
				<div class="clear"></div>
			</div>
		</div>
	</form>
	{elseif $state=='success'}
		<h1>Регистрация</h1>
		<p>На E-mail, указанный при регистрации отправлено письмо с параметрами учетной записи. Для активации аккаунта пройдите по ссылке, указанной в письме</p>
		<p>Если Вы по какой-то причине не получили письмо, пожалуйста напишите нам на адрес {mailto address=$params.email encode='javascript'}</p>
	{elseif $state=='confirm'}
		<h1>Активация учетной записи</h1>
		{if !empty($errors) && $errors|@count > 0}
			<div class="messages">
				{foreach from=$errors item='message'}
					{$message->html}
				{/foreach}
			</div>
		{/if}
		<div class="feedback_wide_block open">
			<div class="feedback">
				<form action="" method="get">
					<input class="text first" type="text" name="token" value="" placeholder="Введите код подтверждения"/><br/>
					<input class="button" type="submit" name="save" value="отправить" />
				</form>
			</div>
		</div>
	{/if}
</div>
