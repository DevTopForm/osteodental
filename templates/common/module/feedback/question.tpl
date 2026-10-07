<div class="popup popup--question" data-popup="question">
    <div class="popup__inside">
        <button class="btn btn--close popup__close js-close" aria-label="Закрыть попап">
            <svg fill="none" width="9" height="9">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#cross"></use>
            </svg>
        </button>

        <div class="popup__top">
            <div class="popup__name h2">Задать вопрос</div>
            <div class="popup__text">Заполните форму, и мы свяжемся с вами, чтобы ответить на ваш вопрос. Если не удастся дозвониться, мы напишем вам в мессенджеры.</div>
        </div>
        <div class="popup__content">

            <form class="form popup__form" method="post" enctype="multipart/form-data" action="/service/formy/zadat-vopros">
                <input type="hidden" name="areaform" value="0"/>
                <input type="hidden" name="ajreq" value="1"/>
                <input type="hidden" name="send" value="1"/>

                <div class="feedback-errors hidden"></div>
                
                <div class="form__fieldset">
                    <label class="label">
                        <input class="label__input" type="text" name="field_130_area_0" value="" placeholder="Имя" required="required">
                        <span class="label__name">Как к вам обращаться</span>
                        <span class="label__error">Обязательное поле</span>
                    </label>
                    <label class="label">
                        <input class="label__input" type="tel" name="field_131_area_0" value="" placeholder="+7 (994) 999 99 99" required="required">
                        <span class="label__name">Телефон</span>
                        <span class="label__error">Обязательное поле</span>
                    </label>
                    <label class="label">
                        <input class="label__input" type="email" name="field_132_area_0" value="" placeholder="Почта" required="required">
                        <span class="label__name">E-mail</span>
                        <span class="label__error">Обязательное поле</span>
                    </label>
                    <label class="label">
                        <textarea class="label__input" type="textarea" name="field_133_area_0" placeholder="Комментарий" rows="4"></textarea>
                        <span class="label__name">Ваш вопрос</span>
                        <span class="label__error">Обязательное поле</span>
                    </label>
                </div>

                <label class="label-check label-agreed">
                    <input type="checkbox" name="field_134_area_0" class="label-check__input" value="1" required="required">
                    <span class="label-check__name">Нажимая кнопку «Перезвоните мне», вы подтверждаете своё согласие на обработку <a href="/policy" target="_blank">персональных данных.</a></span>
                </label>

                <div class="feedback-errors hidden"></div>

                <button class="btn btn--lilac btn--lg form__send" type="submit">Отправить</button>
            </form>
        </div>
    </div>
</div>