{*<div class="bg_blue">*}
{*	<div class="center">*}
{*		<div class="manager_info">*}
{*			<div class="manager_img" style="background-image:url({if $user->image->id}{$user->image->getLink('thumb')}{else}/common/htdocs/images/profile_noimg.png{/if});"></div>*}
{*			<div class="manager_title"><br/>{$user->lastname} {$user->firstname}</div>*}
{*		</div>*}
{*		{if $user->sale}*}
{*			<div class="manager_skype" style="padding-top:17px;">*}
{*				<div class="cabinet_sale">Ваша Скидка: <span>{$user->sale}%</span></div>*}
{*			</div>*}
{*		{/if}*}
{*	</div>*}
{*</div>*}

{*<div class="center cabinet_page">*}
{*	<h1>Личные данные</h1>*}
{*	{if $state=='view'}*}
{*		<div class="user-info clearfix">*}
{*			<table>*}
{*				{if $user->organisation}*}
{*				<tr>*}
{*					<td><span>Организация:</span></td>*}
{*					<td>{$user->organisation}</td>*}
{*				</tr>*}
{*				{/if}*}
{*				{if $user->phone}*}
{*				<tr>*}
{*					<td><span>Телефон:</span></td>*}
{*					<td>{$user->phone}</td>*}
{*				</tr>*}
{*				{/if}*}
{*				{if $user->cellphone}*}
{*				<tr>*}
{*					<td><span>Моб. телефон:</span></td>*}
{*					<td>{$user->cellphone}</td>*}
{*				</tr>*}
{*				{/if}*}
{*				{if $user->email}*}
{*				<tr>*}
{*					<td><span>Электронная почта:</span></td>*}
{*					<td><a href="mailto:{$user->email}">{$user->email}</a></td>*}
{*				</tr>*}
{*				{/if}*}
{*				{if $user->address}*}
{*				<tr>*}
{*					<td><span>Адрес:</span></td>*}
{*					<td>{$user->address}</td>*}
{*				</tr>*}
{*				{/if}*}
{*			</table>*}
{*			<a class="edit_profile" href="{$path_prefix}/edit">Редактировать данные</a>*}
{*		</div>*}
{*		<h2 style="color: #00b4cc;font-size: 24px;line-height: 24px;margin-bottom: 40px;margin-top: 40px;padding-left: 30px;">История заказов</h2>*}
{*		<div class="basket_page">*}
{*			<table class="basket_table">*}
{*				<tr>*}
{*					<th>Номер заказа</th>*}
{*					<th class="date">Дата</th>*}
{*					<th class="status">Статус</th>*}
{*					<th class="summ">Стоимость</th>*}
{*					<th>Повторить заказ</th>*}
{*				</tr>*}
{*				{if $orders|@count > 0}*}
{*					{foreach from=$orders item="item"}*}
{*						<tr>*}
{*							<td><a href="/cabinet/orders/view/{$item->id}">{$item->date|date_format:'%Y-%m-%d'}/{$item->id}</a></td>*}
{*							<td>{$item->date|date_format:'%d %_M %Y'}</td>*}
{*							<td>{$item->status->title}</td>*}
{*							<td>{$item->totalSumm} р.</td>*}
{*							<td><a class="repeat-order-ajax" href="/basket/repeat?order={$item->id}">Повторить заказ</a></td>*}
{*						</tr>*}
{*					{/foreach}*}
{*				{else}*}
{*				<tr>*}
{*					<td colspan="4">Вы не оформили ни одного заказа</td>*}
{*				</tr>*}
{*				{/if}*}
{*			</table>*}
{*		</div>*}
{*	{elseif $state=='edit'}*}
{*		{if !empty($errors) && $errors|@count > 0}*}
{*			<div class="messages">*}
{*				{foreach from=$errors item='message'}*}
{*					{$message->html}*}
{*				{/foreach}*}
{*			</div>*}
{*		{/if}*}
{*		<div class="feedback_wide_block open">*}
{*			<div class="feedback">*}
{*				<form action="" method="post" enctype="multipart/form-data">*}
{*					<input class="text first" type="text" name="email" value="{$user->email|strip_tags|escape}" placeholder="Электронная почта"/>*}
{*					<input class="text first" type="text" name="firstname" value="{$user->firstname|strip_tags|escape}" placeholder="Ваше имя"/>*}
{*					<input class="text first" type="text" name="lastname" value="{$user->lastname|strip_tags|escape}" placeholder="Фамилия"/>*}
{*					<input class="text first" type="text" name="phone" value="{$user->phone|strip_tags|escape}" placeholder="Телефон"/>*}
{*					<input class="text first" type="text" name="cellphone" value="{$user->cellphone|strip_tags|escape}" placeholder="Моб. Телефон"/>*}
{*					<input class="text wide" type="text" name="organisation" value="{$user->organisation|strip_tags|escape}" placeholder="Организация"/>*}
{*					<input class="text wide"  type="text" name="address" value="{$user->address|strip_tags|escape}" placeholder="Адрес"/>*}

