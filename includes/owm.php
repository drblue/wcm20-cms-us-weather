<?php
/**
 * Functions for communicating with the OpenWeatherMap API
 */

function owm_get_current_weather($location) {
	// 1. Get current weather from OpenWeatherMap's API
	$response = wp_remote_get("https://api.openweathermap.org/data/2.5/weather?q={$location}&units=metric&appid=" . ww_get_owm_appid());

	// 2. Make sure we got a valid response
	if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
		return false;
	}

	// 3. Fetch body and decode it
	$body = wp_remote_retrieve_body($response);
	$payload = json_decode($body);

	// 4. Extract needed data
	$data = [];
	$data['temperature'] = $payload->main->temp;
	$data['feels_like'] = $payload->main->feels_like;
	$data['humidity'] = $payload->main->humidity;
	$data['cloudiness'] = $payload->clouds->all;
	$data['wind_speed'] = $payload->wind->speed;
	$data['wind_direction'] = $payload->wind->deg;

	// 5. Return data to caller
	return $data;
}
