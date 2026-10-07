<div class="container pb-60-100 pt-60-100">
    <h1 class="h1 mb-30">{$node->h1|default:$node->title}</h1>
    <div class="top-text mb-20-40 text">
        {$node->before_text}
    </div>
    <div class="doctors-list">
        {if $content}
            {foreach from=$content item='item' name='items'}
                {include file='module/staff/include/element.tpl' content=$item}
            {/foreach}
        {else}
            Врачей не найдено
        {/if}
    </div>

</div>