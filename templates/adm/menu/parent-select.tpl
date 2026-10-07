{if !$space}{assign var='space' value=$spacer}{/if}
{foreach from=$tree item='node'}
<option value="{$node.id}"{if $node.id == $cur_nid || $disabled} disabled="true"{/if}{if $node.id == $cur_pid} selected="true"{/if} rel="{$node.url}">{$space}{$node.title}</option>
{if $node.childs}
{if $node.id == $cur_nid || $disabled}{assign var='dis' value=true}{/if}
{include file='menu/parent-select.tpl' tree=$node.childs space=$space|cat:$spacer cur_nid=$cur_nid cur_pid=$cur_pid disabled=$dis}
{assign var='dis' value=false}
{/if}
{/foreach}
