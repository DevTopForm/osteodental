<div class="fieldset js-to-expand opened">
    <div class="fieldset__top">
        <button class="btn fieldset__head js-filter-expand opened">
            <span>{$title}</span>
            <span class="fieldset__toggler">
                <svg fill="none" width="13" height="13">
                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#chevron"></use>
                </svg>
            </span>
        </button>
        <div class="fieldset__chosen">
            <span>Не выбрано</span>
        </div>
    </div>
    <div class="fieldset__body">
        <div class="fieldset__body-wrapper">
            <div class="fieldset__body-inside fieldset__body-inside--check">
                {foreach from=$filters key=key item=filter}
                    <label class="check-label">
                        <input name="{$name}[]" {if $filter.active}checked{/if} class="check fieldset__check" type="checkbox" value="{$filter.value}">
                        <span>{$filter.title}</span>
                    </label>
                {/foreach}
            </div>
        </div>
    </div>
</div>