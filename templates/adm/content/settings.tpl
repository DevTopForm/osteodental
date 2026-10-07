<div class="settings">
	{if $state == 'edit' || $state == 'images'}
		<h1 class="h1 settings__h1">Настройки сайта</h1>
		<form class="form  form--980" action="" method="post" enctype="multipart/form-data" rel="settings">
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					{foreach from=$fields item='field'}
						{include file='content/fields/'|cat:$field->field|cat:'.tpl'}

{*						{if $state == 'edit'}*}
{*							<div class="form__check-group label form__input-full">*}
{*								<div class="form__check-group-inside">*}
{*									<label class="check">*}
{*										<input class="check__input" name="remove[{$field->id}]" value="1" type="checkbox">*}
{*										<span class="check__name label__name">Удалить поле '{$field->title}'</span>*}
{*									</label>*}
{*								</div>*}
{*							</div>*}
{*						{/if}*}
					{/foreach}
				</div>
			</div>
			<div class="form__check-group label form__input-full">
				<button name="save" value="Сохранить" class="btn btn--blue btn--lg" style="width: fit-content;">
					<span>Сохранить</span>
				</button>
			</div>
		</form>

{elseif $state == 'add'}
		<h2 class="h1 settings__h1">Добавить поле</h2>
		<form class="form  form--980" action="" method="post" enctype="multipart/form-data" rel="settings">
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					<label class="label form__input-full ">
						<div class="label__content">
							<span class="label__name">Название</span>
						</div>
						<span class="label__wrapper">
							<input type="text" value="" class="label__input" name="title" placeholder="">
						</span>
					</label>

					<label class="label form__input-full ">
						<div class="label__content">
							<span class="label__name">Имя в таблице</span>
						</div>
						<span class="label__wrapper">
							<input type="text" value="" class="label__input" name="name" placeholder="">
						</span>
					</label>

					<label class="label form__input-full ">
						<div class="label__content">
							<span class="label__name">Тип поля</span>
						</div>
						<span class="label__wrapper label__wrapper--select">
							<select class="label__select" name="field">
								{foreach from=$data.types key='type' item='type_item' name='types'}
									<option value="{$type}" rel="">{$type}</option>
								{/foreach}
							</select>
						</span>
					</label>

					<div class="form__check-group label form__input-full">
						<button name="save" value="Сохранить" class="btn btn--blue btn--lg" style="width: fit-content;">
							<span>Сохранить</span>
						</button>
					</div>
				</div>
			</div>
		</form>
	{/if}
</div>