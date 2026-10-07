<?php
/* Smarty version 5.8.0, created on 2026-04-22 12:25:06
  from 'file:content/login.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.8.0',
  'unifunc' => 'content_69e893f230fff6_42306427',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '174d9be5be1b6f70c85e35d3fb58a0d734d7da1b' => 
    array (
      0 => 'content/login.tpl',
      1 => 1772458645,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_69e893f230fff6_42306427 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'D:\\Apps\\OSPanel\\home\\osteodental.local\\templates\\adm\\content';
?><div class="login-block">
    <div class="login-block__wrapper">
        <span class="login-block__svg">
          <svg fill="none" width="26" height="26">
            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#user"></use>
          </svg>
        </span>
        <div class="login-block__name">Авторизация</div>
        <form action="<?php echo $_smarty_tpl->getValue('adm_path');?>
/login" method="post" class="form">
            <div class="form__fieldset-column login-block__fieldset">
                <label class="label  <?php if ($_smarty_tpl->getValue('error') && $_smarty_tpl->getValue('error')['field'] == 'login_') {?>mistake<?php }?> form__input-column">
                    <div class="label__content">
                        <span class="label__name">Логин</span>
                    </div>
                    <span class="label__wrapper">
                      <input type="text" value="<?php if ($_smarty_tpl->getValue('query')['login_']) {
echo $_smarty_tpl->getValue('query')['login_'];
}?>" class="label__input" name="login_" placeholder="">

                        <?php if ($_smarty_tpl->getValue('error') && $_smarty_tpl->getValue('error')['field'] == 'login_') {?>
                            <span class="label__mistake"><?php echo $_smarty_tpl->getValue('error')['text'];?>
</span>
                        <?php }?>
                    </span>
                </label>

                <label class="label <?php if ($_smarty_tpl->getValue('error') && $_smarty_tpl->getValue('error')['field'] == 'password_') {?>mistake<?php }?> form__input-column">
                    <div class="label__content">
                        <span class="label__name">Пароль</span>
                    </div>

                    <span class="label__wrapper">
                        <input type="password" value="" class="label__input" name="password_" placeholder="">
                        <?php if ($_smarty_tpl->getValue('error') && $_smarty_tpl->getValue('error')['field'] == 'password_') {?>
                            <span class="label__mistake"><?php echo $_smarty_tpl->getValue('error')['text'];?>
</span>
                        <?php }?>
      
                        <button class="btn label__password">
                          <svg class="label__opened" fill="none" width="22" height="20">
                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#eye"></use>
                          </svg>
                          <svg class="label__closed" fill="none" width="22" height="20">
                            <use xlink:href="<?php echo $_smarty_tpl->getValue('adm_path');?>
/assets/img/sprite.svg#eye-crossed"></use>
                          </svg>
                        </button>
                    </span>
                </label>

            </div>
            <button type="submit" name="sign_in" value="Вход" class="btn btn--blue btn--lg login-block__btn">
                <span>Вход</span>
            </button>
        </form>
    </div>
</div><?php }
}
