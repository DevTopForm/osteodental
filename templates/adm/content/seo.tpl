
<section class="catalog">
    <div class="catalog__item-top">
        <div class="item-controls js-to-expand">
            <button class="btn btn--link item-controls__more js-expand " aria-label="Открыть кнопки">
                <svg fill="none" width="34" height="8">
                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots"></use>
                </svg>
            </button>
            <div class="item-controls__short">
                <div class="item-controls__group">
                </div>
            </div>
            <button form="form-fields" type="submit" name="save" value="Сохранить" class="btn btn--blue btn--lg">
                <span>Сохранить</span>
            </button>
        </div>
        {if $item->type}{include file='menu/module-actions.tpl' type=$module active=param}{/if}
    </div>

    <h1 class="h1 catalog__h1">{if $state == 'robots'}Robots.txt{elseif $state == 'metrika'}Код счетчиков{/if}</h1>
    <form id="form-fields" class="form  form--980" action="" method="post" enctype="multipart/form-data">
        <div class="form__fieldset">
            <div class="form__fieldset-wrap">
                {if $state == 'robots'}
                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">Содержимое файла</span>
                    </div>
                    <span class="label__wrapper">
                        <textarea name="data" type="text" class="label__input">{$item->data}</textarea>
                    </span>
                </label>
                {elseif $state == 'metrika'}
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Yandex metrika</span>
                        </div>
                        <span class="label__wrapper">
                            <textarea name="yandex_code" type="text" class="label__input">{$yandex}</textarea>
                        </span>
                    </label>
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Google analytics</span>
                        </div>
                        <span class="label__wrapper">
                            <textarea name="google_code" type="text" class="label__input">{$item->data}</textarea>
                        </span>
                    </label>
                {/if}
            </div>
        </div>
    </form>
</section>