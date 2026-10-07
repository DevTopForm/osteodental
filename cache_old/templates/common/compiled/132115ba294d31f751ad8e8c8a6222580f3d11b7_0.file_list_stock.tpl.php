<?php
/* Smarty version 5.8.0, created on 2026-04-14 12:29:43
  from 'file:module/prices/include/list_stock.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69de0907e25cc5_17476421',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '132115ba294d31f751ad8e8c8a6222580f3d11b7' => 
    array (
      0 => 'module/prices/include/list_stock.tpl',
      1 => 1776158846,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69de0907e25cc5_17476421 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\prices\\include';
if ($_smarty_tpl->getValue('content')) {?>
    <div class="other-sale bg-blue anim-block anim-masked"  data-animation="anim-masked-mask"">
        <div class="other-sale__img">
            <?php if ($_smarty_tpl->getValue('content')->image->id) {?>
                <img src="<?php echo $_smarty_tpl->getValue('content')->image->getLink();?>
" alt="" width="149" height="103">
            <?php }?>
        </div>
        <div class="other-sale__name"><?php echo $_smarty_tpl->getValue('content')->title;?>
</div>
        <div class="other-sale__descr glass-tag glass-tag--white"><?php echo $_smarty_tpl->getValue('content')->sign;?>
</div>
        <div class="other-sale__prices">

            <?php if ($_smarty_tpl->getValue('content')->price_old) {?>
                <div class="other-sale__price"><?php echo $_smarty_tpl->getValue('content')->price;?>
</div>
                <div class="other-sale__old"><?php echo $_smarty_tpl->getValue('content')->price_old;?>
</div>
            <?php } else { ?>
                <?php echo $_smarty_tpl->getValue('content')->price;?>

            <?php }?>
        </div>
        <div class="other-sale__salt">Акция</div>

        <button class="btn btn--white btn--sm other-sale__btn" data-action="request">
            Запись
        </button>
    </div>
<?php }
}
}
