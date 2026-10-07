{if $content}
    <section class="overflow pb-60-100 pt-60-100">
        <div class="container">
            <h1 class="h3 mb-30" >{$node->h1|default:$node->title}</h1>
            <div class="results-slider ">
                <div class="results-slider__list results-slider__list--small-gap">
                    {foreach $content as $stock}
                        {include file='module/stocks/include/element.tpl' content=$stock}
                    {/foreach}
                </div>
            </div>
        </div>
    </section>

    {foreach from=$content item='stock' name='stocks'}
        {if $stock->text}
            {include file='module/stocks/include/popup.tpl' content=$stock}
        {/if}
    {/foreach}
{/if}