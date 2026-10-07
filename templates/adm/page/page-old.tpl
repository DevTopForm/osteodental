<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8"/>
    <title>TopForm CMS — {$params.site.name}</title>
    <meta name="robots" content="noindex, nofollow">

    <link rel="stylesheet" href="/adm/assets/css/new-style.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="format-detection" content="telephone=no">
</head>
<body>
<div id="showClientData">
    <div class="header"><a class="close"></a></div>
    <div class="data"></div>
</div>
<div class="delete-form js-delete-form">
    <div class="delete-form__close js-delete-close">+</div>
    <p class="delete-form__text js-delete-text"></p>
    <div class="delete-form__btns">
        <a class="btn btn_white js-delete-close">Отмена</a>
        <a class="btn js-delete-true">Да, удалить</a>
    </div>
</div>
<div class="wrapper">
    {if $user}
        <header>
            <div class="logo">
                <a href="/adm"><img src="{$adm_path}/htdocs/images/logo.svg"></a>
                <div class="version">CMS 8.0</div>
            </div>
            <div class="project_middle">
                {if $logo->id}
                    <a href="/" class="project_logo">
                        <img src="{$logo->getLink()}">

                    </a>
                {else}
                    <div class="project_text">{$params.sitename}</div>
                {/if}
            </div>
            {if $user}
                <div class="user_info">
                    {$user->login}
                    <span class="admin_action js-user-menu">
							<img src="{$adm_path}/htdocs/images/admin_list.png">
							<div class="user_info_menu">
								<a href="/adm/admin">Администаторы</a>
								<a href="/adm/logout">Выйти</a>
							</div>
						</span>
                </div>
            {/if}
        </header>
        <article>
            {if $tree &&  $user->hasAccess('node')}
                <section class="structure">
                    {*<h3>{$_LNG.STRUCTURE}</h3>*}
                    <div class="life_block navigation_menu {if $smarty.cookies.navigation == 'closed'}closed{/if}"
                         data-menu="navigation">
                        <div class="open_menu"><img src="{$adm_path}/htdocs/images/icons/open_menu.png"></div>
                        {$main_menu}
                    </div>
                    <div class="pane life_block {if $smarty.cookies.pane == 'closed'}closed{/if}" data-menu="pane">
                        <div class="open_menu"><img src="{$adm_path}/htdocs/images/icons/open_menu.png"></div>
                        <div class="node-actions">
                            <ul class="tabs">
                                <li class="one">
                                    <a class="icon add" href="{$adm_path}/node/add">
                                        {*<img src="{$adm_path}/htdocs/images/icons/add_icon.svg">*}
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                  d="M12 2C6.49 2 2 6.49 2 12C2 17.51 6.49 22 12 22C17.51 22 22 17.51 22 12C22 6.49 17.51 2 12 2ZM11 7V11H7V13H11V17H13V13H17V11H13V7H11ZM4 12C4 16.41 7.59 20 12 20C16.41 20 20 16.41 20 12C20 7.59 16.41 4 12 4C7.59 4 4 7.59 4 12Z"
                                                  fill="#5872FA"/>
                                        </svg>
                                        <span>{$_LNG_ADM.CREATE_NEW_NODE}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div id="node-list">
                            <ul class="node_list">
                                {include file='menu/structure.tpl'}
                            </ul>
                        </div>
                    </div>
                </section>
            {/if}

            <section class="content">
                {$content}
                {include file='ajax/image.tpl' state='init'}
            </section>
            <div class="clear"></div>

        </article>
    {else}
        {$content}
    {/if}
</div>
</body>
</html>
