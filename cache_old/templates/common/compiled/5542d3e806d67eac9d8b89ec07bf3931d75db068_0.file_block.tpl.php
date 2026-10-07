<?php
/* Smarty version 5.8.0, created on 2026-04-14 12:29:43
  from 'file:module/about/block.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69de0907875514_44283730',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '5542d3e806d67eac9d8b89ec07bf3931d75db068' => 
    array (
      0 => 'module/about/block.tpl',
      1 => 1776158846,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69de0907875514_44283730 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\about';
?>
    <div id="about" class="container">
        <h3 class="h3 mb-30 anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('node')->title;?>
</h3>
        <div class="about">
            <div class="clinick-block about__slider js-thumb-swiper">
                <?php if ($_smarty_tpl->getValue('content')->images) {?>
                    <div class="about-slider">
                        <div class="about-slider__slider js-thumb-swiper__slider">
                            <div class="about-slider__wrapper swiper-wrapper">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->images, 'image', false, NULL, 'images', array (
));
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('image')->value) {
$foreach0DoElse = false;
?>
                                    <?php if ($_smarty_tpl->getValue('image')->id) {?>
                                        <div class="about-slider__slide swiper-slide">
                                            <img src="<?php echo $_smarty_tpl->getValue('image')->getLink('thumb');?>
" alt="" width="540" height="540">
                                        </div>
                                    <?php }?>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </div>
                        </div>
                        <div class="about-slider__thumbs js-thumb-swiper__thumbs">
                            <div class="about-slider__thumbs-wrapper swiper-wrapper">
                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->images, 'image', false, NULL, 'images', array (
));
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('image')->value) {
$foreach1DoElse = false;
?>
                                    <?php if ($_smarty_tpl->getValue('image')->id) {?>
                                        <div class="about-slider__thumb swiper-slide">
                                            <img src="<?php echo $_smarty_tpl->getValue('image')->getLink('thumb');?>
" alt="" width="540" height="540">
                                        </div>
                                    <?php }?>
                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                            </div>
                        </div>
                    </div>

                    <div class="address">
                        <div class="address__inside">
                            <?php if ($_smarty_tpl->getValue('params')['address']) {?>
                                <div class="address__row">
                                    <svg class="address__row-icon" fill="none" width="20" height="20">
                                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#pin"></use>
                                    </svg>
                                        <div class="address__row-text address__row-text--addr">
                                            <p><?php echo $_smarty_tpl->getValue('params')['address'];?>
</p>

                                            <?php if ($_smarty_tpl->getValue('params')['map_link']) {?>
                                                <a href="<?php echo $_smarty_tpl->getValue('params')['map_link'];?>
" class="more-link address__more">
                                                    <span>На карте</span>
                                                    <svg class="btn__icon" fill="none" width="25" height="17">
                                                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr2"></use>
                                                    </svg>
                                                </a>
                                            <?php }?>
                                        </div>
                                </div>
                            <?php }?>
                            <div class="address__row">
                                <svg class="address__row-icon" fill="none" width="20" height="20">
                                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#phone"></use>
                                </svg>
                                <div class="address__row-text">
                                    <?php if ($_smarty_tpl->getValue('params')['phone']) {?>
                                        <a href="tel:<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('regex_replace')($_smarty_tpl->getValue('params')['phone'],'/[^0-9|+]/','');?>
" class="phone"><?php echo $_smarty_tpl->getValue('params')['phone'];?>
</a>
                                    <?php }?>

                                    <?php if ($_smarty_tpl->getValue('params')['phone_2']) {?>
                                        <a href="tel:<?php echo $_smarty_tpl->getSmarty()->getModifierCallback('regex_replace')($_smarty_tpl->getValue('params')['phone_2'],'/[^0-9|+]/','');?>
" class="phone"><?php echo $_smarty_tpl->getValue('params')['phone_2'];?>
</a>
                                    <?php }?>
                                </div>
                            </div>
                            <?php if ($_smarty_tpl->getValue('params')['email']) {?>
                                <div class="address__row">
                                    <svg class="address__row-icon" fill="none" width="20" height="20">
                                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#mail"></use>
                                    </svg>
                                    <div class="address__row-text">
                                        <a href="mailto:<?php echo $_smarty_tpl->getValue('params')['email'];?>
" class="phone"><?php echo $_smarty_tpl->getValue('params')['email'];?>
</a>
                                    </div>
                                </div>
                            <?php }?>
                        </div>
                    </div>
                <?php }?>
            </div>
            <div class="about-content about__text">
                <div class="about-content__text anim-block anim-masked"  data-animation="anim-masked-mask">
                    <?php echo $_smarty_tpl->getValue('content')->text;?>

                </div>
                <?php if ($_smarty_tpl->getValue('content')->files) {?>
                    <div class="about-content__links">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->files, 'file', false, NULL, 'files', array (
));
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('file')->value) {
$foreach2DoElse = false;
?>
                            <a target="_blank" rel="nofollow" href="<?php echo $_smarty_tpl->getValue('file')['file']->getLink();?>
" class="more-link">
                                <span><?php echo $_smarty_tpl->getValue('file')['title'];?>
</span>
                                <svg class="btn__icon" fill="none" width="25" height="17">
                                    <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr2"></use>
                                </svg>
                            </a>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                <?php }?>
            </div>
            <?php if ($_smarty_tpl->getValue('content')->staff) {?>
                <div class="doctors about__doctors js-why">
                    <div class="doctors__hide"></div>
                    <div class="doctors__slider js-why__slider">
                        <div class="doctors__wrapper swiper-wrapper">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->staff, 'doctor', false, NULL, 'doctors', array (
));
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('doctor')->value) {
$foreach3DoElse = false;
?>
                                <?php if (!(true && ($_smarty_tpl->hasVariable('doctors_delay') && null !== ($_smarty_tpl->getValue('doctors_delay') ?? null)))) {?>
                                    <?php $_smarty_tpl->assign('doctors_delay', 0, false, NULL);?>
                                <?php } else { ?>
                                    <?php $_smarty_tpl->assign('doctors_delay', $_smarty_tpl->getValue('doctors_delay')+0.2, false, NULL);?>
                                <?php }?>
                                <div class="doctor-slide  doctors__slide swiper-slide  doctors__slide swiper-slide anim-block anim-popup" data-animation="anim-popup-anim" data-delay="<?php echo $_smarty_tpl->getValue('doctors_delay');?>
">
                                    <div class="doctor-slide__img">
                                        <?php if ($_smarty_tpl->getValue('doctor')->image->id) {?>
                                            <img src="<?php echo $_smarty_tpl->getValue('doctor')->image->getLink();?>
" alt="" width="212" height="212">
                                        <?php }?>
                                    </div>
                                    <div class="doctor-slide__content">
                                        <div class="doctor-slide__name"><?php echo $_smarty_tpl->getValue('doctor')->title;?>
</div>
                                        <div class="doctor-slide__pos"><?php echo $_smarty_tpl->getValue('doctor')->position;?>
</div>

                                        <?php if ($_smarty_tpl->getValue('doctor')->experience) {?>
                                            <div class="doctor-slide__exp"><?php echo $_smarty_tpl->getValue('doctor')->experience;?>
</div>
                                        <?php }?>
                                    </div>
                                </div>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>

                        </div>
                    </div>
                </div>
            <?php }?>

        </div>
    </div><?php }
}
