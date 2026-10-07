<!DOCTYPE html>
<html lang="ru">
<head>
    {include file='page/blocks/meta.tpl'}
</head>
<body>
{include file='page/blocks/yandex_counter.tpl'}
{include file='page/blocks/google_counter.tpl'}
<div class="js-top"></div>
{include file='page/blocks/header.tpl'}

<main class="main">
    {$content}
</main>

{include file='page/blocks/footer.tpl'}
{*{include file='module/feedback/consultation.tpl'}*}
{*{include file='module/feedback/question.tpl'}*}

{include file='page/blocks/css-js.tpl'}
</body>
</html>