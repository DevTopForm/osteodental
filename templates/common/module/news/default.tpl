{if $content}
    <section class="overflow pb-60-100 pt-60-100">
        <div class="container">
            <h1 class="h3 mb-30" >{$node->h1|default:$node->title}</h1>
            <div class="results-slider ">
                <div class="results-slider__list results-slider__list--small-gap">
                    {foreach $content as $article}
                        {include file='module/news/include/element.tpl' content=$article class='active swiper-slide'}
                    {/foreach}
                </div>
            </div>

        </div>
    </section>
{/if}