<h3 class="action-title">Скидки</h3>
<p class="action-description edit-content">Управление скидками</p>
{if $state == 'list'}
		{if !empty($list)  && $list|@count > 0}
			<table>
				<thead>
					<tr>
						<th>Сумма</th>
						<th>Скидка</th>
						<th>Описание</th>
						<th style="width: 20px;"></th>
						<th style="width: 20px;"></th>
					</tr>
				</thead>
				<tbody>
					{foreach from=$list item='item'}
					<tr>
						<td>{$item->summ}</td>
						<td>{$item->sale}</td>
						<td>{$item->text}</td>
						<td><a href="/adm/sale/edit/{$item->id}" class="icon edit"></a></td>
						<td><a href="/adm/sale/delete/{$item->id}" class="icon remove"></a></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			{else}
				<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
			{/if}
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
			<label>Скидка</label>
			<table class="orders">
				<tbody>
					<tr>
						<td width="50%">Пороговая сумма:</td>
						<td width="50%"><input type="text" name="summ" value="{$item->summ}"/></td>
					</tr>
					<tr>
						<td width="50%">Размер скидки:</td>
						<td width="50%"><input type="text" name="sale" value="{$item->sale}"/></td>
					</tr>
					<tr>
						<td width="50%">Комментарий:</td>
						<td width="50%"><textarea name="text">{$item->text}</textarea></td>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="clear"></div>
		<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
		<a href="/adm/sale/list">{$_LNG_ADM.BACK}</a>
	</form>
<div class="clear"></div>
{/if}
