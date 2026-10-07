{if $state=='add' || $state == 'edit'}
<form action="/cabinet/link/{if $state=='add'}add/{$category->id}{elseif $state=='edit'}edit/{$item->id}{/if}" method="post" enctype="multipart/form-data" class="form-pop-categoty">
	<div class="errors-container">
	{if !empty($errors) && $errors|@count > 0}
		<div class="messages">
			{foreach from=$errors item='message'}
				{$message->html}
			{/foreach}
		</div>
	{/if}
	</div>
	<label>Адрес ссылки <span class="example">(скопируйте его сюда из адресной строки браузера)</span></label>
	<input class="inp-text" type="text" value="{$item->url}" name="url"/>
	<p class="form-delim"></p>
	<label>Название ссылки:</label>
	<input class="inp-text" type="text" value="{$item->title}" name="title"/>
	<label>Комментарий:</label>
	<textarea class="inp-text" name="comment"/>{$item->comment}</textarea>
	<input type="hidden" value="1" name="save"/>
	<a class="save-btn button" href="#">Сохранить</a>
</form>
{elseif $state=='delete'}
<form action="/cabinet/link/delete/{$item->id}" method="post" enctype="multipart/form-data" class="form-pop-categoty">
	<label>Вы уверены, что хотите удалить ссылку?</label>
	<input type="hidden" value="1" name="save"/>
	<a class="save-btn button" href="#">Да</a> <a class="fbx-close button" href="#" style="float: right;">Отмена</a>
	<div class="clear"></div>
</form>
{/if}