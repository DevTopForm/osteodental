<h3 class="action-title">Редиректы</h3>
<p class="action-description edit-content">Управление редиректами</p>
{if $state == 'list'}
	{if !empty($list)  && $list|@count > 0}
		<table>
			<thead>
			<tr>
				<th>Откуда</th>
				<th>Куда</th>
				<th style="width: 20px;"></th>
				<th style="width: 20px;"></th>
			</tr>
			<tr class="search">
				<td>
					<input type="text" name="filter[from]" value="" class="text">
				</td>
				<td>
					<input type="text" name="filter[to]" value="" class="text">
				</td>
				<td colspan="2">
					<a title="Искать" style="margin:auto;" class="t-icon search" id="do_list_search" href="#"></a>
				</td>
			</tr>
			</thead>
			<tbody>
			{foreach from=$list item='item'}
				<tr>
					<td><a href="{$item->from}" target="_blank">{$item->from}</a></td>
					<td><a href="{$item->to}" target="_blank">{$item->to}</a></td>
					<td><a href="/adm/redirect/edit/{$item->id}" class="icon edit"></a></td>
					<td><a href="/adm/redirect/delete/{$item->id}" class="icon remove"></a></td>
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
		<script>
			{literal}
            $(function() {
                $("input[type='button'][href]").click(function() {
                    window.location.href = $(this).attr("href");
                });

				$(".remove").click(function(e) {
					e.preventDefault();
					$('.js-delete-form').show();
					$('.js-delete-true').attr('href', $(this).attr('href'));
					$('.js-delete-text').html("Вы уверены что хотите удалить?");
				});
            });
			{/literal}
		</script>
		<div class="clear"></div>
	{else}
		<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>

		<div class="list_buttons">
			<input type="button" href="{$path_prefix}/add" value="{$_LNG_ADM.ADD}"/>
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
			<div class="field">
				<label>Откуда:</label>
				<input type="text" name="from" value="{$item->from}"/>
			</div>

			<div class="field">
				<label>Куда:</label>
				<input type="text" name="to" value="{$item->to}"/>
			</div>

			<div class="field checkbox">
				<label class="selected_label {if $item->public}checked{/if}" for="public">Опубликовать</label>
				<input class="selected_field" type="checkbox" class="checkbox" id="public" name="public" {if $item->public}checked="checked"{/if}/>
			</div>
		</div>
		<div class="clear"></div>
		<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
		<a class="btn btn_white" href="/adm/redirect/list">{$_LNG_ADM.BACK}</a>
	</form>
	<div class="clear"></div>
{/if}
