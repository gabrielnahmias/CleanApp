<?php
require "common.php";

header("Content-type: text/javascript");

if (isset($_GET['f']))
	$file = $_GET['f'];
else
	die("No file specified (query parameter `f`).");
	
if (isset($_GET['v']))
	$var = $_GET['v'];
else
	die("No variable specified (query parameter `v`).");
?><?=$var?> = <?php echo file_get_contents($file); ?>;