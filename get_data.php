<?php
require_once "common.php";

header("Content-type: text/javascript");

if (isset($_GET['f']))
	$file = $_GET['f'];
else
	$file = FILE_WORLD;
	//die("No file specified (query parameter `f`).");
	
if (isset($_GET['v']))
	$var = $_GET['v'];
else
	$var = "var worldData";
	//die("No variable specified (query parameter `v`).");
?><?=$var?> = <?php echo file_get_contents($file); ?>;