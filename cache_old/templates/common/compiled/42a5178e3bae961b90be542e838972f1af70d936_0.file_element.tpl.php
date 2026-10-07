<?php
/* Smarty version 5.8.0, created on 2026-04-14 18:08:08
  from 'file:module/services/include/element.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69de5858ceac78_97556420',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '42a5178e3bae961b90be542e838972f1af70d936' => 
    array (
      0 => 'module/services/include/element.tpl',
      1 => 1776179283,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69de5858ceac78_97556420 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\services\\include';
if ($_smarty_tpl->getValue('content')) {?>
    <a href="<?php echo $_smarty_tpl->getValue('content')->getUrl();?>
" class="service-it bg-white <?php echo $_smarty_tpl->getValue('class');?>
" <?php if ($_smarty_tpl->getValue('animation')) {?>data-animation="<?php echo $_smarty_tpl->getValue('animation');?>
"<?php }?> <?php if ($_smarty_tpl->getValue('delay')) {?>data-delay="<?php echo $_smarty_tpl->getValue('delay');?>
"<?php }?>>
        <div class="service-it__img">
            <?php if ($_smarty_tpl->getValue('content')->image->id) {?>
                <img src="<?php echo $_smarty_tpl->getValue('content')->image->getLink();?>
" alt="">
            <?php }?>
        </div>
        <div class="service-it__content">
            <?php if ($_smarty_tpl->getValue('content')->item->sign) {?>
                <div class="service-it__num glass-tag glass-tag--blue">1-2 приёма</div>
            <?php }?>
            <div class="service-it__name"><?php echo $_smarty_tpl->getValue('content')->title;?>
</div>

            <?php if ($_smarty_tpl->getValue('content')->item->price) {?>
                <div class="service-it__price"><?php echo $_smarty_tpl->getValue('content')->item->price;?>
</div>
            <?php }?>
        </div>
    </a>
<?php }
}
}
