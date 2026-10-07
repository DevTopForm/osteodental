{if !empty($content) && count($content)}
    <div class="index-categories">
        <div class="container index-categories__container">
            <div class="{$titleClass} title-large">{$title}</div>
            <div class="index-categories__list">
                {foreach $content as $section}
                    <a href="{$section.url}" class="index-cat {$itemClass}"
                       {if $section.color}style="background-color: {$section.color}"{/if}>
                        {if $section.img}
                            <div class="index-cat__img">
                                <img src="{$section.img}" alt="" width="160" height="200">
                            </div>
                        {/if}
                        <div class="index-cat__name">{$section.title}</div>
                        <div class="index-cat__text">{$section.text}</div>
                    </a>
                {/foreach}

                {if $isForm}
                    <div class="menu-ban index-categories__it menu-ban--cover">
                        <img class="menu-ban__img" src="/htdocs/assets/build/img/bgs/category-it.png" alt="">
                        <div class="menu-ban__name">
                            Подбор под вашу задачу
                        </div>
                        <button class="btn btn--lilac btn--lg menu-ban__btn" aria-label="Подобрать"
                                data-action="consult">
                            Запросить подбор
                        </button>
                    </div>
                {/if}
            </div>
        </div>
    </div>
{/if}