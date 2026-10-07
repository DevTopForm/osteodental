{if $list}
    <div class="bread">
        <div class="bread__inside">
            <div class="bread__container container">
                <ul class="bread__list" itemscope="itemscope" itemtype="https://schema.org/BreadcrumbList">
                    {foreach from=$list item='item' name='bc'}
                        {if $smarty.foreach.bc.last}
                            <li class="bread__it">
                                <span class="bread__link">
                                    {$item.title}
                                </span>
                            </li>
                        {else}
                            <li class="bread__it" itemprop="itemListElement" itemscope="itemscope"
                                itemtype="https://schema.org/ListItem">
                                <a href="{$item.url}" class="bread__link" itemprop="item">
                                    {$item.title}
                                    <meta itemprop="position" content="{$smarty.foreach.bc.iteration}">
                                </a>
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            </div>
        </div>
    </div>

{*    <div class="bread ">*}
{*        <div class="bread__inside">*}
{*            <div class="bread__container container">*}
{*                <ul class="bread__list">*}
{*                    <li class="bread__it"><a href="/" class="bread__link">Главная </a></li>*}
{*                    <li class="bread__it"><a href="/catalog.html" class="bread__link">Услуги</a></li>*}
{*                    <li class="bread__it"><a href="/catalog.html" class="bread__link">Хирургия</a></li>*}
{*                    <li class="bread__it"><span class="bread__link">Лечение пе...</span></li>*}
{*                </ul>*}
{*            </div>*}
{*        </div>*}
{*    </div>*}
{/if}