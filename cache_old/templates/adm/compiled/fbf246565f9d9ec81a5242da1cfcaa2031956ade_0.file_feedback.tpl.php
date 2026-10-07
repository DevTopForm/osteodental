<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:18
  from 'file:widget/feedback.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893fe3bd935_37148458',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fbf246565f9d9ec81a5242da1cfcaa2031956ade' => 
    array (
      0 => 'widget/feedback.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e893fe3bd935_37148458 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\widget';
?><div class="board-block  js-to-expand" data-block="<?php echo $_smarty_tpl->getValue('widget')->name;?>
">
    <div class="board-block__top ">
        <button class="btn board-ico board-block__ico">
            <div class="board-ico__ico">
                <svg fill="none" width="15" height="15">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#email"></use>
                </svg>
            </div>

            <?php if ($_smarty_tpl->getValue('new_count')) {?>
                <div class="board-ico__tick">
                    <?php echo $_smarty_tpl->getValue('new_count');?>

                </div>
            <?php }?>
        </button>
        <h2 class="board-block__name">
            <span>Входящие</span>
        </h2>
        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/widget/is_show/<?php echo $_smarty_tpl->getValue('widget')->id;?>
" class="btn board-block__close js-close" arialabel="Убрать блок">
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

            <div class="mails-block">

                <div class="dashblock-top mails-block__top ">
                    <form onsubmit="return false" action="" method="get" enctype="multipart/form-data" class="dashblock-top__dates">
                        <input id="widget-<?php echo $_smarty_tpl->getValue('widget')->name;?>
-datepicker-hidden" type="hidden" name="<?php echo $_smarty_tpl->getValue('filter_name');?>
" value="<?php echo $_smarty_tpl->getValue('interval');?>
">
                        <span class="dashblock-top__dates-text">Всего за</span>
                        <button id="widget-<?php echo $_smarty_tpl->getValue('widget')->name;?>
-datepicker" name="<?php echo $_smarty_tpl->getValue('filter_name');?>
" class="btn btn--lighter btn--small js-dates-block"><?php echo $_smarty_tpl->getValue('interval');?>
</button>
                        <div class="dashblock-top__total total-info">
                            <span class="total-info__name"><?php echo $_smarty_tpl->getValue('count')['all'];?>
</span>
                            <div class="total-info__info" data-tooltip="content" data-tooltip-style="light">
                                <div class="js-tooltip-content">
                                    <p>Всего: <?php echo $_smarty_tpl->getValue('count')['all'];?>
</p>
                                    <p>Спам: <?php echo $_smarty_tpl->getValue('count')['spam'];?>
</p>
                                </div>
                                i
                            </div>
                        </div>

                    </form>
                    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/feedback" class="btn btn--lighter btn--small">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 4" width="12" height="4">
                            <path fill="#4159D2" d="M1.392 3.382c-.384 0-.714-.134-.99-.403A1.33 1.33 0 0 1 0 1.99c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.339 1.339 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184ZM5.767 3.382c-.384 0-.714-.134-.99-.403a1.33 1.33 0 0 1-.402-.989c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.339 1.339 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184ZM10.142 3.382c-.384 0-.714-.134-.99-.403a1.33 1.33 0 0 1-.402-.989c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.34 1.34 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184Z"></path>
                        </svg>
                        <span>Все сообщения</span>
                    </a>
                </div>

                <div class="mails-block__list">
                    <?php if ($_smarty_tpl->getValue('list')) {?>
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'item');
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach4DoElse = false;
?>
                            <div class="mail-item <?php if (!$_smarty_tpl->getValue('item')->public) {?>new<?php }?>">
                                <div class="mail-item__info">
                                    <div class="mail-item__info-date"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('item')->date,"%d.%m.%Y %H:%M:%S");?>
</div>
                                    <div class="mail-item__info-form"><?php echo $_smarty_tpl->getValue('item')->node->title;?>
</div>
                                </div>
                                <div class="mail-item__contacts">
                                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('item')->data, 'value');
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('value')->value) {
$foreach5DoElse = false;
?>
                                        <?php echo $_smarty_tpl->getValue('value')['title'];?>
: <?php echo $_smarty_tpl->getValue('value')['value'];?>
 <br>
                                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                </div>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <?php } else { ?>
                        Ничего не найдено
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div><?php }
}
