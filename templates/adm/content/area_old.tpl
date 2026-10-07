{*{if $node->id}{include file='menu/node-actions.tpl' node=$node active=area}{/if}*}
{if $state == 'list'}
{*<h3>{$node->title}</h3>
<p class="action-description edit-blocks">{$_LNG_ADM.BLOCKS}</p>
<div class="clear"></div>*}
<div class="content_header">
	<div class="title">
		{$node->title}
	</div>
	{if $node->id}
		<div class="node_actions">
			{include file='menu/node-actions.tpl' node=$node}
		</div>
	{/if}
</div>
{if $node->id}
	<div class="node_menu">
		{include file='menu/node-menu.tpl' node=$node active=area}
	</div>
{/if}
{if !empty($messages) && $messages|@count > 0}
<div class="messages">
	{foreach from=$messages item='message'}
	{$message->html}
	{/foreach}
</div>
{/if}
{include file='../../common/page/scheme/'|cat:$node->template->scheme_file areas=$list}
<div class="fields-panel inline-container">
	<form action="{$adm_path}/area/copy/{$node->id}" method="post" enctype="multipart/form-data">
		<div class="inline-block half-width">
			<label>Скопировать блоки с раздела</label>
			<select id="node-parent" name="node">
				<option value="0" rel="">---</option>
				{include file='menu/parent-select.tpl' tree=$data.nodes cur_pid=$item->parent spacer=' - '}
			</select>
		</div>
		<div class="inline-block half-width">
			<label>&nbsp;</label>
			<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SEND}"/>
		</div>
	</form>
</div>
<a style="display:none;" href="#block_area" id="block-area-trigger"></a>
<div style="display:none;">
	<div id="block_area" style="width: 600px;">
	</div>
</div>
<script>
	$(function() {ldelim}
		$("#block-type, #block-id").change(function() {ldelim}
			$("#block-properties").submit();
		{rdelim});
		$('#block-area-trigger').fancybox({ldelim}
				'padding'		: 0,
				'autoScale'		: false,
				'transitionIn'	: 'none',
				'transitionOut'	: 'none',
				'showTitle'		: false
			{rdelim});
		$("table.blocks td a.area_edit").click(function(e){ldelim}
			$("table.blocks td").removeClass("active");
			$(this).parent().parent().parent().addClass("active");
			var area = $(this).parent().parent().attr('rel');
			var url = "{$adm_path}/ajax/area/edit/{$node->id}/" + area;
			$.get(url,{ldelim}{rdelim},function(data){ldelim}
				$("#block_area").html(data);
				$("#block-area-trigger").trigger('click');
			{rdelim})
			return false;
		{rdelim});

		$("table.blocks td a.area_edit_special").click(function(e){ldelim}
			$("table.blocks td").removeClass("active");
			$(this).parent().parent().parent().addClass("active");
			var area = $(this).parent().parent().attr('rel');
			var url = "{$adm_path}/ajax/node/{$node->id}/area/" + area +"/edit_special";
			$.get(url,{ldelim}{rdelim},function(data){ldelim}
				$("#block_area").html(data);
				$("#block-area-trigger").trigger('click');
			{rdelim})
			return false;
		{rdelim});

		$("table.blocks td a.area_settings").click(function(e){ldelim}
			$("table.blocks td").removeClass("active");
			$(this).parent().parent().parent().addClass("active");
			var area = $(this).parent().parent().attr('rel');
			var url = "{$adm_path}/ajax/area/params/{$node->id}/" + area;
			$.get(url,{ldelim}{rdelim},function(data){ldelim}
				$("#block_area").html(data);
				$("#block-area-trigger").trigger('click');
				$('.multisel2area').multiSelect();
				$('select:not(.hidden, .multisel2area)').dropdown();
			{rdelim})
			return false;
		{rdelim});

		$("table.blocks td a.area_content").click(function(e){ldelim}
			$("table.blocks td").removeClass("active");
			$(this).parent().parent().parent().addClass("active");
			var node = $(this).parent().parent().attr('obj');
			window.location.href = "{$adm_path}/content/list/"+node;
			return false;
		{rdelim});

		$("table.blocks td a.area_lock").click(function(e){ldelim}
			$("table.blocks td").removeClass("active");
			$(this).parent().parent().parent().addClass("active");
			var area = $(this).parent().parent().attr('rel');
			window.location.href = "{$adm_path}/area/lock/{$node->id}/"+area;
			return false;
		{rdelim});

	{rdelim});
</script>

{/if}
