<label class="label form__input-half {if $field->errorsMessage}mistake{/if}">
	<div class="label__content">
		<span class="label__name">{$field->title}{if $field->required}*{/if}</span>

		{if $field->example}
			<span class="label__text">{$field->example}</span>
		{/if}
	</div>


	<span class="label__wrapper">
      <input type="date" value="{$field->getValue()}" class="label__input" name="{$field->name}" placeholder="{$field->default}">
		{if $field->errorsMessage}
			<span class="label__mistake">{$field->errorsMessage}</span>
		{/if}
    </span>
</label>