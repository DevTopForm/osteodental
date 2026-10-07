{if $content}
    <section class="overflow pb-60-100 pt-60-100 bg-light" data-parallax="0.2">
        <div class="container">
            {if $title}
                <h3 class="h3 mb-30  anim-block anim-masked" data-animation="anim-masked-mask">{$title}</h3>
            {/if}

            <div class="equipment js-cards">
                <div class="equipment__slider js-cards__slider">
                    <div class="equipment__wrapper swiper-wrapper">
                        {foreach from=$content item='equopment' name='equipment_list'}
                            <article class="eq-it equipment__it swiper-slide">
                                <div class="eq-it__inside">
                                    <div class="eq-it__img">
                                        {if $equopment->image->id}
                                            <img src="{$equopment->image->getLink()}" alt="{$equopment->title|escape}"
                                                 class="eq-it__pic"
                                                 width="403" height="451">
                                        {/if}
                                    </div>
                                    <div class="eq-it__content">
                                        <div class="eq-it__name">{$equopment->title}</div>
                                        {if $equopment->text}
                                            <div class="eq-it__text">
                                                {$equopment->text}
                                            </div>
                                        {/if}
                                    </div>
                                </div>
                            </article>
                        {/foreach}
                    </div>
                </div>
            </div>
        </div>
    </section>
{/if}