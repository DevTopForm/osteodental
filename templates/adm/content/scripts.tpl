<section class="catalog">
    <h1 class="h1 catalog__h1">Скрипты</h1>
    <div class="table-wrapper catalog__table">
        <table class="catalog-table">
            <thead>
            <tr>
                <th class="catalog-table__th"><span>Наименование</span></th>

                <th class="catalog-table__th "></th>
            </tr>
            </thead>
            <tbody>

            {foreach from=$list item='item' key='key'}
                <tr class="catalog-table__tr undefined">
                    <td class="catalog-table__td">
                        <div class="catalog-item__name">{$key}</div>
                    </td>
                    <td class="catalog-table__td " data-position="right">
                        <div class="jsFixed">
                            <button data-href="{$item}" class="btn btn--blue btn--lg left-auto js-script-run">
                                <span>Запустить</span>
                            </button>
                        </div>
                    </td>
                </tr>
            {/foreach}

            </tbody>
        </table>
    </div>
    <div id="script_result" style="display: none"></div>
</section>

<script>
    {literal}
    // $(function() {
    //     $(".js_script_run").on('click', function() {
    //         var script = $(this).data('href');
    //         $('#script_result').html('<iframe src="'+script+'"></iframe>');
    //         $('#script_result').show();
    //         $('#script_result').click(function(){
    //             $('#script_result').hide();
    //         });
    //     });
    // });

    const scripts = document.querySelectorAll('.js-script-run')
    const result = document.getElementById('script_result')

    if(scripts.length){
        scripts.forEach((element) => {
            element.addEventListener('click', (event) => {
                let iframe = document.createElement('iframe')
                iframe.src = element.dataset.href
                iframe.style.width = "100%"
                result.innerHTML = ""
                result.append(iframe)
                result.style.display = 'block'
            })
        })
    }

    if(result){
        result.addEventListener('click', (event) => {
            result.style.display = 'none'
        })
    }
    {/literal}
</script>