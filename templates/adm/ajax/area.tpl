{if $state == 'edit'}
	<div class="panel">
		<div class="panel__name">Свойства области</div>
		<form class="form" action="{$adm_path}/area/edit/{$node->id}/{$area->id}" method="post">
			<div class="form__fieldset-column login-block__fieldset">
				<label class="label form__input-column">
					<div class="label__content">
						<span class="label__name">Тип раздела</span>
					</div>
					<span class="label__wrapper label__wrapper--select">
						<select class="label__select" name="node_type">
							{foreach from=$data.type item='type'}
								{assign value=$type->type var='itemType'}
								{if $data.template.$itemType}
									<option value="{$type->type}"{if $type->type == $nodeArea->object->type->type} selected="selected"{/if} >{$type->title}</option>
								{/if}
							{/foreach}
						</select>
        			</span>
				</label>
				<label class="label form__input-column">
					<div class="label__content">
						<span class="label__name">Раздел</span>
					</div>
					<span class="label__wrapper label__wrapper--select">
						<select class="label__select" name="node_id">
							{foreach from=$data.nodes item='node'}
								<option {if !$nodeArea || $nodeArea->object->type->type != $node->type->type}disabled{/if} class="{$node->type->type}" value="{$node->id}" {if $nodeArea && $node->id == $nodeArea->object->id} selected="selected"{/if}>{$node->title}</option>
							{/foreach}
						</select>
					</span>
				</label>
				<label class="label form__input-column">
					<div class="label__content">
						<span class="label__name">Шаблон в блок</span>
					</div>
					<span class="label__wrapper label__wrapper--select">
						<select class="label__select" name="node_template">
							 {foreach from=$data.template key='tpl_key' item='templates'}
								 <optgroup label="{$tpl_key}">
									 {foreach from=$templates item='tpl'}
										 <option {if !$nodeArea || $nodeArea->object->type->type != $tpl->type}disabled{/if} class="{$tpl->type}" value="{$tpl->id}" {if $nodeArea && $tpl->id == $nodeArea->template} selected="selected"{/if}>{$tpl->title}</option>
									 {/foreach}
								 </optgroup>
							 {/foreach}
	  					</select>
        			</span>
				</label>
			</div>
			<div class="form__fieldset-inputs">
				<label class="check form__check">
					<input class="check__input" name="allsub" value="1" type="checkbox">
					<span class="check__name">Применить ко всем подразделам</span>
				</label>
				<label class="check form__check">
					<input class="check__input" name="all" value="1" type="checkbox">
					<span class="check__name">Применить на всем сайте</span>
				</label>
			</div>
			<div class="form__add-btns">
				<a class="form__add-link" href="{$adm_path}/area/delete/{$nodeArea->id}" rel="Поиск">Отвязать</a>
				<a class="form__add-link" href="{$adm_path}/area/deletesub/{$nodeArea->id}">Отвязать в подразделах</a>
				<a class="form__add-link" href="{$adm_path}/area/deleteall/{$nodeArea->id}">Отвязать на всем сайте</a>
			</div>
			<button name="save" value="Сохранить" class="btn btn--blue btn--lg ">
				<span>Сохранить</span>
			</button>
		</form>
	</div>
{elseif $state == 'params'}
	<div class="panel">
		<h3>{$_LNG_ADM.BLOCK_PARAMS}</h3>

		{if $messages}
			<div class="messages">
				{foreach from=$messages item='message'}
					{$message->html}
				{/foreach}
			</div>
		{/if}
		{if $fields}
			<form id="block-properties" action="{$adm_path}/area/params/{$nodeArea->id}" method="post" enctype="multipart/form-data">
				{foreach from=$fields item='field'}
					{include file='content/fields/'|cat:$field->field|cat:'.tpl'}
				{/foreach}
				<p></p>
				<div id="area-actions">
					<button name="save" value="{$_LNG_ADM.SAVE}" class="btn btn--blue btn--lg ">
						<span>{$_LNG_ADM.SAVE}</span>
					</button>
				</div>
			</form>
		{else}
			<p>{$_LNG_ADM.EMPTY_SETTINGS_LIST}</p>
		{/if}
	</div>
{/if}