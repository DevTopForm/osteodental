<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>TopForm CMS — {$params.site.name}</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="stylesheet" href="{$adm_path}/assets/css/new-style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no">
</head>
<body>
<header class="header">
    <div class="header__inside">
        <div class="header__logo-wrap">
            {if $user}
                <div class="btn header__logo-toggler js-main-menu-toggler">
                    <svg fill="none" width="12" height="7">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                    </svg>
                </div>
            {/if}
            <a href="{$adm_path}" class="header__logo">
                <svg fill="none" width="94" height="30">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#tf-logo"></use>
                </svg>
            </a>
        </div>

        {if $user}
            <a href="{$adm_path}/clearcache?page={$smarty.server.REQUEST_URI}"
               class="header__refresh btn btn--bd btn--shrink">
                <svg fill="none" width="12" height="12">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#refresh"></use>
                </svg>
                <span>Сбрость кэш</span>
            </a>
            <div class="header__user user">
                <button class="user__link btn">
                    <span class="user__name">{$user->name}</span>
                    <span class="user__svg">
                        <svg fill="none" width="11" height="12">
                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#user"></use>
                        </svg>
                    </span>
                </button>
                <div class="user__block">
                    <div class="user__block-inside">
                        <a href="/adm/logout" class="user__block-leave" title="Выйти из профиля">
                            <span>Выйти</span>
                            <svg fill="none" width="15" height="15">
                                <use xlink:href="{$adm_path}/assets/img/sprite.svg#leave"></use>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        {/if}
    </div>
</header>
<div class="main-container js-container {if $isContent}opened{/if} {if !$user}main-container--login{/if}">
    {if $user}
        <div class="aside">
            {$main_menu}
        </div>
        <div class="content-menu js-menu js-tabindex">
            <div class="content-menu__inside" tabindex="-1">
                {if $logo->id}
                    <a href="/" class="content-menu__logo">
                        <img src="{$logo->getLink()}" alt="" width="107" height="30">
                    </a>
                {else}
                    <div class="content-menu__logo"></div>
                {/if}
                {if $tree &&  $user->hasAccess('node')}
                    <nav class="content-menu__menu menu">
                        <ul class="menu__list">
                            {include file='menu/structure.tpl'}
                        </ul>
                    </nav>
                {/if}
            </div>
        </div>
        <div class="main-container__content">
            {$content}
        </div>
    {else}
        {$content}
    {/if}
</div>
<script src="{$adm_path}/assets/js/script.js"></script>
<script src="{$adm_path}/assets/js/index.js"></script>
</body>
</html>
