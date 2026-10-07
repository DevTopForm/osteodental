<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE yml_catalog SYSTEM "shops.dtd">
<yml_catalog date="{$smarty.now|date_format:'%Y-%m-%d %H:%M'}">
	<shop>
		<name>{$params.sitename}</name>
		<company>{$params.company}</company>
		<url>{$params.site_url}</url>
		<currencies>
			<currency id="RUR" rate="1"/>
		</currencies>
		{if $categories|@count > 0}
		<categories>
			{foreach from=$categories item=category}
			<category id="{$category->id}"{if $category->parent > 0} parentId="{$category->parent}"{/if}>{$category->title}</category>
			{/foreach}
		</categories>
		{/if}
		{if $items|@count > 0}
		<offers>
			{foreach from=$items item=item}
			<offer id="{$item->id}" type="vendor.model" available="true">
				<url>{$item->url}</url>
				<price>{$item->price}</price>
				<currencyId>RUR</currencyId>
				<categoryId>{$item->node}</categoryId>
				{if $item->image_url}<picture>{$item->image_url}</picture>{/if}
				{if $item->delivery}<delivery>{$item->delivery}</delivery>{/if}
				{if $item->vendor}<vendor>{$item->vendor}</vendor>{/if}
				<model>{$item->title}</model>
				{if $item->text}<description><![CDATA[{$item->text}]]></description>{/if}
			</offer>
			{/foreach}
		</offers>
		{/if}
	</shop>
</yml_catalog>
