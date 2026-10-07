{*{if $area->data->object}*}
{*	{assign var=obj value=$area->data->object}	*}
{*{else}*}
{*	{assign var=obj value=''}	*}
{*{/if}*}
{*<div class="scheme-area{if $area->active} active{/if}" rel="{$area->id}" obj="{if $obj}{$obj->id}{else}0{/if}">*}
{*	<strong>{$area->title}</strong> ({$area->alias}) &mdash; {if $obj}<span class="assigned">{$obj->title}</span> ({$obj->type->type}){else}<span class="notassigned">{$_LNG_ADM.NOT_ASSIGNED}</span>{/if}<br/>*}
{*	<div class="actions">*}
{*		{if $user->hasAccess('lock')}*}
{*		<a href="#" class="area_lock{if !$area->blocked} unlock{/if}" title="Блокировать"></a>*}
{*		{/if}*}
{*		{if !$area->blocked || $user->hasAccess('lock')}*}
{*			<a href="#" class="area_edit" title="Редактировать привязку"></a>*}
{*			{if $obj}*}
{*				<a href="#" class="area_settings" title="Редактировать параметры блока"></a>*}
{*				{if $obj->hasContent()}<a href="#" class="area_content" title="Редактировать содержимое"></a>{/if}*}
{*			{/if}*}
{*		{/if}*}
{*	</div>*}
{*	<div class="clear"></div>*}
{*</div>*}

<div class="blocks-item blocks__item {if $area->blocked}blocks-item--locked{/if}">
	<div class="blocks-item__row">
		<span class="blocks-item__name">{$area->title|default:"Блока не существует"}</span>
		{if $area}
			<span class="blocks-item__place">({$area->alias})</span>
			-
			{if $area->data->object}
				<span class="blocks-item__name-colored">{$area->data->object->title}</span>
				<span class="blocks-item__place">({$area->data->object->type->type})</span>
			{else}
				Раздел не назначен
			{/if}
		{/if}
	</div>
	{if $area}
		<div class="blocks-item__btns">
			{if $user->hasAccess('lock')}
				<a href="{$adm_path}/area/lock/{$node->id}/{$area->id}" class="btn  blocks-item__lock" aria-label="элемент заблокирован" data-tooltip="заблокировать содержимое">
					<svg fill="none" width="16" height="16">
						<use xlink:href="{$adm_path}/assets/img/sprite.svg#lock"></use>
					</svg>
				</a>
			{/if}

			<button class="btn  blocks-item__settings2" aria-label="Настройки элемента" data-tooltip="Настройки" data-block-action="edit" data-area="{$area->id}" data-list="{$node->id}">
				<svg fill="none" width="16" height="16">
					<use xlink:href="{$adm_path}/assets/img/sprite.svg#settings2"></use>
				</svg>
			</button>

			{if $area->data->object && $area->data->object->type->has_content}
				<a href="{$adm_path}/content/list/{$area->data->object->id}" class="btn  blocks-item__pencil" data-tooltip="Редактировать содержимое">
					<svg fill="none" width="16" height="16">
						<use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
					</svg>
				</a>
			{/if}

			<button class="btn  blocks-item__params" aria-label="Редактировать параметры блока" data-tooltip="Редактировать параметры блока" data-block-action="params" data-area="{$area->id}" data-list="{$node->id}">
				<svg fill="none" width="16" height="16">
					<use xlink:href="{$adm_path}/assets/img/sprite.svg#params"></use>
				</svg>
			</button>
		</div>
	{/if}
</div>
