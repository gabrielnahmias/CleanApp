<?php
require "common.php";

header("Content-type: text/javascript");

// Get the file and json_decode(), go through the objects,
// adding OSM IDs to each, then json_encode() it and output
// as a string where file_get_contents() is below.

?>CA.globals.data.world = <?php echo file_get_contents($file); ?>;