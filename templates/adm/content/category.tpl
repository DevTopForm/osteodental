<h3 class="action-title">Групповые операции</h3>
<p class="action-description edit-content">Управление товарами</p>
{if !empty($messages) && $messages|@count > 0}
    <div class="messages">
        {foreach from=$messages item='message'}
            {$message->html}
        {/foreach}
    </div>
{/if}
{*<pre>
{$filters.node|@var_dump}
</pre>*}
<form action="/adm/catalog/" method="GET" id="catalog_search" enctype="text/plain">
    <input type="hidden" name="catalog_filter" value="Y">
    <div class="inline-field">{$filters.node}</div>
    <div class="inline-field">
        <div class="filter-container">
            <label>Название:</label>
            <input type="text" name="ft_title" value="{$smarty.get.ft_title}">
        </div>
    </div>
    <div class="inline-field">
        <div class="filter-container">
            <label>Название:</label>
            <input type="text" name="ft_title" value="{$smarty.get.ft_title}">
        </div>
    </div>
    <div class="inline-field">
        <label>&nbsp;</label>
        <button class="btn" type="submit">Фильтровать</button>
    </div>
    <div class="clear"></div>
</form>
<script type="text/javascript">
    {literal}
    $(document).ready(function(){
        if ($('table.catalog-action-list.hide').length) {
            var heightTable_Sf = 70;
            var topPos = $('table.catalog-action-list').offset().top;
            var widthTable = $('table.catalog-action-list:not(.hide)').width();
            $('table.catalog-action-list.hide').css('width', Number(widthTable+1)+'px')
            $(window).scroll(function() {
                if(topPos < $(window).scrollTop()) {
                    $('table.catalog-action-list.hide').css('display', 'table');
                } else {
                    $('table.catalog-action-list.hide').css('display', 'none');
                };
            })
        }
    });
    {/literal}
