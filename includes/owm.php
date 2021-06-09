<?php
/**
 * Functions for communicating with the OpenWeatherMap API
 */

function owm_get_json($url) {
	// Get data from remote URL
	$response = wp_remote_get($url);

	// Make sure we got a valid response
	if (is_wp_error($response) || wp_remote_retrieve_response_code($response) !== 200) {
		return false;
	}

	// Fetch body and decode it
	$body = wp_remote_retrieve_body($response);
	$payload = json_decode($body);

	// Return body 🧟‍♂️🧟‍♀️
	return $payload;
}

function owm_get_current_weather($location) {
	// 1. Construct transient key for location
	$location_slug = str_replace(' ', '_', strtolower(trim($location)));
	$transient_key = "owm_cw_" . $location_slug;

	// 2. Try to get cached data using transient key
	$data = get_transient($transient_key);

	// 3. If no cached data exists (or has expired), get new, fresh data
	if ($data === false) {
		// 4. Get current weather from OpenWeatherMap's API
		$payload = owm_get_json("https://api.openweathermap.org/data/2.5/weather?q={$location}&units=metric&appid=" . ww_get_owm_appid());

		// 5. Extract needed data
		$data = [];
		$data['temperature'] = $payload->main->temp;
		$data['feels_like'] = $payload->main->feels_like;
		$data['humidity'] = $payload->main->humidity;
		$data['cloudiness'] = $payload->clouds->all;
		$data['wind_speed'] = $payload->wind->speed;
		$data['wind_direction'] = $payload->wind->deg;

		/*
		$data['conditions'] = [];
		foreach ($payload->weather as $weather) {
			array_push($data['conditions'], [
				'main' => $weather->main,
				'description' => $weather->description,
				'image' => "https://openweathermap.org/img/wn/{$weather->icon}@2x.png",
			]);
		}
		*/
		$data['conditions'] = array_map(function($weather) {
			return [
				'main' => $weather->main,
				'description' => $weather->description,
				'image' => "https://openweathermap.org/img/wn/{$weather->icon}@2x.png",
			];
		}, $payload->weather);

		// 6. Cache data for location
		// set_transient($transient_key, $data, 10 * MINUTE_IN_SECONDS);
	}

	// 7. Return data to caller
	return $data;
}
