<h3 class="action-title">Рассылки</h3>
<p class="action-description edit-content">Управление рассылками</p>
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
		<table>
			<thead>
				<tr>
					<th>Заголовок письма</th>
					<th>Дата отпраки</th>
					<th>Тематики</th>
          <th>Всего писем</th>
          <th>Отправлено</th>
          <th style="width: 20px;">Завершено</th>
          <th style="width: 20px;">Опубликовано</th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item='item'}
				<tr>
					<td>{$item->title}</td>
					<td>{$item->date|date_format:"%d.%m.%Y"}</td>
					<td>{$item->theme}</td>
          <td>{$item->total}</td>
          <td>{$item->sended}</td>
          <td>{if $item->finished}<span class="t-icon" title="Активен" ></span>{/if}</td>
					<td>{if $item->public}<span class="t-icon" title="Активен" ></span>{/if}</td>
					<td>
						<a href="{$path_prefix}/edit/{$item->id}" class="icon edit" title="Редактировать"></a>
					</td>
					<td>
						<a href="{$path_prefix}/delete/{$item->id}" class="icon remove" title="Удалить"></a>
					</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		<div class="list_buttons">
			<input type="button" href="{$path_prefix}/add" value="{$_LNG_ADM.ADD}"/>
		</div>
		<div class="list_pager">
			{$pager}
		</div>
		<div class="clear"></div>
	</form>
	{else}
	<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
	<input type="button" href="{$path_prefix}/add" value="{$_LNG_ADM.ADD}"/>
	{/if}
	<script>
		$(function() {ldelim}
			$("input[type='button'][href]").click(function() {ldelim}
				window.location.href = $(this).attr("href");
			{rdelim});

			$(".remove").click(function() {ldelim}
				return confirm("Вы уверены что хотите удалить?");
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
		<div class="inline-block">
			<label>Заголовок письма<span class="required"></span></label>
			<input type="text" class="text" name="title" value="{$item->title}"/>
			<label>Текст письма</label>
			<textarea class="text" name="text">{$item->text}</textarea>
      <label>Дата отправки (Год-Месяц-День)<span class="required"></span></label>
			<input type="date" class="text" name="date" data-date-format="YYYY-MM-DD" value="{$item->date|date_format:'%Y-%m-%d'}"/>
			{if $data.themes|@count > 0}
      <label>Тематики<span class="required"></span></label>
      <select class="multisel2area" multiple="multiple" name="themes[]">
        {foreach from=$data.themes item=theme}
          <option value="{$theme->id}" {if !empty($item->themes) && in_array($theme->id,$item->themes)}selected="selected"{/if}>{$theme->title}</option>
        {/foreach}
      </select>
      {/if}
      <label>Дополнительные адреса (указывать через запятую)</label>
			<textarea class="text" name="addresses">{$item->addresses}</textarea>
      <label>Файлы</label>
      {if $item->files|@count > 0}
      <div class="files">
        {foreach from=$item->files item=file}
        <div style="display:inline-block;">
          <label>{$file->src_name}</label>
          <label><input type="checkbox" name="del_files[]" value="{$file->id}"/> Удалить</label>
        </div>
        {/foreach}
      </div>
      {/if}
      <input type="file" name="files[]" multiple="multiple"/>
      <label>Всего писем</label>
			<input type="text" class="text" value="{$item->total}" disabled="disabled"/>
      <label>Отправлено писем</label>
			<input type="text" class="text" value="{$item->sended}" disabled="disabled"/>
      <label><input type="checkbox" name="public" value="1" {if $item->public}checked="checked"{/if}/>Опубликовано</label>
      <label><input type="checkbox" {if $item->finished}checked="checked"{/if} disabled="disabled"/>Закончено</label>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
	<a href="{$path_prefix}">{$_LNG_ADM.CANCEL}</a>
</form>
{/if}
