<section class="catalog">
	{include file='menu/node-actions.tpl' node=$item}

	<h1 class="h1 catalog__h1">{$item->title|default:"Новый раздел"}</h1>

	{include file='menu/node-menu.tpl' node=$item active=params}

	<form id="params-form" action="" method="post" enctype="multipart/form-data" class="form form--980">
		<div class="form__fieldset">
			<div class="form__fieldset-wrap">
				{foreach from=$fields item='field'}
					{include file='content/fields/'|cat:$field->field|cat:'.tpl'}
				{/foreach}
			</div>
		</div>
	</form>

	<div class="form__check-group label form__input-full">
		<button name="save" value="Сохранить" form="params-form" type="submit" class="btn btn--blue btn--lg" style="width: fit-content;">
			<span>Сохранить</span>
		</button>
	</div>
</section>
