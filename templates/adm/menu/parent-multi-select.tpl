{if !$space}{assign var='space' value=$spacer}{/if}
{foreach from=$tree item='node'}
<option value="{$node.id}"{if $node.id|in_array:$cur_pid} selected="true"{/if}>{$space}{$node.title}</option>
{if $node.childs}
{include file='menu/parent-multi-select.tpl' tree=$node.childs space=$space|cat:$spacer cur_pid=$cur_pid}
{/if}
{/foreach}
