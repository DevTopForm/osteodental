{if $state=='register'}
<h1 class="title" id="eventreg">Регистрация на мероприятие</h1>
<div class="article">
	<div class="seminar_main_info list">
		<div class="date">
			{if $event->period_samemonth}
				<p class="day"><span>{$event->date|date_format:'%d'}<span>&mdash;{$event->date_end|date_format:'%d'}</span></span>{$event->date|date_format:'%_M %Y'}</p>
			{elseif $event->period_twomonths}
				<p class="day"><span>{$event->date|date_format:'%d'}<span>&mdash;{$event->date_end|date_format:'%d'}</span></span><span class="second-month">{$event->date_end|date_format:'%_M'}</span>{$event->date|date_format:'%_M'}
				<br class="clear"/>{$event->date|date_format:'%Y'}
				</p>
			{else}
			<p class="day">{$event->date|date_format:'<span>%d</span>%_M %Y (%_FD)'}</p>
			{/if}
			{if $event->time}<p class="day">{$event->time}</p>{/if}
			<!-- <a class="icon_calendar" href="#">Напомнить мне</a> -->
		</div>
		<div class="info_list radius-right">
			<p class="type">{$event->type->title}</p>
			<a class="title" href="{$event->url}">{$event->fulltitle}</a>
			<div class="small_info">
				{if $event->lektor|@count > 0}
				<div class="lektor">
					{foreach from=$event->lektor item=lektor}
					<div class="lektor-item">
						{if $lektor->image}<a href="{$lektor->url}"><img src="{$lektor->image->getLink('thumb')}" alt="" /></a>{/if}
						<p>Лектор: <a class="name" href="{$lektor->url}">{$lektor->title|br_first_word}</a></p>
						<div class="clear"></div>
					</div>
					{/foreach}
				</div>
				{/if}
				<div class="cena">
					<p>Стоимость <span class="name">{if $event->price}{$event->price} руб{else}Бесплатно{/if}</span></p>
				</div>
				{if $event->labels|@count > 0}
				<div class="block_icons">
					{foreach from=$event->labels item=label}
						{if $label->image}<span style="background-image: url('{$label->image->getLink('icon')}')" title="{$label->title}"></span>{/if}
					{/foreach}
				</div>
				{/if}
				{include file="module/event/share.tpl" item=$item}
				<div class="clear"></div>
			</div>
		</div>
		<a class="readmore" href="{$event->url}"><span>Подробнее</span></a>
		{if $event->sale}<div class="marker_label sale"></div>
		{elseif $event->vip}<div class="marker_label vip"></div>
		{elseif $event->hit}<div class="marker_label hit"></div>
		{elseif $event->novelty}<div class="marker_label novelty"></div>
		{/if}
	</div>
	<div class="clear"></div>
	<div class="registration-content" >	
		{if $event->employee && !$user->employee}
			<div class="form-block">
				<p>К сожалению, Вы не можете зарегистрироваться на это мероприятие. Данное мероприятие проводится только для сотрудников Центра профессионального развития «Аскон»</p>
			</div>
		{else}
		<form action="#eventreg" method="post" enctype="multipart/form-data" autocomplete="off">
			<div class="form-block">
				{if !$user->id}
					<p>На Ваше имя будет создан новый аккаунт на нашем сайте. Если у Вас уже есть аккаунт, пожалуйста, <a href="/cabinet/?from=/cabinet/eventreg/{$event->id}">авторизуйтесь</a></p>
				{/if}
				{if !empty($errors) && $errors|@count > 0}
					<div class="messages">
						{foreach from=$errors item='message'}
							{$message->html}
						{/foreach}
					</div>
				{/if}
				<div class="registration-form">
					<fieldset>
						<label></label>
						<div class="field">
							<span class="required">*</span> - <span class="example">Поля, обязательные для заполнения</span>
						</div>
					</fieldset>
					<fieldset>
						<label>Фамилия:<span class="required">*</span></label>
						<div class="field">
							<input type="text" name="lastname" value="{$user->lastname|escape}"/>
						</div>
					</fieldset>
					<fieldset>
						<label>Имя:<span class="required">*</span></label>
						<div class="field">
							<input type="text" name="firstname" value="{$user->firstname|escape}"/>
						</div>
					</fieldset>
					<fieldset>
						<label>Отчество:<span class="required">*</span></label>
						<div class="field">
							<input type="text" name="middlename" value="{$user->middlename|escape}"/>
						</div>
					</fieldset>
					{if !$user->id}
					<fieldset>
						<label>Телефон:<span class="required">*</span></label>
						<div class="field">
							<input type="text" name="phone" value="{$user->phone|escape}"/>
						</div>
					</fieldset>
					<fieldset>
						<label>E-mail:<span class="required">*</span></label>
						<div class="field">
							<input type="text" name="email" value="{$user->email|escape}"/>
						</div>
					</fieldset>
					<fieldset>
						<label>Пароль:<span class="required">*</span></label>
						<div class="field">
							<input type="password" name="pass" value=""/>
							<span class="example">Придумайте свой пароль. При помощи e-mail и пароля Вы получите доступ в личный кабинет на нашем сайте. Пароль должен содержать 4 и более символов</span>
						</div>
					</fieldset>
					<fieldset>
						<label>Повторите пароль:<span class="required">*</span></label>
						<div class="field">
							<input type="password" name="pass_2" value=""/>
						</div>
					</fieldset>
					{else}
						{if !$user->phone}
						<fieldset>
							<label>Телефон:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="phone" value="{$user->phone|escape}"/>
							</div>
						</fieldset>
						{/if}
						{if !$user->email}
						<fieldset>
							<label>E-mail:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="email" value="{$user->email|escape}"/>
							</div>
						</fieldset>
						{/if}
					{/if}
					{if $event->price > 0}
					<fieldset>
						<label>Способ оплаты:<span class="required">*</span></label>
						<div class="field">
							<select name="payway">
								<option value="">Не выбран</option>
								<option value="cash" {if $order->payway == 'cash'}selected="selected"{/if}>Наличными</option>
								<option value="beznal_fiz" {if $order->payway == 'beznal_fiz'}selected="selected"{/if}>Безналичный - Физическое лицо</option>
								<option value="beznal_law" {if $order->payway == 'beznal_law'}selected="selected"{/if}>Безналичный - Юридическое лицо</option>
								<option value="abonement" {if $order->payway == 'abonement'}selected="selected"{/if}>Абонемент</option>
								<option value="invite" {if $order->payway == 'invite'}selected="selected"{/if}>Приглашение</option>
								{if $event->promo}
								<option value="promo" {if $order->payway == 'promo'}selected="selected"{/if}>Промо-код</option>
								{/if}
							</select>
						</div>
					</fieldset>
					<div class="payway-block payway-abonement field-block">
						<fieldset>
							<label>Номер абонемента:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="abonement_num" value="{$order->abonement_num|escape}"/>
							</div>
						</fieldset>
					</div>
					<div class="payway-block payway-invite field-block">
						<fieldset>
							<label>Номер приглашения:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="invite_num" value="{$order->invite_num|escape}"/>
							</div>
						</fieldset>
					</div>
					{if $event->promo}
					<div class="payway-block payway-promo field-block">
						<fieldset>
							<label>Промо-код:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="promo_num" value="{$order->promo_num|escape}"/>
							</div>
						</fieldset>
					</div>
					{/if}
					<div class="payway-block payway-cash payway-beznal_fiz payway-beznal_law field-block">
						<fieldset>
							<label>Номер дисконтной карты, если есть:</label>
							<div class="field">
								<input type="text" name="card" value="{$user->card|escape}"/>
							</div>
						</fieldset>
					</div>
					<div class="payway-block payway-beznal_fiz field-block">
						<label class="title">Данные паспорта</label>
						<fieldset>
							<label>Серия:<span class="required">*</span></label>
							<div class="field small-field">
								<input type="text" name="passport_serie" value="{$user->passport_serie|escape}"/>
							</div>
							<label class="small">Номер:<span class="required">*</span></label>
							<div class="field medium-field">
								<input type="text" name="passport_num" value="{$user->passport_num|escape}"/>
							</div>
							<label class="small">Выдан:<span class="required">*</span></label>
							<div class="field medium-field">
								<input class="date" type="text" name="passport_when" value="{if $user->passport_when > 0}{$user->passport_when|date_format:'%d.%m.%Y'}{/if}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Кем выдан:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="passport_where" value="{$user->passport_where|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Адрес регистрации:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="passport_address" value="{$user->passport_address|escape}"/>
							</div>
						</fieldset>
					</div>
					<div class="payway-block payway-beznal_law field-block">
						<label class="title">Реквизиты</label>
						<fieldset>
							<label>Название компании:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="company" value="{$user->company|escape}"/>
								<span class="example">Полное наименование организации с указанием формы собственности</span>
							</div>
						</fieldset>
						<fieldset>
							<label>Грузополучатель:</label>
							<div class="field">
								<input type="text" name="productgetter" value="{$user->productgetter|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>ИНН:</label>
							<div class="field half-field">
								<input type="text" name="inn" value="{$user->inn|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>КПП:</label>
							<div class="field half-field">
								<input type="text" name="kpp" value="{$user->kpp|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Юридический адрес:</label>
							<div class="field">
								<input type="text" name="law_address" value="{$user->law_address|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Фактический адрес:</label>
							<div class="field">
								<input type="text" name="fact_address" value="{$user->fact_address|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>БИК:</label>
							<div class="field half-field">
								<input type="text" name="bik" value="{$user->bik|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Корреспондентский счет:</label>
							<div class="field half-field">
								<input type="text" name="ks" value="{$user->ks|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Расчетный счет:</label>
							<div class="field half-field">
								<input type="text" name="rs" value="{$user->rs|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Наименование банка:</label>
							<div class="field">
								<input type="text" name="bank" value="{$user->bank|escape}"/>
							</div>
						</fieldset>
					</div>
					{elseif $event->promo}
					<div class="field-block">
						<fieldset>
							<label>Промо-код:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="promo_num" value="{$order->promo_num|escape}"/>
							</div>
						</fieldset>
					</div>
					{/if}
					{if $event->certificate}
					<div class="field-block">
						<label class="title">Дополнительные данные для выдачи сертификатов проф. бухгалтеров</label>
						<fieldset>
							<label>Членом какой организации Вы являетесь?<span class="error">*</span></label>
							<input id="org_type1" type="radio" name="org_type" value="" class="styled" {if !$user->org_type}checked="checked"{/if}/><label for="org_type1" class="radiolabel">Не являюсь</label>
							<input id="org_type2" type="radio" name="org_type" value="ИПБ" class="styled" {if $user->org_type == 'ИПБ'}checked="checked"{/if}/><label for="org_type2" class="radiolabel">ИПБ</label>
							<input id="org_type3" type="radio" name="org_type" value="ППБА" class="styled" {if $order->from == 'ППБА'}checked="checked"{/if}/><label for="org_type3" class="radiolabel">ППБА</label>
							<div class="clear"></div>
						</fieldset>
						<div class="org_type">
							<fieldset>
								<label>№ членского билета:<span class="required">*</span></label>
								<div class="field">
									<input type="text" name="bilet_num" value="{$user->bilet_num|escape}"/>
								</div>
							</fieldset>
							<fieldset>
								<label>№ аттестата/диплома проф. бухгалтера:</label>
								<div class="field">
									<input type="text" name="diplom_num" value="{$user->diplom_num|escape}"/>
								</div>
							</fieldset>
							<fieldset>
								<label>Дата оплаты членского взноса:</label>
								<div class="field medium-field">
									<input class="date" type="text" name="vznos_date" value="{if $user->vznos_date > 0}{$user->vznos_date|date_format:'%d.%m.%Y'}{/if}"/>
								</div>
							</fieldset>
							<fieldset>
								<label>№ платежного документа оплаты членского взноса:</label>
								<div class="field">
									<input type="text" name="vznos_doc_num" value="{$user->vznos_doc_num|escape}"/>
								</div>
							</fieldset>
						</div>
					{/if}
					{if $event->foreign}
					<div class="field-block">
						<label class="title">Данные заграничного паспорта</label>
						<fieldset>
							<label>Фамилия:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="zagran_lastname" value="{$user->zagran_lastname|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Имя:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="zagran_firstname" value="{$user->zagran_firstname|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Серия:<span class="required">*</span></label>
							<div class="field small-field">
								<input type="text" name="zagran_serie" value="{$user->zagran_serie|escape}"/>
							</div>
							<label class="small">Номер:<span class="required">*</span></label>
							<div class="field medium-field">
								<input type="text" name="zagran_num" value="{$user->zagran_num|escape}"/>
							</div>
							<div class="clear"></div>
						</fieldset>
						<fieldset>
							<label>Выдан:<span class="required">*</span></label>
							<div class="field medium-field">
								<input class="date" type="text" name="zagran_when" value="{if $user->zagran_when > 0}{$user->zagran_when|date_format:'%d.%m.%Y'}{/if}"/>
							</div>
							<label class="small">Годен до:<span class="required">*</span></label>
							<div class="field medium-field">
								<input class="date" type="text" name="zagran_till" value="{if $user->zagran_till > 0}{$user->zagran_till|date_format:'%d.%m.%Y'}{/if}"/>
							</div>
							<div class="clear"></div>
						</fieldset>
						<fieldset>
							<label>Страна, выдавшая визу:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="visa_country" value="{$user->visa_country|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Наименование страховщика:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="safe_title" value="{$user->safe_title|escape}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Срок действия страховки до:<span class="required">*</span></label>
							<div class="field medium-field">
								<input class="date" type="text" name="safe_till" value="{if $user->safe_till > 0}{$user->safe_till|date_format:'%d.%m.%Y'}{/if}"/>
							</div>
						</fieldset>
						<fieldset>
							<label>Территория страхового покрытия:<span class="required">*</span></label>
							<div class="field">
								<input type="text" name="safe_place" value="{$user->safe_place|escape}"/>
							</div>
						</fieldset>
					</div>
					{/if}
					<div class="field-block">
						<fieldset>
							<label>Откуда Вы узнали о семинаре?<span class="error">*</span></label>
							<input id="from1" type="radio" name="from" value="Из интернета" class="styled" {if $order->from == 'Из интернета' || !$order->from}checked="checked"{/if}/><label for="from1" class="radiolabel">Из интернета</label>
							<input id="from2" type="radio" name="from" value="От специалиста Аскон" class="styled" {if $order->from == 'От специалиста Аскон'}checked="checked"{/if}/><label for="from2" class="radiolabel">От специалиста Аскон</label>
							<input id="from3" type="radio" name="from" value="От знакомых (коллег)" class="styled" {if $order->from == 'От знакомых (коллег)'}checked="checked"{/if}/><label for="from3" class="radiolabel">От знакомых (коллег)</label>
							<div class="clear"></div>
							<label id="label_from1" class="from-labels">На каком ресурсе?</label>
							<label id="label_from2" class="from-labels">Укажите Ф.И.О. менеджера</label>
							<label id="label_from3" class="from-labels">Укажите название компании, Ф.И.О. и телефон коллеги</label>
							<div class="field">
								<input type="text" name="from_comment" value="{$order->from_comment|escape}"/>
							</div>
						</fieldset>
						{if !$user->id}
						<fieldset>
							<label>Являетесь ли Вы клиентом ИПЦ «Консультант+Аскон»?<span class="error">*</span></label>
							<input id="client1" type="radio" name="client" class="styled" value="1"/><label for="client1" class="radiolabel">Да</label>
							<input id="client2" type="radio" name="client" class="styled" value="0"/><label for="client2" class="radiolabel">Нет</label>
							<div class="clear"></div>
						</fieldset>
						<fieldset>
							<label></label>
							<div class="field">
								<input type="checkbox" name="subscribe" value="1" id="input-subscribe" {if $user->subscribe_checked}checked="checked"{/if} class="styled"/>
								<label for="input-subscribe">Я хочу получать уведомление на e-mail</label>
							</div>
						</fieldset>
						{/if}
						<fieldset>
							<label></label>
							<div class="field" style="width: auto;">
								<input type="checkbox" name="security" value="1" id="input-security" {if $user->security_checked}checked="checked"{/if} class="styled"/>
								<label for="input-security">С настоящими "<a href="/common/htdocs/upload/fm/personalnye_dannye.doc">Правилами предоставления и использования персональных данных</a>" ознакомлен</label>
							</div>
						</fieldset>
						<fieldset>
							<label>Введите проверочный код с картинки</label>
							<div class="field" style="">
								<img class="captcha" style="float: left; margin-right: 10px;" onclick="this.src='/common/htdocs/captcha?'+Math.random()+'&key=regevent'" src="/common/htdocs/captcha?{$smarty.now}&key=regevent">
								<input style="float: left; width: 200px;" class="captcha" type="text" value="" name="captcha">
								<div class="clear"></div>
							</div>
						</fieldset>
						
					</div>
				</div>
				<div class="clear"></div>
			</div>
			<div class="button-block">
				<a class="save button-save" href="#"><span>Зарегистрироваться</span></a>
			</div>
		</form>
		{/if}
		<div class="clear"></div>
	</div>
</div>
{elseif $state=='success'}
<h1 class="title">Регистрация на мероприятие</h1>
<div class="article">
	<div class="txt">
		<p>Поздравляем! Вы успешно зарегистрировались на мероприятие!</p>
		<div class="clear"></div>
	</div>
</div>
{elseif $state=='presaved'}
<h1 class="title">Регистрация на мероприятие</h1>
<div class="article">
	<div class="txt">
		<p>Для подтверждения регистрации на мероприятие необходимо пройти по ссылке, отправленной на указанный Вами E-mail</p>
		<p>Если Вы по какой-то причине не получили письмо, пожалуйста напишите нам на адрес {mailto address=$params.email encode='javascript'}</p>
		<div class="clear"></div>
	</div>
</div>
{elseif $state=='confirm'}
<h1 class="title">Подтверждение регистрации</h1>
<div class="article">
	<div class="txt">
		{if !empty($errors) && $errors|@count > 0}
		<div class="messages">
			{foreach from=$errors item='message'}
				{$message->html}
			{/foreach}
		</div>
		{/if}
		<div class="gray-block">
			<div class="gray-top"></div>
			<div class="gray-bg">
				<form action="" method="get" enctype="multipart/form-data">
					<table class="registration">
						<tr>
							<td class="label">Введите код подтверждения:</td>
							<td class="field"><input class="text" type="text" name="token" value=""/></td>
						</tr>
						<tr>
							<td></td>
							<td><input class="button" type="submit" name="save" value="отправить" /></td>
						</tr>
					</table>
					<div class="clear"></div>
				</form>
			</div>
			<div class="gray-bot"></div>
		</div>
		<div class="clear"></div>
	</div>
</div>
{/if}