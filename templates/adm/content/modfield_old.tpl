{include file='menu/module-actions.tpl' type=$module active=fields}
<h3 class="action-title">{$module->title} ({$module->type})</h3>
<p class="action-description edit-content">Настройка полей</p>
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
					<th style="width: 50px;">Сортировать<br/>по&nbsp;полю</th>
					<th style="width: 50px;">В&nbsp;поиске<br/>на&nbsp;сайте</th>
					<th style="width: 50px;">В&nbsp;списке<br/>на&nbsp;сайте</th>
					<th style="width: 50px;">Отображать&nbsp;в<br/>характерис-<br/>тиках</th>
					<th style="width: 50px;">Отображать<br/>в&nbsp;списке<br/>товаров</th>
					{if $module->has_compare}
						<th style="width: 50px;">Поле&nbsp;для<br/>сравнения</th>
					{/if}
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
					<td>{if $item->sorter}<span class="t-icon" title="Сортировать по этому полю"></span>{/if}</td>
					<td>{if $item->search}<span class="t-icon" title="Участвует в поиске"></span>{/if}</td>
					<td>{if $item->inlist}<span class="t-icon" title="Обрабатывать в списке на сайте"></span>{/if}</td>
					<td>{if $item->property_show}<span class="t-icon" title="Отображать в характеристиках"></span>{/if}</td>
					<td>{if $item->property_list_show}<span class="t-icon" title="Отображать в списке товаров"></span>{/if}</td>
					{if $module->has_compare}
						<td>{if $item->compare_field}<span class="t-icon" title="Поле для сравнения"></span>{/if}</td>
					{/if}
					<td><a href="{$path_prefix}/edit/{$module->id}/{$item->id}" class="icon edit" title="Изображения"></a></td>
					<td><a href="{$path_prefix}/delete/{$module->id}/{$item->id}" class="icon remove" title="Шаблоны"></a></td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		<div class="list_buttons">
			<input class="btn" type="button" href="{$path_prefix}/add/{$module->id}" value="{$_LNG_ADM.ADD}"/>
		</div>
		<div class="list_pager">
			{$pager}
		</div>
		<div class="clear"></div>
	</form>
	{else}
		<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
		<input class="btn" type="button" href="{$path_prefix}/add/{$module->id}" value="{$_LNG_ADM.ADD}"/>
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
			<div class="field">
				<label>Название</label>
				<input type="text" class="text required" name="title" value="{$item->title}"/>
			</div>

			<div class="field">
				<label>Имя в таблице</label>
				<input type="text" class="text required" name="name" value="{$item->name}"/>
			</div>

			<div class="field">
				<label>Тип поля</label>
				<select class="required" name="field">
					{foreach from=$data.types item=type key=key}
					<option value="{$key}" {if $item->field == $key}selected="selected"{/if}>{$key}</option>
					{/foreach}
				</select>
			</div>

			<div class="field">
				<label>Группа поля</label>
				<select class="required" name="node_group">
					<option value="0" {if !$item->node_group}selected{/if}>Без группы</option>
					{foreach from=$data.groups item=group key=key}
						<option value="{$group->id}" {if $item->node_group == $group->id}selected="selected"{/if}>{$group->title}</option>
					{/foreach}
				</select>
			</div>

			<div class="field checkbox">
				<label class="selected_label {if $item->editor}checked{/if}" for="editor">Текстовый редактор</label>
				<input class="selected_field" type="checkbox" value="1" id="editor" name="editor" {if $item->editor}checked="checked"{/if}/>
			</div>

			<div class="field checkbox">
				<label class="selected_label {if $item->show}checked{/if}" for="show">Показывать в списке</label>
				<input class="selected_field" type="checkbox" value="1" id="show" name="show" {if $item->show}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->required}checked{/if}" for="required">Обязательное</label>
				<input class="selected_field" type="checkbox" value="1" id="required" name="required" {if $item->required}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->advanced}checked{/if}" for="advanced">Специальное</label>
				<input class="selected_field" type="checkbox" value="1" id="advanced" name="advanced" {if $item->advanced}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->sorter}checked{/if}" for="sorter">Сортировать по этому полю</label>
				<input class="selected_field" type="checkbox" value="1" id="sorter" name="sorter" {if $item->sorter}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->search}checked{/if}" for="search">Поиск по этому полю</label>
				<input class="selected_field" type="checkbox" value="1" id="search" name="search" {if $item->search}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->filter_show}checked{/if}" for="filter_show">Отображать в фильтре</label>
				<input class="selected_field" type="checkbox" value="1" id="filter_show" name="filter_show" {if $item->filter_show}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->property_show}checked{/if}" for="property_show">Отображать в характеристиках</label>
				<input class="selected_field" type="checkbox" value="1" id="property_show" name="property_show" {if $item->property_show}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->property_list_show}checked{/if}" for="property_list_show">Отображать в списке товаров</label>
				<input class="selected_field" type="checkbox" value="1" id="property_list_show" name="property_list_show" {if $item->property_list_show}checked="checked"{/if}/>
			</div>
			<div class="field checkbox">
				<label class="selected_label {if $item->property_list_show_mobile}checked{/if}" for="property_list_show">Отображать в списке товаров на мобильной версии</label>
				<input class="selected_field" type="checkbox" value="1" id="property_list_show" name="property_list_show" {if $item->property_list_show_mobile}checked="checked"{/if}/>
			</div>
			{if $module->has_compare}
				<div class="field checkbox">
					<label class="selected_label {if $item->search}checked{/if}" for="compare_field">Сравнение по этому полю</label>
					<input class="selected_field" type="checkbox" value="1" id="compare_field" name="compare_field" {if $item->compare_field}checked="checked"{/if}/>
				</div>
			{/if}
		</div>
		<div class="inline-block half-width">
			<div class="field">
				<label>Комментарий к полю</label>
				<input type="text" class="text" name="example" value="{$item->example}"/>
			</div>
			<div class="field">
				<label>Формат данных (format)</label>
				<input type="text" class="text" name="format" value="{$item->format}"/>
			</div>
			<div class="field">
				<label>Фукция обработки (prepare)</label>
				<input type="text" class="text" name="prepare" value="{$item->prepare}"/>
			</div>
			<div class="field">
				<label>Таблица с данными (table_data)</label>
				<input type="text" class="text" name="table_data" value="{$item->table_data}"/>
			</div>
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
	<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
	<a class="btn btn_white" href="{$path_prefix}/list/{$module->id}">{$_LNG_ADM.CANCEL}</a>
</form>
{/if}