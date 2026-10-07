<div class="field">
	<label>{$field->title}{if $field->required}*{/if}
	</label>

	{assign var='value' value=$field->getValue()|unserialize}

	{if $value.service}
		{assign var='attach' value=$field->getSpecValue()}
		<div class="video_block" style="display:block;">
			<iframe id="{$field->name}_video" width="480" height="297" src="{if $value.service=='youtube'}http://www.youtube.com/embed/{else}http://player.vimeo.com/video/{/if}{$value.code}" frameborder="0" allowfullscreen></iframe>
			{if $value.img}
				<div class="video_block_img crop curcrop" rel="{$attach->id}" id="{$field->name}_img" style="cursor:pointer; background:url({$attach->getLink("thumb")}) no-repeat left center"></div>
			{/if}
			<div class="video_control_block">
				<label>Загрузить превью:</label>
				<p><input type="file" name="{$field->name}[image]" value="141" class="file" /></p>
			</div>
		</div>
	{else}
		<input class="videolink" field="{$field->name}" type="text" value="">
		<div class="video_block">
			<iframe id="{$field->name}_video" width="480" height="297" src="" frameborder="0" allowfullscreen></iframe>
			<div class="video_block_img" id="{$field->name}_img"></div>
			<div class="video_control_block" style="display:block;">
				<label><input type="checkbox" name="{$field->name}[prevyuVideo]" value="1" checked="checked" />Использовать превью видео</label>
				<label>Загрузить свою:</label>
				<p><input type="file" name="{$field->name}[image]" value="141" class="file" /></p>
			</div>
		</div>
		<input id="{$field->name}_service" type="hidden" name="{$field->name}[service]" value="" />
		<input id="{$field->name}_code" type="hidden" name="{$field->name}[code]" value="" />
		<input id="{$field->name}_image" type="hidden" name="{$field->name}[img]" value="" />
		{literal}<script type="text/javascript">
		$(document).ready(function() {
			$('.videolink').change(function(){
				$('#'+$(this).attr('id')+'_img').parent().hide();
				var id =$(this).attr('field');
				var value=getVideoInfo($(this).val(),id);
				if(value.service){
					$('#'+id+'_service').val(value.service);
					$('#'+id+'_code').val(value.code);
					var video_player=(value.service=='youtube') ? 'http://www.youtube.com/embed/' : 'http://player.vimeo.com/video/'
					$('#'+id+'_video').attr('src',video_player+value.code);
					$('.messages').remove();
				}else{
					if(!$('.messages').length){
						$('#item-edit').before('<div class="messages"><p class="error">Данный тип ссылок не поддерживается</p></div>');
					}
				}
			});
			function getVideoInfo(url,id){
				var result={};
				//youtube
				var matches = url.match(/[http|https]+:\/\/(?:www\.|)youtube\.com\/watch\?(?:.*)?v=([a-zA-Z0-9_\-]+)/);
				if(!matches) matches = url.match(/[http|https]+:\/\/(?:www\.|)youtube\.com\/embed\/([a-zA-Z0-9_\-]+)/);
				if(!matches) matches = url.match(/[http|https]+:\/\/(?:www\.|)youtu\.be\/([a-zA-Z0-9_\-]+)/);
				if(matches){
					result['code']=matches[1];
					result['service']='youtube';
					var title = '';
					$.ajax({
						url: 'https://gdata.youtube.com/feeds/api/videos/'+matches[1]+'?alt=json&v=2',
						type: 'GET',
						crossDomain:true,
						dataType:'json',
						success: function(data) {
							setVideoThumb('http://img.youtube.com/vi/'+result['code']+'/0.jpg',id,data['entry']['title']['$t']);
						}
					});
				}

				// Vimeo
				var matches = url.match(/[http|https]+:\/\/(?:www\.|)vimeo\.com\/([a-zA-Z0-9_\-]+)(&.+)?/);
				if(!matches) matches = url.match(/[http|https]+:\/\/player\.vimeo\.com\/video\/([a-zA-Z0-9_\-]+)(&.+)?/);
				if(matches){
					result['code']=matches[1];
					result['service']='vimeo';
					$.ajax({
						url: 'http://vimeo.com/api/v2/video/'+matches[1]+'.json',
						type: 'GET',
						crossDomain:true,
						dataType:'jsonp',
						success: function(data) {
							setVideoThumb(((data[0].thumbnail_large) ? data[0].thumbnail_large : data[0].thumbnail_medium),id,data[0].title);
						}
					});
				}
				return result;
			}
			var oldtitle = '';
			function setVideoThumb(src,id,title){
				if(src.length>5) {
					if ($('#title').attr('value') == '' || $('#title').attr('value') == oldtitle) {
						oldtitle = title;
						$('#title').attr('value',title);
					}
					$('#'+id+'_img').css('background','url("'+src+'") no-repeat center center');
					$('#'+id+'_image').val(src);
					$('#uniform-'+id+'_thumbAdd').removeAttr( 'style' );
					$('#'+id+'_img').parent().show();
				}
			}
		});
		</script>{/literal}
	{/if}
</div>
