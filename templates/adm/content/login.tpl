<div class="login-block">
    <div class="login-block__wrapper">
        <span class="login-block__svg">
          <svg fill="none" width="26" height="26">
            <use xlink:href="{$adm_path}/assets/img/sprite.svg#user"></use>
          </svg>
        </span>
        <div class="login-block__name">Авторизация</div>
        <form action="{$adm_path}/login" method="post" class="form">
            <div class="form__fieldset-column login-block__fieldset">
                <label class="label  {if $error && $error.field == 'login_'}mistake{/if} form__input-column">
                    <div class="label__content">
                        <span class="label__name">Логин</span>
                    </div>
                    <span class="label__wrapper">
                      <input type="text" value="{if $query.login_}{$query.login_}{/if}" class="label__input" name="login_" placeholder="">

                        {if $error && $error.field == 'login_'}
                            <span class="label__mistake">{$error.text}</span>
                        {/if}
                    </span>
                </label>

                <label class="label {if $error && $error.field == 'password_'}mistake{/if} form__input-column">
                    <div class="label__content">
                        <span class="label__name">Пароль</span>
                    </div>

                    <span class="label__wrapper">
                        <input type="password" value="" class="label__input" name="password_" placeholder="">
                        {if $error && $error.field == 'password_'}
                            <span class="label__mistake">{$error.text}</span>
                        {/if}
      
                        <button class="btn label__password">
                          <svg class="label__opened" fill="none" width="22" height="20">
                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#eye"></use>
                          </svg>
                          <svg class="label__closed" fill="none" width="22" height="20">
                            <use xlink:href="{$adm_path}/assets/img/sprite.svg#eye-crossed"></use>
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
</div>