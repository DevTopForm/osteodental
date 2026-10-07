<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:18
  from 'file:widget/order.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893fe455486_76467450',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a1e0976b3473260a565ad26f7a14e97a79342f6c' => 
    array (
      0 => 'widget/order.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e893fe455486_76467450 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\widget';
?><div class="board-block wide blue js-to-expand" data-block="<?php echo $_smarty_tpl->getValue('widget')->name;?>
">
    <div class="board-block__top ">
        <button class="btn board-ico board-block__ico">
            <div class="board-ico__ico">
                <svg fill="none" width="15" height="15">
                    <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#orders"></use>
                </svg>
            </div>

            <?php if ($_smarty_tpl->getValue('new_count')) {?>
                <div class="board-ico__tick">
                    <?php echo $_smarty_tpl->getValue('new_count');?>

                </div>
            <?php }?>
        </button>
        <h2 class="board-block__name">
            <span>Заказы</span>
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

            <div class="orders-block">

                <div class="dashblock-top orders-block__top">
                    <form onsubmit="return false" action="" method="get" enctype="multipart/form-data"
                          class="dashblock-top__dates">
                        <input id="widget-<?php echo $_smarty_tpl->getValue('widget')->name;?>
-datepicker-hidden" type="hidden" name="<?php echo $_smarty_tpl->getValue('filter_name');?>
"
                               value="<?php echo $_smarty_tpl->getValue('interval');?>
">
                        <span class="dashblock-top__dates-text">Всего за</span>
                        <button id="widget-<?php echo $_smarty_tpl->getValue('widget')->name;?>
-datepicker"
                                class="btn btn--lighter btn--small js-dates-block"><?php echo $_smarty_tpl->getValue('interval');?>
</button>
                        <div class="dashblock-top__total total-info">
                            <span class="total-info__name"><?php echo $_smarty_tpl->getValue('count')['all'];?>
</span>
                            <?php if ($_smarty_tpl->getValue('count')['statuses']) {?>
                                <div class="total-info__info" data-tooltip="content" data-tooltip-style="light">
                                    <div class="js-tooltip-content">
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('count')['statuses'], 'status');
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('status')->value) {
$foreach6DoElse = false;
?>
                                            <p><?php echo $_smarty_tpl->getValue('status')['title'];?>
: <?php echo $_smarty_tpl->getValue('status')['count'];?>
 (<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('status')['summ'],2,'.',' ');?>

                                                р.)</p>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </div>
                                    i
                                </div>
                            <?php }?>
                        </div>


                        <div class="dashblock-top__sum">на сумму <?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('count')['summ'],2,'.',' ');?>
 р.</div>
                    </form>
                    <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/order" class="btn btn--lighter btn--small">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 12 4" width="12" height="4">
                            <path fill="#4159D2"
                                  d="M1.392 3.382c-.384 0-.714-.134-.99-.403A1.33 1.33 0 0 1 0 1.99c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.339 1.339 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184ZM5.767 3.382c-.384 0-.714-.134-.99-.403a1.33 1.33 0 0 1-.402-.989c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.339 1.339 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184ZM10.142 3.382c-.384 0-.714-.134-.99-.403a1.33 1.33 0 0 1-.402-.989c-.003-.378.131-.7.403-.97.275-.268.605-.402.99-.402.364 0 .685.134.964.403.281.268.424.591.427.97a1.34 1.34 0 0 1-.204.705 1.5 1.5 0 0 1-.507.502 1.321 1.321 0 0 1-.68.184Z"></path>
                        </svg>
                        <span>Все заказы</span>
                    </a>
                </div>


                <div class="table-wrapper catalog__table orders-block__list">
                    <?php if ($_smarty_tpl->getValue('list')) {?>
                        <table class="catalog-table">
                            <tbody>
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('list'), 'order');
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('order')->value) {
$foreach7DoElse = false;
?>
                                <tr class="catalog-table__tr  <?php if ($_smarty_tpl->getValue('order')->isNew()) {?>catalog-table__tr--action<?php }?>">
                                    <td class="catalog-table__td">
                                        <a href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/order/edit/<?php echo $_smarty_tpl->getValue('order')->id;?>
"
                                           class="catalog-item__name"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('date_format')($_smarty_tpl->getValue('order')->date,"%d.%m.%Y %H:%M:%S");?>
</a>
                                    </td>
                                    <td class="catalog-table__td">
                                        <div class="catalog-item__strong">
                                            <?php if ($_smarty_tpl->getValue('order')->user->id) {?>
                                                <?php echo $_smarty_tpl->getValue('order')->user->lastname;?>
 <?php echo $_smarty_tpl->getValue('order')->user->firstname;?>
 <?php echo $_smarty_tpl->getValue('order')->user->middlename;?>

                                            <?php } else { ?>
                                                <?php echo $_smarty_tpl->getValue('order')->firstname;?>

                                            <?php }?>
                                        </div>
                                    </td>
                                    <td class="catalog-table__td">
                                        <div class="catalog-item__strong"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('order')->orderSumm,2,'.',' ');?>

                                            руб.
                                        </div>
                                    </td>
                                    <?php if ($_smarty_tpl->getValue('order')->delivery) {?>
                                        <td class="catalog-table__td">
                                            <div class="catalog-item__strong"><?php echo $_smarty_tpl->getValue('order')->delivery;?>
</div>
                                        </td>
                                    <?php }?>
                                    <td class="catalog-table__td">
                                    </td>
                                    <td class="catalog-table__td">
                                        <div class="catalog-item__strong"><?php echo $_smarty_tpl->getSmarty()->getModifierCallback('number_format')($_smarty_tpl->getValue('order')->totalSumm,2,'.',' ');?>

                                            руб.
                                        </div>
                                    </td>
                                    <td class="catalog-table__td" data-position="right">
                                        <div class="jsFixed">
                                            <div class="btn btn--small status <?php echo $_smarty_tpl->getValue('order')->status->class;?>
">
                                                <?php echo (($tmp = $_smarty_tpl->getValue('order')->status->title ?? null)===null||$tmp==='' ? "Неизвестный статус" ?? null : $tmp);?>

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        Заказы отсутствуют
                    <?php }?>
                </div>
            </div>
        </div>
    </div>
</div><?php }
}
