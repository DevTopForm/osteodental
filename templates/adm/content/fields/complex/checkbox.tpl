<label class="check">
    <input class="check__input" name="{$name}" value="1" type="checkbox" {if $field->getValue()}checked{/if}>
    {if $field->errorsMessage}
        <span class="label__mistake">{$field->errorsMessage}</span>
    {/if}
    <span class="check__name">{$field->title}{if $field->required}*{/if}</span>
</label>