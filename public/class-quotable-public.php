<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://iamlocaljo.com
 * @since      1.0.0
 *
 * @package    Quotable
 * @subpackage Quotable/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Quotable
 * @subpackage Quotable/public
 * @author     Jo Sprague <josiah.sprague@gmail.com>
 */
class Quotable_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->container_id = $plugin_name . '-content';
		$this->version = $version;

	}

	/**
	 * Determine which quotable features are active
	 *
	 * @return is_active An array of features and booleans
	 * with their activation state
	 */
	public function get_active() {
		$post_meta = get_post_meta(get_the_ID());
		$is_post_blockquote_disabled = $post_meta['_quotable_blockquote_disable'][0];
		$is_post_text_disabled = $post_meta['_quotable_text_disable'][0];
		$activation = get_option( 'quotable_activation' );
		$is_blockquote_enabled = isset( $activation['blockquotes'] ) ;
		$is_text_enabled = isset( $activation['textselection'] ) ;
		$is_active = array(
			"blockquotes" => $is_blockquote_enabled && !$is_post_blockquote_disabled,
			"textSelection" => $is_text_enabled && !$is_post_text_disabled
		);
		return $is_active;
	}

	/**
	 * Add quotable classname to content
	 *
	 * @param str $content the post content passed in by the_content filter.
	 * @return $content the post content, wrapped in quotablecontent class if active
	 */
	public function quotable_filter_content( $content ) {
		if ( is_singular() && is_main_query() ) {
			$is_active = $this->get_active();
			if ($is_active['blockquotes'] || $is_active['textSelection']) {
				$content = '<div id="' . $this->container_id . '">' . $content . '</div>';
			}
		}
		return $content;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Quotable_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quotable_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quotable-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * An instance of this class should be passed to the run() function
		 * defined in Quotable_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Quotable_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		$script_name = 'quotable-public';
		$postMeta = get_post_meta(get_the_ID());
		$host = isset( $_SERVER['HTTP_HOST'] ) // Input var okay.
			? sanitize_text_field( wp_unslash(
				$_SERVER['HTTP_HOST'] // Input var okay.
			) ) : '';
		$request_uri = isset( $_SERVER['REQUEST_URI'] ) // Input var okay.
			? sanitize_text_field( wp_unslash(
				$_SERVER['REQUEST_URI'] // Input var okay.
			) ) : '';
		$pageurl     = esc_url_raw(
			( is_ssl() ? 'https://' : 'http://' ) . $host . $request_uri
		);
		$tag_names = function($tag) {
			return $tag->name;
		};
		$tags = get_the_tags() ? array_map($tag_names, get_the_tags()) : array();
		$post_author_id = get_post_field( 'post_author', $post->ID );
		$options = array (
			"containerId" => $this->container_id,
			"isActive" => $this->get_active(),
			"authorTwitter"   => get_the_author_meta( 'twitter', $post_author_id ),
			"siteSocial"  => get_option( 'wpseo_social' ),
			"tags" => $tags,
			"pageUrl" => $pageurl
		);

		$public_bundle = include( plugin_dir_path( __FILE__ ) . 'bundle.asset.php');
		wp_register_script(
				$script_name,
				plugins_url( 'bundle.js', __FILE__ ),
				$public_bundle['dependencies'],
				$public_bundle['version']
		);

		wp_enqueue_script( $script_name );

		wp_localize_script( $script_name, 'wpQuotable', $options );

	}

}
