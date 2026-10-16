{if $content}
    <{if $content->banner_file->id || $content->banner_link}a{else}div{/if} {if  $content->banner_file->id}href="{$content->banner_file->getLink()}"{elseif $content->banner_link}href="{$content->banner_link}"{/if} class="blog-ban {$class}" target="_blank">
        {if $content->image->id}
            <img class="blog-ban__img" src="{$content->image->getLink()}" alt="" loading="lazy" decoding="async" width="3357" height="1175">
        {/if}

        {if $content->banner_file->id}
            <svg fill="none" width="40" height="40">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#download"></use>
            </svg>
        {/if}

        <div class="blog-ban__txt">
            {$content->title}
        </div>
    </{if $content->banner_file->id || $content->banner_link}a{else}div{/if}>
{/if}