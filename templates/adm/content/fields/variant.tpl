<div class="inline-field variants">
	<label>
		{$field->title}{if $field->required}*{/if}
	</label>
	{assign var='spec_data' value=$field->getSpecValue()}
	{foreach from=$spec_data.variants item='variant'}
		<div class="item_variant">
			<label class="remove"><input type="checkbox" name="remove_{$field->name}[{$variant->id}]" value="{$variant->id}" class="checkbox" /> Удалить вариант</label>
			{foreach from=$variant->nodes_fields  item='inner_field'}
				{if !$inner_field->advanced || ($inner_field->advanced && !$inner_field.seo_things)}
					{include file='content/fields/'|cat:$inner_field->field|cat:'.tpl' field=$inner_field}
				{/if}
			{/foreach}
		</div>
	{/foreach}

	Добавить новый
	<div class="item_variant new">
		{foreach from=$spec_data.fields  item='inner_field'}
				{include file='content/fields/'|cat:$inner_field->field|cat:'.tpl' field=$inner_field}
		{/foreach}
	</div>
</div>
