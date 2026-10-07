{include file='menu/module-actions.tpl' type=$module active=value}
<h3 class="action-title">{$module->title} ({$module->type})</h3>
<p class="action-description edit-content">Значения параметров по умолчанию</p>
{if $state == 'edit'}
<div class="clear"></div>
{if !empty($errors) && $errors|@count > 0}
<div class="messages">
	{foreach from=$errors item='message'}
	{$message->html}
	{/foreach}
</div>
{/if}
{if $fields|@count > 0}
<form action="" method="post" enctype="multipart/form-data">
	{foreach from=$fields item='field'}
		{include file='content/fields/'|cat:$field->field|cat:'.tpl'}
	{/foreach}
	<hr/>
	<div class="field checkbox">
		<label class="selected_label" for="clearall">Очистить значения заданные в разделах</label>
		<input class="selected_field" type="checkbox" value="1" id="clearall" name="clearall"/>
	</div>
	<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}">
</form>
{/if}
{/if}