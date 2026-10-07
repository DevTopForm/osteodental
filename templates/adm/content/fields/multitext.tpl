<div class="label form__input-full {if $field->errorsMessage}mistake{/if}">
    <div class="label__content">
        <span class="label__name">{$field->title}{if $field->required}*{/if}</span>

        {if $field->example}
            <span class="label__text">{$field->example}</span>
        {/if}
    </div>
    <div class="label__wrapper-labels field-multiselect field-multiselect-{$field->name}">
        {if $field->getSpecValue()|@count > 0}
            {foreach $field->getSpecValue() as $text}
                <div class="input-yt">
                    <label class="check input-yt__check">
                        <input class="check__input" name="{$field->name}_delete[]" value="{$text.id}" type="checkbox">
                        <span class="check__name">выбрать элемент</span>
                    </label>
                    <label class="input-yt__label">
                        <input type="text" class="input-yt__input" name="{$field->name}[{$text.id}]"
                               value="{$text.value}">
                    </label>
                    {if $field->errorsMessage}
                        <span class="label__mistake">{$field->errorsMessage}</span>
                    {/if}
                </div>
            {/foreach}
        {else}
            <div class="input-yt">
                <label class="check input-yt__check">
                    <input class="check__input" name="{$field->name}_delete[]" value="1" type="checkbox">
                    <span class="check__name">выбрать элемент</span>
                </label>
                <label class="input-yt__label">
                    <input type="text" class="input-yt__input" name="{$field->name}[]"
                           value="">
                </label>
            </div>
        {/if}

        <div class="label__wrapper-btns">
            <div class="btn btn--lg btn--light field-multiselect__add js-add-multitext-line">
                <svg fill="none" width="16" height="16">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#add"></use>
                </svg>
                <span>Добавить элемент</span>
            </div>
            <div class="btn btn--lg btn--bd field-multiselect__remove js-remove-multitext-line">
                <span>Удалить</span>
            </div>

            {if $field->errorsMessage}
                <span class="label__mistake">{$field->errorsMessage}</span>
            {/if}
        </div>
    </div>
</div>

{literal}
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        const fieldName = "{/literal}{$field->name}{literal}";
        let newKey = parseInt("{/literal}{if $field->getSpecValue()|@count>0}{$field->getSpecValue()|@array_keys|@max}{else}1{/if}{literal}", 10) + 1;
        const valuesContainer = document.querySelector(".field-multiselect-" + fieldName);
        const addBtn = valuesContainer.querySelector(".js-add-multitext-line");
        const removeBtn = valuesContainer.querySelector(".js-remove-multitext-line");

        addBtn.addEventListener("click", function () {
            const btns = valuesContainer.querySelector(".label__wrapper-btns");
            // valuesContainer.insertBefore("123", btns);
            btns.insertAdjacentHTML('beforebegin',
                `<div class="input-yt">
                    <label class="check input-yt__check">
                        <input class="check__input" name="${fieldName}_delete[]" value="${newKey}" type="checkbox">
                        <span class="check__name">выбрать элемент</span>
                    </label>
                    <label class="input-yt__label">
                        <input type="text" class="input-yt__input" name="${fieldName}[${newKey}]"
                               value="">
                    </label>
                </div>`);

            newKey += 1;
        })

        removeBtn.addEventListener("click", function () {
            const checked = valuesContainer.querySelectorAll("input[type=checkbox]:checked");
            checked.forEach((input) => {
               input.closest(".input-yt").remove();
            });
        });
    });
</script>
{/literal}