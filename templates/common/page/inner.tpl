<!DOCTYPE html>

<html lang="ru">
<head>
    {include file='page/blocks/meta.tpl'}
</head>
<body>
{*{include file='page/blocks/yandex_counter.tpl'}*}
{*{include file='page/blocks/google_counter.tpl'}*}
{include file='page/blocks/header.tpl'}

<main id="main-content" class="{if $node->type->type == 'services'}main{/if}">
{*    {if $node->type->type != 'services'}*}
        {$breadcrumbs}
{*    {/if}*}

    <script type="application/ld+json">
      {$breadcrumbs_schema}
    </script>

    {$content}
</main>

{include file='page/blocks/footer.tpl'}

{include file='page/blocks/css-js.tpl'}
</body>
</html>