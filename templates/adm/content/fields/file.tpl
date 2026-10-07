{*<div class="field image">*}
{*	<label>*}
{*		{$field->title}*}
{*		{if $field->required}<span class="required"></span>{/if}*}
{*	</label>*}
{*	{$field->getHtml()}*}
{*	<input type="hidden" name="{$field->name}_broswer" id="{$field->name}_broswer" value="">*}
{*	<div>*}
{*		<label class="btn" style="display: inline-block" for="{$field->name}">Загрузить с компьютера</label>*}
{*		<div class="btn js_broswer_open" data-type="web" data-name="{$field->name}_broswer" style="display: inline-block">Выбрать из структуры</div>*}
{*	</div>*}
{*</div>*}


<div class="label form__input-full {if $field->errorsMessage}mistake{/if}">
    <label class="label__content">
        <span class="label__name">{$field->title}{if $field->required}*{/if}</span>
    </label>

    <div class="label__wrapper-imgs">
        <div class="label__wrapper-btns">
            <label class="btn btn--lg btn--blue label__file-wrapper">
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

        {assign attach $field->getAttach()}
        <div class="label__imgs imgs">
            {if $attach->id}
                <div class="img" data-rel="{$field->id}">
                    <div class="img__inside">
                        <svg fill="none" width="50" height="50">
                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#file"></use>
                        </svg>
                    </div>
                    <a target="_blank" href="{$attach->getLink()}" class="img__name">{$attach->src_name}</a>
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