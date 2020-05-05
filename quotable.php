<?php
/**
 * Plugin entry point
 *
 * @link              https://iamlocaljo.com
 * @since             1.0.0
 * @package           Quotable
 *
 * @wordpress-plugin
 * Plugin Name:       Quotable
 * Plugin URI:        https://iamlocaljo.com
 * Description:       Adds buttons to quotes and text selection that make it quick and easy for your readers to share quotes from your website.
 * Version:           2.1.0
 * Author:            Jo Sprague
 * Author URI:        https://iamlocaljo.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       quotable
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'QUOTABLE_VERSION', '2.1.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-quotable-activator.php
 */
function activate_quotable() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quotable-activator.php';
	Quotable_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-quotable-deactivator.php
 */
function deactivate_quotable() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-quotable-deactivator.php';
	Quotable_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_quotable' );
register_deactivation_hook( __FILE__, 'deactivate_quotable' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-quotable.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_quotable() {

	$plugin = new Quotable();
	$plugin->run();

}
run_quotable();
