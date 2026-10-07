<ul class="top-menu">
	{foreach from=$menu item=item name=menu}
		<li class="top-menu__item {if $item->active}active{/if}">
			<a href="{$adm_path}{$item->link}" class="top-menu__link" title="{$item->title|escape}">
				<svg fill="none" width="16" height="16">
					<use xlink:href="{$adm_path}/assets/img/sprite.svg#{$item->icon}"></use>
				</svg>
				<span class="top-menu__name">{$item->title}</span>

				{if $item->infodata}
					<span class="top-menu__num">
						{$item->infodata}
					</span>
				{/if}
			</a>

			{if $item->childs}
				<ul class="top-menu__subs">
					{foreach from= $item->childs item='child' name='children'}
						<li class="top-menu__sub {if $child->active}active{/if}">
							<a href="{$adm_path}{$child->link}" class="top-menu__sub-link" title="{$child->title|escape}">
								<svg fill="none" width="16" height="16">
									<use xlink:href="{$adm_path}/assets/img/sprite.svg#{$child->icon}"></use>
								</svg>
								<span class="top-menu__name">{$child->title}</span>

							</a>
						</li>
					{/foreach}
				</ul>
			{/if}
		</li>

		{if $smarty.foreach.menu.first}
			<li class="top-menu__item js-content-toggler {if $content}active opened{/if}">
				<div class="top-menu__link" title="Контент">
					<svg fill="none" width="16" height="16">
						<use xlink:href="{$adm_path}/assets/img/sprite.svg#content"></use>
					</svg>
					<span class="top-menu__name">Контент</span>
					<div class="btn top-menu__toggler">
						<svg fill="none" width="12" height="7">
							<use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
						</svg>
					</div>
				</div>
			</li>
		{/if}
	{/foreach}
</ul>