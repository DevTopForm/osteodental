{if !$space}{assign var='space' value=$spacer}{/if}
{foreach from=$tree item=item}
	{if $item->menu}
		<option value="{$item->id}"{if $item->id == $cur_nid || $disabled} disabled="true"{/if}{if $item->id == $cur_pid} selected="true"{/if}>{$space}{$item->title}</option>
		{if $item->childs|@count>0}
		{if $item->id == $cur_nid || $disabled}{assign var='dis' value=true}{/if}
		{include file='menu/tree-select.tpl' tree=$item->childs space=$space|cat:$spacer cur_nid=$cur_nid cur_pid=$cur_pid disabled=$dis}
		{assign var='dis' value=false}
		{/if}
	{/if}
{/foreach}
