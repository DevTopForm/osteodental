<h3 class="action-title">Комментарии</h3>
<p class="action-description edit-user">Модерация комментариев</p>
{if $state=='list'}
	{if !empty($list)  && $list|@count > 0}
	<form action="" method="post">
		<table>
			<thead>
				<tr>
					<th style="width: 20px;"><input type="checkbox" id="selectAll" name="selectAll" value="1" class="no-uniform"/></th>
					<th>Дата</th>
					<th>Комментарий</th>
					<th>Автор</th>
					<th>Раздел</th>
					<th style="width: 16px;"></th>
					<th style="width: 16px;"></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item='item'}
				<tr {if !$item->public}class="new"{/if}>
					<td><input type="checkbox" name="list[{$item->id}]" value="1" class="no-uniform"/></td>
					<td>{$item->date|date_format:'%d.%m.%Y'}</td>
					<td><a href="{$adm_path}/comment/edit/{$item->id}" >{$item->text}</a></td>
					<td>{$item->getAuthor()}</td>
					<td><a href="{if $item->item->id}{$item->item->getUrl()}{else}{$item->node->getUrl()}{/if}" target="_blank">{if $item->item->title}{$item->item->title}{else}{$item->node->title}{/if}</a></td>
					<td><a href="{$adm_path}/comment/public/{$item->id}" title="{if $item->public}Скрыть{else}Опубликовать{/if}" class="t-icon public{if !$item->public} not-active{/if}"></a></td>
					<td><a href="{$adm_path}/comment/edit/{$item->id}" class="t-icon edit" title="Редактировать"></a></td>
				</tr>
				{/foreach}
			</tbody>
		</table>
		<div class="list_buttons">
			Все отмеченные <input type="submit" name="public" value="Опубликовать"/>&nbsp;&nbsp;<input type="submit" name="remove" value="{$_LNG_ADM.REMOVE}" id="items-remove"/>
		</div>
		<div class="list_pager">
			{$pager}
		</div>
		<div class="clear"></div>
	</form>

	{else}
	<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
	{/if}

	<script>
		$(function() {ldelim}
			$("input[type='button'][href]").click(function() {ldelim}
				window.location.href = $(this).attr("href");
			{rdelim});
			
			$("#items-remove").click(function() {ldelim}
				return confirm('{$_LNG_ADM.REMOVE_ITEMS_CONFIRM}');
			{rdelim});
			
			$("#selectAll").click(function() {ldelim}
				var checkboxes = $(this).parents('form').find("input[type=checkbox]").not(this);
				var checked = $(this).attr("checked");
				if (checked) {ldelim}
					$(checkboxes).attr("checked", checked);
				{rdelim} else {ldelim}
					$(checkboxes).removeAttr("checked");
				{rdelim}
			{rdelim});
		{rdelim});
	</script>
{elseif $state=='edit' || $state =='add'}
	{if !empty($errors) && $errors|@count > 0}
	<div class="messages">
		{foreach from=$errors item='message'}
		{$message->html}
		{/foreach}
	</div>
	{/if}
	<form id="item-edit" action="" method="post" enctype="multipart/form-data">
		<label>Дата <span class="required"></span></label>
		<input type="text" name="date" class="text date" value="{$item->date|date_format:'%d.%m.%Y'}">

		<label>Комментарий <span class="required"></span></label>
		<textarea name="text">{$item->text}</textarea>
		
		<label>Автор</label>
		{$item->getAuthor()}

		<label>Раздел</label>
		<a href="{if $item->item->id}{$item->item->getUrl()}{else}{$item->node->getUrl()}{/if}" target="_blank">{if $item->item->title}{$item->item->title}{else}{$item->node->title}{/if}</a>
		
		<p></p>
		<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
		<a href="{$path_prefix}">{$_LNG_ADM.CANCEL}</a>
	</form>

{/if}