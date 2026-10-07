{if $content}
    <section class="overflow pb-60-100 pt-60-100 bg-light">
        <div class="container">
            <h1 class="h3 mb-30 " >{$node->h1|default:$node->title}</h1>

            {foreach from=$content item='service' name='services'}
                {if $service.children}
                    {if $content|count > 1}
                        <div class="h3 mb-30 anim-block">
                            {if $service.url}
                                <a style="color: inherit" href="{$service.url}">{$service.title}</a>
                            {else}
                                {$service.title}
                            {/if}
                        </div>
                    {/if}

                    <div class="services {if !$smarty.foreach.services.last}mb-30{/if}">
                        {foreach from=$service.children item='child' name='children'}
                            {include file='module/services/include/element.tpl' content=$child}
                        {/foreach}
                    </div>
                {/if}
            {/foreach}
        </div>
    </section>
{/if}