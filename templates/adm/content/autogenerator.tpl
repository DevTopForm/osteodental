<h3 class="action-title">Автогенерация страниц</h3>
<p class="action-description">Автогенерация страниц с шаблоном текста.</p>

{if $success}

<div class="messages">
  <p class="success">Автогенерация завершена. Сгенерировано 10 страниц из 20.</p>
</div>

{else}

{if $messages.error|@count > 0}
<div class="messages">
  {foreach from=$messages.error item='message'}
    <p class="error">{$message}</p>
  {/foreach}
</div>
{/if}

<form id="autogenerator_form" action="" method="POST" enctype="multipart/form-data">
  <div class="inline-block">
    <label>Выберите страны</label>
    {if $data.country|@count > 0}
    <select class="multisel2area" name="county[]" multiple="multiple">
    {foreach from=$data.country item=country}
      <option value="{$country->id}">{$country->title}</option>
    {/foreach}
    </select>
    {/if}
    <p>Если ни одна значение не выбрано, то генерация будет для всех элементов списка.</p>
  </div>
  <div class="clear"></div>
  <div class="inline-block">
    <label>Выберите тип перевозок</label>
    {if $data.type|@count > 0}
    <select class="multisel2area" name="type[]" multiple="multiple">
    {foreach from=$data.type item=type}
      <option value="{$type->id}">{$type->title}</option>
    {/foreach}
    </select>
    {/if}
    <p>Если ни одна значение не выбрано, то генерация будет для всех элементов списка.</p>
  </div>
  <div class="clear"></div>
  <input type="submit" value="Генерировать" name="submit">
</form>
<script type="text/javascript">
{literal}
  $(document).ready(function() {
    $('#autogenerator_form').submit(function(){

    });
  });
{/literal}
</script>
{/if}
<br/>
<br/>
{if !empty($list)  && $list|@count > 0}
<table>
  <thead>
    <tr>
      <th>ID</th>
      <th>Страны</th>
      <th>Города</th>
      <th>Типы перевозок</th>
      <th>Выполнено / Всего</th>
    </tr>
  </thead>
  <tbody>
  {foreach from=$list item="item" name="item"}
    <tr>
      <td>{$item->id}</td>
      <td>
      {if $item->countries|@count > 0}
        {foreach from=$item->countries item="country" name="country"}
          {$country->title}{if !$smarty.foreach.country.last}, {/if}
        {/foreach}
      {/if}
      </td>
      <td>
      {if $item->cities|@count > 0}
        {foreach from=$item->cities item="city" name="city"}
          {$city->title}{if !$smarty.foreach.city.last}, {/if}
        {/foreach}
      {/if}
      </td>
      <td>
      {if $item->type|@count > 0}
        {foreach from=$item->type item="tp" name="tp"}
          {$tp->title}{if !$smarty.foreach.tp.last}, {/if}
        {/foreach}
      {/if}
      </td>
      <td>{$item->success} / {$item->total}</td>
    </tr>
  {/foreach}
  </tbody>
</table>
{/if}
