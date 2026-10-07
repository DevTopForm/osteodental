<?php
/* Smarty version 5.8.0, created on 2026-04-14 12:29:43
  from 'file:module/prices/include/list_element.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69de0907e3abd9_75016338',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'd1e49bf004b9b7535ce7d12f4ba97ae901a41799' => 
    array (
      0 => 'module/prices/include/list_element.tpl',
      1 => 1776158846,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69de0907e3abd9_75016338 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\prices\\include';
if ($_smarty_tpl->getValue('content')) {?>
    <div class="other-it bg-white anim-block anim-masked" data-animation="anim-masked-mask">
        <div class="other-it__name"><?php echo $_smarty_tpl->getValue('content')->title;?>
</div>
        <div class="other-it__descr glass-tag"><?php echo $_smarty_tpl->getValue('content')->sign;?>
</div>
        <div class="other-it__actions">
            <div class="other-it__price">
                <?php echo $_smarty_tpl->getValue('content')->price;?>

            </div>

            <button class="btn btn--black btn--square other-it__btn" data-action="request">
                <svg class="btn__icon" fill="none" width="22" height="26">
                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#hand"></use>
                </svg>
            </button>
        </div>
    </div>
<?php }
}
}
