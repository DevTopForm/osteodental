<div class="label form__input-full {if $field->errorsMessage}mistake{/if}">
    <div class="label__name">
        {$field->title}{if $field->required}*{/if}
{*        {if $field->required}<span class="required"></span>{/if}*}
    </div>

    {$field->getHtml()}
    {if $field->errorsMessage}
        <span class="label__mistake">{$field->errorsMessage}</span>
    {/if}
</div>
