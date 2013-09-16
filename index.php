<?php
require "common.php";



// Get a list of IDs and their data from the world file.
$collection = json_decode(file_get_contents(FILE_WORLD));
//file_put_contents("collection.txt", print_r($collection, true));
$countryInfo = array();
foreach ($collection->features as $feature) {
	$id = $feature->id;
	$countryInfo[$id] = array(				// Use OSM ID as index in the future.
					"registered" => true,	// Check the DB for this ID and if it's been taken.
					"properties" => array(
						"name" => $feature->properties->name
					)
				);
}
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?=TITLE?></title>
<link rel="shortcut icon" href="<?=DIR_IMG?>/favicon.ico">
<!-- normalize.css -->
<link rel="stylesheet" href="<?=DIR_CSS?>/normalize.min.css" type="text/css">
<!-- Console.js -->
<script src="<?=DIR_CON?>/Console.js" type="text/javascript"></script>
<!-- jQuery -->
<script src="<?=DIR_JS?>/jquery-<?=VER_JQ?>.min.js" type="text/javascript"></script>
<!-- jQuery UI -->
<link href="<?=DIR_JQUI?>/css/redmond/jquery-ui-<?=VER_JQUI?>.min.css" rel="stylesheet" type="text/css">
<script src="<?=DIR_JQUI?>/jquery-ui-<?=VER_JQUI?>.min.js" type="text/javascript"></script>
<!-- jQuery-shorty (my shortcut plugin) -->
<script src="<?=DIR_JS?>/shorty/jquery.shorty.min.js" type="text/javascript"></script>
<!-- Leaflet -->
<link rel="stylesheet" href="<?=DIR_LEAF?>/leaflet.css" type="text/css">
<!--[if lte IE 8]><link rel="stylesheet" href="<?=DIR_LEAF?>/leaflet.ie.css" /><![endif]-->
<script src="<?=DIR_LEAF?>/leaflet.js" type="text/javascript"></script>
<!-- Map assets -->
<script src="<?=FILE_GETWORLD?>" type="text/javascript"></script>
<script src="<?=DIR_LEAF_PLUG?>/Leaflet.TileLayer.Common.js" type="text/javascript"></script>
<!-- Proprietary -->
<link rel="stylesheet" href="<?=DIR_CSS?>/styles.css" type="text/css">
<script src="<?=DIR_JS?>/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
(function($) {
	$(function() {
		var map  = L.map('map', {
				attributionControl: false
			}),
			featureData = <?=json_encode($countryInfo)?>;
		L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
			maxZoom: 18,
			attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery Â© <a href="http://cloudmade.com">CloudMade</a>'
		}).addTo(map);
	
		function onLocationFound(e) {
			var radius = e.accuracy / 2;
			if (radius.hasDecimal())
				radius = radius.toFixed(1);
			L.marker(e.latlng).addTo(map).bindPopup("You are within " + radius + " meters from this point");//.openPopup();
			L.circle(e.latlng, radius).addTo(map);
			Console.debug("Radius: ", radius);
		}
	
		function onLocationError(e) {
			alert(e.message);
		}
		
		// get color depending on population density value
		function getColor(id) {
			var color;
			$.ajax({
				async: false,
				type: "GET",
				url: "check.php",
				data: {
					id: id
				},
				success: function(data) {
					if (data == "true")
						color = "#00FF00";
					else
						color = "#FF0000";
				}
			});
			return color;
		}
	
		function style(feature) {
			return {
				weight: 2,
				opacity: 1,
				color: 'white',
				dashArray: '3',
				fillOpacity: 0.7,
				fillColor: getColor(feature.id)
			};
		}
	
		function highlightFeature(e) {
			var layer = e.target;
			layer.setStyle({
				weight: 5,
				color: '#666',
				dashArray: '',
				fillOpacity: 0.7
			});
	
			if (!L.Browser.ie && !L.Browser.opera) {
				layer.bringToFront();
			}
	
			//info.update(layer.feature.properties);
		}
	
		function resetHighlight(e) {
			geojson.resetStyle(e.target);
			//info.update();
		}
	
		function zoomToFeature(e) {
			map.fitBounds(e.target.getBounds());
		}
	
		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: zoomToFeature
			});
		}
		
		geojson = L.geoJson(CA.globals.data.world, {
			style: style,
			onEachFeature: onEachFeature
		}).addTo(map);
		
		map.on('locationfound', onLocationFound);
		map.on('locationerror', onLocationError);
		
		map.locate({setView: true, maxZoom: 16});
	});
})(jQuery);
</script>
</head>
<body>
	<div id="wrapper">
    	<div id="map"></div>
    </div>
</body>
</html>