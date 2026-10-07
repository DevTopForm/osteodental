{if $state=="init"}
	<a style="display:none;" href="#ajax_crop" id="ajax-crop-trigger"></a>
	<div style="display:none;">
		<div id="ajax_crop" style="width: auto;">
		</div>
	</div>
	<script>
		$(function() {ldelim}
			$('#ajax-crop-trigger').fancybox({ldelim}
				'padding'		: 0,
				'autoScale'		: false,
				'transitionIn'	: 'none',
				'transitionOut'	: 'none',
				'showTitle'		: false
				{rdelim});
			$("body").on('click', 'img.crop', function(e){ldelim}
				$("img.crop").removeClass("curcrop").filter(this).addClass("curcrop");
				var image = $(this).attr('rel');
				var url = "/adm/ajax/image/crop/"+image;
				$.get(url,{ldelim}{rdelim},function(data){ldelim}
					if(data){ldelim}
						$("#ajax_crop").html(data);
						$("#ajax-crop-trigger").trigger('click');
						{rdelim}
					{rdelim})
				return false;
				{rdelim});
			{rdelim});
	</script>
{elseif $state=='crop'}
	<form id="item-edit-crop" action="/adm/ajax/image/save/{$image->id}" method="post" enctype="multipart/form-data">
		<div id="tabs">
			<ul>
				{foreach from=$size key='name' item='item' name="tabsTitle"}
					<li><a href="#tabs-{$smarty.foreach.tabsTitle.iteration}" name="{$name}">{if $item.title}{$item.title}{else}{$name}{/if}</a></li>
				{/foreach}
			</ul>
			{foreach from=$size item='item' key='type' name='tabsContent'}
				<div id="tabs-{$smarty.foreach.tabsContent.iteration}">
					<div class="crop-image">
						<img src="{$image->getLink('default')}?{$smarty.now}" id="{$type}_crop-target" style="max-width: 547px; height: auto; border: 2px solid #ccc;">
					</div>
				</div>
			{/foreach}
			<div style="float: left; margin: 0 0 10px 22px;">
				{foreach from=$size key='type' item='item'}
					<input type="hidden" id="{$type}_x1" name="crop[{$type}][x1]" value="{$item.x1}"/>
					<input type="hidden" id="{$type}_y1" name="crop[{$type}][y1]" value="{$item.y1}"/>
					<input type="hidden" id="{$type}_x2" name="crop[{$type}][x2]" value="{$item.x2}"/>
					<input type="hidden" id="{$type}_y2" name="crop[{$type}][y2]" value="{$item.y2}"/>
					<input type="hidden" id="{$type}_bx" name="crop[{$type}][bx]" value=""/>
					<input type="hidden" id="{$type}_by" name="crop[{$type}][by]" value=""/>
					<input type="hidden" id="{$type}_w"  name="crop[{$type}][w]" value="{$item.width}"/>
					<input type="hidden" id="{$type}_h"  name="crop[{$type}][h]" value="{$item.height}"/>
				{/foreach}

				<label>Заголовок изображения</label>
				<input type="text" name="title" value="{$image->title}"/><br/><br/>
				<label>Альтернативное название</label>
				<input type="text" name="alt" value="{$image->alt}"/><br/><br/>
				<input type="button" id="crop-but" value="Готово">
			</div>
			<div class="clear"></div>
		</div>

	</form>

	<script type="text/javascript">
		jQuery(function($){ldelim}
			{foreach from=$size key='type' name='sizeForeach' item='item'}
			{if $smarty.foreach.sizeForeach.first}
			init_Jcrop_script('{$type}');
			{/if}
			{/foreach}
			$("#tabs").tabs({ldelim}
				activate: function(event, ui){ldelim}
					jcrop_api.destroy();
					init_Jcrop_script(ui.newTab.find('a').attr('name'));
					{rdelim}
				{rdelim});
			$('#tabs img').on('load', function() {ldelim}
				$.fancybox.getInstance().update();
				{rdelim});
			$('#crop-but').click(function(){ldelim}
				$.post($('#item-edit-crop').attr('action'), $('#item-edit-crop').serializeArray(), function(data){ldelim}
					var err = data.split("Error: ");
					if (err.lenght > 1)	{ldelim}
						alert(data);
						{rdelim}
					if ($("img.crop.curcrop").length > 0){ldelim}
						var src = $("img.crop.curcrop").attr('src').split('?');
						$("img.crop.curcrop").attr('src',src[0]+'?'+Math.random().toString().substr(2));
						{rdelim}
					{rdelim});
				$.fancybox.close();
				{rdelim});
			{rdelim});
		var jcrop_api;
		function init_Jcrop_script(type){ldelim}
			// Create variables (in this scope) to hold the API and image size
			var w=$('#'+type+'_w').val();
			var h=$('#'+type+'_h').val();
			var boundx, boundy, real_width, real_height;

			$('#tabs img').on('load', function(){ldelim}
				$.fancybox.getInstance().update();
				{rdelim});

			$('#'+type+'_crop-target').Jcrop({ldelim}
				aspectRatio: (w > 0 && h > 0) ? w/h : 0,
				onChange: updatePreview,
				onSelect: updatePreview
				{rdelim}, function(){ldelim}
				// Use the API to get the real image size
				var bounds = this.getBounds();
				boundx = bounds[0];
				boundy = bounds[1];
				$('#'+type+'_bx').val(boundx);
				$('#'+type+'_by').val(boundy);
				//Если сторона не задана
				if(w==0) w= boundx;
				if(h==0) h= boundy;
				// Store the API in the jcrop_api variable
				jcrop_api = this;
				$("<img/>").attr("src", $('#'+type+'_crop-target').attr("src")).on('load',function() {ldelim}
					real_width = this.width;
					real_height = this.height;
					var x1 = Math.round($('#'+type+'_x1').val() / real_width * boundx);
					var y1 = Math.round($('#'+type+'_y1').val() / real_height * boundy);
					var x2 = Math.round($('#'+type+'_x2').val() / real_width * boundx);
					var y2 = Math.round($('#'+type+'_y2').val() / real_height * boundy);
					if (x2 > 0 && y2 > 0){ldelim}
						jcrop_api.animateTo([x1,y1,x2,y2]);
						{rdelim} else {ldelim}
						jcrop_api.animateTo([0,0,real_width,real_height]);
						{rdelim}
					{rdelim});
				{rdelim});


			function updatePreview(c) {ldelim}
				$('#'+type+'_x1').val(c.x / boundx * real_width);
				$('#'+type+'_y1').val(c.y / boundy * real_height);
				$('#'+type+'_x2').val(c.x2 / boundx * real_width);
				$('#'+type+'_y2').val(c.y2 / boundy * real_height);
				{rdelim};
			{rdelim};
	</script>
{/if}