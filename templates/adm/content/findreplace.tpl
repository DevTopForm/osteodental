<h3 class="action-title">Поиск и замена</h3>
<p></p>
{if !empty($messages) && $messages|@count > 0}
<div class="messages">
	{foreach from=$messages item='message'}
	{$message->html}
	{/foreach}
</div>
{/if}

{if $state == 'list'}

<form action="" method="post">
	{if $list_modules}
		<p>Модули с текстовыми полями:</p>
		<table>
			<thead>
				<tr>
					<th style="width:20px;">&nbsp;</th>
					<th>Название</th>
					<th>Тип</th>
					<th>Кол-во элементов модуля</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list_modules item='modul'}
				<tr>
					<td>
						<label class="selected_label inner_label {if $post.type_modules && $modul.type|in_array:$post.type_modules}checked{/if}" for="{$modul.type}"></label>
						<input class="no-uniform selected_field" type="checkbox" class="checkbox" value="{$modul.type}" id="{$modul.type}" name="type_modules[]" {if $post.type_modules && $modul.type|in_array:$post.type_modules} checked="checked"{/if}/>
					</td>
					<td>{$modul.title}</td>
					<td>{$modul.type}</td>
					<td>{$modul.count_elem}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}

	{if $fileds_in_params}
		<p>Текстовые поля в параметрах модулей:</p>
		<table>
			<thead>
				<tr>
					<th style="width:20px;">&nbsp;</th>
					<th>Тип модуля</th>
					<th>Название поля</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$fileds_in_params item='fparams'}
				<tr>
					<td>
						<div class="field checkbox">
							<label class="selected_label inner_label {if $post.fileds_params && $fparams.name|in_array:$post.fileds_params}checked{/if}" for="{$fparams.name}"></label>
							<input class="no-uniform selected_field" type="checkbox" class="checkbox" value="{$fparams.name}" id="{$fparams.name}" name="fileds_params[]" {if $post.fileds_params && $fparams.name|in_array:$post.fileds_params} checked="checked"{/if}/>
						</div>
						<input type="checkbox" name="fileds_params[]" value="{$fparams.name}"{if $post.fileds_params && $fparams.name|in_array:$post.fileds_params} checked="checked"{/if}>
					</td>
					<td>{$fparams.type}</td>
					<td>{$fparams.title}</td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	{/if}

	{if $inners_text_count}
		<div class="field checkbox">
			<label class="selected_label {if $post.inner_search}checked{/if}" for="inner_search">
				Кол-во заполненных полей вводного текста: {$inners_text_count}
			</label>
			<input class="selected_field" value="1" type="checkbox" class="checkbox" id="inner_search" name="inner_search" {if $post.inner_search}checked="checked"{/if}/>
		</div>
	{/if}

	<div class="field editor">
		<input type="text" name="search_text" placeholder="Поиск (LIKE %...%)" value="{$post.search_text}" style="width: 47%;" />
		<input type="text" name="replace_text" placeholder="Заменить на" value="{$post.replace_text}" style="width: 47%;" />
	</div>
	<div class="field checkbox">
		<label class="selected_label {if $post.replace_text_ok}checked{/if}" for="replace_text_ok">
			Кол-во заполненных полей вводного текста: {$inners_text_count}
		</label>
		<input class="selected_field" value="1" type="checkbox" class="checkbox" id="replace_text_ok" name="replace_text_ok" {if $post.replace_text_ok}checked="checked"{/if}/>
	</div>
	<input  class="btn" type="submit" name="send" value="Найти">
</form>

{if $result_search_modules}
	<p><strong>Поиск в модулях:</strong></p>
	<table>
		<thead>
			<tr>
				<th width="50%">Модуль</th>
				<th>Найдено совпадений</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$result_search_modules key=key item='result'}
			<tr style="background: #e6e6e6;">
				<td>
					{foreach from=$list_modules item='modul'}
						{if $key==$modul.type}
							{$modul.title}
						{/if}
					{/foreach}
				</td>
				<td>&nbsp;</td>
			</tr>
			{if $result|@count>0}
				{foreach from=$result key=keyAr item='arr' name='counter1'}
				<tr>
					<td>
						<p>Поле - <b>{$keyAr}</b></p>
					</td>
					<td>
						{if $arr.0|@count==0}
							<b style="color: green;">{$arr.0|@count}</b>
						{else}
							<b style="color: red;">{$arr.0|@count}</b>
						{/if}
					</td>
				</tr>
					{if $arr.0|@count>0}
					<tr>
						<td colspan="2">
							{foreach from=$arr.0 item='it' name='counter2'}
								<p>№{$smarty.foreach.counter2.iteration} - <a href="{$it.link}" target="_blank" title="Открыть на сайте">{$it.title}</a></p>
							{/foreach}
						</td>
					</tr>
					{/if}
				{/foreach}
			{/if}
			{/foreach}
		</tbody>
	</table>
{/if}
{if $result_search_params}
	<p><strong>Поиск в параметрах модулей:</strong></p>
	<table>
		<thead>
			<tr>
				<th width="50%">Название поля</th>
				<th>Найдено совпадений</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$result_search_params key=keyp item='resultp'}
			<tr>
				<td>
					{foreach from=$fileds_in_params item='fparams'}
						{if $keyp==$fparams.name}
							{$fparams.title}
						{/if}
					{/foreach}
				</td>
				<td>
					{if $resultp.0|@count==0}
						<b style="color: green;">{$resultp.0|@count}</b>
					{else}
						<b style="color: red;">{$resultp.0|@count}</b>
					{/if}
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/if}
{if $result_search_inners}
	<p><strong>Поиск в вводном тексте:</strong></p>
	<table>
		<thead>
			<tr>
				<th width="50%">Название поля</th>
				<th>Найдено совпадений</th>
			</tr>
		</thead>
		<tbody>
			{foreach from=$result_search_inners key=keyi item='resulti'}
			<tr>
				<td>
					{if $keyi=='before_text'}Текст до{elseif $keyi=='after_text'}Текст после{/if}
				</td>
				<td>
					{if $resulti.0|@count==0}
						<b style="color: green;">{$resulti.0|@count}</b>
					{else}
						<b style="color: red;">{$resulti.0|@count}</b>
					{/if}
				</td>
			</tr>
			{/foreach}
		</tbody>
	</table>
{/if}

{/if}
