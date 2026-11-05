<meta charset="UTF-8">

<title>{if $node->meta_title}{$node->meta_title}{else}{$node->title}{/if}</title>
<meta name="keywords" content="{$node->meta_keywords|escape}"/>
<meta name="description" content="{$node->meta_description}"/>

<meta property="og:type" content="website">
<meta property="og:title" content="{if $node->meta_title}{$node->meta_title}{else}{$node->title}{/if}">
<meta property="og:description" content="{$node->meta_description}">
{if $node->og_image->id}
    <meta property="og:image" content="{$params.site.protocol}{$params.site.host}{$node->og_image->getLink()}">
{/if}
{if $node->id}
    <meta property="og:url" content="{$params.site.protocol}{$params.site.host}{if $node->getUrl() == '/main'}/{else}{$node->getUrl()}{/if}">
{/if}

<meta name="yandex-verification" content="2054402ca0b52f1a" />
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="format-detection" content="telephone=no">
{if !empty($node->noindex)}
    <meta name="{$node->noindex}" content="noindex,follow">
{/if}

{if $node->canonical}
    <link rel="canonical" href="{$params.site.protocol}{$params.site.host}{$node->canonical}"/>
{else}
    <link rel="canonical" href="{$params.site.protocol}{$params.site.host}{$smarty.server.REQUEST_URI|strtok:"?"}"/>
{/if}

<link rel="icon" href="{$favicon}" type="image/x-icon">
<link rel="shortcut icon" href="{$favicon}" type="image/x-icon">
<link rel="stylesheet" href="/htdocs/assets/build/css/style.css">

{literal}
    <!-- Yandex.Metrika counter -->
    <script>
        (function(m,e,t,r,i,k,a){
            m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
            m[i].l=1*new Date();
            for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
            k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
        })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=107154300', 'ym');

        ym(107154300, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
    </script>
    <!-- /Yandex.Metrika counter -->
{/literal}