{if $state=='list'}
<h3 class="action-title">Установка модулей</h3>
<p class="action-description edit-content">Установка и настройка модулей</p>
	{if !empty($errors) && $errors|@count > 0}
	<div class="messages">
		{foreach from=$errors item='message'}
			{$message->html}
		{/foreach}
	</div>
	{/if}
	{if !empty($list)  && $list|@count > 0}
	<form id="items-remove" action="" method="post">
		<input type="hidden" name="act" value="list"/>
		<table class="sortable-table" rel="module">
			<thead>
				<tr>
					<th>Название</th>
					<th>Сервисное имя</th>
					<th style="width: 120px;">Доступен в ноде</th>
					<th style="width: 120px;">Доступен в блоке</th>
					<th style="width: 20px;">Поиск</th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item='item'}
				<tr rel="{$item->id}">
					<td>{$item->title}</td>
					<td>{$item->type}</td>
					<td>{if $item->in_node}<span class="t-icon" title="Доступен в ноде" ></span>{/if}</td>
					<td>{if $item->in_block}<span class="t-icon" title="Доступен в блоке" ></span>{/if}</td>
					<td>{if $item->search}<span class="t-icon" title="Поиск по разделам данного типа" ></span>{/if}</td>
					<td><a href="{$path_prefix}/edit/{$item->id}" class="icon edit" title="Общие настройки"></a></td>
					<td>{if $item->has_content}<a href="{$adm_path}/modfield/list/{$item->id}" class="icon fields" title="Поля"></a>{/if}</td>
					<td>{if $item->has_content}<a href="{$adm_path}/modgroup/list/{$item->id}" class="icon fields" title="Группы свойств"></a>{/if}</td>
					<td>{if $item->has_content && $item->has_variants}<a href="{$adm_path}/modvariant/list/{$item->id}" class="icon fields" title="Поля вариантов"></a>{/if}</td>
					<td><a href="{$adm_path}/modimage/list/{$item->id}" class="icon image" title="Изображения"></a></td>
					<td><a href="{$adm_path}/modtpl/list/{$item->id}" class="icon template" title="Шаблоны"></a></td>
					<td><a href="{$adm_path}/modparam/list/{$item->id}" class="icon params" title="Параметры"></a></td>
					<td><a href="{$adm_path}/modvalue/edit/{$item->id}" class="icon paramsVal" title="Значения параметров"></a></td>
					<td>{if $item->has_filters}<a href="{$adm_path}/modfilter/list/{$item->id}" class="icon filters" title="Фильтры"></a>{/if}</td>
					<td><a href="{$path_prefix}/uninstall/{$item->id}" class="icon remove" title="Удалить"></a></td>
				</tr>
				{/foreach}
				{if $data.not_install}
					<tr>
						<td colspan="16"><strong><center>Не установлены</center></strong></td>
					</tr>
					{foreach from=$data.not_install key='module_name' item='module'}
						<tr>
							<td>{$module.type.title}</td>
							<td>{$module.type.name}</td>
							<td><a href="{$path_prefix}/install/{$module.type.name}" class="icon add" title="Установить"></a></td>
						</tr>
					{/foreach}
				{/if}
			</tbody>
		</table>
		<div class="list_buttons">
			<input class="btn" type="button" href="{$path_prefix}/add" value="{$_LNG_ADM.ADD}"/>
		</div>
		<div class="list_pager">
			{$pager}
		</div>
		<div class="clear"></div>
	</form>
	{/if}
	<script>
		$(function() {ldelim}
			$("input[type='button'][href]").click(function() {ldelim}
				window.location.href = $(this).attr("href");
			{rdelim});

			$(".remove").click(function(e) {ldelim}
				e.preventDefault();
				$('.js-delete-form').show();
				$('.js-delete-true').attr('href', $(this).attr('href'));
				$('.js-delete-text').html("Вы уверены что хотите удалить?");
				{rdelim});
		{rdelim});
	</script>
{elseif $state == 'edit' || $state == 'add'}
{if $item->type}{include file='menu/module-actions.tpl' type=$item active=module}{/if}
{if $item->type}
<h3 class="action-title">{$item->title} ({$item->type})</h3>
{else}
<h3 class="action-title">Создание модуля</h3>
{/if}
<p class="action-description edit-content">Настройка модуля</p>
{if !empty($errors) && $errors|@count > 0}
<div class="messages">
	{foreach from=$errors item='message'}
	{$message->html}
	{/foreach}
