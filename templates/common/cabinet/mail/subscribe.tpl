<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=Windows-1251"/>
		<title>Любая Работа. Вакансии, которые могут Вас заинтересовать</title>
	</head>
	<body style="font-family:'Trebuchet MS',Tahoma,Arial;font-size: 13px;">
		<div style="float: left; width: 210px;"><a href="http://{$site}"><img src="cid:logo_img" alt="" /></a></div>
		<div style="float: left; width: 390px;" >
			<h3 style="color: #0D409B;font-size: 24px;">Уважаемый {$user->lastname} {$user->firstname} {$user->middlename}!</h3>		
			<p>На сайте <a href="http://{$site}">{$sitename}</a> появились новые вакансии, которые могут Вас заинтересовать</p>
		</div>
		<div style="clear: both;"></div>
		<div style="width: 600px; margin: 20px 0;">
		{foreach from=$vacancies item=item}
			<div style="width: 500px; float: left;">
				<p style="margin: 5px 0;"><span style="color: #999999;display:block;font-size: 12px;font-style:italic;">{$item->pub_date|date_format:"%d %_M %Y"}</span></p>
				<p style="margin: 5px 0;">{if $item->company}<a href="http://{$site}{$item->company->itemurl}" style="color: #999999;display:block;font-size: 12px;">{$item->company->title}</a>{/if}{if $item->city}({$item->city->title}){/if}</p>
				<p style="margin: 5px 0;"><a href="http://{$site}{$item->url}" style="color: #0066CC;font-size: 18px;font-style: italic;">{$item->title}</a></p>
				<p style="margin: 5px 0;"><strong>{if $item->salary_neg}З/п договорная{else}{if $item->salary_from}от {$item->salary_from} {if !$item->salary_to} руб.{/if}{/if} {if $item->salary_to}до {$item->salary_to} руб.{/if}{/if}</strong></p>
			</div>
			{if $item->company->image->id}
			<div style="width: 80px; float: right;"><a href="http://{$site}{$item->company->itemurl}"><img style="max-width: 80px;" src="http://{$site}{$item->company->image->getLink()}" /></a></div>
			{/if}
			<div style="clear: both;"></div>
		{/foreach}
		</div>
		<p>Вы можете отписаться от рассылки в <a href="http://{$site}/cabinet/subscribe">Личном Кабинете</a></p>
	</body>
</html>
