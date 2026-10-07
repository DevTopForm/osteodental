{*<h3 class="action-title">Входящие сообщения</h3>*}
{*<p class="action-description edit-user">Сообщения с форм обратной связи</p>*}
{*{if $state=='list'}*}
{*	{if !empty($messages) && $messages|@count > 0}*}
{*	<div class="messages">*}
{*		{foreach from=$messages item='message'}*}
{*		{$message->html}*}
{*		{/foreach}*}
{*	</div>*}
{*	{/if}*}

{*	{if !empty($list)  && $list|@count > 0}*}
{*	<form action="" method="post">*}
{*		<input type="hidden" name="act" value="list"/>*}
{*		<input type="hidden" name="remove" value="0"/>*}
{*		<table>*}
{*			<thead>*}
{*				<tr>*}
{*					<th style="width: 20px;">*}
{*						<label class="selected_label" for="selectAll" id="selectAlllabel"></label>*}
{*						<input type="checkbox" id="selectAll" name="selectAll" value="1" class="no-uniform selected_field"/>*}
{*					</th>*}
{*					<th>Дата</th>*}
{*					<th>Раздел</th>*}
{*					<th>Сообщение</th>*}
{*					<th>IP</th>*}
{*					<th style="width: 16px;"></th>*}
{*					<th style="width: 16px;"></th>*}
{*					<!-- <th style="width: 16px;"></th> -->*}
{*				</tr>*}
{*			</thead>*}
{*			<tbody>*}
{*				{foreach from=$list item='item'}*}
{*				<tr {if !$item->public}class="new"{/if}>*}
{*					<td>*}
{*						<label class="selected_label" for="list[{$item->id}]"></label>*}
{*						<input type="checkbox" id="list[{$item->id}]" name="list[{$item->id}]" value="1" class="no-uniform selected_field"/>*}
{*					</td>*}
{*					<td>{$item->date|date_format:'%d.%m.%Y %H:%M'}</td>*}
{*					<td>{$item->node->title}</td>*}
{*					<td>{$item->html}</td>*}
{*					<td>{$item->ip}</td>*}
{*					<td><a href="/adm/feedback/public/{$item->id}" title="Отметить как просмотренное" class="t-icon {if !$item->public} not-active{/if}"></a></td>*}
{*					<td><a href="/adm/feedback/spam/{$item->id}" title="Отметить как спам" class="t-icon {if !$item->spam} not-active{/if}"></a></td>*}
{*					<!-- <td><a href="/adm/feedback/edit/{$item->id}" class="t-icon edit" title="Редактировать"></a></td> -->*}
{*				</tr>*}
{*				{/foreach}*}
{*			</tbody>*}
{*		</table>*}
{*		<div class="list_buttons">*}
{*			Все отмеченные <input type="submit" class="btn" name="public" value="Просмотрены"/>&nbsp;&nbsp;<input class="btn btn_white" type="submit" value="{$_LNG_ADM.REMOVE}" id="items-remove"/>*}
{*		</div>*}
{*		<div class="list_pager">*}
{*			{$pager}*}
{*		</div>*}
{*		<div class="clear"></div>*}
{*	</form>*}

{*	{else}*}
{*	<p>{$_LNG_ADM.LIST_IS_EMPTY}</p>*}
{*	{/if}*}

