<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:29:32
  from 'file:module/services/default.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e894fc6fdb88_22481249',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '880d45955dbb68bc2959ddc520eb34a5a6df3a7b' => 
    array (
      0 => 'module/services/default.tpl',
      1 => 1776850171,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:module/prices/include/element.tpl' => 1,
    'file:module/prices/include/list_stock.tpl' => 1,
    'file:module/prices/include/list_element.tpl' => 1,
    'file:module/services/include/element.tpl' => 1,
  ),
))) {
function content_69e894fc6fdb88_22481249 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\common\\module\\services';
if ($_smarty_tpl->getValue('content')->banner_staff) {?>
    <div class="top-slider container pt-25  js-main-swiper">
        <div class="top-slide top-slider__slide" style="background-image: url(/htdocs/assets/build/img/bg.jpg);">
            <div class="top-slide__left">
                <div class="top-slide__name">
                    <?php echo (($tmp = $_smarty_tpl->getValue('content')->title ?? null)===null||$tmp==='' ? $_smarty_tpl->getValue('node')->title ?? null : $tmp);?>

                </div>
                <?php if ($_smarty_tpl->getValue('content')->banner_list) {?>
                    <div class="top-slide__content">
                        <ul class="top-slide__list">
                            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->banner_list, 'item', false, NULL, 'list_items', array (
));
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('item')->value) {
$foreach0DoElse = false;
?>
                                <li><?php echo $_smarty_tpl->getValue('item')['value'];?>
</li>
                            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        </ul>
                    </div>
                <?php }?>
                <div class="top-slide__btm">
                    <?php if ($_smarty_tpl->getValue('content')->price) {?>
                        <div class="top-slide__price">
                            <?php echo $_smarty_tpl->getValue('content')->price;?>

                        </div>
                    <?php }?>

                    <?php if ($_smarty_tpl->getValue('content')->sign) {?>
                        <div class="top-slide__num"><?php echo $_smarty_tpl->getValue('content')->sign;?>
</div>
                    <?php }?>

                    <button class="btn btn--black btn--lg top-slide__btn" data-action="request"><span>Запись</span>
                    </button>
                </div>
            </div>
            <div class="top-slide__right">
                <div class="tag tag--white top-slide__tag">Ваш врач</div>
                <div class="top-slide__slider js-main-swiper__slider">
                    <div class="top-slide__wrapper swiper-wrapper">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->banner_staff, 'staff', false, NULL, 'staff_list', array (
));
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('staff')->value) {
$foreach1DoElse = false;
?>
                            <div class="top-slide__slide swiper-slide">
                                <div class="top-slide__doctor-wrapper">
                                    <?php if ($_smarty_tpl->getValue('staff')->image->id) {?>
                                        <img class="top-slide__doctor" src="<?php echo $_smarty_tpl->getValue('staff')->image->getLink('banner');?>
" alt="" width="576" height="619">
                                    <?php }?>
                                </div>
                                <div class="top-slide__info info">
                                    <?php if ($_smarty_tpl->getValue('staff')->rating) {?>
                                        <div class="info__top">
                                            <img class="info__lic" src="/htdocs/assets/build/img/licences.png" alt="" width="162" height="106">
                                            <div class="info__rating">
                                                <div class="info__rate">
                                                    <p class="info__rate-rate"><?php echo $_smarty_tpl->getValue('staff')->rating;?>
</p>
                                                    <p>
                                                        <svg class="btn__icon" fill="none" width="17" height="17">
                                                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#star"></use>
                                                        </svg>
                                                    </p>

                                                </div>
                                                <div class="info__checked">
                                                    <svg class="btn__icon" fill="none" width="9" height="12">
                                                        <use xlink:href="/htdocs/assets/build/img/sprite.svg#shield"></use>
                                                    </svg>
                                                    Проверено
                                                </div>
                                                <img class="info__img" src="/htdocs/assets/build/img/pro-doctorov.png" alt="" width="129" height="20">
                                            </div>
                                        </div>
                                    <?php }?>
                                    <div class="info__about">
                                        <p class="info__name"><?php echo $_smarty_tpl->getValue('staff')->title;?>
</p>

                                        <?php if ($_smarty_tpl->getValue('staff')->position) {?>
                                            <p class="info__text"><?php echo $_smarty_tpl->getValue('staff')->position;?>
</p>
                                        <?php }?>
                                    </div>
                                </div>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('content')->banner_staff) > 1) {?>
            <div class="top-slider__controls">
                <div class="top-slider__dots js-main-swiper__dots"></div>
                <div class="top-slider__arrs arrs">
                    <button class="btn btn--bordered btn--bordered-white arr arr--left">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                    <button class="btn btn--bordered btn--bordered-white arr arr--right">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                </div>
            </div>
        <?php }?>
    </div>
