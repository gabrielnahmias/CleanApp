<?php

require_once "config.php";

class Web {
	public static function debug($val, $title = "Data") {
		if (CONFIG_DEBUG):
			echo "<!--\r\n$title:\r\n".print_r($val, true)."\r\n-->";
		endif;
	}
	public function filter($var, $option = FILTER_SANITIZE_STRING) {
		return filter_var($var, $option);
	}
}