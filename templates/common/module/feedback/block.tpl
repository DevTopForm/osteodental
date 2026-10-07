<div class="popup" data-target="request">
    <div class="popup__inside">
        <button class="btn popup__close js-close">
            <svg fill="none" width="30" height="30">
                <use xlink:href="/htdocs/assets/build/img/sprite.svg#cross"></use>
            </svg>
        </button>
        <div class="popup__name">Запишитесь на консультацию</div>
        <form action="" enctype="multipart/form-data" method="post" class="form feedback-form">
            <input type="hidden" name="areaform" value="{$area_id}"/>
            <input type="hidden" name="ajreq" value="1"/>
            <input type="hidden" name="send" value="1"/>

            <div class="form__part ">
                {foreach from=$content item='field' name='fields'}
                    {if $field->field->type != 'checkbox'}
                        <label class="label form__label">
                            <input name="{$field->field->getName()}" type="{$field->field->type}" class="input label__input label__input--bordered">
                            <span class="label__name">{$field->title}</span>
{*                            <span class="label__err">Обязательное поле</span>*}
                        </label>
                    {/if}
                {/foreach}
            </div>


            <div class="form__row">
                {foreach from=$content item='field' name='fields'}
                    {if $field->field->type == 'checkbox'}
                        <label class="form__agree {if $field->title == "Согласие"}feedback-form__agreed agreed{/if}">
                            <input type="checkbox" value="1" name="{$field->field->getName()}" class="check form__check check--bordered">
                            <span class="label__name">
                                {if $field->title == "Согласие"}
                                    Нажимая кнопку «Отправить заявку», я даю свое согласие на обработку моих <a href="/policy">персональных данных</a>, в соответствии с
                                    Федеральным законом от 27.07.2006 года №152-ФЗ «О персональных данных», на условиях и для целей, определенных в Согласии
                                    на обработку персональных данных
                                {else}
                                    {$field->title}
                                {/if}
                            </span>
                        </label>
                    {/if}
                {/foreach}

                <div class="form__btns">

                    <button type="submit" class="btn btn--sm btn--black popup__form-submit">Позвоните мне</button>
                    <div class="form__more">
                        Напишите в
                        {if $params.link_tg}
                            <a href="{$params.link_tg}" target="_blank" rel="nofollow" class="more-link"><span>telegram</span></a>
                        {/if}
                        {if $params.link_tg && $params.link_max} или {/if}
                        {if $params.link_max}
                            <a class="more-link" href="{$params.link_max}" target="_blank" rel="nofollow"><span>max</span></a>
                        {/if}
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>