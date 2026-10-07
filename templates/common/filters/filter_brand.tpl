<div class="fieldset opened">
    <button class="btn fieldset__head js-filter-sub">
        <span>{$title}</span>
        <span class="fieldset__toggler">
            <svg fill="none" width="20" height="20">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#chevron"></use>
            </svg>
        </span>
    </button>
    <div class="fieldset__body">
        <div class="fieldset__body-wrapper">
            <div class="fieldset__body-inside fieldset__body-inside--brand">
                {foreach from=$filters key=key item=filter}
                    <label class="check-tag" for="key_{$name}-{$filter.value}">
                        <input id="key_{$name}-{$filter.value}" name="{$name}[]" class="check-tag__input" type="checkbox"
                               {if $filter.active}checked{/if} value="{$filter.value}">
                        <span class="check-tag__inside">
                            {$filter.title}
                        </span>
                    </label>
                {/foreach}
            </div>
        </div>
    </div>
</div>