<div class="panel">
    <div class="panel__name">Свойства области</div>
    <form class="form panel__form" action="/adm/ajax/image/save/{$image->id}" method="post"
          enctype="multipart/form-data">
        <div class="tabs js-tabs imgs-tabs">
            <div class="tabs__btns imgs-tabs__btns">
                {foreach from=$size key='name' item='item' name="tabsTitle"}
                    <label
                            class="btn tabs__btn active"
                            role="tab"
                            aria-selected="true"
                            aria-controls="tab-{$smarty.foreach.tabsTitle.iteration}"
                            id="tab{$smarty.foreach.tabsTitle.iteration}"
                            title="{if $item.title}{$item.title}{else}{$name}{/if}"
                    >
                        <input type="radio" class="btn__input" name="crop" value="{$name}">
                        {if $item.title}{$item.title}{else}{$name}{/if}
                    </label>
                {/foreach}
            </div>

            <div class="tabs__panels  imgs-tabs__panes" role="tablist">
                {foreach from=$size item='item' key='type' name='tabsContent'}
                    <div class="tabs__panel js-tabs-panes" role="tabpanel"
                         id="tab-{$smarty.foreach.tabsContent.iteration}"
                         aria-labelledby="tab{$smarty.foreach.tabsContent.iteration}">
                        <div class="crop-image imgs-tabs__img">
                            <img src="{$image->getLink()}?{$smarty.now}" data-crop="crop-img">
                        </div>
                    </div>
                {/foreach}
            </div>
            <div class="tabs__form imgs-tabs__form">
                <div class="{if $is_cabinet}form__rows{else}form__fieldset-full{/if}">
                    {foreach from=$size key='type' item='item'}
                        <input type="hidden" id="{$type}_x1" name="crop[{$type}][x1]" value="{$item.x1}"/>
                        <input type="hidden" id="{$type}_y1" name="crop[{$type}][y1]" value="{$item.y1}"/>
                        <input type="hidden" id="{$type}_x2" name="crop[{$type}][x2]" value="{$item.x2}"/>
                        <input type="hidden" id="{$type}_y2" name="crop[{$type}][y2]" value="{$item.y2}"/>
                        <input type="hidden" id="{$type}_bx" name="crop[{$type}][bx]" value=""/>
                        <input type="hidden" id="{$type}_by" name="crop[{$type}][by]" value=""/>
                        <input type="hidden" id="{$type}_w" name="crop[{$type}][w]" value="{$item.width}"/>
                        <input type="hidden" id="{$type}_h" name="crop[{$type}][h]" value="{$item.height}"/>
                        <input type="hidden" id="{$type}_is_aspect_ratio" name="crop[{$type}][is_aspect_ratio]"
                               value="{$item.is_aspect_ratio}"/>
                        <input type="hidden" id="{$type}_ratio_w" name="crop[{$type}][ratio_w]" value="{$item.ratio_w}">
                        <input type="hidden" id="{$type}_ratio_h" name="crop[{$type}][ratio_h]" value="{$item.ratio_h}">
                    {/foreach}

                    {if !$is_cabinet}
                        <label class="label">
                            <div class="label__content">
                                <span class="label__name">Заголовок изображения</span>
                            </div>
                            <span class="label__wrapper">
                            <input type="text" value="{$image->title}" class="label__input" name="title" placeholder="">
                        </span>
                        </label>
                    {/if}

                    {if !$is_cabinet}
                        <label class="label">
                            <div class="label__content">
                                <span class="label__name">Альтернативное название</span>
                            </div>
                            <span class="label__wrapper">
                            <input type="text" value="{$image->alt}" class="label__input" name="alt" placeholder="">
                        </span>
                        </label>
                    {/if}

                    {if $is_cabinet}
                        <div class="label ">
                            <div class="label__name">Реальные размеры</div>
                            <div><span class="jcrop-real-width"></span> x <span class="jcrop-real-height"></span>
                            </div>
                        </div>
                    {else}
                        <label class="check ">
                            <input class="check__input" name="fake-aspect" value="" type="checkbox">
                            <span class="check__name">Задать пропорции</span>
                        </label>
                        <div class="label__wrapper-btns label__wrapper-btns--check">
                            <div class="label__wrapper-name">Соотношение ширины к высоте</div>
                            <label class="label">
                                <span class="label__name">ширина</span>
                                <span class="label__wrapper">
                                    <input type="text" value="" class="label__input" name="fake-aspect-width"
                                           placeholder="">
                                    <span class="label__mistake">Внесите данные</span>
                                </span>
                            </label>
                            <label class="label">
                                <span class="label__name">высота</span>
                                <span class="label__wrapper">
                                    <input type="text" value="" class="label__input" name="fake-aspect-height"
                                           placeholder="">
                                    <span class="label__mistake">Внесите данные</span>
                                </span>
                            </label>
                        </div>
                        <div class="label__wrapper-btns">
                            <div class="label__wrapper-name">Размеры на странице</div>
                            <label class="label">
                                <span class="label__name">ширина</span>
                                <span class="label__wrapper">
                                    <input type="text" value="" class="label__input" name="fake-width" placeholder="">
                                    <span class="label__mistake">Внесите данные</span>
                                </span>
                            </label>
                            <label class="label">
                                <span class="label__name">высота</span>
                                <span class="label__wrapper">
                                    <input type="text" value="" class="label__input" name="fake-height" placeholder="">
                                    <span class="label__mistake">Внесите данные</span>
                                </span>
                            </label>
                        </div>
                    {/if}

                    {if $is_cabinet}
                        <button class="btn  btn--acid btn--lg">
                            <span>Сохранить</span>
                        </button>
                    {else}
                        <button class="btn btn--blue btn--lg right-auto">
                            <span>Сохранить</span>
                        </button>
                    {/if}
                </div>
            </div>
        </div>
    </form>
</div>