<label class="label form__input-full {if $field->errorsMessage}mistake{/if}">
	<div class="label__content">
		<span class="label__name">{$field->title}{if $field->required}*{/if}</span>
		<span class="label__text">(Если поле оставить пустым, ЧПУ сгенерируется автоматически)</span>
	</div>


	<span class="label__wrapper label__wrapper--alias">
		<input type="text" value="{$field->getValue()}" class="label__input" name="{$field->name}" placeholder="{$field->default}">
		{if $field->errorsMessage}
			<span class="label__mistake">{$field->errorsMessage}</span>
		{/if}
		<span class="label__text">{$node->url}/<span class="label__alias">{$field->getValue()}</span></span>
    </span>
</label>