<?php }?>

<section class="overflow" id="service">
    <?php if ($_smarty_tpl->getValue('content')->text) {?>
        <section class="digital mb-60-100 container">
            <?php if ($_smarty_tpl->getValue('content')->text_sign) {?>
                <div class="tag  digital__tag"><?php echo $_smarty_tpl->getValue('content')->text_sign;?>
</div>
            <?php }?>
            <div class="digital__content">
                <?php if ($_smarty_tpl->getValue('content')->text_title) {?>
                    <h2 class="h2 anim-block anim-masked" data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->text_title;?>
</h2>
                <?php }?>

                <div class="digital__text  anim-block anim-masked" data-animation="anim-masked-mask">
                    <?php echo $_smarty_tpl->getValue('content')->text;?>

                </div>
            </div>

            <div class="digital__imgs anim-block">
                <div class="digital__imgs-inside">
                    <?php if ($_smarty_tpl->getValue('content')->head_1->id || $_smarty_tpl->getValue('content')->head_2->id || $_smarty_tpl->getValue('content')->head_3->id) {?>
                        <?php if ($_smarty_tpl->getValue('content')->head_1->id) {?>
                            <img src="<?php echo $_smarty_tpl->getValue('content')->head_1->getLink();?>
" alt="" class="digitlal__face">
                        <?php }?>

                        <?php if ($_smarty_tpl->getValue('content')->head_2->id) {?>
                            <img src="<?php echo $_smarty_tpl->getValue('content')->head_2->getLink();?>
" alt="" class="digitlal__face2 anim" data-animation="slide-in">
                        <?php }?>

                        <?php if ($_smarty_tpl->getValue('content')->head_3->id) {?>
                            <img src="<?php echo $_smarty_tpl->getValue('content')->head_3->getLink();?>
" alt="" class="digitlal__face3 anim" data-animation="slide-in2">
                        <?php }?>
                    <?php } else { ?>
                        <img src="/htdocs/assets/build/img/face3.png" alt="" class="digitlal__face">
                        <img src="/htdocs/assets/build/img/face2.png" alt="" class="digitlal__face2 anim" data-animation="slide-in">
                        <img src="/htdocs/assets/build/img/face.png" alt="" class="digitlal__face3 anim" data-animation="slide-in2">
                    <?php }?>
                </div>
            </div>
        </section>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('content')->advantages) {?>
        <section class="container">
            <?php if ($_smarty_tpl->getValue('content')->advantages_title) {?>
                <h3 class="h3 mb-30 h3--arr  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->advantages_title;?>
</h3>
            <?php }?>
            <div class="why js-why">
                <div class="why__slider js-why__slider">
                    <div class="why__wrapper swiper-wrapper">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->advantages, 'advantage', false, NULL, 'advantages', array (
));
$foreach2DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('advantage')->value) {
$foreach2DoElse = false;
?>
                            <article class="why-it bg-gray why__it swiper-slide">
                                <div class="why-it__img">
                                    <?php if ($_smarty_tpl->getValue('advantage')['image']->id) {?>
                                        <img src="<?php echo $_smarty_tpl->getValue('advantage')['image']->getLink();?>
" alt="" width="261" height="270">
                                    <?php }?>
                                </div>
                                <div class="why-it__content">
                                    <h4 class="why-it__name"><?php echo $_smarty_tpl->getValue('advantage')['title'];?>
</h4>
                                    <div>
                                        <p><?php echo $_smarty_tpl->getValue('advantage')['text'];?>
</p>
                                    </div>
                                </div>
                            </article>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
                <div class="why__arrs arrs">
                    <button class="btn btn--bordered  arr arr--left">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                    <button class="btn btn--bordered arr arr--right">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </section>
    <?php }?>
</section>