</div>
{/if}
<form id="item-edit" action="" method="post" enctype="multipart/form-data">
	<div class="fields-panel inline-container">
		<div class="inline-block half-width">
			<div class="field">
				<label>Название</label>
				<input type="text" class="text required" name="title" value="{$item->title}"/>
			</div>

			<div class="field">
				{if $item->type && $item->title}
					<label>Сервисное имя: {$item->type}</label>
				{else}
					<label>Сервисное имя</span></label>
					<input type="text" class="required text" name="type" value="{$item->type}"/>
				{/if}
			</div>
			<div class="inline-block half-width">
				<div class="field checkbox">
					<label class="selected_label {if $item->in_node}checked{/if}" for="in_node">Доступен в ноде</label>
					<input class="selected_field" type="checkbox" value="1" id="in_node" name="in_node" {if $item->in_node}checked="checked"{/if}/>
				</div>
			</div>
			<div class="inline-block half-width">
				<div class="field checkbox">
					<label class="selected_label {if $item->in_block}checked{/if}" for="in_block">Доступен в блоке</label>
					<input class="selected_field" type="checkbox" value="1" id="in_block" name="in_block" {if $item->in_block}checked="checked"{/if}/>
				</div>
			</div>
		</div>
		<div class="inline-block half-width">
			<div class="field checkbox">
				<label class="selected_label {if $item->search}checked{/if}" for="search">Поиск по элементам разделов данного типа</label>
				<input class="selected_field" type="checkbox" value="1" id="search" name="search" {if $item->search}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->has_content}checked{/if}" for="has_content">Редактируемый контент</label>
				<input class="selected_field" type="checkbox" value="1" id="has_content" name="has_content" {if $item->has_content}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->has_items}checked{/if}" for="has_items">Отдельные элементы контента</label>
				<input class="selected_field" type="checkbox" value="1" id="has_items" name="has_items" {if $item->has_items}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->sortable}checked{/if}" for="sortable">Сортировка перетаскиванием</label>
				<input class="selected_field" type="checkbox" value="1" id="sortable" name="sortable" {if $item->sortable}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->has_filters}checked{/if}" for="has_filters">Есть фильтры</label>
				<input class="selected_field" type="checkbox" value="1" id="has_filters" name="has_filters" {if $item->has_filters}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->has_variants}checked{/if}" for="has_variants">Есть варианты</label>
				<input class="selected_field" type="checkbox" value="1" id="has_variants" name="has_variants" {if $item->has_variants}checked="checked"{/if}/>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
	<a class="btn btn_white" href="{$path_prefix}">{$_LNG_ADM.CANCEL}</a>
	<script>
		$(function() {ldelim}
			$("input[name=has_content]").change(function() {ldelim}
				if ($(this).is(':checked')){ldelim}
					$('label[for="has-items"]').show();
					$('input[name=has_items]').change();
				{rdelim} else {ldelim}
					$('label[for="has-items"]').hide();
				{rdelim}
			{rdelim});
			$("input[name=has_items]").change(function() {ldelim}
				if ($(this).is(':checked')){ldelim}
					$('label[for="sortable"]').show();
				{rdelim} else {ldelim}
					$('label[for="sortable"]').hide();
				{rdelim}
			{rdelim});
			$("input[name=has_content]").change();
		{rdelim});
	</script>
</form>
{elseif $state == 'uninstall'}
	{if !empty($errors) && $errors|@count > 0}
	<div class="messages">
		{foreach from=$errors item='message'}
			{$message->html}
		{/foreach}
	</div>
	{else}
		<p>Модуль удален</p>
	{/if}
	<a href="{$path_prefix}">Назад</a>
{elseif $state == 'install'}
	{if !empty($errors) && $errors|@count > 0}
	<div class="messages">
		{foreach from=$errors item='message'}
			{$message->html}
		{/foreach}
	</div>
	{else}
		<p>Модуль установлен</p>
	{/if}
	<a href="{$path_prefix}">Назад</a>
{/if}
