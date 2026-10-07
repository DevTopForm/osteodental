<h3 class="action-title">Статусы</h3>
<p class="action-description edit-content">Управление статусами</p>
{if $state == 'list'}
		{if !empty($list)  && $list|@count > 0}
			<table>
				<thead>
					<tr>
						<th>Название</th>
						<th style="width: 20px;"></th>
						<th style="width: 20px;"></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$list item='item'}
					<tr>
						<td>{$item->title}</td>
						<td><a href="/adm/status/edit/{$item->id}" class="icon edit"></a></td>
						<td><a href="/adm/status/delete/{$item->id}" class="icon remove"></a></td>
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
			<script>
				{literal}
				$(function() {
					$("input[type='button'][href]").click(function() {
						window.location.href = $(this).attr("href");
					});

					$(".remove").click(function() {
						return confirm("Вы уверены что хотите удалить?");
					});
				});
				{/literal}
			</script>
			<div class="clear"></div>
	{else}
		<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
	{/if}
{elseif $state == 'edit' || $state == 'add'}
	{if !empty($errors) && $errors|@count > 0}
	<div class="messages">
		{foreach from=$errors item='message'}
		{$message->html}
		{/foreach}
	</div>
	{/if}
	<form action="" method="post">
		<div style="width: 100%;">
			<label>Статус</label>
			<table class="orders">
				<tbody>
					<tr>
						<td><strong>Название:</strong></td>
						<td><input type="text" name="title" value="{$item->title}"/></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="clear"></div>
		<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
		<a href="/adm/status/list">{$_LNG_ADM.BACK}</a>
	</form>
<div class="clear"></div>
{/if}
