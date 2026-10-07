<div class="label {if $field->errorsMessage}mistake{/if}">
    <div class="imgs imgs--sortable">
        <label class="btn label__file-wrapper label-file">
            <input type="file" class="label__file" name="{$name}" accept="" value="" data-max-length="20">
            <svg fill="none" width="16" height="16">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#plus"></use>
            </svg>
            <span>{$field->title}{if $field->required}*{/if}</span>
            <div class="label__file-uploader uploader">
                <div class="uploader-inside"></div>
            </div>
        </label>


        {assign attach $field->getAttach()}
        {if $attach->id}
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
                                <use href="{$adm_path}/assets/img/sprite.svg#clear"></use>
                            </svg>
                        </div>
                        <label class="img__label">
                            <input type="checkbox" name="clear_{$name}" value="1">
                            <span>Удалить</span>
                        </label>
                    </div>
                {/if}
            </div>
        {/if}
    </div>
</div>