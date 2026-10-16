{if $content}
    <div class="author">
        <div class="author__img">
            {if $content->image->id}
                <img src="{$content->image->getLink()}" alt="" width="38" height="38">
            {/if}
        </div>
        <div class="author__name">{$content->title}</div>
        <div class="author__pos">
            {$content->position}
        </div>
    </div>
{/if}