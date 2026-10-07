{if $state == 'list'}
	<section class="catalog">
		<h1 class="h1 catalog__h1">Действия администраторов</h1>
		<div class="top"></div>
		<div class="catalog-controls">
			<div class="catalog-controls__btns">
				<a href="{$path_prefix}/add" class="btn btn--blue btn--shrink">
					<svg fill="none" width="16" height="16">
						<use xlink:href="{$adm_path}/assets/img/sprite.svg#add"></use>
					</svg>
					<span>Добавить элемент</span>
				</a>
			</div>
		</div>
		<div class="table-wrapper catalog__table">
			<table class="catalog-table">
				<thead>
				<tr>
					<th class="catalog-table__th"><span>Сервисное имя</span></th>
					<th class="catalog-table__th"><span>Название</span></th>
					<th class="catalog-table__th"><span>Класс</span></th>
					<th class="catalog-table__th"><span>Ссылка</span></th>
					<th class="catalog-table__th "></th>
					<th class="catalog-table__th "></th>
					<th class="catalog-table__th "></th>
					<th class="catalog-table__th"><span></span></th>
				</tr>
				</thead>
				<tbody>
					{foreach from=$list item='item'}
						<tr class="catalog-table__tr js-delete-element">
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->action}</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->title}</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->class}</div>
							</td>
							<td class="catalog-table__td">
								<div class="catalog-item__name">{$item->link}</div>
							</td>
							<td class="catalog-table__td">
								<label class=" input-elt">
									<input title="Выводить в меню" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" {if $item->menu}checked{/if}>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="{$adm_path}/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
									<span class="input-elt__text">выбрать ...</span>
								</label>
							</td>

							<td class="catalog-table__td">
								<label class=" input-elt">
									<input title="Выводить информацию" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" {if $item->info}checked{/if}>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="{$adm_path}/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
									<span class="input-elt__text">выбрать ...</span>
								</label>
							</td>

							<td class="catalog-table__td">
								<label class=" input-elt">
									<input title="Настройки доступа" data-id="1" data-node="1" class="input-elt__input ajax-node-field" type="checkbox" value="1" name="1" {if $item->access}checked{/if}>
									<span class="input-elt__fake">
										<svg fill="none" width="21" height="16">
										  <use xlink:href="{$adm_path}/assets/img/sprite.svg#tick"></use>
										</svg>
									</span>
									<span class="input-elt__text">выбрать ...</span>
								</label>
							</td>

							<td class="catalog-table__td" data-position="right">
								<div class="jsFixed">
									<div class="catalog-item__controls">
										<div class="ico-btns catalog-item__btns">
											<a href="{$path_prefix}/edit/{$item->id}" class="ico-btn" aria-label="Редактировать">
												<svg fill="none" width="21" height="16">
													<use xlink:href="{$adm_path}/assets/img/sprite.svg#pencil"></use>
												</svg>
											</a>

											<a href="{$path_prefix}/delete/{$item->id}" class="ico-btn js-delete" data-name="{$item->title}" aria-label="Удалить">
												<svg fill="none" width="21" height="16">
													<use xlink:href="{$adm_path}/assets/img/sprite.svg#trash"></use>
												</svg>
											</a>
										</div>
									</div>
								</div>
							</td>
						</tr>
					{/foreach}
				</tbody>
			</table>
		</div>

	</section>
{else}
	<div class="settings">
		<h1 class="h1 settings__h1">Действия администраторов</h1>
		<form action="" method="post" enctype="multipart/form-data" class="form  form--980">
			<div class="form__fieldset">
				<div class="form__fieldset-wrap">
					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Сервисное имя</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="{$item->action}" class="label__input" name="action" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Название</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="{$item->title}" class="label__input" name="title" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Иконка</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="{$item->icon}" class="label__input" name="icon" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Название класса</span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="{$item->class}" class="label__input" name="class" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Ссылка </span>
						</div>

						<span class="label__wrapper">
							<input type="text" value="{$item->link}" class="label__input" name="link" placeholder="">
							<span class="label__mistake">Внесите данные</span>
						</span>
					</label>

					<label class="label form__input-full">
						<div class="label__content">
							<span class="label__name">Относится к</span>
						</div>

						<span class="label__wrapper label__wrapper--select">
							<select class="label__select" name="parent">
								<option value="0" rel="">---</option>
								{include file='menu/tree-select.tpl' tree=$data.action cur_nid=$item->id cur_pid=$item->parent spacer=' - '}
							</select>
						</span>
					</label>

					<div class="form__check-group label form__input-full">
						<div class="form__check-group-inside">
							<label class="check ">
								<input class="check__input" name="menu" value="1" {if $item->menu}checked{/if} type="checkbox">
								<span class="check__name">Выводить в меню</span>
							</label>
							<label class="check ">
								<input class="check__input" name="info" value="1" {if $item->info}checked{/if} type="checkbox">
								<span class="check__name">Есть информер</span>
							</label>
							<label class="check ">
								<input class="check__input" name="access" value="1" {if $item->access}checked{/if} type="checkbox">
								<span class="check__name">Доступно для настройки доступа</span>
							</label>
						</div>
					</div>
				</div>
			</div>
			<div class="form__check-group label form__input-full">
				<button name="save" value="Сохранить" type="submit" class="btn btn--blue btn--lg" style="width: fit-content;">
					<span>Сохранить</span>
				</button>
			</div>
		</form>
	</div>
{/if}

