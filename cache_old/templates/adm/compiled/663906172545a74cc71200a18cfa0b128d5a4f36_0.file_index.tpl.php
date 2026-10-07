<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:18
  from 'file:content/index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893fe28c347_56700776',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '663906172545a74cc71200a18cfa0b128d5a4f36' => 
    array (
      0 => 'content/index.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e893fe28c347_56700776 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
?><section class="dashboard">
    <h1 class="h1 dashboard__h1">Дашборд</h1>
    <div class="board">
        <?php if ($_smarty_tpl->getValue('widgets')) {?>
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('widgets'), 'widget');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('widget')->value) {
$foreach0DoElse = false;
?>
                <?php if ($_smarty_tpl->getValue('widget')->isShow()) {?>
                    <?php echo $_smarty_tpl->getValue('widget')->widget->getHtml();?>

                <?php }?>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        <?php }?>
    </div>
    <?php if ($_smarty_tpl->getValue('widgets')) {?>
        <div class="d-icos dashboard__icos">
            <div class="d-icos__inside">

                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('widgets'), 'widget');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('widget')->value) {
$foreach1DoElse = false;
?>
                    <div class="d-ico active" aria-label="<?php echo $_smarty_tpl->getValue('widget')->title;?>
" data-block="<?php echo $_smarty_tpl->getValue('widget')->name;?>
" draggable="false" style="">
                        <button class="js-handle d-ico__handle btn">
                            <svg fill="none" width="7" height="13">
                                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#dots2"></use>
                            </svg>
                        </button>
                        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/widget/is_show/<?php echo $_smarty_tpl->getValue('widget')->id;?>
" class="btn board-ico">
                            <div class="board-ico__ico">
                                <?php if ($_smarty_tpl->getValue('widget')->icon) {?>
                                    <svg fill="none" width="15" height="15">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#<?php echo $_smarty_tpl->getValue('widget')->icon;?>
"></use>
                                    </svg>
                                <?php }?>
                            </div>
                            <?php if ($_smarty_tpl->getValue('widget')->isShow()) {?>
                                <div class="board-ico__tick">
                                    <svg fill="none" width="8" height="6">
                                        <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#tick"></use>
                                    </svg>
                                </div>
                            <?php }?>
                        </a>
                    </div>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        </div>
    <?php }?>
</section><?php }
}
