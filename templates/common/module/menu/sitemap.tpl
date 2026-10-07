<div>
    {if !empty($content) && $content|@count>0}
        {include file='module/menu/sitemap-menu.tpl' menu=$content first=1}
    {/if}
</div>