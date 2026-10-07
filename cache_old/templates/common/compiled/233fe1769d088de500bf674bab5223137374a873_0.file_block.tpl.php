<?php
/* Smarty version 5.8.0, created on 2026-04-14 12:29:43
  from 'file:module/feedback/block.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69de09079c5988_00383804',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '233fe1769d088de500bf674bab5223137374a873' => 
    array (
      0 => 'module/feedback/block.tpl',
      1 => 1776158846,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69de09079c5988_00383804 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\feedback';
?><div class="popup" data-target="request">
    <div class="popup__inside">
        <button class="btn popup__close js-close">
            <svg fill="none" width="30" height="30">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#cross"></use>
            </svg>
        </button>
        <div class="popup__name">Запишитесь на консультацию</div>
        <form action="" enctype="multipart/form-data" method="post" class="form feedback-form">
            <input type="hidden" name="areaform" value="<?php echo $_smarty_tpl->getValue('area_id');?>
"/>
            <input type="hidden" name="ajreq" value="1"/>
            <input type="hidden" name="send" value="1"/>

            <div class="form__part ">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content'), 'field', false, NULL, 'fields', array (
));
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach4DoElse = false;
?>
                    <?php if ($_smarty_tpl->getValue('field')->field->type != 'checkbox') {?>
                        <label class="label form__label">
                            <input name="<?php echo $_smarty_tpl->getValue('field')->field->getName();?>
" type="<?php echo $_smarty_tpl->getValue('field')->field->type;?>
" class="input label__input label__input--bordered">
                            <span class="label__name"><?php echo $_smarty_tpl->getValue('field')->title;?>
</span>
                        </label>
                    <?php }?>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>


            <div class="form__row">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content'), 'field', false, NULL, 'fields', array (
));
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('field')->value) {
$foreach5DoElse = false;
?>
                    <?php if ($_smarty_tpl->getValue('field')->field->type == 'checkbox') {?>
                        <label class="form__agree <?php if ($_smarty_tpl->getValue('field')->title == "Согласие") {?>feedback-form__agreed agreed<?php }?>">
                            <input type="checkbox" value="1" name="<?php echo $_smarty_tpl->getValue('field')->field->getName();?>
" class="check form__check check--bordered">
                            <span class="label__name">
                                <?php if ($_smarty_tpl->getValue('field')->title == "Согласие") {?>
                                    Нажимая кнопку «Отправить заявку», я даю свое согласие на обработку моих <a href="/policy">персональных данных</a>, в соответствии с
                                    Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных в Согласии
                                    на обработку персональных данных
                                <?php } else { ?>
                                    <?php echo $_smarty_tpl->getValue('field')->title;?>

                                <?php }?>
                            </span>
                        </label>
                    <?php }?>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                <div class="form__btns">

                    <button type="submit" class="btn btn--sm btn--black popup__form-submit">Позвоните мне</button>
                    <div class="form__more">
                        Напишите в
                        <?php if ($_smarty_tpl->getValue('params')['link_tg']) {?>
                            <a href="<?php echo $_smarty_tpl->getValue('params')['link_tg'];?>
" target="_blank" rel="nofollow" class="more-link"><span>telegram</span></a>
                        <?php }?>
                        <?php if ($_smarty_tpl->getValue('params')['link_tg'] && $_smarty_tpl->getValue('params')['link_max']) {?> или <?php }?>
                        <?php if ($_smarty_tpl->getValue('params')['link_max']) {?>
                            <a class="more-link" href="<?php echo $_smarty_tpl->getValue('params')['link_max'];?>
" target="_blank" rel="nofollow"><span>max</span></a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div><?php }
}
