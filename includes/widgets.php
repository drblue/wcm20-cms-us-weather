<?php

/**
 * Include widget class(es)
 */
require(WW_PLUGIN_DIR . 'includes/class.CurrentWeatherWidget.php');

/**
 * Register widget(s)
 */
function ww_widgets_init() {
	register_widget('CurrentWeatherWidget');
}
add_action('widgets_init', 'ww_widgets_init');
