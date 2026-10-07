<div class="catalog-controls">
    <div class="catalog-controls__btns">
        <a href="{$adm_path}/content/add/{$node->id}" class="btn btn--blue btn--shrink">
            <svg fill="none" width="16" height="16">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#add"></use>
            </svg>
            <span>Добавить элемент</span>
        </a>
        <button form="catalog-list-form" type="submit" name="delete" value="1" class="btn btn--bd btn--lg btn--shrink js-delete-multiple">
            <svg fill="none" width="16" height="16">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
            </svg>

            <span>Удалить</span>
        </button>
        <button form="catalog-list-form" type="submit" name="copy" value="1" class="btn btn--bd btn--lg btn--shrink js-item-multiple">
            <svg fill="none" width="16" height="16">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#copy"></use>
            </svg>

            <span>Копировать</span>
        </button>

        <div class="catalog-controls__search-block js-to-expand-close">
            <form method="get" enctype="multipart/form-data" class="search-block catalog-controls__search">
                <label class="search-block__label">
                    <input type="search" name="search_text" value="{$smarty.get.search_text}" class="search-block__input">
                </label>
                <button type="submit" name="search" value="Искать" class="btn btn--blue search-block__btn" aria-label="начать поиск">
                    <svg fill="none" width="14" height="14">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#search"></use>
                    </svg>
                </button>
            </form>
            <button type="submit" class="btn btn--blue btn--square js-expand-close" aria-label="начать поиск">
                <svg fill="none" width="14" height="14">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#search"></use>
                </svg>
            </button>
        </div>
    </div>

    {include file='blocks/content/list/pages.tpl'}
</div>