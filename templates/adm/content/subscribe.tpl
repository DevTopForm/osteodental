<h3 class="action-title">Подписчики</h3>
<p class="action-description edit-content">Управление подписчиками</p>
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
					<th>ФИО</th>
					<th>Email</th>
					<th>Тематики</th>
          <th style="width: 20px;">Подписка оформлена</th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item='item'}
				<tr>
					<td>{$item->title}</td>
					<td>{$item->email}</td>
					<td>{$item->theme}</td>
					<td>{if $item->active}<span class="t-icon" title="Активен" ></span>{/if}</td>
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
			<input class="btn" type="button" href="{$path_prefix}/add" value="{$_LNG_ADM.ADD}"/>
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
		<div class="inline-block half-width">
			<div class="field">
				<label>ФИО</label>
				<input type="text" class="text required" name="title" value="{$item->title}"/>
			</div>
			<div class="field">
				<label>E-mail</label>
				<input type="text" class="text" name="email" value="{$item->email}"/>
			</div>
			{if $data.theme|@count > 0}
				<div class="field">
					<label>Тематики</label>
					<select class="multisel2area" multiple="multiple" name="theme[]">
						{foreach from=$data.theme item=themeItem}
							<option value="{$themeItem->id}" {if in_array($themeItem->id,$item->theme)}selected="selected"{/if}>{$themeItem->title}</option>
						{/foreach}
					</select>
				</div>
			{/if}
			<div class="field checkbox">
				<label class="selected_label {if $item->active}checked{/if}" for="active">Активный</label>
				<input class="selected_field" type="checkbox" value="1" id="active" name="active" {if $item->active}checked="checked"{/if}/>
			</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
	<a href="{$path_prefix}">{$_LNG_ADM.CANCEL}</a>
</form>
{/if}
