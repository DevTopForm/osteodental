<?php
/* Smarty version 5.8.0, created on 2026-04-14 12:29:43
  from 'file:module/prices/include/element.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69de0907dfad56_24704214',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f97f7639b1ab6dc8ab02bd6070f4b068e079e077' => 
    array (
      0 => 'module/prices/include/element.tpl',
      1 => 1776158846,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69de0907dfad56_24704214 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\prices\\include';
if ($_smarty_tpl->getValue('content')) {?>
    <div class="prices-it  " data-parallax="0.2">
        <div class="prices-it__top">
            <div class="prices-it__img">
                <?php if ($_smarty_tpl->getValue('content')->image->id) {?>
                    <img src="<?php echo $_smarty_tpl->getValue('content')->image->getLink();?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('content')->title, ENT_QUOTES, 'UTF-8', true);?>
" class="prices-it__pic">
                <?php }?>
            </div>
            <div class="prices-it__name"><?php echo $_smarty_tpl->getValue('content')->title;?>
</div>
            <div class="prices-it__price"><?php echo $_smarty_tpl->getValue('content')->price;?>
</div>
            <?php if ($_smarty_tpl->getValue('content')->sign) {?>
                <div class="prices-it__num glass-tag glass-tag--white"><?php echo $_smarty_tpl->getValue('content')->sign;?>
</div>
            <?php }?>
        </div>
        <div class="prices-it__btm">
            <?php if ($_smarty_tpl->getValue('content')->list) {?>
                <ul class="prices-it__list">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->list, 'list_item', false, NULL, 'list', array (
));
$foreach19DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('list_item')->value) {
$foreach19DoElse = false;
?>
                        <li><?php echo $_smarty_tpl->getValue('list_item')['value'];?>
</li>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </ul>
            <?php }?>
            <button class="btn btn--black btn--sm prices-it__btn" data-action="request"><span>Записаться</span>
            </button>
        </div>
    </div>
<?php }
}
}
