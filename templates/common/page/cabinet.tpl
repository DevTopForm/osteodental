<!DOCTYPE html>

<html lang="ru">
<head>
    {include file='page/blocks/meta.tpl'}
</head>
<body>
{include file='page/blocks/yandex_counter.tpl'}
{include file='page/blocks/google_counter.tpl'}
{include file='page/blocks/header.tpl'}

<main>
    <div class="container pb40-120 pt-desk">
        {if $user}
            <div class="personal">
                <div class="personel__left">
                    <div class="personal-info">
                        <div class="personal-info__top">
                            <div class="personal-info__img">
                                {$user->getLetter()}
                            </div>
                            <div class="personal-info__name h2">{$user->getShortName()}</div>
                        </div>

                        {if $menu}
                            <ul class="personal-info__ul">
                                {foreach from=$menu item='menu_item' name='menu_items'}
                                    <li>
                                        <a
                                                href="{$menu_item.url}"
                                                class="personal-info__link"
                                                title="{$menu_item.title|escape}"
                                        >
                                            {$menu_item.title}
                                        </a>
                                    </li>
                                {/foreach}
                            </ul>
                        {/if}

                        <a href="{$cabinet_path}/logout" class="btn personal-info__btn">

                            <span>Выход</span>
                            <svg fill="none" width="29" height="15">
                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                            </svg>
                        </a>
                    </div>
                </div>

                <div class="personal__right">
                    {$content}
                </div>
            </div>
        {else}
            <div class="personal-enter">
                {$content}
            </div>
        {/if}
    </div>
</main>

{include file='page/blocks/footer.tpl'}
{include file='module/feedback/consultation.tpl'}
{include file='module/feedback/question.tpl'}

{include file='page/blocks/css-js.tpl'}
</body>
</html>