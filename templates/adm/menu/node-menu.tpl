<div class="catalog__tabs">

    <a href="{$adm_path}/content/list/{$node->id}" class="tab-name {if $active == 'content'}active{/if}" title="Содержимое">
        Содержимое
    </a>

    <a href="{$adm_path}/inner/edit/{$node->id}" class="tab-name {if $active == 'inner'}active{/if}" title="Вводный текст">
        Вводный текст
    </a>

    <a href="{$adm_path}/area/list/{$node->id}" class="tab-name {if $active == 'area'}active{/if}" title="Блоки">
        Блоки
    </a>

    <a href="{$adm_path}/node/edit/{$node->id}" class="tab-name {if $active == 'node'}active{/if}" title="Свойства">
        Свойства
    </a>

    <a href="{$adm_path}/params/edit/{$node->id}" class="tab-name {if $active == 'params'}active{/if}" title="Параметры">
        Параметры
    </a>

    <a href="{$adm_path}/seo/edit/{$node->id}" class="tab-name {if $active == 'seo'}active{/if}" title="Сео">
        Сео
    </a>

</div>