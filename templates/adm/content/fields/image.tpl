{*<div class="field image">*}
{*	<label>*}
{*		{$field->title}*}
{*		{if $field->required}<span class="required"></span>{/if}*}
{*	</label>*}
{*	<div class="load_image" id="list_image_{$field->id}"></div>*}
{*	{$field->getHtml()}*}
{*	<label class="btn" style="display: inline-block" for="{$field->name}">Загрузить с компьютера</label>*}
{*	<input type="hidden" name="{$field->name}_broswer" id="{$field->name}_broswer" value="">*}
{*	<div class="btn js_broswer_open" data-type="web" data-name="{$field->name}_broswer" style="display: inline-block">Выбрать из структуры</div>*}
{*</div>*}

<div class="label form__input-full {if $field->errorsMessage}mistake{/if}">
    <label class="label__content">
        <span class="label__name">{$field->title}{if $field->required}*{/if}</span>
    </label>

    <div class="label__wrapper-imgs">
        <div class="label__wrapper-btns">
            <label class="btn btn--lg btn--blue label__file-wrapper js-image-wrapper">
                {$field->getHtml()}
                <svg fill="none" width="16" height="16">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#"></use>
                </svg>
                <span>Загрузить с компьютера</span>
                <div class="label__file-uploader uploader">
                    <div class="uploader-inside"></div>
                </div>
                {if $field->errorsMessage}
                    <span class="label__mistake">{$field->errorsMessage}</span>
                {/if}
            </label>
        </div>
        <div class="label__imgs imgs">
            {assign var=image value=$field->getSpecValue()}

            {if $image->id}
                <div class="img" data-rel="{$image->id}">
                    <div class="img__inside">
                        <img class="img__img" src="{$image->getLink('admin')}" alt="" width="50" height="50">
                    </div>
                    <div class="img__name">{$image->title}</div>
                    <div class="btn img__close">
                        <svg fill="none" width="16" height="16">
                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#clear"></use>
                        </svg>
                    </div>
                    <label class="img__label">
                        <input type="checkbox" name="clear_{$field->name}" value="1">
                        <span>Удалить</span>
                    </label>
                </div>
            {/if}
        </div>
    </div>
</div>
