<?php
/**
 * Plugin Name:	WCM20 Weather
 * Description:	This plugin adds a widget for viewing the current weather in a specific location
 * Version:		0.1
 * Author:		Johan Nordström
 * Author URI:	https://www.thehiveresistance.com
 * Text Domain:	ww
 * Domain Path:	/languages
 */

define('WW_PLUGIN_DIR', plugin_dir_path(__FILE__));

/**
 * Include dependencies.
 */
require_once(WW_PLUGIN_DIR . 'includes/functions.php');
require_once(WW_PLUGIN_DIR . 'includes/owm.php');
require_once(WW_PLUGIN_DIR . 'includes/widgets.php');
