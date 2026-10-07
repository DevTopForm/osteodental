<div class="cities {if $class}{$class}{else}header__cities{/if}">
    <div class="cities__btn">
        <label class="cities__label">
            <svg fill="none" width="9" height="10">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#place"></use>
            </svg>
            <input class="cities__text js-location-input" type="text" value="{$region->title}" placeholder=""
                   name="cities">
        </label>
    </div>
    <div class="cities__its">
        <div class="cities__its-inside">
        </div>
    </div>
</div>