{foreach from=$menu item='item' name='menu'}
    {if !$type || $item.type == $type}
        <option value="{$item.id}" {if $smarty.get.node_id == $node.id}selected{/if}>
            {section name=foo start=1 loop=$first}
                &nbsp;&nbsp;
            {/section}

            {$item.title}
        </option>
    {/if}

    {if $item.childs}
        {include file='content/import-tree.tpl' menu=$item.childs first=$first+1}
    {/if}

    {*if $item.public}
        <li>
            <a{if $item.active} class="active"{/if} href="{if $item.redirect}{$item.redirect}{else}{$item.url}{/if}">{$item.title}</a>
            {if $item.childs}
                {include file='content/import-tree.tpl' menu=$item.childs first=0}
            {/if}
        </li>
    {/if*}
{/foreach}