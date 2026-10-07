<div class="section">
	<div class="node-actions">
		<ul class="tabs">
			<li class="first {if $active == 'content'}active{/if}"><a href="{$adm_path}/content/list/{$node->id}">{$_LNG_ADM.CONTENT}</a></li>
			<li {if $active == 'inner'}class="active"{/if}><a href="{$adm_path}/inner/edit/{$node->id}">{$_LNG_ADM.INNER_TEXT}</a></li>
			<li {if $active == 'area'}class="active"{/if}><a href="{$adm_path}/area/list/{$node->id}">{$_LNG_ADM.BLOCKS}</a></li>
			<li {if $active == 'node'}class="active"{/if}><a href="{$adm_path}/node/edit/{$node->id}">{$_LNG_ADM.PROPERTIES}</a></li>
			<li class="last {if $active == 'params'}active{/if}"><a href="{$adm_path}/params/edit/{$node->id}">{$_LNG_ADM.BLOCK_PARAMS}</a></li>
		</ul>
		<ul>
			<li><a href="{$node->getUrl()}" class="icon web" target="_blank">Открыть на сайте</a></li>
			<li><a class="icon add" href="{$adm_path}/node/add/{$node->id}">{$_LNG_ADM.CREATE_NEW_SUBNODE}</a></li>
			{if !$node->blocked || $user->hasAccess('lock')}
			<li><a class="icon remove" href="{$adm_path}/node/delete/{$node->id}">{$_LNG_ADM.REMOVE_NODE}</a></li>
			{/if}
			{if $user->hasAccess('lock')}
			<li><a class="icon {if !$node->blocked}lock{else}unlock{/if}" href="{$adm_path}/node/lock/{$node->id}">{if !$node->blocked}За{else}Раз{/if}блокировать</a></li>
			{/if}
		</ul>
	</div>
	<script>
		$(function() {ldelim}
			$("a.remove").click(function() {ldelim}
				return confirm("{$_LNG_ADM.NODE_REMOVE_CONFIRM} «{$node->title|escape}»?");
			{rdelim});
		{rdelim});
	</script>
</div>