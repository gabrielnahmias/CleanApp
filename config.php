<?php

// Configuration settings

define("CONFIG_DEBUG", true);

// Constants

// Basic
define("NAME", "CleanApp");
define("NAME_RESPONDER", "Add Responder Data");
define("SEP", " - ");
define("MOTTO", "Restoring the Planet");
define("TITLE", NAME.SEP.MOTTO);

// Versions
define("VER", "2.0");
define("VER_JQ", "1.10.2");
define("VER_JQUI", "1.10.3");

// Directories
define("DIR_ASSETS", "assets");
define("DIR_CSS", DIR_ASSETS."/css");
define("DIR_CLS", DIR_ASSETS."/cls");
define("DIR_DATA", DIR_ASSETS."/data");
define("DIR_IMG", DIR_ASSETS."/img");
define("DIR_APPLE", DIR_IMG."/apple");
define("DIR_APPLE_ICONS", DIR_APPLE."/icons");
define("DIR_APPLE_SPLASH", DIR_APPLE."/splash");
define("DIR_INC", DIR_ASSETS."/inc");
define("DIR_JS", DIR_ASSETS."/js");
define("DIR_CON", DIR_JS."/Console");
define("DIR_JQUI", DIR_JS."/jquery-ui");
define("DIR_LEAF", DIR_JS."/leaflet");
define("DIR_LEAF_PLUG", DIR_JS."/leaflet/plugins");

// Files
define("FILE_WORLD", DIR_DATA."/world.geojson");
define("FILE_GETDATA", "get_data.php");
define("FILE_GETWORLD", "get_world.php");