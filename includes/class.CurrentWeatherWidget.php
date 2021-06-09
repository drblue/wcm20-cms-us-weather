<?php

class CurrentWeatherWidget extends WP_Widget {

	const DEFAULT_NBR_POSTS_TO_SHOW = 3;

	/**
	 * Construct a new widget instance.
	 */
	public function __construct() {
		parent::__construct(
			'wcm20-weather-current-weather-widget', // Base ID
			'Current Weather', // Name
			[
				'description' => 'Widget for displaying the current weather at a specific location.',
			]
		);
	}

	/**
	 * Front-end display of the widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved option values for this specific instance of the widget.
	 * @return void
	 */
	public function widget($args, $instance) {
		// start widget
		echo $args['before_widget'];

		// render title
		if (!empty($instance['title'])) {
			echo $args['before_title'] . $instance['title'] . $args['after_title'];
		}

		// render output
		if (!empty($instance['location'])) {

			// get current weather for location
			$weather = owm_get_current_weather($instance['location']);
			if ($weather) {
				/**
				 *	$data['temperature'] = $payload->main->temp;
				 *	$data['feels_like'] = $payload->main->feels_like;
				 *	$data['humidity'] = $payload->main->humidity;
				 *	$data['cloudiness'] = $payload->clouds->all;
				 *	$data['wind_speed'] = $payload->wind->speed;
				 *	$data['wind_direction'] = $payload->wind->deg;
				 */
				?>
					<div class="current-weather">
						<div class="current-weather-conditions">
							<?php foreach($weather['conditions'] as $condition) : ?>
								<div class="current-weather-condition">
									<img
										src="<?php echo $condition['image']; ?>"
										class="img-fluid"
										alt="<?php echo $condition['description']; ?>"
										title="<?php echo $condition['description']; ?>"
									>

									<?php echo $condition['main']; ?>
								</div>
							<?php endforeach; ?>
						</div>

						<div class="current-weather-temperature">
							<?php echo $weather['temperature']; ?>&deg;C
						</div>

						<div class="current-weather-feels-like">
							<span class="label">Feels like:</span> <?php echo $weather['feels_like']; ?>&deg;C
						</div>

						<div class="current-weather-humidity">
							<span class="label">Humidity:</span> <?php echo $weather['humidity']; ?>&percnt;
						</div>

						<div class="current-weather-cloudiness">
							<span class="label">Cloudiness:</span> <?php echo $weather['cloudiness']; ?>&percnt;
						</div>

						<div class="current-weather-wind">
							<span class="label">Wind:</span> <?php echo $weather['wind_speed']; ?> m/s in <?php echo $weather['wind_direction']; ?>&deg;
						</div>
					</div>
				<?php
			} else {
				?><p><em>Error retrieving weather for this location.</em></p><?php
			}

		} else {

			echo "<p><em>No location is set for this widget.</em></p>";

		}

		// end widget
		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Current saved values for this instance of the widget.
	 * @return void
	 */
	public function form($instance) {
		// do we have a title set? if so, use it, otherwise set empty title
		$title = isset($instance['title'])
			? $instance['title']
			: get_option('ww_default_title', __('Current Weather', 'ww'));

		// do we have a location set? if so, use it, otherwise set location to null
		$location = isset($instance['location'])
			? $instance['location']
			: null;

		?>
			<!-- title -->
			<p>
				<label for="<?php echo $this->get_field_id('title') ?>">Title:</label>

				<input
					class="widefat"
					id="<?php echo $this->get_field_id('title') ?>"
					name="<?php echo $this->get_field_name('title') ?>"
					type="text"
					value="<?php echo $title; ?>"
				>
			</p>

			<!-- location -->
			<p>
				<label for="<?php echo $this->get_field_id('location') ?>">Location:</label>

				<input
					class="widefat"
					id="<?php echo $this->get_field_id('location') ?>"
					name="<?php echo $this->get_field_name('location') ?>"
					type="text"
					value="<?php echo $location; ?>"
				>
			</p>
		<?php
	}

	/**
	 * Sanitize widget form data before they are saved to the database.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Form values just sent to be saved.
	 * @param array $old_instance Currently saved values.
	 * @return void
	 */
	public function update($new_instance, $old_instance) {
		$instance = [];

		$instance['title'] = (!empty($new_instance['title']))
			? strip_tags($new_instance['title'])
			: '';

		$instance['location'] = (!empty($new_instance['location']))
			? strip_tags($new_instance['location'])
			: null;

		return $instance;
	}
}
