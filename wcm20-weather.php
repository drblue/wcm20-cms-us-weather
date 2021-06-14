<?php
/**
 * Plugin Name:	WCM20 Weather
 * Description:	This plugin adds a widget for viewing the current weather in a specific location
 * Version:		0.1
 * Author:		Johan Nordström
 * Author URI:	https://www.thehiveresistance.com
 * Text Domain:	wcm20-weather
 * Domain Path:	/languages
 */

define('WW_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WW_PLUGIN_URL', plugin_dir_url(__FILE__));
define('WW_OWM_APPID', 'a9f6719e37f20890ebff5d91724dec1f');

/**
 * Include dependencies.
 */
require_once(WW_PLUGIN_DIR . 'includes/functions.php');
require_once(WW_PLUGIN_DIR . 'includes/owm.php');
require_once(WW_PLUGIN_DIR . 'includes/widgets.php');
