{include file='menu/module-actions.tpl' type=$module active=filters}
<h3 class="action-title">{$module->title} ({$module->type})</h3>
<p class="action-description edit-content">Настройка фильтров</p>
{if $state=='list'}
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
		<table class="sortable-table" rel="nodefields">
			<thead>
				<tr>
					<th>Название</th>
					<th>Имя в таблице</th>
					<th>Тип поля</th>
					<th style="width: 50px;">Required</th>
					<th style="width: 50px;">В&nbsp;списке<br/>в&nbsp;админке</th>
					<th style="width: 50px;">В&nbsp;поиске<br/>на&nbsp;сайте</th>
					<th style="width: 50px;">В&nbsp;списке<br/>на&nbsp;сайте</th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item='item'}
				<tr rel="{$item->id}">
					<td>{$item->title}</td>
					<td>{$item->name}</td>
					<td>{$item->field}</td>
					<td>{if $item->required}<span class="t-icon" title="Обязательно для заполнения"></span>{/if}</td>
					<td>{if $item->show}<span class="t-icon" title="Показывать в списке в админке"></span>{/if}</td>
					<td>{if $item->search}<span class="t-icon" title="Участвует в поиске"></span>{/if}</td>
					<td>{if $item->inlist}<span class="t-icon" title="Обрабатывать в списке на сайте"></span>{/if}</td>
					<td><a href="{$path_prefix}/edit/{$module->id}/{$item->id}" class="icon edit" title="Изображения"></a></td>
					<td><a href="{$path_prefix}/delete/{$module->id}/{$item->id}" class="icon remove" title="Шаблоны"></a></td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		<div class="list_buttons">
			<input type="button" href="{$path_prefix}/add/{$module->id}" value="{$_LNG_ADM.ADD}"/>
		</div>
		<div class="list_pager">
			{$pager}
		</div>
		<div class="clear"></div>
	</form>
	{else}
		<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
		<input type="button" href="{$path_prefix}/add/{$module->id}" value="{$_LNG_ADM.ADD}"/>
		<div class="clear"></div>
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
			<label>Название <span class="required"></span></label>
			<input type="text" class="text" name="title" value="{$item->title}"/>
	
			<label>Имя в таблице<span class="required"></span></label>
			<input type="text" class="text" name="name" value="{$item->name}"/>
			
			<label>Тип поля <span class="required"></span></label>
			<select name="field">
				{foreach from=$data.types item=type key=key}
				<option value="{$key}" {if $item->field == $key}selected="selected"{/if}>{$key}</option>
				{/foreach}
			</select>
			<label><input type="checkbox" name="editor" value="1" {if $item->editor}checked="checked"{/if}/> Текстовый редактор</label>
			<label><input type="checkbox" name="show" value="1" {if $item->show}checked="checked"{/if}/> Показывать в списке</label>
			<label><input type="checkbox" name="required" value="1" {if $item->required}checked="checked"{/if}/> Обязательное</label>
			<label><input type="checkbox" name="advanced" value="1" {if $item->advanced}checked="checked"{/if}/> Специальное</label>
			<label><input type="checkbox" name="search" value="1" {if $item->search}checked="checked"{/if}/> Поиск по этому полю</label>
		</div>		
		<div class="inline-block half-width">
			<label>Комментарий к полю</label>
			<input type="text" class="text" name="example" value="{$item->example}"/>
			<label>Формат данных (format)</label>
			<input type="text" class="text" name="format" value="{$item->format}"/>
			<label>Фукция обработки (prepare)</label>
			<input type="text" class="text" name="prepare" value="{$item->prepare}"/>
			<label>Таблица с данными (table_data)</label>
			<input type="text" class="text" name="table_data" value="{$item->table_data}"/>
			<div class="inline-block half-width">
				<label>Поле фильтрации (table_filter)</label>
				<input type="text" class="text" name="table_filter" value="{$item->table_filter}"/>
			</div>
			<div class="inline-block half-width">
				<label>Значение фильтра (table_value)</label>
				<input type="text" class="text" name="table_value" value="{$item->table_value}"/>
			</div>
		</div>
	</div>
	<div class="clear"></div>
	<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
	<a href="{$path_prefix}/list/{$module->id}">{$_LNG_ADM.CANCEL}</a>
</form>
{/if}