<section class="catalog">
    {include file='menu/node-actions.tpl' node=$node}

    <h1 class="h1 catalog__h1">{$node->title|default:"Новый раздел"}</h1>

    {include file='menu/node-menu.tpl' node=$node active=area}
    <div class="catalog-controls">
        <form class="form  form--980" action="{$adm_path}/area/copy/{$node->id}" method="post" enctype="multipart/form-data">
            <div class="filter-form__fieldset">
                <div class="label">
                    <span class="label__name">Скопировать блоки с раздела:</span>
                    <div class="status-select js-blocks">
                        <label class="status-select__select-label" style="display: none">
                            <select name="node" class="status-select__select" tabindex="-1">
                                <option value="0" rel="">---</option>
                                {include file='menu/parent-select.tpl' tree=$data.nodes cur_pid=$item->parent spacer=' - '}
                            </select>
                            <span class="status-select__select-svg">
                                <svg fill="none" width="12" height="8">
                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                                </svg>
                            </span>
                        </label>
                        <div class="status-select__fake" tabindex="0">
                            <span></span>
                            <span class="status-select__select-svg">
                                <svg fill="none" width="12" height="8">
                                    <use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
                <button name="save" value="{$_LNG_ADM.SEND}" class="btn btn--blue btn--lg">
                    <span>Применить</span>
                </button>
            </div>
        </form>
    </div>

    {include file='../../common/page/scheme/'|cat:$node->template->scheme_file areas=$list}
</section>
