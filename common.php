<?php

require_once "config.php";
require_once DIR_CLS."/Browser/Browser.php";
require_once DIR_CLS."/Web.php";

$br = new Browser();

// Normalize some commonly referred-to values.
$browser = $br->getBrowserArray();
// Possible future overrides:
//$browser['classString'] = $br->getClassString("", true, true, true, true);

//$db = mysql_connect("localhost", "gabriel", "shitfuck1");