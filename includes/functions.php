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

	wp_enqueue_script('wcm20-weather', WW_PLUGIN_URL . "assets/js/wcm20-weather.js", [], "0.1", true);
	wp_localize_script('wcm20-weather', 'ww_settings', [
		'ajax_url' => admin_url('admin-ajax.php'),
	]);
}
add_action('wp_enqueue_scripts', 'ww_enqueue_styles');

/**
 * Respond to incoming ajax-request with action "ww_get_current_weather"
 *
 * @return void
 */
function ww_ajax_get_current_weather() {

	$location = $_REQUEST['location'];
	if (empty($location)) {
		wp_send_json_error("No location set!");
	}

	// get current weather
	$weather_response = owm_get_current_weather($location);

	// did we get current weather?
	if (!$weather_response['success']) {
		wp_send_json_error("Could not get current weather for location {$location} 😢");
	}

	// respond with current weather
	wp_send_json_success($weather_response['data']);
}
add_action('wp_ajax_ww_get_current_weather', 'ww_ajax_get_current_weather');
add_action('wp_ajax_nopriv_ww_get_current_weather', 'ww_ajax_get_current_weather');
