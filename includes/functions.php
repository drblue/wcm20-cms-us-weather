<?php

if (!function_exists('pre')) {
	/**
	 * Print human-readable information about a variable, wrapped in HTML `<pre>`-tags.
	 *
	 * @param mixed $obj
	 * @return string
	 */
	function pre($obj) {
		return sprintf("<pre>%s</pre>", print_r($obj, true));
	}
}

function ww_get_owm_appid() {
	return WW_OWM_APPID;
}

function ww_enqueue_styles() {
	wp_enqueue_style('wcm20-weather-styles', WW_PLUGIN_URL . "assets/css/wcm20-weather.css", [], "0.1", "screen");
}
add_action('wp_enqueue_scripts', 'ww_enqueue_styles');
