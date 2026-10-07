{if $state=='add' || $state == 'edit'}
<form action="/cabinet/category/{if $state=='add'}add{elseif $state=='edit'}edit/{$item->id}{/if}" method="post" enctype="multipart/form-data" class="form-pop-categoty">
	<div class="errors-container">
	{if !empty($errors) && $errors|@count > 0}
		<div class="messages">
			{foreach from=$errors item='message'}
				{$message->html}
			{/foreach}
		</div>
	{/if}
	</div>
	<label>Название категории:</label>
	<input class="inp-text" type="text" value="{$item->title}" name="title"/>
	<input type="hidden" value="1" name="save"/>
	<a class="save-btn button" href="">Сохранить</a>
</form>
{elseif $state=='delete'}
<form action="" method="post" enctype="multipart/form-data" class="form-pop-categoty">
	<label>Вы уверены, что хотите удалить категорию?</label>
	<a class="button" href="/cabinet/category/delete/{$item->id}">Да</a> <a class="fbx-close button" href="#" style="float: right;">Отмена</a>
	<div class="clear"></div>
</form>
{/if}