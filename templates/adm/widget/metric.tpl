<div class="board-block wide  board-block--metrics js-to-expand" data-block="{$widget->name}">
    <div class="board-block__top ">
        <button class="btn board-ico board-block__ico">
            <div class="board-ico__ico">
                <svg fill="none" width="15" height="15">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#metrika"></use>
                </svg>
            </div>
        </button>
        <h2 class="board-block__name">
            <span>Метрика</span>
        </h2>
        <a href="{$adm_path}/widget/is_show/{$widget->id}" class="btn board-block__close js-close"
           arialabel="Убрать блок">
            <svg fill="none" width="20" height="20">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#cross"></use>
            </svg>
        </a>
        <button class="js-handle board-block__handle btn ">
            <svg fill="none" width="7" height="13">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
            </svg>
        </button>
        <button class="board-block__opener btn js-expand">
            <svg fill="none" width="12" height="7">
                <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
            </svg>
        </button>
    </div>
    <div class="board-block__content ">
        <div class="board-block__inside">
            {if $error}
                <p>{$error}</p>
            {elseif $content.data}
                <div class="metrics-block">
                    <div class="dashblock-top metrics-block__top ">
                        <form onsubmit="return false" action="" method="get" enctype="multipart/form-data"
                              class="dashblock-top__dates">
                            <span class="dashblock-top__dates-text">Статистика посещений </span>

                            <input id="widget-{$widget->name}-datepicker-hidden" type="hidden" name="{$filter_name}"
                                   value="{$interval}">
                            <button id="widget-{$widget->name}-datepicker" name="{$filter_name}"
                                    class="btn btn--lighter btn--small js-dates-block">{$interval}</button>

                            <div class="dashblock-top__metrics">
                                <div class="metrics-it metrics-it--large">
                                    <div class="metrics-it__name">
                                        <span>Посетители</span>
                                    </div>
                                    <div class="metrics-it__num {if $content.data.total.users.isBetter} up {else} down {/if}">
                                        <div class="metrics-it__num-new">{$content.data.total.users.currentDisplay}</div>
                                    </div>
                                </div>
                                <div class="metrics-it metrics-it--black">
                                    <div class="metrics-it__name">
                                        <span>Визиты</span>
                                    </div>
                                    <div class="metrics-it__num {if $content.data.total.visits.isBetter} up {else} down {/if}">
                                        <div class="metrics-it__num-new">{$content.data.total.visits.currentDisplay}</div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="metrics-block__row">
                        <div class="metrics-it ">
                            <div class="metrics-it__name">
                            <span class="metrics-it__ico">
                                <img src="{$adm_path}/assets/img/search.png" alt="" width="16" height="16">
                            </span>
                                <span>Из поисковых систем</span>
                            </div>
                            <div class="metrics-it__num {if $content.data.items.organic.users.isBetter} up {else} down {/if}">
                                <div class="metrics-it__num-new">{$content.data.items.organic.users.currentDisplay}</div>
                                <div class="metrics-it__num-old">({$content.data.items.organic.visits.currentDisplay})
                                </div>
                            </div>
                        </div>
                        <div class="metrics-it ">
                            <div class="metrics-it__name">
                            <span class="metrics-it__ico">
                                <img src="{$adm_path}/assets/img/ads.png" alt="" width="16" height="16">
                            </span>
                                <span>Реклама</span>
                            </div>
                            <div class="metrics-it__num {if $content.data.items.ad.users.isBetter} up {else} down {/if}">
                                <div class="metrics-it__num-new">{$content.data.items.ad.users.currentDisplay}</div>
                                <div class="metrics-it__num-old">({$content.data.items.ad.visits.currentDisplay})</div>
                            </div>
                        </div>
                        <div class="metrics-it ">
                            <div class="metrics-it__name">
                            <span class="metrics-it__ico">
                                <img src="{$adm_path}/assets/img/links.png" alt="" width="16" height="16">
                            </span>
                                <span>ссылки</span>
                            </div>
                            <div class="metrics-it__num {if $content.data.items.referral.users.isBetter} up {else} down {/if}">
                                <div class="metrics-it__num-new">{$content.data.items.referral.users.currentDisplay}</div>
                                <div class="metrics-it__num-old">({$content.data.items.referral.visits.currentDisplay}
                                    )
                                </div>
                            </div>
                        </div>
                        <div class="metrics-it ">
                            <div class="metrics-it__name">
                            <span class="metrics-it__ico">
                                <img src="{$adm_path}/assets/img/direct.png" alt="" width="16" height="16">
                            </span>
                                <span>Прямые заходы</span>
                            </div>
                            <div class="metrics-it__num {if $content.data.items.direct.users.isBetter} up {else} down {/if}">
                                <div class="metrics-it__num-new">{$content.data.items.direct.users.currentDisplay}</div>
                                <div class="metrics-it__num-old">({$content.data.items.direct.visits.currentDisplay})
                                </div>
                            </div>
                        </div>
                        <div class="metrics-it ">
                            <div class="metrics-it__name">
                            <span class="metrics-it__ico">
                                <img src="{$adm_path}/assets/img/internal.png" alt="" width="16" height="16">
                            </span>
                                <span>Внутренние</span>
                            </div>
                            <div class="metrics-it__num {if $content.data.items.internal.users.isBetter} up {else} down {/if}">
                                <div class="metrics-it__num-new">{$content.data.items.internal.users.currentDisplay}</div>
                                <div class="metrics-it__num-old">({$content.data.items.internal.visits.currentDisplay}
                                    )
                                </div>
                            </div>
                        </div>
                        <div class="metrics-it ">
                            <div class="metrics-it__name">
                            <span class="metrics-it__ico">
                                <img src="{$adm_path}/assets/img/other.png" alt="" width="16" height="16">
                            </span>
                                <span>Другие</span>
                            </div>
                            <div class="metrics-it__num {if $content.data.items.others.users.isBetter} up {else} down {/if}">
                                <div class="metrics-it__num-new">{$content.data.items.others.users.currentDisplay}</div>
                                <div class="metrics-it__num-old">({$content.data.items.others.visits.currentDisplay})
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            {/if}
        </div>
    </div>
</div>