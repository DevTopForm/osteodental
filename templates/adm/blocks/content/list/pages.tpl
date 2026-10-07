<div class="pages {if $class}{$class}{/if}">
    <label class="pages__label">
        <span class="pages__label-name">Показывать на странице:</span>
        <select class="pages__select js_per_page">
            <option value="10" {if !$count == 10}selected{/if}>10</option>
            <option value="20" {if $count == 20}selected{/if}>20</option>
            <option value="50" {if $count == 50}selected{/if}>50</option>
            <option value="100" {if $count == 100}selected{/if}>100</option>
            <option value="all" {if !$count}selected{/if}>Все</option>
        </select>
        <span class="pages__svg">
              <svg fill="none" width="12" height="7">
                <use xlink:href="/adm/assets/img/sprite.svg#chevron"></use>
              </svg>
            </span>
    </label>

    {$pager}
</div>