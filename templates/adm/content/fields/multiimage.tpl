<div class="label form__input-full {if $field->errorsMessage}mistake{/if}">
	<label class="label__content">
		<span class="label__name">{$field->title}{if $field->required}*{/if}</span>
	</label>
	{assign var=sort value=''}

	<div class="label__wrapper-imgs">
		<div class="label__wrapper-btns">
			<label class="btn btn--lg btn--blue label__file-wrapper">
				{$field->getHtml()}
				<svg fill="none" width="16" height="16">
					<use xlink:href="{$adm_path}/assets/img/sprite.svg#"></use>
				</svg>
				<span>Загрузить с компьютера</span>
				<div class="label__file-uploader uploader"><div class="uploader-inside"></div></div>
				{if $field->errorsMessage}
					<span class="label__mistake">{$field->errorsMessage}</span>
				{/if}
			</label>
		</div>
		<div class="label__imgs imgs imgs--sortable">
			{if $field->getSpecValue()|@count > 0}
				{foreach from=$field->getSpecValue() item='mValue'}
					{if $sort != ''}
						{assign var=sort value=$sort|cat:';'|cat:$mValue->id}
					{else}
						{assign var=sort value=$mValue->id}
					{/if}

					<div class="img" data-rel="{$mValue->id}">
						<div class="js-handle img__handle">
							<svg fill="none" width="7" height="13">
								<use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
							</svg>
						</div>
						<div class="img__inside">
								<img class="img__img" src="{$mValue->getLink('admin')}" alt="" width="50" height="50">
						</div>
						<div class="img__name">{$mValue->title}</div>
						<div class="btn img__close">
							<svg fill="none" width="16" height="16">
								<use xlink:href="{$adm_path}/assets/img/sprite.svg#clear"></use>
							</svg>
						</div>
						<label class="img__label">
							<input type="checkbox" name="clear_{$field->name}[{$mValue->id}]">
							<span>Удалить</span>
						</label>
					</div>
				{/foreach}

				<input class="js-sort-imgs" id="sorting_multiimage_{$field->name}" type="hidden" name="sorting_{$field->name}" value="{$sort}">
			{/if}
		</div>
	</div>
</div>
