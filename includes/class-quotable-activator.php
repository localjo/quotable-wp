<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @link       https://iamlocaljo.com
 * @since      1.0.0
 * @package    Quotable
 * @subpackage Quotable/includes
 * @author     Jo Sprague <josiah.sprague@gmail.com>
 */
class Quotable_Activator {

	/**
	 * Set transient indicating that plugin was just activated
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		set_transient( 'quotable_activated', 1 );
	}

}
