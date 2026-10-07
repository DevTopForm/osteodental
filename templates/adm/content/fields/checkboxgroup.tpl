<div class="field">
	<label>
		{$field.title}{if $field.required}*{/if}
{*		{if $field.required}<span class="required"></span>{/if}*}
	</label>
	{if $field.options_data|@count > 0}
		{foreach from=$field.options_data item='option'}
			<label><input type="checkbox" name="{$field.name}[{$option.value}]" value="1"{if $option.checked} checked="checked"{/if}/>{$option.title}</label>
		{/foreach}
	{/if}
</div>