</script>
{if !empty($list)  && $list|@count > 0}
    <form action="" method="post">
        <table>
            <thead>
            <tr>
                <th style="width: 4%;"><input type="checkbox" class="no-uniform" id="selectAll" value="1"/></th>
                <th style="width: 20%;">Название</th>
                <th style="width: 10%;">Бренд</th>
                <th style="width: 10%;">Артикул</th>
                <th style="width: 10%;">Акции</th>
                <th style="width: 10%;">Промокод</th>
                <th style="width: 3%;"></th>
                <th style="width: 3%;"></th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$list item='item'}
                <tr>
                    <td><input type="checkbox" class="no-uniform" name="list[{$item->id}]" value="{$item->id}"/></td>
                    <td><a href="/adm/content/edit/{$item->node->id}/{$item->id}">{if $item->naimenovanie}{$item->naimenovanie}{else}{$item->title}{/if}</a></td>
                    <td>{$item->brend}</td>
                    <td>{$item->artikul}</td>
                    <td>
                        {if $item->stocks}
                            {foreach from=$item->stocks item=sItem}
                                <a class="edit-selects" href="/adm/content/edit/800031/{$sItem->id}"><br>{if $sItem->title}{$sItem->title}{/if}</a>
                            {/foreach}
                        {/if}
                    </td>
                    <td>
                        {if $item->promocode}
                            {foreach from=$item->promocode item=promo}
                                <p>{$promo}</p>
                            {/foreach}
                        {/if}
                    </td>
                    <td><span class="t-icon {if !$item->public} not-active{/if}"></span></td>
                    <td><a href="/adm/content/edit/{$item->node->id}/{$item->id}" class="icon edit"></a></td>
                </tr>
                {if !empty($item->childrens) && $item->childrens|@count > 0}
                    <tr>
                        <th></th>
                        <th colspan="14">Варианты товара</th>
                    </tr>
                    <tr>
                        <td colspan="15" style="padding: 0;">
                            <table style="margin: 0;background-color: #e9e9e9;">
                                <tbody>
                                {foreach from=$item->childrens item='variant'}
                                    <tr>
                                        <td style="width: 4%;"><input type="checkbox" class="no-uniform" name="list[{$variant->id}]" value="{$variant->id}"/></td>
                                        <td style="width: 20%;"><a href="/adm/content/edit/{$variant->node->id}/{$variant->id}">{$variant->title}</a></td>
                                        <td style="width: 10%;">{$item->proizv->title}</td>
                                        <td style="width: 10%;">{$variant->article}</td>
                                        <td style="width: 10%;"><a class="edit-select" id="linejjka-{$variant->id}" href="/adm/catalog/ajaxEdit/{$variant->id}/linejjka">Теги:<br>{if $variant->linejjka_a}{$variant->linejjka_a}{/if}</a></td>
                                        <td style="width: 10%;"><a class="edit-select" id="vozrast-{$variant->id}" href="/adm/catalog/ajaxEdit/{$variant->id}/vozrast">Теги:<br>{if $variant->vozrast_a}{$variant->vozrast_a}{/if}</a></td>
                                        <td style="width: 10%;"><a class="edit-select" id="vkus-{$variant->id}" href="/adm/catalog/ajaxEdit/{$variant->id}/vkus">Теги:<br>{if $variant->vkus_a}{$variant->vkus_a}{/if}</a></td>
                                        <td style="width: 10%;"><a class="edit-select" id="naznachenie-{$variant->id}" href="/adm/catalog/ajaxEdit/{$variant->id}/naznachenie">Теги:<br>{if $variant->naznachenie_a}{$variant->naznachenie_a}{/if}</a></td>
                                        <td><a class="edit-select" id="tip_tovara-{$variant->id}" href="/adm/catalog/ajaxEdit/{$variant->id}/tip_tovara">Теги:<br>{if $variant->tip_tovara}{$variant->tip_tovara}{/if}</a></td>
                                        <td><span class="t-icon {if !$variant->for_market} not-active{/if}"></span></td>
                                        <td style="width: 10%;">
                                            {if $variant->stocks}
                                                {foreach from=$variant->stocks item=sVariant}
                                                    <a class="edit-selects" href="/adm/content/edit/800031/{$sVariant->id}"><br>{if $sVariant->title}{$sVariant->title}{/if}</a>
                                                {/foreach}
                                            {/if}
                                        </td>
                                        <td style="width: 10%;">{$variant->discount_2}</td>
                                        <td style="width: 10%;">
                                            {if $variant->promocode}
                                                {foreach from=$variant->promocode item=vPromo}
                                                    <p>{$vPromo}</p>
                                                {/foreach}
                                            {/if}
                                        </td>
                                        <td style="width: 3%;"><span class="t-icon {if !$variant->public} not-active{/if}"></span></td>
                                        <td style="width: 3%;"><a href="/adm/content/edit/{$variant->node->id}/{$variant->id}" class="icon edit"></a></td>
                                    </tr>
                                {/foreach}
                                </tbody>
                            </table>
                        </td>
                    </tr>
                {/if}
            {/foreach}
            </tbody>
        </table>
        <div>
            <p>Все отмеченные:</p>
            {if $allIds}
                <div class="all-catalog-field">
                    <input type="checkbox" class="no-uniform" nocheck="1" name="check_all" value="{$allIds}"/>
                    <span>Выбрать все товары с учетом фильтра</span>
                </div>
            {/if}
            <div class="inline-field">
                <select name="listaction" class="styled small">
                    <option value="">- Выберите действие -</option>
                    <option value="public">Опубликовать</option>
                    <option value="public_clear">Снять с публикации</option>
                    <option value="text">Заполнить текст</option>
                    {if $data.promo}
                        <option value="promo">Привязать промокод</option>
                    {/if}
                    {if $data.promo}
                        <option value="promo_clear">Отвязать промокоды</option>
                    {/if}
                    {if $data.stock}
                        <option value="stock">Привязать акции</option>
                    {/if}
                    {if $data.stock}
                        <option value="stock_clear">Отвязать акции</option>
                    {/if}
                    {if $data.brands}
                        <option value="brand">Привязать бренд</option>
                    {/if}
                    <option value="category">Перенести в категорию</option>
                    <option value="category_advance">Перенести в сборную</option>
                </select>
            </div>
            <div class="inline-field" style="border-bottom: 20px">
                <div style="display: none;"></div>
                <div id="text" class="listaction small" style="display: none;">
                    - Добавьте текст -
                    <textarea id="text" name="text" class="text editor" rows="5" aria-hidden="true"></textarea>
                </div>
                {if $data.promo}
                    <div id="promo" class="listaction small" style="display: none;">
                        - Выберите промокод -
                        {foreach from=$data.promo item=item}
                            <label><input type="checkbox" name="promo[]" nocheck="1" value="{$item->id}" class="no-uniform"> {$item->title}</label>
                        {/foreach}
                    </div>
                {/if}
                {if $data.stock}
                    <div id="stock" class="listaction small" style="display: none;">
                        - Выберите акцию -
                        {foreach from=$data.stock item=item}
                            <label><input type="checkbox" name="stock[]" nocheck="1" value="{$item->id}" class="no-uniform"> {$item->title}</label>
                        {/foreach}
                    </div>
                {/if}
                {if $data.brands}
                    <div id="brand" class="listaction small" style="display: none;">
                        <select name="brand" class="listaction small">
                            <option value="">- Выберите бренд -</option>
                            {foreach from=$data.brands item=item}
                                <option value="{$item->id}">{$item->title}</option>
                            {/foreach}
                        </select>
                    </div>
                {/if}
                {if $data.tree}
                    <div id="category" class="listaction small" style="display: none;">
                        <select name="category" class="listaction small">
                            <option value="">- Выберите категорию -</option>
                            {include file='content/nodetree.tpl' tree=$data.tree spacer="-" cur_pid=$smarty.get.fi_node}
                        </select>
                    </div>
                {/if}
                {if $data.tree}
                    <div id="category_advance" class="listaction small" style="display: none;">
                        <select name="advanced_category" class="listaction small">
                            <option value="">- Выберите сборную категорию -</option>
                            {include file='content/nodetree.tpl' tree=$data.tree spacer="-" cur_pid=$smarty.get.fi_node}
                        </select>
                    </div>
                {/if}
            </div>
            <input class="btn" type="submit" value="Отправить">
        </div>
        <div class="list_pager">
            {$pager}
        </div>
        <div class="clear"></div>
    </form>
{else}
    <p>{$_LNG_ADM.LIST_IS_EMPTY}</p>
{/if}

<script>
    $(function() {ldelim}
        $("input[type='button'][href]").click(function() {ldelim}
            window.location.href = $(this).attr("href");
            {rdelim});

        $(".edit-select").fancybox({ldelim}

            {rdelim});

        $("#selectAll").click(function() {ldelim}
            var checkboxes = $("input[type=checkbox]",$(this).parents('form')).not(this).not('input[nocheck=1]');
            var checked = $(this).prop("checked");
            if (checked){ldelim}
                checkboxes.prop("checked", checked);
                {rdelim} else {ldelim}
                checkboxes.prop("checked", checked);
                {rdelim}
            {rdelim});

        $('select[name=listaction]').change(function(){ldelim}
            $('select.listaction').hide();
            $('div.listaction').hide();
            if ($(this).val() != ''){ldelim}
                $('select[name='+$(this).val()+'],select[name="'+$(this).val()+'[]"]').show();
                $('#'+$(this).val()).show();
                {rdelim}
            {rdelim});
        $('select[name=listaction]').change();
        {rdelim});
</script>
