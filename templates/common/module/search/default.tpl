<div class="pt-50-100 pb-60">
    <div class="container">
        <h1 class="h1 mb-16-20">Результаты поиска</h1>
        <div class="top-text text mb-30-50">
            <p>Результаты: {$count ?: 0}</p>
        </div>
        <div class="search mb-60">
            <form class="search__form" action="/search" method="get">
                <label class="search__label">
                    <input name="s" value="{$smarty.get.s}" type="text" class="search__input" placeholder="Найти">
                </label>
                <button class="btn search__clear">
                    <svg fill="none" width="8" height="8">
                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#close"></use>
                    </svg>
                    Очистить
                </button>
                <button class="btn btn--green search__btn">
                    <svg fill="none" width="20" height="20">
                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#search"></use>
                    </svg>
                </button>
            </form>
        </div>

        {if $results}
            <div class="search-list mb-60">
                {foreach $results as $item}
                    <div class="search-item search-page__item ">
                        <a href="{$item->url}" class="search-item__image-wrapper">
                            {if $item->image->id || $item->images[0]->id}
                                <img loading="lazy" decoding="async"
                                     src="{$item->image->id ? $item->image->getLink() : $item->images[0]->getLink()}"
                                     alt="{$item->title}" class="search-item__image">
                            {/if}
                        </a>

                        <div class="search-item__info">
                            <a href="{$item->url}" class="search-item__title">{$item->title}</a>
                            <div class="search-item__description">{$item->announce}</div>
                        </div>
                        <div class="search-item__path">
                            {foreach $item->chain as $node name="nodes"}
                                <a href="{$node->getUrl()}" class="search-item__path-part">{$node->title} {if !$smarty.foreach.nodes.last}/{/if}</a>
                            {/foreach}
                        </div>
                    </div>
                {/foreach}
            </div>
            {$pager->getHtml()}
        {/if}
    </div>
</div>