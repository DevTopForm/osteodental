<div class="content_header">
	<div class="title">
		{$node->title}
	</div>
	{if $node->id}
		<div class="node_actions">
			{include file='menu/node-actions.tpl' node=$node active=content}
			{if $state == 'edit'}
				<div class="return_previous">
					<form action="" method="post" enctype="multipart/form-data">
						<input class="btn" type="submit" name="history_return" value="{$_LNG_ADM.RETURN_HISTORY}"/>
					</form>
				</div>
			{/if}
		</div>

	{/if}
</div>
{if $node->id}
	<div class="node_menu">
		{include file='menu/node-menu.tpl' node=$node active=content}
	</div>
{/if}

{if !empty($errors) && $errors|@count > 0}
<div class="messages">
	{foreach from=$errors item='message'}
		{$message->html}
	{/foreach}
</div>
{/if}
{if $state == 'list'}
	{if $list || $smarty.get.search_text}
		<form action="" class="search_content_form only_string">
			<input type="text" name="search_text" value="{$smarty.get.search_text}">
			<input class="btn" type="submit" name="search" value="Искать">
		</form>
	{/if}

	{if !empty($list)  && $list|@count > 0}
		<form id="items-remove" action="" method="post">
			<input type="hidden" name="act" value="list"/>
			<div class="list_buttons">
				<input type="button" class="btn" href="{$adm_path}/content/add/{$node->id}" value="{$_LNG_ADM.ADD}"/>
				<input type="submit" class="btn btn_white" name="save_list" value="{$_LNG_ADM.REMOVE}"/>
			</div>
			<div class="list_pager">
				{$pager}
			</div>
			<div class="clear"></div>
			<div class="sortable_pager top">
				<div class="first" to='first'>Поставить первым</div>
				<div class="last" to='last'>Поставить последним</div>
			</div>
			<table {if $node->type->sortable}id="node_content_list"{/if}>
				<thead>
					<tr>
						<th style="width: 20px;">
							<label class="selected_label" id="selectAlllabel" for="selectAll"></label>
							<input type="checkbox" class="no-uniform selected_field" id="selectAll" name="selectAll" value="1"/>
						</th>
						{foreach from=$fields item='field'}
							{if $field->show}{if $field->field != "checkbox"}<th>{$field->title}</th>{/if}{/if}
						{/foreach}
						{foreach from=$fields item='field'}
							{if $field->show}{if $field->field == "checkbox"}<th style="width: 16px;"></th>{/if}{/if}
						{/foreach}
						<th style="width: 16px;"></th>
						<th style="width: 16px;"></th>
					</tr>
				</thead>
				<tbody node="{$node->id}">
					{foreach from=$list item='item' name='list'}
					<tr itemId="{$item->id}">
						<td>
							<label class="selected_label inner_label" for="remove_{$item->id}"></label>
							<input type="checkbox" class="no-uniform selected_field" id="remove_{$item->id}" name="remove[{$item->id}]" value="1"/>
						</td>
						{foreach from=$fields item='field'}
							{if $field->show}
								{assign var=key value=$field->name}
								{if $field->field == "text" || $field->field == "smalltext" || $field->field == "integer" || $field->field == "medtext" || $field->field == "hidden"}
									<td>
									<div class="ajaxEdit" fieldType="{$field->type}">
									<span>{$item->$key}</span>
									<input style="display:none;" type="text" value="{$item->$key}" />
									<div node="{$item->node->id}" itemId="{$item->id}" field="{$field->name}" class="saveBtn"></div>
									</div>
									</td>
								{elseif $field->field == "checkbox"}
								{elseif $field->field == "date"}
									<td><input class="ajaxSaveDate" node="{$item->node->id}" itemId="{$item->id}" field="{$field->name}" type="text" value="{$item->$key}" name="date"/></td>
								{else}
								   <td>{$item->$key}</td>
								{/if}
							{/if}
						{/foreach}
						{foreach from=$fields item='field'}
							{if $field->show}
								{assign var=key value=$field->name}
								{if $field->field == "checkbox"}
									<td class="ajaxEdit" fieldType="{$field->field}" node="{$item->node->id}" itemId="{$item->id}" field="{$field->name}">
										{$item->$key}
									</td>
								{/if}
							{/if}
						{/foreach}
						<td><a href="{$adm_path}/content/edit/{$node->id}/{$item->id}" class="t-icon edit"></a></td>
						<td><a href="{$item->getUrl()}" class="t-icon web" title="Открыть на сайте" target="_blank"></a></td>
					</tr>
					{/foreach}
				</tbody>
			</table>
			<div class="sortable_pager bottom">
				<div class="first" to='first'>Поставить первым</div>
				<div class="last" to='last'>Поставить последним</div>
			</div>
			<div class="list_buttons">
				<input type="submit" class="btn  btn_white" name="save_list" value="{$_LNG_ADM.REMOVE}"/>
				<input type="button" class="btn" href="{$adm_path}/content/add/{$node->id}" value="{$_LNG_ADM.ADD}"/>
			</div>
			<div class="list_pager">
				{$pager}
				<div class=change_coun style="float:right; display:flex; align-items: center">
					<span style="padding-right: 10px">Количество на странице: </span>
					<select onchange="changeCount(this.options[this.selectedIndex].value)" name="change_count">
						{foreach from=$countChange item=item}
							<option {if $smarty.get.count == $item.value} selected {/if} value="{$item.value}">{$item.name}</option>
						{/foreach}
					</select>
				</div>
			</div>
			<div class="clear"></div>
		</form>
	{elseif $node->type->has_content}
	<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
	<input class="btn" type="button" href="{$adm_path}/content/add/{$node->id}" value="{$_LNG_ADM.ADD}"/>
	{else}
	<p>Редактирование содержимого данного раздела не предусмотрено</p>
	{/if}
	<script>
		$(function() {ldelim}

			$("input[type='button'][href]").click(function() {ldelim}
				window.location.href = $(this).attr("href");
			{rdelim});

			var deleteStatus = false;

			$("#items-remove").submit(function(e) {ldelim}
				if($("input:focus").parent().hasClass("ajaxEdit")) return false;
				if(!deleteStatus)  {ldelim}
					e.preventDefault();
					$('.js-delete-text').html('{$_LNG_ADM.REMOVE_ITEMS_CONFIRM}');
					$('.js-delete-form').show();
				{rdelim}else {ldelim}
					deleteStatus = false;
				{rdelim}
				{*return confirm('{$_LNG_ADM.REMOVE_ITEMS_CONFIRM}');*}
			{rdelim});

			$(".js-delete-true").on('click', function(e) {ldelim}
				deleteStatus = true;
				$(".js-delete-form").hide();
				$('#items-remove').submit();

			{rdelim});

			$("label[for='selectAll']").click(function() {ldelim}
				var checkboxes = $(this).parents('form').find("input[type=checkbox]").not('#selectAll');
				var labels = $(this).parents('form').find("label").not(this);
				var checked = $(this).hasClass("checked");
				if (!checked) {ldelim}
					checkboxes.prop("checked", true);
					labels.addClass('checked');
					{rdelim} else {ldelim}
					checkboxes.prop("checked", false);
					labels.removeClass('checked');
					{rdelim}
				{rdelim});
			{rdelim});
	</script>
{elseif $state == 'edit' || $state == 'add'}
	<form id="item-edit" action="" method="post" class="fields-panel" enctype="multipart/form-data">
		{if $smarty.post.history_return}
			<input type="hidden" name="history_save" value="1"/>
		{/if}
		<div class="content_item_container">
			<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
			<input class="btn" type="submit" name="save_item" value="{$_LNG_ADM.ITEM_SAVE}"/>
			<input class="btn" type="submit" name="copy_item" value="{$_LNG_ADM.ITEM_COPY}"/>
			<a class="btn btn_white" href="">{$_LNG_ADM.CANCEL}</a>
			{if $node->type->has_variants}
				<div class="btn js_show_variant_page variant_button" data-url="{$adm_path}/content/variant/{$node->id}/{$item->id}">Варианты товара</div>
			{/if}
		</div>
		<br>
		<a class="return-btn" href="{$adm_path}/content/list/{$node->id}">< Назад к списку</a>
		<div class="content_item_header">{$item->title}</div>
		<input type="hidden" name="act" value="item"/>
		{foreach from=$fields item='field'}
			{if !$field->advanced || ($field->advanced && !$params.seo_things)}
				{include file='content/fields/'|cat:$field->field|cat:'.tpl'}
			{/if}
		{/foreach}
		<p></p>
		<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
		<input class="btn" type="submit" name="save_item" value="{$_LNG_ADM.ITEM_SAVE}"/>
		<input class="btn" type="submit" name="copy_item" value="{$_LNG_ADM.ITEM_COPY}"/>
		<a class="btn btn_white" href="">{$_LNG_ADM.CANCEL}</a>
{*		{if $node->type->has_variants}
			<div class="variant_list"></div>
			<div class="item_variant_edit">
				<div class="content_item_container">
					<div class="btn js_variant_save" style="display: inline-block;">{$_LNG_ADM.SAVE}</div>
				</div>
				{foreach from=$variantFields item='field'}
					{if !$field->advanced || ($field->advanced && !$params.seo_things)}
						{include file='content/fields/'|cat:$field->field|cat:'.tpl'}
					{/if}
				{/foreach}
			</div>
		{/if}*}
	</form>
	<div class="variant_block"></div>
	<div class="clear"></div>
	{if $node->type->type == 'feedback'}
		<script>
			$(function() {ldelim}
				$('#item-edit select[name=field]').change(function(){ldelim}
					if (eval('(window.feedback_'+$(this).val()+') ? 1 : 0')) eval('feedback_'+$(this).val()+'()');
				{rdelim});
				$('#item-edit select[name=field]').trigger('change');
			{rdelim});

			function feedback_text(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').show().prev().show();
			{rdelim}

			function feedback_textarea(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').show().prev().show();
				$('#item-edit input[name=format]').hide().prev().hide();
			{rdelim}

			function feedback_password(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').hide().prev().hide();
			{rdelim}

			function feedback_hidden(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').show().prev().show();
			{rdelim}

			function feedback_captcha(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').hide().prev().hide();
				$('#item-edit input[name=format]').hide().prev().hide();
			{rdelim}

			function feedback_date(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				//$('#item-edit input[name=default]').hide().prev().hide();
				$('#item-edit input[name=format]').hide().prev().hide();
			{rdelim}

			function feedback_file(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').hide().prev().hide();
			{rdelim}

			function feedback_image(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').hide().prev().hide();
			{rdelim}

			function feedback_checkbox(){ldelim}
				$('#item-edit .multi-field').hide().prev().hide();
				$('#item-edit input[name=default]').show().prev().show();
			{rdelim}

			function feedback_select(){ldelim}
				$('#item-edit .multi-field').show().prev().show();
				$('#item-edit input[name=default]').hide().prev().hide();
			{rdelim}

			function feedback_checkboxgroup(){ldelim}
				$('#item-edit .multi-field').show().prev().show();
				$('#item-edit input[name=default]').hide().prev().hide();
			{rdelim}

			function feedback_radiogroup(){ldelim}
				$('#item-edit .multi-field').show().prev().show();
				$('#item-edit input[name=default]').hide().prev().hide();
			{rdelim}

			function feedback_multiselect(){ldelim}
				$('#item-edit .multi-field').show().prev().show();
				$('#item-edit input[name=default]').hide().prev().hide();
			{rdelim}
		</script>
	{/if}
{/if}