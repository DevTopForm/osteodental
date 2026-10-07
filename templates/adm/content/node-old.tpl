{*{if $item->id}{include file='menu/node-actions.tpl' node=$item active=node}{/if}*}
{if $state == 'edit' || $state == 'add'}
{*{if $state == 'edit'}
<h3>{$item->title}</h3>
<p class="action-description edit-properties">Редактирование основных свойств раздела</p>
{else}
<h3>Создание раздела</h3>
<p class="action-description edit-properties">Основные свойства раздела</p>
{/if}*}
<div class="content_header">
	<div class="title">
		{if $state == 'edit'}{$item->title}{else}Создание раздела{/if}
	</div>
	{if $item->id}
		<div class="node_actions">
			{include file='menu/node-actions.tpl' node=$item}
		</div>
	{/if}
</div>
{if $item->id}
	<div class="node_menu">
		{include file='menu/node-menu.tpl' node=$item active=node}
	</div>
{/if}
<div class="clear"></div>
{if !empty($errors) && $errors|@count > 0}
<div class="messages">
	{foreach from=$errors item='message'}
	{$message->html}
	{/foreach}
</div>
{/if}
<form action="" method="post" enctype="multipart/form-data">
	<input type="hidden" name="id" value="{$item->id}"/>
	<div class="fields-panel inline-container">
		<div class="inline-block half-width">
			<label>Название раздела</label>
			<input type="text" class="text required" name="title" value="{$item->title|escape}"/>
		</div>
		<div class="inline-block half-width">
			<label>Название в меню</label>
			<input type="text" name="menutitle" value="{$item->menutitle|escape}"/>
		</div>
		{if !$item->blocked || $user->hasAccess('lock')}
		<div class="inline-block half-width">
			<label>Относится к разделу</label>
			<select id="node-parent" name="parent">
				<option value="0" rel="">{$_LNG_ADM.ROOT_NODE}</option>
				{include file='menu/parent-select.tpl' tree=$data.nodes cur_nid=$item->id cur_pid=$item->parent spacer=' - '}
			</select>
			<p class="description">&nbsp;</p>
			{if !$item->id}
				<label>{$_LNG_ADM.COPY_BLOCKS}</label>
				<select name="blocks_from">
					<option value="">--{$_LNG_ADM.DONT_COPY}--</option>
					<option disabled="true"></option>
					{include file='menu/parent-select.tpl' tree=$data.nodes cur_pid=$item->parent spacer=' - '}
				</select>
			{/if}
			<label>H1</label>
			<input type="text" class="text" name="h1" value="{$item->h1|escape}"/>
		</div>
		<div class="inline-block half-width">
			<label>{$_LNG_ADM.ALIAS} <span class="example">{$_LNG_ADM.ALIAS_EXAMPLE}</span></label>
			<input type="text" id="node-alias" name="alias" value="{$item->alias|escape}"/>
			<p class="description" id="node-url">{$item->url}</p>
			{*<label>{$_LNG_ADM.REDIRECT}</label>
			<input type="text" id="node-redirect" name="redirect" value="{$item->redirect|escape}"/>*}
		</div>
		{*<div class="inline-block half-width">
			<label>{$_LNG_ADM.NOINDEX}</label>
			<input type="text" id="node-noindex" name="noindex" value="{$item->noindex|escape}"/>
		</div>*}
		{*<div class="inline-block half-width">
			<label>{$_LNG_ADM.BREAD}</label>
			<input type="text" id="node-bread" name="bread" value="{$item->bread|escape}"/>
		</div>*}
		{*<div class="inline-block half-width">
			<label>{$_LNG_ADM.CANONICAL}</label>
			<input type="text" id="node-canonical" name="canonical" value="{$item->canonical|escape}"/>
		</div>*}
		{/if}
	</div>
	<div class="fields-panel inline-container">
		<div class="inline-block half-width">
			<label>{$_LNG_ADM.PRIORITY_NODE}</label>
			<input type="text" id="priority_node" name="priority_node" value="{$item->priority_node|escape}"/>
		</div>

		<div class="inline-block half-width">
			<label>{$_LNG_ADM.PRIORITY_ELEMENT}</label>
			<input type="text" id="priority_element" name="priority_element" value="{$item->priority_element|escape}"/>
		</div>

		<div class="inline-block half-width">
			<label>{$_LNG_ADM.PRIORITY_NODE}</label>
			<select id="changefreq_node" name="changefreq_node">
				<option value="" {if !$item->changefreq_node}selected{/if} rel="">---</option>

				<option value="always" {if $item->changefreq_node == 'always'}selected{/if} rel="">always</option>
				<option value="hourly" {if $item->changefreq_node == 'hourly'}selected{/if} rel="">hourly</option>
				<option value="daily" {if $item->changefreq_node == 'daily'}selected{/if} rel="">daily</option>
				<option value="weekly" {if $item->changefreq_node == 'weekly'}selected{/if} rel="">weekly</option>
				<option value="monthly" {if $item->changefreq_node == 'monthly'}selected{/if} rel="">monthly</option>
				<option value="yearly" {if $item->changefreq_node == 'yearly'}selected{/if} rel="">yearly</option>
				<option value="never" {if $item->changefreq_node == 'never'}selected{/if} rel="">never</option>
			</select>
		</div>

		<div class="inline-block half-width">
			<label>{$_LNG_ADM.PRIORITY_ELEMENT}</label>
			<select id="changefreq_element" name="changefreq_element">
				<option value="" {if !$item->changefreq_element}selected{/if} rel="">---</option>

				<option value="always" {if $item->changefreq_element == 'always'}selected{/if} rel="">always</option>
				<option value="hourly" {if $item->changefreq_element == 'hourly'}selected{/if} rel="">hourly</option>
				<option value="daily" {if $item->changefreq_element == 'daily'}selected{/if} rel="">daily</option>
				<option value="weekly" {if $item->changefreq_element == 'weekly'}selected{/if} rel="">weekly</option>
				<option value="monthly" {if $item->changefreq_element == 'monthly'}selected{/if} rel="">monthly</option>
				<option value="yearly" {if $item->changefreq_element == 'yearly'}selected{/if} rel="">yearly</option>
				<option value="never" {if $item->changefreq_element == 'never'}selected{/if} rel="">never</option>
			</select>
		</div>
	</div>
	<div class="fields-panel inline-container">
		{if !$item->blocked || $user->hasAccess('lock')}
			<div class="inline-block half-width">
				<div class="inline-block">
					<label>{$_LNG_ADM.NODE_TEMPLATE}</label>
					<select name="template">
						{foreach from=$data.templates item='template'}
						<option value="{$template->id}"{if $template->id == $item->template->id} selected="selected"{/if}>{$template->title}</option>
						{/foreach}
					</select>
				</div>
				<div class="inline-block">
					<label>{$_LNG_ADM.NODE_TYPE}</label>
					<select name="type" id="node-type">
						{foreach from=$data.types item='type'}
						<option value="{$type->type}"{if $type->type == $item->type->type} selected="selected"{/if}>{$type->title}</option>
						{/foreach}
					</select>
				</div>
				<div class="inline-block">
					<label>{$_LNG_ADM.CONTENT_TEMPLATE}</label>
					<select name="content_template" id="content-template">
					</select>
				</div>
					<select class="hidden" id="content-template-storage" style="display: none;">
						{foreach from=$data.content item='template'}
						<option class="{$template->type}" value="{$template->id}"{if $template->id == $item->content_template->id} selected="selected"{/if}>{$template->title}</option>
						{/foreach}
					</select>
			</div>
		{/if}
		{if $item->id}
		<div class="inline-block half-width">
			<label>Изображение раздела</label>
			{if $item->image && $item->image->getLink()}
			<img src="{$item->image->getLink('thumb')}" alt="" align="right" class="crop" rel="{$item->image->id}"/>
			<label><input type="checkbox" name="clear_image" value="1"/> Удалить или заменить:</label>
			<input type="file" name="image" />
			{else}
			<input type="file" name="image" />
			{/if}
			<div class="clear"></div>
		</div>
		{/if}
	</div>
	<div class="fields-panel inline-container">
		{if !$item->blocked || $user->hasAccess('lock')}
			<div class="inline-block third-width">
				<label class="selected_label {if $item->public || !$item->id}checked{/if}" for="public">Опубликовать раздел</label>
				<input class="selected_field" type="checkbox" id="public" name="public" value="1" {if $item->public || !$item->id}checked="checked"{/if}/>
			</div>
		{/if}
		<div class="inline-block third-width">
			<label class="selected_label {if $item->sitemap || !$item->id}checked{/if}" for="sitemap">{$_LNG_ADM.SITEMAP_XML}</label>
			<input class="selected_field" type="checkbox" id="sitemap" name="sitemap" value="1" {if $item->sitemap || !$item->id}checked="checked"{/if}/>
		</div>

		<div class="inline-block third-width">
			<label class="selected_label {if $item->nomenu || !$item->id}checked{/if}" for="nomenu">Скрыть в меню</label>
			<input class="selected_field" type="checkbox" id="nomenu" name="nomenu" value="1" {if $item->nomenu || !$item->id}checked="checked"{/if}/>
		</div>

		<div class="inline-block third-width">
			<label class="selected_label {if $item->nosearch || !$item->id}checked{/if}" for="nosearch">Скрыть в поиске</label>
			<input class="selected_field" type="checkbox" id="nosearch" name="nosearch" value="1" {if $item->nosearch || !$item->id}checked="checked"{/if}/>
		</div>

		<div class="inline-block third-width">
			<label class="selected_label {if $item->passworded || !$item->id}checked{/if}" for="passworded">Только для пользователей</label>
			<input class="selected_field" type="checkbox" id="passworded" name="passworded" value="1" {if $item->passworded || !$item->id}checked="checked"{/if}/>
		</div>

		<div class="inline-block third-width">
			<label class="selected_label {if $item->selection || !$item->id}checked{/if}" for="selection">{$_LNG_ADM.SELECTION}</label>
			<input class="selected_field" type="checkbox" id="selection" name="selection" value="1" {if $item->selection || !$item->id}checked="checked"{/if}/>
		</div>

		{if $user->role == 'sadmin'}
			<div class="inline-block third-width">
				<label class="selected_label {if $item->sadmin || !$item->id}checked{/if}" for="sadmin">Выводить в списке только у разработчика</label>
				<input class="selected_field" type="checkbox" id="sadmin" name="sadmin" value="1" {if $item->sadmin || !$item->id}checked="checked"{/if}/>
			</div>
		{/if}
	</div>
	<input class="btn" type="submit" name="save" value="{$_LNG_ADM.SAVE}"/>
