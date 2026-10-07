{if !$space}{assign var='space' value=$spacer}{/if}
{foreach from=$tree item='node'}
<option value="{$node.id}" {if $node.id == $cur} selected="true"{/if}>{$space}{$node.title}</option>
{if $node.childs}
	{include file='filters/tree.tpl' tree=$node.childs space=$space|cat:$spacer cur=$cur}
{/if}
{/foreach}