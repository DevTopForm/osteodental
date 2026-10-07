<?php
/* Smarty version 5.8.0, created on 2026-03-02 16:38:23
  from 'file:module/platforms/block.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a592cf538bb5_46574754',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '754d644f9d3cfa3a1036f74caef87e7a5038cc0f' => 
    array (
      0 => 'module/platforms/block.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a592cf538bb5_46574754 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\platforms';
if ($_smarty_tpl->getValue('content')) {?>
    <div class="bg-light pt-60-100 pb-60-100 fb-wrapper">
        <div class="container">
            <h3 class="h3 mb-30"><?php echo $_smarty_tpl->getValue('node')->title;?>
</h3>
            <div class="fbs js-auto-swiper" data-gap="20">
                <div class="fbs__slider js-auto-swiper__slider">
                    <div class="fbs__wrapper swiper-wrapper">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content'), 'platform', false, NULL, 'platforms', array (
));
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('platform')->value) {
$foreach4DoElse = false;
?>
                            <<?php if ($_smarty_tpl->getValue('platform')->link) {?>a href="<?php echo $_smarty_tpl->getValue('platform')->link;?>
" target="_blank" rel="nofollow" <?php } else { ?>div<?php }?> class="fbs__it fbs-it swiper-slide">
                                <div class="fbs-it__img">
                                    <?php if ($_smarty_tpl->getValue('platform')->image->id) {?>
                                        <img src="<?php echo $_smarty_tpl->getValue('platform')->image->getLink();?>
" alt="" height="35" width="205">
                                    <?php }?>
                                </div>
                                <div class="fbs-it__content">
                                    <?php if ($_smarty_tpl->getValue('platform')->rating) {?>
                                        <div class="fbs-it__rate">
                                            <svg class="btn__icon" fill="none" width="17" height="17">
                                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#star"></use>
                                            </svg>
                                            <?php echo $_smarty_tpl->getValue('platform')->rating;?>

                                        </div>
                                    <?php }?>
                                    <div><?php echo $_smarty_tpl->getValue('platform')->title;?>
</div>
                                </div>
                            </<?php if ($_smarty_tpl->getValue('platform')->link) {?>a<?php } else { ?>div<?php }?>>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php }
}
}
