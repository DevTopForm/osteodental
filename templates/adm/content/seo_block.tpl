{*{if $item->id}{include file='menu/node-actions.tpl' node=$item active=node}{/if}*}
{if $state == 'edit' || $state == 'add'}

<section class="catalog">
    {include file='menu/node-actions.tpl' node=$item}

    <h1 class="h1 catalog__h1">
        {if $state == 'edit'}{$item->title}{else}Создание раздела{/if}
    </h1>

    {include file='menu/node-menu.tpl' node=$item active="seo"}

    <form id="seo-form" action="" method="post" enctype="multipart/form-data" class="form form--980">
        <div class="form__fieldset">
            <div class="form__fieldset-wrap">
                {if !$item->blocked || $user->hasAccess('lock')}
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">{$_LNG_ADM.NOINDEX}</span>
                        </div>
                        <span class="label__wrapper">
                            <input type="text" value="{$item->noindex|escape}" class="label__input" name="noindex" placeholder="">
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">{$_LNG_ADM.BREAD}</span>
                        </div>
                        <span class="label__wrapper">
                            <input type="text" value="{$item->bread|escape}" class="label__input" name="bread" placeholder="">
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">{$_LNG_ADM.CANONICAL}</span>
                        </div>
                        <span class="label__wrapper">
                            <input type="text" value="{$item->canonical|escape}" class="label__input" name="canonical" placeholder="">
                        </span>
                    </label>

                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">{$_LNG_ADM.REDIRECT}</span>
                        </div>
                        <span class="label__wrapper">
                            <input type="text" value="{$item->redirect|escape}" class="label__input" name="redirect" placeholder="">
                        </span>
                    </label>
                {/if}

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">Мета-заголовок</span>
                    </div>
                    <span class="label__wrapper">
                        <input type="text" value="{$item->meta_title|escape}" class="label__input" name="meta_title" placeholder="">
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.KEYWORDS}</span>
                    </div>
                    <span class="label__wrapper">
                        <textarea class="label__input" name="meta_keywords">{$item->meta_keywords}</textarea>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.DESCRIPTION}</span>
                    </div>
                    <span class="label__wrapper">
                        <textarea class="label__input" name="meta_description">{$item->meta_description}</textarea>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">H1</span>
                    </div>

                    <span class="label__wrapper">
                        <input type="text" value="{$item->h1}" class="label__input" name="h1">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.PRIORITY_NODE}</span>
                    </div>

                    <span class="label__wrapper">
                        <input type="text" value="{$item->priority_node}" class="label__input" name="priority_node">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.PRIORITY_NODE}</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="changefreq_node">
                            <option value="" {if !$item->changefreq_node}selected{/if} rel="">---</option>
                            <option value="always" {if $item->changefreq_node == 'always'}selected{/if} rel="">always</option>
                            <option value="hourly" {if $item->changefreq_node == 'hourly'}selected{/if} rel="">hourly</option>
                            <option value="daily" {if $item->changefreq_node == 'daily'}selected{/if} rel="">daily</option>
                            <option value="weekly" {if $item->changefreq_node == 'weekly'}selected{/if} rel="">weekly</option>
                            <option value="monthly" {if $item->changefreq_node == 'monthly'}selected{/if} rel="">monthly
                            </option>
                            <option value="yearly" {if $item->changefreq_node == 'yearly'}selected{/if} rel="">yearly</option>
                            <option value="never" {if $item->changefreq_node == 'never'}selected{/if} rel="">never</option>
                        </select>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.PRIORITY_ELEMENT}</span>
                    </div>

                    <span class="label__wrapper">
                        <input type="text" value="{$item->priority_element}" class="label__input" name="priority_element">
                        <span class="label__mistake">Внесите данные</span>
                    </span>
                </label>

                <label class="label form__input-full">
                    <div class="label__content">
                        <span class="label__name">{$_LNG_ADM.PRIORITY_ELEMENT}</span>
                    </div>

                    <span class="label__wrapper label__wrapper--select">
                        <select class="label__select" name="changefreq_element">
                            <option value="" {if !$item->changefreq_element}selected{/if} rel="">---</option>
                            <option value="always" {if $item->changefreq_element == 'always'}selected{/if} rel="">always
                            </option>
                            <option value="hourly" {if $item->changefreq_element == 'hourly'}selected{/if} rel="">hourly
                            </option>
                            <option value="daily" {if $item->changefreq_element == 'daily'}selected{/if} rel="">daily</option>
                            <option value="weekly" {if $item->changefreq_element == 'weekly'}selected{/if} rel="">weekly
                            </option>
                            <option value="monthly" {if $item->changefreq_element == 'monthly'}selected{/if} rel="">monthly
                            </option>
                            <option value="yearly" {if $item->changefreq_element == 'yearly'}selected{/if} rel="">yearly
                            </option>
                            <option value="never" {if $item->changefreq_element == 'never'}selected{/if} rel="">never</option>
                        </select>
                    </span>
                </label>
            </div>
        </div>
    </form>

    <div class="form__check-group label form__input-full">
        <button name="save" value="{$_LNG_ADM.SAVE}" form="seo-form" type="submit" class="btn btn--blue btn--lg" style="width: fit-content;">
            <span>Сохранить</span>
        </button>
    </div>
</section>
{/if}
