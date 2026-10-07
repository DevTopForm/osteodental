<div class="field image">
	<label>
		{$field->title}{if $field->required}*{/if}
{*		{if $field->required}<span class="required"></span>{/if}*}
	</label>
	{$field->getHtml()}
</div>