<?php if ($_smarty_tpl->getValue('content')->equipment) {?>
    <section class="overflow pb-60-100 pt-60-100 bg-light" data-parallax="0.2">
        <div class="container">
            <?php if ($_smarty_tpl->getValue('content')->equipment_title) {?>
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->equipment_title;?>
</h3>
            <?php }?>

            <div class="equipment js-cards">
                <div class="equipment__slider js-cards__slider">
                    <div class="equipment__wrapper swiper-wrapper">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->equipment, 'equopment', false, NULL, 'equipment_list', array (
));
$foreach3DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('equopment')->value) {
$foreach3DoElse = false;
?>
                            <article class="eq-it equipment__it swiper-slide">
                                <div class="eq-it__inside">
                                    <div class="eq-it__img">
                                        <?php if ($_smarty_tpl->getValue('equopment')->image->id) {?>
                                            <img src="<?php echo $_smarty_tpl->getValue('equopment')->image->getLink();?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('equopment')->title, ENT_QUOTES, 'UTF-8', true);?>
" class="eq-it__pic"
                                                 width="403" height="451">
                                        <?php }?>
                                    </div>
                                    <div class="eq-it__content">
                                        <div class="eq-it__name"><?php echo $_smarty_tpl->getValue('equopment')->title;?>
</div>
                                        <?php if ($_smarty_tpl->getValue('equopment')->text) {?>
                                            <div class="eq-it__text">
                                                <?php echo $_smarty_tpl->getValue('equopment')->text;?>

                                            </div>
                                        <?php }?>
                                    </div>
                                </div>
                            </article>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>

<?php if ($_smarty_tpl->getValue('content')->video->id || $_smarty_tpl->getValue('content')->video_cover->id) {?>
    <div class="video-block container" style="transform: translate3d(0,0,0);" data-parallax="0.2">
        <div class="video-block__content anim-block anim-masked" data-animation="anim-masked-mask">
            <?php if ($_smarty_tpl->getValue('content')->video_title) {?>
                <h2 class="h2"><?php echo $_smarty_tpl->getValue('content')->video_title;?>
</h2>
            <?php }?>

            <?php if ($_smarty_tpl->getValue('content')->video_text) {?>
                <div class="video-block__text"><?php echo $_smarty_tpl->getValue('content')->video_text;?>
</div>
            <?php }?>
        </div>
        <div class="video-block__video js-video-block">
            <div class="video anim-cliped anim-block" data-animation="anim-cliped-anim"  <?php if ($_smarty_tpl->getValue('content')->video->id) {?>data-video="<?php echo $_smarty_tpl->getValue('content')->video->getLink();?>
"<?php }?>>
                <?php if ($_smarty_tpl->getValue('content')->video_cover->id) {?>
                    <img src="/htdocs/assets/build/img/img7.jpg" alt="" width="820" height="476">
                <?php }?>
                <?php if ($_smarty_tpl->getValue('content')->video->id) {?>
                    <button class="btn video-btn">
                        <svg class="btn__play" width="30" height="34" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>

                        </svg>
                        <svg class="btn__pause" width="30" height="34" viewBox="0 0 33 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M27.5 75.5L27.5 5.5M5.5 75.5L5.5 5.5" stroke="url(#play)" stroke-width="11" stroke-linecap="round"></path>

                        </svg>
                    </button>
                <?php }?>
            </div>
        </div>
        <?php if ($_smarty_tpl->getValue('content')->video->id) {?>
            <div class="video-block__btn">
                <div class="result-slide__video-btn-inside">
                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"
                              fill="url(#paint0_linear_750_782)"></path>
                        <defs>
                            <linearGradient id="paint0_linear_750_782" x1="6.5" y1="-0.72998" x2="0.00811087" y2="14.3424"
                                            gradientUnits="userSpaceOnUse">
                                <stop stop-color="#7BFAD5"></stop>
                                <stop offset="1" stop-color="white"></stop>
                            </linearGradient>
                        </defs>
                    </svg>
                </div>
            </div>
        <?php }?>
    </div>
<?php }?>

<?php if ($_smarty_tpl->getValue('content')->under_video_text) {?>
    <div class="results  container" data-parallax="0.2">
        <?php if ($_smarty_tpl->getValue('content')->under_video_title) {?>
            <h3 class="h3 results__h3 anim-block anim-masked" data-animation="anim-masked-mask">
                <?php echo $_smarty_tpl->getValue('content')->under_video_title;?>

            </h3>
        <?php }?>
        <div class="results__img">
            <?php if ($_smarty_tpl->getValue('content')->under_video_image->id) {?>
                <img src="<?php echo $_smarty_tpl->getValue('content')->under_video_image->getLink();?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('content')->under_video_title, ENT_QUOTES, 'UTF-8', true);?>
" width="748" height="571">
            <?php }?>
        </div>
        <div class="results__content">
            <div class="results__text">
                <?php echo $_smarty_tpl->getValue('content')->under_video_text;?>

            </div>
            <button class="btn btn--blue btn--lg top-slide__btn" data-action="request"><span>Запись</span></button>
        </div>

    </div>
<?php }?>

<section id="prices" class="overflow pb-60-100 pt-60-100 bg-light" data-parallax="0.2">
    <?php if ($_smarty_tpl->getValue('content')->prices) {?>
        <section class="container mb-60-100">
            <?php if ($_smarty_tpl->getValue('content')->prices_title) {?>
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->prices_title;?>
</h3>
            <?php }?>
            <div class="prices">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->prices, 'price', false, NULL, 'prices', array (
));
$foreach4DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('price')->value) {
$foreach4DoElse = false;
?>
                    <?php $_smarty_tpl->renderSubTemplate('file:module/prices/include/element.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('content'=>$_smarty_tpl->getValue('price')), (int) 0, $_smarty_current_dir);
?>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        </section>
    <?php }?>

    <?php if ($_smarty_tpl->getValue('content')->prices_list) {?>
        <section class="container">
            <?php if ($_smarty_tpl->getValue('content')->prices_list_title) {?>
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->prices_list_title;?>
</h3>
            <?php }?>

            <div class="other">
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->prices_list, 'price', false, NULL, 'prices', array (
));
$foreach5DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('price')->value) {
$foreach5DoElse = false;
?>
                    <?php if ($_smarty_tpl->getValue('price')->is_stock) {?>
                        <?php $_smarty_tpl->renderSubTemplate('file:module/prices/include/list_stock.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('content'=>$_smarty_tpl->getValue('price')), (int) 0, $_smarty_current_dir);
?>
                    <?php } else { ?>
                        <?php $_smarty_tpl->renderSubTemplate('file:module/prices/include/list_element.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('content'=>$_smarty_tpl->getValue('price')), (int) 0, $_smarty_current_dir);
?>
                    <?php }?>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </div>
        </section>
    <?php }?>
</section>
<?php if ($_smarty_tpl->getValue('content')->numbers) {?>
    <section>
        <?php if ($_smarty_tpl->getValue('content')->numbers_title) {?>
            <div class="container">
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->numbers_title;?>
</h3>
            </div>
        <?php }?>

        <div class="history ">
            <div class="container history__arrs">
                <div class="arrs">
                    <button class="btn btn--bordered  arr arr--left">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                    <button class="btn btn--bordered arr arr--right">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="overflow">
                <div class="history__slider container">
                    <div class="history__wrapper swiper-wrapper">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->numbers, 'number', false, NULL, 'numbers', array (
));
$foreach6DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('number')->value) {
$foreach6DoElse = false;
?>
                            <?php if (!(true && ($_smarty_tpl->hasVariable('history_delay') && null !== ($_smarty_tpl->getValue('history_delay') ?? null)))) {?>
                                <?php $_smarty_tpl->assign('history_delay', 0.2, false, NULL);?>
                            <?php } else { ?>
                                <?php $_smarty_tpl->assign('history_delay', $_smarty_tpl->getValue('history_delay')+0.2, false, NULL);?>
                            <?php }?>

                            <div class="history-it history__it swiper-slide anim-block anim-popup" data-animation="anim-popup-anim" data-delay="<?php echo $_smarty_tpl->getValue('history_delay');?>
">
                                <div class="history-it__num">
                                    <div class="history-it__round">
                                    </div>
                                </div>
                                <div class="history-it__content">
                                    <div class="history-it__content-inside">
                                        <?php echo $_smarty_tpl->getValue('number')['value'];?>

                                    </div>
                                </div>
                            </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                        <div class="history-it history__it swiper-slide"></div>
                        <div class="history-it history__it swiper-slide"></div>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php }?>

<div class="overflow">
    <?php echo $_smarty_tpl->getValue('blocks')['about'];?>

    <?php echo $_smarty_tpl->getValue('blocks')['rating'];?>

</div>

<?php if ($_smarty_tpl->getValue('content')->results) {?>
    <div id="results" class="overflow result-block">
        <?php if ($_smarty_tpl->getValue('content')->results_title) {?>
            <div class="result-block__top container  mb-30">
                <h3 class="h3"><?php echo $_smarty_tpl->getValue('content')->results_title;?>
</h3>
            </div>
        <?php }?>
        <div class="results-slider js-auto-swiper">
            <div class="container results-slider__arrs ">
                <div class="arrs">
                    <button class="btn btn--bordered  arr arr--left">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                    <button class="btn btn--bordered arr arr--right">
                        <svg class="btn__icon" fill="none" width="90" height="46">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#arr"></use>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="results-slider__slider js-auto-swiper__slider">
                <div class="results-slider__wrapper swiper-wrapper">
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->results, 'result', false, NULL, 'results', array (
));
$foreach7DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('result')->value) {
$foreach7DoElse = false;
?>
                        <div class="results-slider__slide result-slide swiper-slide">
                            <div class="container result-slide__container">
                                <div class="result-slide__person">
                                    <div class="result-slide__person-img">
                                        <?php if ($_smarty_tpl->getValue('result')->image->id) {?>
                                            <img src="<?php echo $_smarty_tpl->getValue('result')->image->getLink();?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('result')->title, ENT_QUOTES, 'UTF-8', true);?>
" width="88" height="88">
                                        <?php }?>
                                    </div>
                                    <div class="result-slide__person-name"><?php echo $_smarty_tpl->getValue('result')->title;?>
</div>
                                    <?php if ($_smarty_tpl->getValue('result')->age) {?>
                                        <div class="result-slide__person-age"><?php echo $_smarty_tpl->getValue('result')->age;?>
</div>
                                    <?php }?>
                                </div>
                                <?php if ($_smarty_tpl->getValue('result')->text) {?>
                                    <div class="result-slide__anam">
                                        <h4>Анамнез</h4>
                                        <?php echo $_smarty_tpl->getValue('result')->text;?>

                                    </div>
                                <?php }?>

                                <?php if ($_smarty_tpl->getValue('result')->video->id || $_smarty_tpl->getValue('result')->video_cover->id) {?>
                                    <div class="result-slide__video js-video-block">
                                        <div class="video anim-block anim-cliped" data-animation="anim-cliped-anim" <?php if ($_smarty_tpl->getValue('result')->video->id) {?>data-video="<?php echo $_smarty_tpl->getValue('result')->video->getLink();?>
"<?php }?>>
                                            <?php if ($_smarty_tpl->getValue('result')->video_cover->id) {?>
                                                <img src="<?php echo $_smarty_tpl->getValue('result')->video_cover->getLink();?>
" alt="" width="820" height="476">
                                            <?php }?>

                                            <?php if ($_smarty_tpl->getValue('result')->video->id) {?>
                                                <button class="btn video-btn">
                                                    <svg class="btn__play" width="30" height="34" viewBox="0 0 12 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z" fill="url(#play)"></path>

                                                    </svg>
                                                    <svg class="btn__pause" width="30" height="34" viewBox="0 0 33 81" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M27.5 75.5L27.5 5.5M5.5 75.5L5.5 5.5" stroke="url(#play)" stroke-width="11" stroke-linecap="round"></path>

                                                    </svg>
                                                </button>
                                            <?php }?>
                                        </div>
                                        <?php if ($_smarty_tpl->getValue('result')->video->id) {?>
                                            <div class="result-slide__video-btn">
                                                <div class="result-slide__video-btn-inside">
                                                    <svg width="12" height="14" viewBox="0 0 12 14" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M11.4986 5.90383C12.1656 6.28866 12.1656 7.25138 11.4986 7.63621L1.49972 13.4048C0.833055 13.7894 4.20706e-08 13.3083 7.57384e-08 12.5386L5.80418e-07 1.00143C6.14086e-07 0.231771 0.833057 -0.249371 1.49972 0.135244L11.4986 5.90383Z"
                                                              fill="url(#paint0_linear_750_782)"></path>
                                                        <defs>
                                                            <linearGradient id="paint0_linear_750_782" x1="6.5" y1="-0.72998"
                                                                            x2="0.00811087" y2="14.3424" gradientUnits="userSpaceOnUse">
                                                                <stop stop-color="#7BFAD5"></stop>
                                                                <stop offset="1" stop-color="white"></stop>
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                <?php }?>
                                <div class="result-slide__solution solution">
                                    <?php if ($_smarty_tpl->getValue('result')->solution) {?>
                                        <div class="solution__name">Наше решение</div>
                                        <div class="solution__text">
                                            <?php echo $_smarty_tpl->getValue('result')->solution;?>

                                        </div>
                                    <?php }?>
                                    <?php if ($_smarty_tpl->getValue('result')->staff) {?>
                                        <div class="solution__slider">
                                            <div class="solution__slider-name">Команда</div>
                                            <div class="doctors solution__slider-doctors js-why">
                                                <div class="doctors__hide"></div>
                                                <div class="doctors__slider js-why__slider">
                                                    <div class="doctors__wrapper swiper-wrapper">

                                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('result')->staff, 'doctor', false, NULL, 'doctors', array (
));
$foreach8DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('doctor')->value) {
$foreach8DoElse = false;
?>
                                                            <?php if (!(true && ($_smarty_tpl->hasVariable('delay') && null !== ($_smarty_tpl->getValue('delay') ?? null)))) {?>
                                                                <?php $_smarty_tpl->assign('delay', 0, false, NULL);?>
                                                            <?php } else { ?>
                                                                <?php $_smarty_tpl->assign('delay', $_smarty_tpl->getValue('delay')+0.2, false, NULL);?>
                                                            <?php }?>

                                                            <div class="doctor-slide  doctor-slide--sm swiper-slide anim-block anim-popup" data-animation="anim-popup-anim" data-delay="<?php echo $_smarty_tpl->getValue('delay');?>
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
                                                                    <?php if ($_smarty_tpl->getValue('doctor')->position) {?>
                                                                        <div class="doctor-slide__pos">
                                                                            <?php echo $_smarty_tpl->getValue('doctor')->position;?>

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
                                        </div>
                                    <?php }?>

                                    <?php if ($_smarty_tpl->getValue('result')->images) {?>
                                        <div class="solution__progress progress">
                                            <div class="progress__name">Ход лечения и динамика</div>
                                            <div class="progress__imgs" data-glightbox="<?php echo $_smarty_tpl->getValue('result')->id;?>
">
                                                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('result')->images, 'image', false, NULL, 'images', array (
));
$foreach9DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('image')->value) {
$foreach9DoElse = false;
?>
                                                    <?php if ($_smarty_tpl->getValue('image')->id) {?>
                                                        <a href="<?php echo $_smarty_tpl->getValue('image')->getLink();?>
" class="progress__img glightbox-<?php echo $_smarty_tpl->getValue('result')->id;?>
">
                                                            <img src="<?php echo $_smarty_tpl->getValue('image')->getLink();?>
" alt="" width="88" height="58">
                                                        </a>
                                                    <?php }?>
                                                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                            </div>
                                        </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </div>
            </div>
        </div>
    </div>
<?php }?>

<?php if ($_smarty_tpl->getValue('content')->stocks) {?>
    <section id="stocks" class="overflow">
        <div class="container">
            <?php if ($_smarty_tpl->getValue('content')->stocks_title) {?>
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->stocks_title;?>
</h3>
            <?php }?>
            <div class="promo-slider js-why">
                <div class="promo-slider__slider js-why__slider">
                    <div class="promo-slider__wrapper swiper-wrapper">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->stocks, 'stock', false, NULL, 'stocks', array (
));
$foreach10DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('stock')->value) {
$foreach10DoElse = false;
?>
                            <div class="promo promo-slider__it swiper-slide anim-block anim-popup" data-animation="anim-popup-anim" style="--promo-bg: #6BD8DB;">
                                <div class="promo__content">
                                    <?php if ($_smarty_tpl->getValue('stock')->sign) {?>
                                        <div class="glass-tag glass-tag--white"><?php echo $_smarty_tpl->getValue('stock')->sign;?>
</div>
                                    <?php }?>
                                    <div class="promo__name"><?php echo $_smarty_tpl->getValue('stock')->title;?>
</div>
                                    <?php if ($_smarty_tpl->getValue('stock')->price) {?>
                                        <div class="promo__price"><?php echo $_smarty_tpl->getValue('stock')->price;?>
</div>
                                    <?php }?>


                                    <?php if ($_smarty_tpl->getValue('stock')->text) {?>
                                        <button class="btn btn--bordered btn--bordered-white btn--sm promo__btn" data-action="promo-<?php echo $_smarty_tpl->getValue('stock')->id;?>
">
                                            <span>Подробнее</span>
                                        </button>
                                    <?php }?>
                                </div>
                                <div class="promo__img">
                                    <?php if ($_smarty_tpl->getValue('stock')->image->id) {?>
                                        <img src="<?php echo $_smarty_tpl->getValue('stock')->image->getLink();?>
" alt="<?php echo htmlspecialchars((string)$_smarty_tpl->getValue('stock')->title, ENT_QUOTES, 'UTF-8', true);?>
"
                                             width="527" height="401">
                                    <?php }?>
                                </div>
                                    </div>
                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }?>

<?php if ($_smarty_tpl->getValue('content')->stocks) {?>
    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->stocks, 'stock', false, NULL, 'stocks', array (
));
$foreach11DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('stock')->value) {
$foreach11DoElse = false;
?>
        <?php if ($_smarty_tpl->getValue('stock')->text) {?>
            <div class="popup" data-target="promo-<?php echo $_smarty_tpl->getValue('stock')->id;?>
">
                <div class="popup__inside">
                    <button class="btn popup__close js-close">
                        <svg fill="none" width="30" height="30">
                            <use xlink:href="/htdocs/assets/build/img/sprite.svg#cross"></use>
                        </svg>
                    </button>
                    <div class="popup__name"><?php echo $_smarty_tpl->getValue('stock')->title;?>
</div>
                    <div class="popup__content text">
                        <?php echo $_smarty_tpl->getValue('stock')->text;?>

                    </div>

                    <div class="form__btns">
                        <button class="btn btn--sm btn--black" data-action="request">Оставить заявку</button>
                    </div>
                </div>
            </div>
        <?php }?>
    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);
}?>

<?php if ($_smarty_tpl->getValue('content')->faq) {?>
    <section id="faq" class="container questions-block overflow">
        <?php if ($_smarty_tpl->getValue('content')->faq_title) {?>
            <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->faq_title;?>
</h3>
        <?php }?>
        <div class="questions-block__content">
            <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->faq, 'question', false, NULL, 'questions', array (
));
$foreach12DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('question')->value) {
$foreach12DoElse = false;
?>
                <details class="faq-it anim-block anim-popup" data-animation="anim-popup-anim">
                    <summary class="faq-it__btn">
                        <span class="faq-it__btn-text"><?php echo $_smarty_tpl->getValue('question')['title'];?>
</span>
                        <div class="faq-it__btn-svg btn">

                            <svg class="btn__icon" fill="none" width="18" height="18">
                                <use xlink:href="/htdocs/assets/build/img/sprite.svg#plus"></use>
                            </svg>
                        </div>
                    </summary>
                    <div class="faq-it__content">
                        <div class="faq-it__content-inside">
                            <?php echo $_smarty_tpl->getValue('question')['answer'];?>

                        </div>
                    </div>
                </details>
            <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
        </div>
    </section>
<?php }?>


