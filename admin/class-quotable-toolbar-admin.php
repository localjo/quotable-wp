<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://iamlocaljo.com
 * @since      1.0.0
 *
 * @package    Quotable_Toolbar
 * @subpackage Quotable_Toolbar/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Quotable_Toolbar
 * @subpackage Quotable_Toolbar/admin
 * @author     Jo Sprague <josiah.sprague@gmail.com>
 */
class Quotable_Toolbar_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Quotable_Toolbar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quotable_Toolbar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quotable-toolbar-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Quotable_Toolbar_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quotable_Toolbar_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$admin_bundle = include( plugin_dir_path( __FILE__ ) . 'bundle.asset.php');
		wp_register_script(
				'quotable-admin',
				plugins_url( 'bundle.js', __FILE__ ),
				$admin_bundle['dependencies'],
				$admin_bundle['version']
		);

		wp_enqueue_script( 'quotable-admin' );

	}

}
