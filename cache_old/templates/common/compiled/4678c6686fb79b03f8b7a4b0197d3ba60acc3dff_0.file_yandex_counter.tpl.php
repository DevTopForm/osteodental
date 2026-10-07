<?php
/* Smarty version 5.8.0, created on 2026-03-10 18:20:31
  from 'file:page/blocks/yandex_counter.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69b036bfb7e1c5_73836035',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4678c6686fb79b03f8b7a4b0197d3ba60acc3dff' => 
    array (
      0 => 'page/blocks/yandex_counter.tpl',
      1 => 1773155861,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69b036bfb7e1c5_73836035 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\page\\blocks';
?><!-- Yandex.Metrika counter -->
<?php echo '<script'; ?>
 type="text/javascript">
    (function(m,e,t,r,i,k,a){
        m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
        m[i].l=1*new Date();
        for (var j = 0; j < document.scripts.length; j++) {if (document.scripts[j].src === r) { return; }}
        k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)
    })(window, document,'script','https://mc.yandex.ru/metrika/tag.js?id=107154300', 'ym');

    ym(107154300, 'init', {ssr:true, webvisor:true, clickmap:true, ecommerce:"dataLayer", referrer: document.referrer, url: location.href, accurateTrackBounce:true, trackLinks:true});
<?php echo '</script'; ?>
>
<noscript><div><img src="https://mc.yandex.ru/watch/107154300" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<?php }
}
