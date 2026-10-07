<div class="field image">
	<label>
		{$field->title}{if $field->required}*{/if}
{*		{if $field->required}<span class="required"></span>{/if}*}
	</label>
	<table class="multi-field">
		<tbody id="values-field-{$field->name}">
			{if $field->getSpecValue()|@count > 0}
			{foreach from=$field->getSpecValue() item='mValue'}
				{if $mValue->getLink()}
				<tr class="with_file">
					<td>
						<a href="{$mValue->getLink()}"/>{$mValue->src_name}</a><br/>
						<span style="">
							<input type="checkbox" name="clear_{$field->name}[{$mValue->id}]" value="1"/>
							{$_LNG_ADM.REMOVE}
						</span>
					</td>
				</tr>
				{/if}
			{/foreach}
			{else}
			<tr>
				<td>
					{$field->getHtml()}
					<label class="btn" style="display: inline-block" for="{$field->name}">Загрузить с компьютера</label>
					<div class="btn js_broswer_open" data-type="web" data-name="{$field->name}_broswer" style="display: inline-block">Выбрать из структуры</div>
				</td>
			</tr>
			{/if}
		</tbody>
	</table>
	<table class="multi-field">
		<tbody>
			<tr>
				<td class="actions">
					<a class="icon list-add" href="#add-field-{$field->name}"></a><a class="icon list-remove" href="#remove-field-{$field->name}"></a>
				</td>
			</tr>
		</tbody>
	</table>
	{literal}
	<script type="text/javascript">
		$(function() {
			var fieldName = "{/literal}{$field->name}{literal}";
			var newKey = parseInt("{/literal}{if $field->value}{$field->value|@array_keys|@max}{else}0{/if}{literal}", 10) + 1;
			var valuesContainer = $("#values-field-" + fieldName);
			
			$("a.list-add").livequery(function() {
				$(this).click(function() {
					$(valuesContainer).append("<tr><td><input type=\"file\" name=\"" + fieldName + "[" + newKey + "]\" /></td></tr>");
					newKey += 1;
					
					return false;
				});
			});
			
			$("a.list-remove").livequery(function() {
				$(this).click(function() {
					var parent = $(this).parent().parent();
					$("input.text", parent).val("");
					
					if ($("tr:not('.with_file')", valuesContainer).length > 1) {
						$(valuesContainer).find('tr:last').remove();
					} else if(($("tr.with_file", valuesContainer).length > 0) && $("tr:not('.with_file')", valuesContainer).length > 0){
						$(valuesContainer).find('tr:last').remove();
					}
					return false;
				});
			});
		});
	</script>
	{/literal}
	<div class="clear"></div>
</div>