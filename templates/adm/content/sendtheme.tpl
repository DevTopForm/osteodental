<h3 class="action-title">Тематики рассылки</h3>
<p class="action-description edit-content">Управление тематиками</p>
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
					<th>Заголовок</th>
          <th style="width: 20px;">Опубликовано</th>
					<th style="width: 20px;"></th>
					<th style="width: 20px;"></th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item='item'}
				<tr>
					<td>{$item->title}</td>
					<td>{if $item->public}<span class="t-icon" title="Опубликовано" ></span>{/if}</td>
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
		<div class="inline-block half-width">
			<label>Заголовок <span class="required"></span></label>
			<input type="text" class="text" name="title" value="{$item->title}"/>
      <label><input type="checkbox" name="public" value="1" {if $item->public}checked="checked"{/if}/>Опубликовано</label>
		</div>
		<div class="clear"></div>
	</div>
	<div class="clear"></div>
	<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
	<a href="{$path_prefix}">{$_LNG_ADM.CANCEL}</a>
</form>
{/if}
