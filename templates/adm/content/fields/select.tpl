<label class="label form__input-full {if $field->errorsMessage}mistake{/if}">
    <div class="label__content">
        <span class="label__name">{$field->title}{if $field->required}*{/if}</span>
        {if $field->example}
            <span class="label__text">{$field->example}</span>
        {/if}
    </div>

    <span class="label__wrapper label__wrapper--select">
      <select class="label__select" name="{$field->name}">
        <option value="0" {if !$field->getValue()}selected{/if}>Не выбрано</option>

          {foreach from=$field->options_data item="option"}
              <option value="{$option.value}" {if $field->getValue()->id && $field->getValue()->id == $option.value}selected{elseif $field->getValue() == $option.value}selected{/if}>{$option.title}</option>
          {/foreach}
      </select>
    </span>
    {if $field->errorsMessage}
        <span class="label__mistake">{$field->errorsMessage}</span>
    {/if}
</label>