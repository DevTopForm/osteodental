<form class="category-actions__tags category-inputs">
    {foreach from=$filters key=key item=filter}
        <label class="category-inputs__label" for="key_{$name}-{$filter.value}">
            <input class="category-inputs__input js-filters-tag" type="checkbox" id="key_{$name}-{$filter.value}" name="{$name}[]"
                   {if $filter.active}checked{/if} value="{$filter.value}">
            <span class="category-inputs__span">{$title}</span>
            <div class="tag tag--{if $filter.image}{$filter.title}{else}other{/if}">
                {if $filter.image}
                    <img src="{$filter.image}" alt="">
                {else}
                    {$filter.title}
                {/if}
            </div>
        </label>
    {/foreach}
</form>