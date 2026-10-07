{if $content}
    <section class="mb-60" id="results">
        <h2 class="h2 mb-20-30 anim" data-anim-type="transform" data-anim-start="translateY(150px)"
            data-anim-end="translateY(0)" data-anim-duration="0.3s"
            data-anim-delay="0.2s">{$title ?: "Случаи из практики"}</h2>
        <div class="results-block {$class}">
            {foreach $content as $item name="results"}
                {$setDisplayNone = ($smarty.foreach.results.iteration > 3)}
                {include file="page/includes/result.tpl" content=$item hidden=$setDisplayNone}
            {/foreach}
        </div>

        {if count($content) > 3}
            <div class="more-block">
                <button class="btn btn--rounded2 btn--blue more-block__btn">Показать еще</button>
            </div>
        {/if}
    </section>
    <script>
        {literal}
        (function () {
            const btnEl = document.querySelector("#results .more-block__btn");
            btnEl && document.addEventListener("click", function () {
                btnEl.remove();
                document.querySelectorAll(".result-it").forEach((el) => {
                   el.classList.remove("hidden");
                });
            });
        })();
        {/literal}
    </script>
{/if}