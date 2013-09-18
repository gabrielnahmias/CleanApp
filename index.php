<?php
require_once "common.php";

// TODO:	MAYBE add json.js method to pull in PHP variables to JS and create global CA
//			namespace for option defaults (to provide a skeleton).

// Get a list of IDs and their data from the world file.
$collection = json_decode(file_get_contents(FILE_WORLD));
//file_put_contents("collection.txt", print_r($collection, true));
$countryInfo = array();
// Loop through and supplement the data inside the world file.
foreach ($collection->features as $feature) {
	$id = $feature->id;
	$countryInfo[$id] = array(				// Use OSM ID as index in the future.
					"added" => false,		// Check the DB for this ID and if it's been taken.
					/*"properties" => array(
						"name" => $feature->properties->name
					)*/
				);
}

Web::debug($browser, "Browser Data");
?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<?php include DIR_INC."/apple_meta.inc.php" ?>
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
<script src="<?=FILE_GETDATA?>" type="text/javascript"></script>
<script src="<?=DIR_LEAF_PLUG?>/Leaflet.TileLayer.Common.js" type="text/javascript"></script>
<!-- Proprietary -->
<link rel="stylesheet" href="<?=DIR_CSS?>/styles.css" type="text/css">
<script src="<?=DIR_JS?>/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
// Set to global for debugging purposes.
//var map;
<?php if (!CONFIG_DEBUG): ?>
Console.setOption("enabled", false);
<?php endif; ?>
(function($) {
	$(function() {
		var ua = navigator.userAgent,
			currentBrowser = {
				firefox: /firefox/gi.test(ua),
				ie: /msie/gi.test(ua),
				ios: /i(phone|pad)/gi.test(ua),
				webkit: /webkit/gi.test(ua),
			},
			featureData = <?=json_encode($countryInfo)?>,
			map = L.map('map', {
				attributionControl: false
			}),
			popup = L.popup({
				keepInView: true
			});
		
		Console.debug(featureData);
		
		L.tileLayer('http://{s}.tile.cloudmade.com/BC9A493B41014CAABB98F0471D759707/997/256/{z}/{x}/{y}.png', {
			maxZoom: 18,
			minZoom: 4,
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
			Console.error(e.message.replace("error", "Error"));
		}
		
		// get color depending on population density value
		function getColor(id) {
			var added = featureData[id].added,
				color;
			//Console.debug(added);
			if (added)
				color = "#00FF00";
			else
				color = "#FF0000";
			return color;
		}
	
		function style(feature) {
			return {
				weight: 2,
				opacity: 1,
				color: '#FFFFFF',
				//dashArray: '3',
				fillOpacity: 0.3,
				fillColor: getColor(feature.id)
			};
		}
	
		function highlightFeature(e) {
			var layer = e.target;
			layer.setStyle({
				weight: 2,
				color: '#FFFFFF',
				//dashArray: '',
				fillOpacity: 0.5
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
	
		function showForm(e) {
			//Console.debug(e);
			var coords = e.latlng,
				feature = e.target.feature;
			popup.setLatLng([coords.lat, coords.lng])
				 .setContent('<iframe src="form.php?n={name}" frameborder="0" height="380" width="300" scrolling="no"></iframe>'.format({name: feature.properties.name}))
				 .openOn(map);
			//map.fitBounds(e.target.getBounds());
		}
	
		function onEachFeature(feature, layer) {
			layer.on({
				mouseover: highlightFeature,
				mouseout: resetHighlight,
				click: showForm
			});
		}
		
		geojson = L.geoJson(worldData, {
			style: style,
			onEachFeature: onEachFeature
		}).addTo(map);
		
		// Instead of this, put a margin-bottom on the page and that should accomplish
		// everything. Make it subclassed by the iPhone or and iPad page classes.
		/*if (currentBrowser.ios) {
			function orientationChange(e) {
				/*if(e.orientation){
					if(e.orientation == 'portrait'){
						//
					}
					else if(e.orientation == 'landscape') {
						//
					}
				}*//*
				window.scrollTo(0, 1);
			}
			$("body").css({ height: "+=300" }).scrollTop(1);
			$(window).bind("orientationchange", orientationChange);
		}*/
		
		map.on('locationfound', onLocationFound);
		map.on('locationerror', onLocationError);
		
		map.locate({setView: true, maxZoom: 16});
	});
})(jQuery);
</script>
</head>
<body<?=$browser['classString']?>>
	<div id="wrapper">
    	<div id="map"></div>
    </div>
    <script type="text/javascript">
	(function () {
		
	})();
	</script>
</body>
</html>