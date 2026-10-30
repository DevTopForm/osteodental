{if $doctor}
    <div class="doctor-slide  {$class}"
         data-animation="anim-popup-anim" data-delay="{$delay}">
        <div class="doctor-slide__img">
            {if $doctor->image->id}
                <img src="{$doctor->image->getLink()}" alt="{$doctor->title|escape}"
                     width="212" height="212">
            {/if}
        </div>
        <div class="doctor-slide__content">
            <div class="doctor-slide__name">{$doctor->title}</div>
            {if $doctor->position}
                <div class="doctor-slide__pos">
                    {$doctor->position}
                </div>
            {/if}
        </div>
    </div>
{/if}