{*	<script>*}
{*		$(function() {ldelim}*}
{*			$("input[type='button'][href]").click(function() {ldelim}*}
{*				window.location.href = $(this).attr("href");*}
{*			{rdelim});*}

{*			var deleteStatus = false;*}

{*			$("#items-remove").click(function(e) {ldelim}*}
{*				if(!deleteStatus)  {ldelim}*}
{*					e.preventDefault();*}
{*					$('.js-delete-text').html('{$_LNG_ADM.REMOVE_ITEMS_CONFIRM}');*}
{*					$('.js-delete-form').show();*}
{*					{rdelim}else {ldelim}*}
{*					deleteStatus = false;*}
{*					{rdelim}*}
{*				*}{*return confirm('{$_LNG_ADM.REMOVE_ITEMS_CONFIRM}');*}
{*				{rdelim});*}

{*			$(".js-delete-true").on('click', function(e) {ldelim}*}
{*				deleteStatus = true;*}
{*				$(".js-delete-form").hide();*}
{*				$("input[type='hidden'][name='remove']").val(1);*}
{*				$('#items-remove').closest('form').submit();*}

{*				{rdelim});*}

{*			$("label[for='selectAll']").click(function() {ldelim}*}
{*				var checkboxes = $(this).parents('form').find("input[type=checkbox]").not('#selectAll');*}
{*				var labels = $(this).parents('form').find("label").not(this);*}
{*				var checked = $(this).hasClass("checked");*}
{*				if (!checked) {ldelim}*}
{*					checkboxes.prop("checked", true);*}
{*					labels.addClass('checked');*}
{*				{rdelim} else {ldelim}*}
{*					checkboxes.prop("checked", false);*}
{*					labels.removeClass('checked');*}
{*				{rdelim}*}
{*			{rdelim});*}
{*		{rdelim});*}
{*	</script>*}
{*{elseif $state=='edit' || $state =='add'}*}
{*{if !empty($messages) && $messages|@count > 0}*}
{*	<div class="messages">*}
{*		{foreach from=$messages item='message'}*}
{*			{$message->html}*}
{*		{/foreach}*}
{*	</div>*}
{*	{/if}*}
{*	<form id="item-edit" action="" method="post" enctype="multipart/form-data">*}
{*		<label>Дата <span class="required"></span></label>*}
{*		<input type="text" name="date" class="text date" value="{$item->date|date_format:'%d.%m.%Y'}">*}

{*		<label>Раздел</label>*}
{*		<a href="{$item->node->getUrl()}" target="_blank">{$item->node->title}</a>*}

{*		<p></p>*}
{*		<input type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>*}
{*		<a href="/adm/feedback/list">{$_LNG_ADM.CANCEL}</a>*}
{*	</form>*}

{*{/if}*}

{if $state == 'list'}
	<section class="catalog">
		<h1 class="h1 catalog__h1">Входящие</h1>

		<div class="table-wrapper catalog__table">
			<table class="catalog-table">
				<thead>
				<tr>
					<th class="catalog-table__th">
						<span>Дата</span>
					</th>
					<th class="catalog-table__th"><span>Раздел</span></th>
					<th class="catalog-table__th">
						<span>Сообщение</span>
					</th>
					<th class="catalog-table__th"><span>IP</span></th>
					<th class="catalog-table__th"><span>Данные с метрики</span></th>
					<th class="catalog-table__th"></th>
					<th class="catalog-table__th"></th>
					<th class="catalog-table__th"></th>
				</tr>
				</thead>
				<tbody>
					{foreach from=$list item='item'}
						<tr class="catalog-table__tr {if !$item->public}catalog-table__tr--action{/if}">
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->date|date_format:'%d.%m.%Y'}&nbsp{$item->date|date_format:'%H:%M'}</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->node->title}</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->html}</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->ip}</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name" style="flex-direction: column;">{$item->getYmData()}</div>
							</td>
							<td class="catalog-table__td">
								<a href="{$adm_path}/feedback/public/{$item->id}" class=" input-elt" title="Отметить как просмотренное">
									<input class="input-elt__input hidden" style="display: none" type="checkbox" value="1" name="digital" {if $item->public}checked{/if}>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="/adm/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
								</a>
							</td>
							<td class="catalog-table__td">
								<a href="{$adm_path}/feedback/spam/{$item->id}" class=" input-elt" title="Отметить как спам">
									<input class="input-elt__input hidden" style="display: none" type="checkbox" value="1" name="digital" {if $item->spam}checked{/if}>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="/adm/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
								</a>
							</td>
							<td class="catalog-table__td">
								<a href="{$adm_path}/feedback/delete/{$item->id}" class=" ico-btn" aria-label="Удалить" title="Удалить">
									<svg fill="black" width="21" height="16">
										<use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
									</svg>
								</a>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>

			{$pager}
		</div>
	</section>
{/if}