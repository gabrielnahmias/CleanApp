<?php
if (isset($_GET['id']))
	$id = $_GET['id'];
else
	$id = NULL;
$db = new PDO("sqlsrv:Server=localhost;Database=TERRASOFT", 'Gabriel-PC\Gabriel', "shitfuck1");
?>