<label class="label input-yt__textarea {if $field->errorsMessage}mistake{/if}">
	<div class="label__content">
		<span class="label__name">{$field->title}{if $field->required}*{/if}</span>

		{if $field->example}
			<span class="label__text">{$field->example}</span>
		{/if}
	</div>


	<span class="label__wrapper js-webspeech {if $field->editor}label__wrapper--quill{/if}">
		<textarea {if $field->editor}data-role="editor"{/if} rows="5" class="label__input" name="{$name}">{$field->getValue()}</textarea>
		<button class="js-webspeech-btn"></button>
    </span>
	{if $field->errorsMessage}
		<span class="label__mistake">{$field->errorsMessage}</span>
	{/if}
</label>