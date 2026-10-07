<div class="field">
	<label>
		{$field->title}{if $field->required}*{/if}
	</label>
	<script type="text/javascript" src="http://api-maps.yandex.ru/2.0/?load=package.full&lang=ru-RU"></script>
	<div class="fields" style="width: 220px; float:left;">
		{$field->getHtml()}
		<div class="clear"></div>
		<div style="float:left; margin-top: 10px;"><input type="text" id="map-search" value="Найти на карте" ></div>
		<div style="float:left; margin-top: 6px; margin-left: 10px;"><input type="button" value="Найти" style="float:left;" id="map-search-but"></div>
		<div class="clear"></div>
	</div>
	<div class="map-container" style="width: 400px; float:right;">
		<div id="map" style="width: 400px; height: 300px;"></div>
	</div>
	<div class="clear"></div>
	<script>
	$(document).ready(function(){ldelim}
		$('#map-search').focus(function(){ldelim}
			if ($(this).val() == 'Найти на карте'){ldelim}
				$(this).val('');
			{rdelim}
		{rdelim}).blur(function(){ldelim}
			if ($(this).val() == ''){ldelim}
				$(this).val('Найти на карте');
			{rdelim}
		{rdelim});
		var field = '{$field->name}';
		var title = {if $field->table_filter}$('#{$field->table_filter}').val(){else}$('#title').val(){/if};
		ymaps.ready(init);
		function init () {ldelim}
			// Поиск координат центра текущего города
			if ($('#coord_'+field+'_x').val() != 0 && $('#coord_'+field+'_y').val() != 0){ldelim}
				initMap([$('#coord_'+field+'_x').val(), $('#coord_'+field+'_y').val()],10);
			{rdelim} else {ldelim}
				ymaps.geocode(title, {ldelim} results: 1 {rdelim}).then(function (res) {ldelim}
					// Выбираем первый результат геокодирования
					initMap(res.geoObjects.get(0).geometry.getCoordinates(),10);
				{rdelim},function (err) {ldelim}
					initMap([66.42, 94.26],6);
				{rdelim});
			{rdelim}

			$('#map-search-but').click(function () {ldelim}
				var search_query = $('#map-search').val();
				if (search_query != 'Найти на карте'){ldelim}
					ymaps.geocode(title+' '+search_query, {ldelim}results: 1{rdelim}).then(function (res) {ldelim}
						mapPoint.geometry.setCoordinates(res.geoObjects.get(0).geometry.getCoordinates());
						myMap.zoomRange.get(mapPoint.geometry.getCoordinates()).then(function (range) {ldelim}
							myMap.setCenter(mapPoint.geometry.getCoordinates(), range[1]);
						{rdelim});
						changePointCoords();
					{rdelim});
				{rdelim}
				return false;
			{rdelim});

			$('#region').change(function(){ldelim}
				title = $('#region option:selected').text();
				ymaps.geocode(title, {ldelim}results: 1{rdelim}).then(function (res) {ldelim}
					mapPoint.geometry.setCoordinates(res.geoObjects.get(0).geometry.getCoordinates());
					myMap.setCenter(mapPoint.geometry.getCoordinates(),10);
					changePointCoords();
				{rdelim});
			{rdelim});

			function initMap(coords,zoom){ldelim}
				myMap = new ymaps.Map("map", {ldelim}
					center: coords, // Центр России
					zoom: zoom,
					behaviors: ['default', 'scrollZoom']
				{rdelim});
				myMap.controls.add('zoomControl');
				myCollection = new ymaps.GeoObjectCollection();
				mapPoint = new ymaps.Placemark(coords, {ldelim}{rdelim}, {ldelim}draggable: true{rdelim});
				myCollection.add(mapPoint);
				myMap.geoObjects.add(myCollection);
				mapPoint.events.add('dragend', changePointCoords);
				changePointCoords();
			{rdelim}

			function changePointCoords(){ldelim}
				var p_coords = mapPoint.geometry.getCoordinates();
				$('#coord_'+field+'_x').val(p_coords[0]);
				$('#coord_'+field+'_y').val(p_coords[1]);
			{rdelim}

		{rdelim}
	{rdelim});
	</script>
</div>