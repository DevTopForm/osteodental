<div class="label form__input-full {if $field->errorsMessage}mistake{/if}">
    <div class="label__content">
        <span class="label__name">{$field->title}{if $field->required}*{/if}</span>

        {if $field->example}
            <span class="label__text">{$field->example}</span>
        {/if}
    </div>
    <div class="label__wrapper-labels js-yt-elements" data-field-name="{$field->name}"
         data-field-id="{if $field->getSpecValue()|@count>0}{$field->getSpecValue()|@array_keys|@max}{else}1{/if}">
        {if $field->getSpecValue()|@count > 0}
            {* Костыль! Не удалять! Валидация для установки $field->errorsMessage *}
            {*            {$a = $field->validate(true)}*}
            {foreach $field->getSpecValue() as $row}
                <div class="input-yt input-yt--block">
                    <label class="check input-yt__check">
                        <input class="check__input" name="{$field->name}_delete[]" value="{$row.rowId}" type="checkbox">
                        <span class="check__name js-row-id">id: {$row.rowId}</span>
                    </label>

                    <div class="input-yt__content">
                        {foreach $row.fields as $subfield}
                            {$name = "{$field->name}[{$row.rowId}][{$subfield->id}]"}
                            {include file='content/fields/complex/'|cat:$subfield->field|cat:'.tpl' field=$subfield name=$name}
                        {/foreach}
                    </div>
                </div>
            {/foreach}
        {else}
            <div class="input-yt input-yt--block">
                <label class="check input-yt__check">
                    <input class="check__input" name="{$field->name}_delete[]" value="{$row.rowId}" type="checkbox">
                    <span class="check__name js-row-id">id: 1</span>
                </label>

                <div class="input-yt__content">
                    {foreach $field->subfields as $subfield}
                        {$name = "{$field->name}[1][{$subfield->id}]"}
                        {include file='content/fields/complex/'|cat:$subfield->field|cat:'.tpl' field=$subfield->node_field name=$name}
                    {/foreach}
                </div>
            </div>
        {/if}

        <div class="label__wrapper-btns js-place">
            <div class="btn btn--lg btn--light js-yt-elements-add">
                <svg fill="none" width="16" height="16">
                    <use href="{$adm_path}/assets/img/sprite.svg#add"></use>
                </svg>
                <span>Добавить элемент</span>
            </div>
            <div class="btn btn--lg btn--bd js-yt-elements-remove">
                <span>Удалить</span>
            </div>

            {if $field->errorsMessage}
                <span class="label__mistake">{$field->errorsMessage}</span>
            {/if}
        </div>
    </div>
</div>
