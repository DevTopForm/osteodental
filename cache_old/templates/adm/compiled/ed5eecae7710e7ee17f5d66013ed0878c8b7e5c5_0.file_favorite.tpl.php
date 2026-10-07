<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:18
  from 'file:widget/favorite.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893fe33a135_73922416',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ed5eecae7710e7ee17f5d66013ed0878c8b7e5c5' => 
    array (
      0 => 'widget/favorite.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e893fe33a135_73922416 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\widget';
?><div class="board-block  js-to-expand" data-block="<?php echo $_smarty_tpl->getValue('widget')->name;?>
">
    <div class="board-block__top ">
        <button class="btn board-ico board-block__ico">
            <div class="board-ico__ico">
                <svg fill="none" width="15" height="15">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#heart"></use>
                </svg>
            </div>
        </button>
        <h2 class="board-block__name">
            <span>Избранное</span>
        </h2>
        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/widget/is_show/<?php echo $_smarty_tpl->getValue('widget')->id;?>
" class="btn board-block__close js-close"
           arialabel="Убрать блок">
            <svg fill="none" width="20" height="20">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#cross"></use>
            </svg>
        </a>
        <button class="js-handle board-block__handle btn ">
            <svg fill="none" width="7" height="13">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#dots2"></use>
            </svg>
        </button>
        <button class="board-block__opener btn js-expand">
            <svg fill="none" width="12" height="7">
                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#chevron"></use>
            </svg>
        </button>
    </div>
    <div class="board-block__content ">
        <div class="board-block__inside">
            <div class="history-block">
                <?php if (is_array($_smarty_tpl->getValue('list')) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('list'))) {?>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item');
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach3DoElse = false;
?>
                        <div class="dash-link history-block__it">
                            <a href="<?php echo $_smarty_tpl->getValue('item')->url;?>
" class="dash-link__link" title="<?php echo $_smarty_tpl->getValue('item')->title;?>
"></a>
                            <span class="dash-link__text"><?php echo $_smarty_tpl->getValue('item')->title;?>
</span>
                            <button class="dash-link__close btn js-remove-favorite" data-id="<?php echo $_smarty_tpl->getValue('item')->id;?>
">
                                <svg fill="none" width="12" height="12">
                                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#cross"></use>
                                </svg>
                            </button>
                            <svg class="dash-link__arr" fill="none" width="12" height="12">
                                <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#arrow"></use>
                            </svg>
                        </div>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                <?php }?>
            </div>
        </div>
    </div>
</div><?php }
}
