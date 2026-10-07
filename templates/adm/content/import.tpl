{if $state === "edit"}
    <section class="catalog">
        <h1 class="h1 catalog__h1">Импорт</h1>
        <div class="xls_import_new">
            <form action="" method="GET" enctype="multipart/form-data" class="js-import-form form">
                <div class="form__fieldset-wrap">
                    <label class="label form__input-full">
                        <div class="label__content">
                            <span class="label__name">Модуль</span>
                        </div>

                        {if $tables|@count>0}
                            <span class="label__wrapper label__wrapper--select">
                                <select name="table" class="js-onchange label__select">
                                    <option value="0">-- Выберите модуль</option>
                                    {foreach from=$tables item='table'}
                                        <option value="{$table->id}" {if $smarty.get.table == $table->id}selected{/if}>
                                            {$table->title}
                                        </option>
                                    {/foreach}
                                </select>
                            </span>
                        {/if}
                    </label>

                    {if $nodes|@count>0}
                        <label class="label form__input-full">
                            <div class="label__content">
                                <span class="label__name">Раздел</span>
                            </div>
                            <span class="label__wrapper label__wrapper--select">
                                <select name="node_id" class="label__select">
                                    <option value="0">-- Выберите раздел</option>
{*                                        <option value="{$node->id}" {if $smarty.get.node_id == $node->id}selected{/if}>*}
                                    {*                                            {$node->title}*}
                                    {*                                        </option>*}
                                    {include file='content/import-tree.tpl' menu=$nodes first=0 type=$type}
                                </select>
                            </span>
                        </label>
                    {/if}

                    {if $columns|@count && $fields|@count}
                        <div class="fields-matching {if $props|@count}fields-matching--4{/if}">
                            {foreach from=$columns key="key" item="title"}
                                <div class="match-row__title">
                                    {$title}
                                </div>
                                {if $props|@count}
                                    <div class="fields-matching__props">
                                        <label for="" class="label label--import">
                                            <span class="label__name">Свойство:</span>
                                            <div class="label__wrapper label__wrapper--select">
                                                <select name="props[{$key}]" class="js-prop label__select">
                                                    <option value="0">-- Новое свойство</option>
                                                    {foreach from=$props item='prop'}
                                                        <option value="{$prop->id}"
                                                                {if $smarty.get.props.$key == $prop->id || $matches.props.$key == $prop->id}selected{/if}>
                                                            {$prop->title}
                                                        </option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </label>

                                        <label for="" class="match-row__select label label--import"
                                               {if !empty($smarty.get.props.$key)}style="display: none"{/if}>
                                            <span class="label__name">Тип свойства</span>
                                            <div class="label__wrapper label__wrapper--select">
                                                <select name="types[{$key}]" class="label__select js-field-types">
                                                    {foreach from=$fieldTypes key="fieldKey" item='title'}
                                                        <option value="{$fieldKey}"
                                                                {if $smarty.get.types.$key == $fieldKey}selected{/if}>
                                                            {$title}
                                                        </option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </label>

                                        <label class="match-row__select label label--import" data-key="{$key}"
                                               {if empty($smarty.get.types.$key) || !in_array($smarty.get.types.$key, ["select", "multiselect", "multisel2area"])}style="display: none"{/if}>
                                            <span class="label__name">Таблица</span>
                                            <div class="label__wrapper label__wrapper--select">
                                                <select name="tables[{$key}]" class="label__select js-field-types-tables">
                                                    <option value="0">-- Выберите таблицу</option>
                                                    {foreach from=$tables item='table'}
                                                        <option value="{$table->id}"
                                                                {if $smarty.get.tables.$key == $table->id}selected{/if}>
                                                            {$table->title}
                                                        </option>
                                                    {/foreach}
                                                </select>
                                            </div>
                                        </label>
                                    </div>
                                {/if}
                                <label for="" class="match-row__select label">
                                    <div class="label__wrapper label__wrapper--select">
                                        <select name="fields[{$key}]" class="label__select">
                                            <option value="0">-- Выберите поле</option>
                                            {foreach from=$fields item='field'}
                                                <option value="{$field->id}"
                                                        {if $smarty.get.fields.$key == $field->id || $matches.fields.$key == $field->id}selected{/if}>
                                                    {$field->title}
                                                </option>
                                            {/foreach}
                                        </select>
                                    </div>
                                </label>
                                <div class="match-row__checkboxes">
                                    <label class="check ">
                                        <input type="checkbox" id="section_keys[{$key}]" name="section_keys[{$key}]"
                                               value="1" class="check__input"
                                               {if $smarty.get.section_keys.$key}checked{/if}/>
                                        <span class="check__name">Является названием раздела</span>
                                    </label>
                                    <label class="check ">
                                        <input type="checkbox" id="item_keys[{$key}]" name="item_keys[{$key}]"
                                               value="1" class="check__input"
                                               {if $smarty.get.item_keys.$key}checked{/if}/>
                                        <span class="check__name">Является ключом элемента</span>
                                    </label>
                                </div>
                            {/foreach}
                        </div>
                    {/if}

                    {if $smarty.get.table}
                        <div class="label form__input-full">
                            <label class="label__content"></label>

                            <div class="label__wrapper-imgs">
                                <div class="label__wrapper-btns">
                                    <label class="btn btn--lg btn--blue label__file-wrapper">
                                        <input type="file" name="file">
                                        <svg fill="none" width="16" height="16">
                                            <use href="{$adm_path}/assets/img/sprite.svg#"></use>
                                        </svg>
                                        <span>Загрузить с компьютера</span>
                                        <div class="label__file-uploader uploader">
                                            <div class="uploader-inside"></div>
                                        </div>
                                    </label>
                                </div>

                                <div class="label__imgs imgs"></div>
                            </div>
                        </div>
                        <div class="label form__input-full">
                            <div>
                            </div>
                            <div>
                                <input type="submit" value="Импортировать" name="send" class="btn btn--blue btn--lg"
                                       onclick="this.closest('form').setAttribute('method', 'POST')">
                            </div>
                        </div>
                    {else}
                        <div class="label form__input-full">
                            <div>
                            </div>
                            <div>
                                <input type="submit" value="Далее" name="next" class="btn btn--blue btn--lg">
                            </div>
                        </div>
                    {/if}
                </div>
            </form>
        </div>
        <div style="display:none" id="processlog" class="xls_import_new xls_width_50 margin_20"></div>
        <div class="xls_import_new xls_width_50 margin_20 js-errors-block"
             {if !$messages.error}style="display: none"{/if}>
            {if $messages.error}
                {foreach from=$messages.error item=err}
                    <p class="action-description error">{$err}</p>
                {/foreach}
            {/if}
        </div>

        {if $columns|@count && $fields|@count}
        {literal}
            <script>
                const form = document.querySelector(".js-import-form");
                const errorBlock = document.querySelector(".js-errors-block");

                if (form) {
                    form.addEventListener("submit", async function (e) {
                            e.preventDefault();

                            errorBlock.setAttribute("style", "display: none;")

                            const formData = new FormData(form);
                            formData.append("step", "import");

                            const response = await fetch("/adm/import", {
                                method: "POST", // *GET, POST, PUT, DELETE, etc.
                                body: formData, // body data type must match "Content-Type" header
                            });
                            const res = await response.json();

                            let timerId = setInterval(async function () {
                                const response = await fetch("/upload/import_process.txt", {
                                    method: "GET", // *GET, POST, PUT, DELETE, etc.
                                });
                                document.querySelector("#processlog").innerHTML = await response.text();
                                document.querySelector("#processlog").style.display = "block";
                            }, 500);

                            if (res && res.error.length) {
                                clearInterval(timerId);
                                document.querySelector("#processlog").style.display = "none";

                                errorBlock.innerHTML = "";
                                res.error.forEach((err) => {
                                    const str = document.createElement("p");
                                    str.setAttribute("class", "action-description error");
                                    str.innerHTML = err;
                                    errorBlock.appendChild(str);
                                })
                                errorBlock.setAttribute("style", "display: block;")
                            }
                        }
                    )
                }
            </script>
        {/literal}
        {/if}
    </section>
{literal}
    <script>
        let selects = document.querySelectorAll(".js-onchange");
        if (selects && selects.length) {
            selects.forEach((select) => {
                select.addEventListener("change", function (e) {
                    e.target.closest("form").submit();
                })
            })
        }

        let propsSelect = document.querySelectorAll(".js-prop");
        if (propsSelect && propsSelect.length) {
            propsSelect.forEach((select) => {
                select.addEventListener("change", function (e) {
                    let allSiblings = [...e.target.parentElement.parentElement.parentElement.children].filter(child => child !== e.target.parentElement.parentElement);
                    let selector = e.target.parentElement.parentElement.nextElementSibling;
                    if (e.target.value > 0) {
                        allSiblings.forEach((el) => {
                            el.setAttribute("style", "display: none;")
                        })
                    } else {
                        selector.setAttribute("style", "display: grid;")
                        selector.querySelector("select").value = "text";
                    }
                })
            })
        }

        let fieldTypesSelects = document.querySelectorAll(".js-field-types");
        if (fieldTypesSelects && fieldTypesSelects.length) {
            fieldTypesSelects.forEach((select) => {
                select.addEventListener("change", function (e) {
                    let selector = e.target.parentElement.parentElement.nextElementSibling;
                    if (["select", "multiselect", "multisel2area"].includes(e.target.value)) {
                        selector.setAttribute("style", "display: grid;")
                    } else {
                        selector.setAttribute("style", "display: none;")
                        if (selector.nextElementSibling) {
                            selector.nextElementSibling.setAttribute("style", "display: none;")
                        }
                    }
                })
            })
        }

        let fieldTypesTablesSelects = document.querySelectorAll(".js-field-types-tables");
        if (fieldTypesTablesSelects && fieldTypesTablesSelects.length) {
            fieldTypesTablesSelects.forEach((select) => {
                select.addEventListener("change", async function (e) {
                    let selector = e.target.parentElement.parentElement.nextElementSibling;

                    let response = await fetch(`/adm/ajax/node/getbymodule?type=${e.target.value}`);
                    let nodes = await response.json();

                    if (nodes && nodes.length) {
                        const select = document.createElement("select");
                        select.setAttribute("name", `nodes[${e.target.parentElement.parentElement.dataset.key}]`)
                        select.setAttribute("class", "label__select")
                        nodes.forEach(function (value) {
                            select.appendChild(new Option(value.title, value.id));
                        })

                        if (!selector) {
                            const label = document.createElement("label");
                            const div = document.createElement("div");
                            const span = document.createElement("span");
                            span.setAttribute("class", "label__name");
                            span.innerHTML = "Раздел ";
                            div.setAttribute("class", "label__wrapper label__wrapper--select");
                            label.setAttribute("class", "match-row__select label label--import");

                            label.appendChild(span);
                            div.appendChild(select);
                            label.appendChild(div);
                            e.target.parentElement.parentElement.parentElement.appendChild(label);
                        } else {
                            selector.setAttribute("style", "display: grid;")
                            selector.querySelector("select").replaceWith(select);
                        }
                    }
                })
            })
        }
    </script>
{/literal}
{/if}
