<?php
/* Smarty version 5.8.0, created on 2026-03-02 16:38:23
  from 'file:module/platforms/footer.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69a592cf552d64_91665563',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '49f6710fbf6a8df27b40c0b1d8cd2dd872201de5' => 
    array (
      0 => 'module/platforms/footer.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69a592cf552d64_91665563 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\platforms';
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content'), 'item', false, NULL, 'items', array (
));
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach5DoElse = false;
?>
    <<?php if ($_smarty_tpl->getValue('item')->link) {?>a href="<?php echo $_smarty_tpl->getValue('item')->link;?>
" target="_blank" rel="nofollow" <?php } else { ?>div<?php }?> class="footer-fb">
        <div class="footer-fb__img">
            <?php if ($_smarty_tpl->getValue('item')->image_white->id) {?>
                <img src="<?php echo $_smarty_tpl->getValue('item')->image_white->getLink();?>
" alt="" height="35" width="205">
            <?php }?>
        </div>

        <div class="footer-fb__rate">
            <svg fill="none" width="17" height="17">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#star"></use>
            </svg> <?php echo $_smarty_tpl->getValue('item')->rating;?>

        </div>
    </<?php if ($_smarty_tpl->getValue('item')->link) {?>a<?php } else { ?>div<?php }?>>
<?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
}
}
