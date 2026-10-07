<form id="item-variant-add" action="{$adm_path}/content/variant/{$node->id}/{$item->id}" onsubmit="saveVariant(this)" method="post" class="fields-panel" enctype="multipart/form-data">
    <input type="hidden" name="action" value="add">
    <input type="hidden" name="variant" value="">
    <input type="hidden" name="item" value="{if $item->id}{$item->id}{else}0{/if}">
    <input type="hidden" name="save_variant" value="1">
    <div class="content_item_container">
        <input class="btn" type="submit" name="save_variant" value="{$_LNG_ADM.SAVE}"/>
        {*<input class="btn" type="submit" name="apply_variant" value="{$_LNG_ADM.ITEM_SAVE}"/>*}
        <a class="btn btn_white" href="{$adm_path}/content/variant/{$node->id}/{$item->id}">{$_LNG_ADM.CANCEL}</a>
    </div>
    <br>
    <a class="return-btn" href="{$adm_path}/content/list/{$node->id}">< Назад к списку</a>
    <div class="content_item_header">{$item->title}</div>
    <input type="hidden" name="act" value="item"/>
    {foreach from=$variantFields item='field'}
        {if !$field->advanced || ($field->advanced && !$params.seo_things)}
            {include file='content/fields/'|cat:$field->field|cat:'.tpl'}
        {/if}
    {/foreach}
    <p></p>
    <input class="btn" type="submit" name="save_variant" value="{$_LNG_ADM.SAVE}"/>
    {*<input class="btn" type="submit" name="apply_variant" value="{$_LNG_ADM.ITEM_SAVE}"/>*}
    <a class="btn btn_white" href="{$adm_path}/content/variant/{$node->id}/{$item->id}">{$_LNG_ADM.CANCEL}</a>
</form>