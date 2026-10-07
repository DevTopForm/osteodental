<div class="popup popup--consult" data-popup="consult">
    <div class="popup__inside">
        <button class="btn btn--close popup__close js-close" aria-label="Закрыть попап">
            <svg fill="none" width="9" height="9">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#cross"></use>
            </svg>
        </button>

        <div class="popup__top">
            <div class="popup__name h2">Заказать звонок / консультацию</div>
            <div class="popup__text">Заполните пожалуйста поля ниже, чтобы мы смогли связаться с вами</div>
        </div>
        <div class="popup__content">
            <form class="form popup__form" method="post" enctype="multipart/form-data" action="/service/formy/zakazat-zvonok--konsultaciju">
                <input type="hidden" name="areaform" value="0"/>
                <input type="hidden" name="ajreq" value="1"/>
                <input type="hidden" name="send" value="1"/>
                <input type="hidden" name="field_135_area_0" value=""/>

                <div class="feedback-errors hidden"></div>

                <div class="form__fieldset">
                    <label class="label">
                        <input class="label__input" type="text" name="field_127_area_0" value="" placeholder="Имя"
                               required="required">
                        <span class="label__name">Как к вам обращаться</span>
                        <span class="label__error">Обязательное поле</span>
                    </label>
                    <label class="label">
                        <input class="label__input" type="tel" name="field_128_area_0" value="" placeholder="+7 (994) 999 99 99"
                               required="required">
                        <span class="label__name">Телефон</span>
                        <span class="label__error">Обязательное поле</span>
                    </label>
                </div>

                <label class="label-check label-agreed">
                    <input type="checkbox" name="field_129_area_0" class="label-check__input" value="1" required="required">
                    <span class="label-check__name">Нажимая кнопку «Перезвоните мне», вы подтверждаете своё согласие на обработку <a
                                href="/policy" target="_blank">персональных данных.</a></span>
                </label>

                <button class="btn btn--lilac btn--lg form__send" type="submit">Перезвоните мне</button>
            </form>
        </div>
    </div>
</div>