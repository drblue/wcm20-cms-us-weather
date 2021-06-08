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
			echo "<p>HERE BE DRAGONS in {$instance['location']} 🐉!</p>";
		} else {
			echo "<p>NO DRAGONS 😢🐉</p>";
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