</form>

<script>
	$(function() {ldelim}
		var parentUrl = $("#node-parent :selected").attr("rel");
		var nodeAlias = $("#node-alias").val();

		$("#node-url").html("<span class=\"parent\">" + parentUrl + "</span>/<span class=\"alias\">" + nodeAlias + "</span>");

		$("#node-parent").change(function() {ldelim}
			var parentUrl = $(":selected", this).attr("rel");
			$("#node-url span.parent").html(parentUrl);
		{rdelim});

		$("#node-type").change(function() {ldelim}
			update_select('#content-template',$('#content-template-storage option.'+$(this).val()).clone());
		{rdelim});

		$("#node-alias").keyup(function(event) {ldelim}
			$("#node-url span.alias").html($(this).val());
		{rdelim});

		{if $item->id}
		$("#node-remove").click(function() {ldelim}
			return confirm("{$_LNG_ADM.NODE_REMOVE_CONFIRM} «{$item->title|escape}»?");
		{rdelim});
		{/if}

		function clear_select(select){ldelim}
			$(select).find('option').remove();
		{rdelim}

		function update_select(select,items){ldelim}
			clear_select(select);
			if ($(items).length > 0){ldelim}
				$(select).show().append($(items));
				var val = ($(select+' option:selected').length > 0 ) ? $(select+' option:selected:first').val() : $(select+' option:first').val();
				$(select).val(val).trigger('change');
				$('select:not(.hidden)').dropdown('destroy');
				$('select:not(.hidden)').dropdown();
			{rdelim}
		{rdelim}

		$("#node-type").change();
	{rdelim});
</script>
{/if}
