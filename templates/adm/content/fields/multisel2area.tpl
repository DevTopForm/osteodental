<div class="label form__input-full {if $field->errorsMessage}mistake{/if}">
    <label class="label__name">
        {$field->title}{if $field->required}*{/if}
    </label>
    {$field->getHtml()}
    {if $field->errorsMessage}
        <span class="label__mistake">{$field->errorsMessage}</span>
    {/if}
</div>

