<div class="blocks-item blocks__item">
	<div class="blocks-item__row">
		<span class="blocks-item__name">Основной контент</span>
	</div>

	{if $node->type->has_content}
		<div class="blocks-item__btns">
			<a href="{$adm_path}/content/list/{$node->id}" class="btn  blocks-item__pencil" data-tooltip="Редактировать содержимое">
				<svg fill="none" width="16" height="16">
					<use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
				</svg>
			</a>
		</div>
	{/if}
</div>