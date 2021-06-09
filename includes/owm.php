<?php
/**
 * Functions for communicating with the OpenWeatherMap API
 */

function owm_get_current_weather($location) {
	// 1. Construct transient key for location
	$location_slug = str_replace(' ', '_', strtolower(trim($location)));
	$transient_key = "owm_cw_" . $location_slug;

	// 2. Try to get cached data using transient key
	$data = get_transient($transient_key);

	if ($data === false) {
		// 3. No (or expired) cached data exists, get new, fresh data

		// 4. Get current weather from OpenWeatherMap's API
		$response = wp_remote_get("https://api.openweathermap.org/data/2.5/weather?q={$location}&units=metric&appid=" . ww_get_owm_appid());

		// 5. Make sure we got a valid response
		if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
			return false;
		}

		// 6. Fetch body and decode it
		$body = wp_remote_retrieve_body($response);
		$payload = json_decode($body);

		// 7. Extract needed data
		$data = [];
		$data['temperature'] = $payload->main->temp;
		$data['feels_like'] = $payload->main->feels_like;
		$data['humidity'] = $payload->main->humidity;
		$data['cloudiness'] = $payload->clouds->all;
		$data['wind_speed'] = $payload->wind->speed;
		$data['wind_direction'] = $payload->wind->deg;

		// 8. Cache data for location
		set_transient($transient_key, $data, 10 * MINUTE_IN_SECONDS);
	}

	// 9. Return data to caller
	return $data;
}
