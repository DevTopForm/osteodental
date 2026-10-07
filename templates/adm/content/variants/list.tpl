<div class="content_item_container">
    <div class="btn js_add_variant"  data-url="{$adm_path}/content/variant/{$node->id}/{$item->id}" style="display: inline-block;">{$_LNG_ADM.ADD_VARIANT}</div>
    <div class="btn btn_white js_variant_cancel" style="display: inline-block;" data-url="{$adm_path}/content/variant/{$node->id}/{$item->id}" >{$_LNG_ADM.VARIANT_CLOSE}</div>
</div>
<table>
    <thead>
        <tr>
            <th>Название варианта</th>
            <th style="width: 20px;"></th>
            <th style="width: 20px;"></th>
        </tr>
    </thead>
    {if $variants}
        <tbody node="{$node->id}">
            {foreach from=$variants item='variant' name='list'}
                <tr itemId="{$variant->id}">
                    <td>{$variant->title}</td>
                    <td><a href="#" data-variant="{$variant->id}" data-item="{$item->id}" data-url="{$adm_path}/content/variant/{$node->id}/{$item->id}" class="t-icon js_edit_variant edit"></a></td>
                    <td><a href="#" data-variant="{$variant->id}" data-item="{if $item->id}{$item->id}{else}0{/if}" data-url="{$adm_path}/content/variant/{$node->id}/{$item->id}" class="icon js_remove_variant remove"></a></td>
                </tr>
            {/foreach}
        </tbody>
    {/if}
</table>