{if $content}
    <div class="videos-it {if $content->video_short}videos-it--short{else}videos-it--long{/if} {$class}" {if $content->video_file->id}data-video="{$content->video_file->getLink()}"{/if}>

        {if $content->image->id}
            <img width="870" height="1548" loading="lazy" decoding="async" src="{$content->image->getLink()}" alt="">
        {/if}

        <div class="rotate-btn btn  videos-it__btn">
            <div class="rotate-btn__inside">
                <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>
                </svg>
            </div>
        </div>
    </div>
{/if}