<?php if ($_smarty_tpl->getValue('content')->services) {?>
    <section class="overflow pb-60-100 pt-60-100 bg-light">
        <div class="container">
            <?php if ($_smarty_tpl->getValue('content')->services_title) {?>
                <h3 class="h3 mb-30  anim-block anim-masked"  data-animation="anim-masked-mask"><?php echo $_smarty_tpl->getValue('content')->services_title;?>
</h3>
            <?php }?>
            <div class="services-slider js-auto-swiper" data-gap="20">
                <div class="services-slider__slider js-auto-swiper__slider">
                    <div class="services-slider__wrapper swiper-wrapper">
                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('content')->services, 'service', false, NULL, 'services', array (
));
$foreach13DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('service')->value) {
$foreach13DoElse = false;
?>
                            <?php if (!(true && ($_smarty_tpl->hasVariable('service_delay') && null !== ($_smarty_tpl->getValue('service_delay') ?? null)))) {?>
                                <?php $_smarty_tpl->assign('service_delay', 0.2, false, NULL);?>
                            <?php } else { ?>
                                <?php $_smarty_tpl->assign('service_delay', $_smarty_tpl->getValue('service_delay')+0.2, false, NULL);?>
                            <?php }?>

                            <?php $_smarty_tpl->renderSubTemplate('file:module/services/include/element.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('content'=>$_smarty_tpl->getValue('service'),'class'=>'services-slider__it swiper-slide anim-block anim-popup','animation'=>'anim-popup-anim','delay'=>$_smarty_tpl->getValue('service_delay')), (int) 0, $_smarty_current_dir);
?>

                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php }
}
}
