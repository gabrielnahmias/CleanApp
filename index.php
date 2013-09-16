<?php
// Basic
define("NAME", "CleanApp");

// Versions
define("VER", "2.0");
define("VER_JQ", "1.10.2");
define("VER_JQUI", "1.10.3");

// Directories
define("DIR_ASSETS", "assets");
define("DIR_CSS", DIR_ASSETS."/css");
define("DIR_DATA", DIR_ASSETS."/data");
define("DIR_IMG", DIR_ASSETS."/img");
define("DIR_JS", DIR_ASSETS."/js");
define("DIR_CON", DIR_JS."/Console");
define("DIR_JQUI", DIR_JS."/jquery-ui");
define("DIR_LEAF", DIR_JS."/leaflet");
define("DIR_LEAF_PLUG", DIR_JS."/leaflet/plugins");

// Files
define("FILE_WORLD", DIR_DATA."/world.geojson");

// Get a list of IDs from the world file.
$world = json_decode(file_get_contents(FILE_WORLD));
$ids = array();
foreach ($world as $collection) {
	$features = $collection->features;
	foreach ($features as $feature) {
		$id = $feature->id;
		array_push($ids, $id);
	}
}
?><!-- <?php //print_r($ids, true)?> --><!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<title><?=NAME?></title>
<link rel="shortcut icon" href="<?=DIR_IMG?>/favicon.ico">
<!-- normalize.css -->
<link rel="stylesheet" href="<?=DIR_CSS?>/normalize.min.css" type="text/css">
<!-- Console.js -->
<script src="<?=DIR_CON?>/Console.min.js" type="text/javascript"></script>
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
<script src="<?=FILE_WORLD?>" type="text/javascript"></script>
<script src="<?=DIR_LEAF_PLUG?>/Leaflet.TileLayer.Common.js" type="text/javascript"></script>
<!-- Proprietary -->
<link rel="stylesheet" href="<?=DIR_CSS?>/styles.css" type="text/css">
<script src="<?=DIR_JS?>/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
(function($) {
	$(function() {
		var map = L.map('map', {
				attributionControl: false
			}),
			featureData = {},
			worldData = "";
	
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
			/*$.ajax({
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
			});*/
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
	
		geojson = L.geoJson(worldData, {
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