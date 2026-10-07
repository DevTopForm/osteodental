{foreach from=$tree item='item'}
    {if $user->role == 'sadmin' || !$item.sadmin}
        <li class="menu__item {if $node->id == $item.id}active{/if} {if $item.expanded}opened{/if}"
            data-position="{$item.id}" {if $item.childs}draggable="false"{/if}>
			<span class="menu__span">
				<span class="js-handle" tabindex="0">
                    <svg fill="none" width="7" height="13">
                        <use xlink:href="{$adm_path}/assets/img/sprite.svg#dots2"></use>
                    </svg>
                </span>
				<a href="/adm/content/list/{$item.id}" class="menu__link" title="{$item.title|escape}">
					<span class="menu__name">{$item.title}</span>
				</a>

				{if $item.childs}
                    <button class="btn menu__toggler js-menu-toggler">
					  <svg fill="none" width="12" height="7">
						<use xlink:href="{$adm_path}/assets/img/sprite.svg#chevron"></use>
					  </svg>
					</button>
                {/if}
			</span>

            {if $item.childs}
                <ul class="menu__subs">
                    {include file='menu/structure.tpl' tree=$item.childs}
                </ul>
            {/if}
        </li>
    {/if}
{/foreach}
