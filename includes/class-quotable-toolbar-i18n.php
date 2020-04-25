<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://iamlocaljo.com
 * @since      1.0.0
 *
 * @package    Quotable_Toolbar
 * @subpackage Quotable_Toolbar/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Quotable_Toolbar
 * @subpackage Quotable_Toolbar/includes
 * @author     Jo Sprague <josiah.sprague@gmail.com>
 */
class Quotable_Toolbar_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'quotable-toolbar',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
