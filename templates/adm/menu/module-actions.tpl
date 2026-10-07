<div class="catalog__tabs">
    <a class="tab-name {if $active == 'module'}active{/if}" href="{$adm_path}/module/edit/{$type->id}">Свойства</a>

    {if $type->has_content}
        <a class="tab-name {if $active == 'fields'}active{/if}" href="{$adm_path}/modfield/list/{$type->id}">Поля</a>
    {/if}

    {if $type->has_content}
        <a class="tab-name {if $active == 'group'}active{/if}" href="{$adm_path}/modgroup/list/{$type->id}">Группы полей</a>
    {/if}

    <a class="tab-name {if $active == 'image'}active{/if}" href="{$adm_path}/modimage/list/{$type->id}">Изображения</a>
    <a class="tab-name {if $active == 'template'}active{/if}" href="{$adm_path}/modtpl/list/{$type->id}">Шаблоны</a>
    <a class="tab-name {if $active == 'param'}active{/if}" href="{$adm_path}/modparam/list/{$type->id}">Параметры</a>
{*    <a class="tab-name {if $active == 'value'}active{/if}" href="{$adm_path}/modvalue/edit/{$type->id}">Значения параметров</a>*}
</div>