
{if $state == 'edit'}

	<section class="catalog">
		{include file='menu/node-actions.tpl' node=$item}
		<h1 class="h1 catalog__h1">Вводный текст</h1>
		{include file='menu/node-menu.tpl' node=$item active="inner"}

		<form id="inner-form" action="" method="post" enctype="multipart/form-data" class="form form--980">
			<input type="hidden" name="id" value="{$item->id}"/>
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Заголовок до основного содержимого</span>
						</div>
						<span class="label__wrapper">
							<input type="text" value="{$item->before_title|escape}" class="label__input" name="before_title" placeholder="">
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Текст до основного содержимого</span>
						</div>
						<span class="label__wrapper label__wrapper--quill">
							<textarea data-role="editor" rows="5" class="label__input" name="before_text">{$item->before_text}</textarea>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Заголовок после основного содержимого</span>
						</div>
						<span class="label__wrapper">
							<input type="text" value="{$item->after_title|escape}" class="label__input" name="after_title" placeholder="">
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Текст после основного содержимого</span>
						</div>
						<span class="label__wrapper label__wrapper--quill">
							<textarea data-role="editor" rows="5" class="label__input" name="after_text">{$item->after_text}</textarea>
						</span>
					</label>
				</div>
			</div>
		</form>

		<div class="form__check-group label form__input-full">
			<button name="save" value="{$_LNG_ADM.SAVE}" form="inner-form" type="submit" class="btn btn--blue btn--lg" style="width: fit-content;">
				<span>Сохранить</span>
			</button>
		</div>
	</section>
{/if}