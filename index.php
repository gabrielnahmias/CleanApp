<?php
define("NAME", "CleanApp");
define("VER", "2.0");
define("VER_JQ", "1.10.2");
define("VER_JQUI", "1.10.3");
define("DIR_ASSETS", "assets");
define("DIR_CSS", DIR_ASSETS."/css");
define("DIR_DATA", DIR_ASSETS."/data");
define("DIR_IMG", DIR_ASSETS."/img");
define("DIR_JS", DIR_ASSETS."/js");
define("DIR_CON", DIR_JS."/Console");
define("DIR_JQUI", DIR_JS."/jquery-ui");
define("DIR_LEAF", DIR_JS."/leaflet");
define("DIR_LEAF_PLUG", DIR_JS."/leaflet/plugins");
?><!doctype html>
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
<script src="<?=DIR_LEAF?>/leaflet.js" type="text/javascript"></script>
<!-- Map assets -->
<script src="<?=DIR_DATA?>/world.js" type="text/javascript"></script>
<script src="<?=DIR_LEAF_PLUG?>/Leaflet.TileLayer.Common.js" type="text/javascript"></script>
<!-- Proprietary -->
<link rel="stylesheet" href="<?=DIR_CSS?>/styles.css" type="text/css">
<script src="<?=DIR_JS?>/scripts.js" type="text/javascript"></script>
<script type="text/javascript">
(function($) {
	$(function() {
		/*var map2 = L.map('map2').setView([37.8, -96], 4);
		L.tileLayer(CA.globals.const.CM_URL, {attribution: CM_ATTR, styleId: 22677}).addTo(map);
		L.geoJson(statesData).addTo(map);
		var map3 = L.map('map3').setView([37.8, -96], 4);
		L.tileLayer(CA.globals.const.CM_URL, {attribution: CM_ATTR, styleId: 22677}).addTo(map3);
		L.geoJson(statesData, {style: style}).addTo(map3);*/
		var map = L.map('map', {
			attributionControl: false
		}).setView([35, -89], 13);
		//L.TileLayer.OpenStreetMap().addTo(map);
		L.tileLayer(CA.globals.const.URL_CM, {styleId: 997}).addTo(map);
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