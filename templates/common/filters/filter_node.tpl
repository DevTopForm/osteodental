<label class="label ">
	<div class="label__content">
		<span class="label__name">{$title}:</span>
	</div>

	<span class="label__wrapper label__wrapper--select">
      <select class="label__select" name="{$name}">
        {include file='filters/tree.tpl' tree=$filters spacer="-" cur=$active}
      </select>
    </span>
</label>