{*					{if $user->image->id}*}
{*						<br/><br/>*}
{*						<p>ФОТОГРАФИЯ</p>*}
{*						<div><img src="{$user->image->getLink('thumb')}" alt=""/></div><br/>*}
{*						<p style="margin-bottom:5px;font-size:12px;">Заменить:</p>*}
{*						<input style="border: 1px solid #00B4CC;margin-left:0px;" class="wide file" type="file" name="image"/>*}
{*					{else}*}
{*						<p>Фотография</p>*}
{*						<input style="border: 1px solid #00B4CC;margin-left:0px;" class="wide file" type="file" name="image"/>*}
{*					{/if}*}

{*					<br/><br/>*}
{*					<p>Сменить пароль:</p>*}
{*					{if !$user->social_type}*}
{*						<input class="text first" type="password" name="pass" autocomplete="off" placeholder="Новый пароль"/>*}
{*						<input class="text first" type="password" name="pass_2" autocomplete="off" placeholder="Повторите пароль"/>*}
{*					{/if}*}
{*					<br/><input class="button" type="submit" name="save" value="Сохранить"/>*}
{*				</form>*}
{*			</div>*}
{*		</div>*}
{*	{/if}*}
{*</div>*}

<div class="personal-form ">

    {if $errors}
        {foreach from=$errors item='error' name='errors'}
            {$error->html}
        {/foreach}
    {/if}

    {if $message}
        {$message}
    {/if}
    <form method="post" action="{$path_prefix}" enctype="multipart/form-data"  class="form order mb40-120">
        <input type="hidden" name="save" value="1">

        <div class="h2 order__h2">Контактные данные</div>
        <div class="order__fieldset mb30">
            <label class="label">
                <input type="text" class="input label__input" name="fio" value="{$user->getName()}" placeholder="">
                <span class="label__name">ФИО</span>
            </label>
            <label class="label">
                <input type="tel" class="input label__input" name="phone" value="{if $user->phone}{$user->phone}{/if}" placeholder="">
                <span class="label__name">Контактный телефон</span>
            </label>
            <label class="label">
                <input type="email" class="input label__input" name="email" value="{if $user->email}{$user->email}{/if}" placeholder="">
                <span class="label__name">E-mail</span>
            </label>
            <label class="label">
                <input type="text" class="input label__input" name="instagramm_login" value="{if $user->instagramm_login}{$user->instagramm_login}{/if}" placeholder="">
                <span class="label__name">Ваш логин в instagram</span>
            </label>
        </div>
        <div class="order__agreed">
            <div></div>
            <button type="submit" name="action" value="main" class="btn btn--gray btn--st order__btn">Сохранить</button>
        </div>
    </form>
    <form method="post" action="{$path_prefix}" enctype="multipart/form-data" class="form order">
        <input type="hidden" name="save" value="1">
        <div class="h2 order__h2">Данные доступа</div>
        <div class="order__fieldset mb30">
            <label class="label">
                <input type="password" class="input label__input" name="pass" value="" placeholder="">
                <span class="label__name">Новый пароль</span>
            </label>
            <label class="label">
                <input type="password" class="input label__input" name="pass_2" value="" placeholder="">
                <span class="label__name">Повторите пароль</span>
            </label>
        </div>
        <div class="order__agreed">
            <div></div>
            <button name="action" value="password" type="submit" class="btn btn--gray btn--st order__btn">Сохранить</button>
        </div>
    </form>
</div>