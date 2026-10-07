<div class="form__check-group label form__input-full {if $field->errorsMessage}mistake{/if}">
	<label class="check">
		<input class="check__input" name="{$field->name}" value="1" type="checkbox" {if $field->getValue()}checked{/if}>
		{if $field->errorsMessage}
			<span class="label__mistake">{$field->errorsMessage}</span>
		{/if}
		<span class="check__name">{$field->title}{if $field->required}*{/if}</span>
	</label>
</div>