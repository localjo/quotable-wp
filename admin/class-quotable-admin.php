<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://iamlocaljo.com
 * @since      1.0.0
 *
 * @package    Quotable
 * @subpackage Quotable/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Quotable
 * @subpackage Quotable/admin
 * @author     Jo Sprague <josiah.sprague@gmail.com>
 */
class Quotable_Admin {

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
	 * Add Twitter contact method to WP user profiles if it doesn't already exist.
	 * Yoast's WP SEO also adds this.
	 *
	 * @param array $user_contact an array of user contact methods.
	 * @return user_contact
	 */
	public function add_twitter_contactmethod( $user_contact ) {
		if ( ! isset( $user_contact['twitter'] ) ) {
			$user_contact['twitter'] = 'Twitter';
		}
		return $user_contact;
	}

	/**
	 * Set default settings for quotable
	 */
	function quotable_default_settings() {
		$defaults = array(
			'blockquotes'   => true,
			'textselection' => true,
		);
		return apply_filters( 'quotable_default_settings', $defaults );
	}

	/**
	 * Initialize Quotable Settings
	 */
	public function quotable_settings_init() {
		// Check if settings exist before adding the defaults.
		if ( false === get_option( 'quotable_activation' ) ) {
			add_option(
				'quotable_activation',
				apply_filters( 'quotable_default_settings', quotable_default_settings() )
			);
		}

		add_settings_section(
			'quotable_settings',
			'Quotable',
			array( $this, 'quotable_settings_section_setup' ),
			'discussion'
		);

		add_settings_field(
			'quotable_activation',
			'Quotable Features',
			array( $this, 'quotable_activation_setting_setup' ),
			'discussion',
			'quotable_settings'
		);

		register_setting( 'discussion', 'quotable_activation' );
	}

	/**
	 * Add settings description markup
	 */
	function quotable_settings_section_setup() {
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-settings-header.php' );
	}

	/**
	 * Set up Quotable's activation settings markup
	 */
	function quotable_activation_setting_setup() {
		$is_activated = (array) get_option( 'quotable_activation' );
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-settings-checkboxes.php' );
	}

	/**
	 * Add link to Quotable settings from plugin list
	 */
	function quotable_add_plugin_page_settings_link( $links ) {
		$links[] = '<a href="' .
			admin_url( 'options-discussion.php#quotable-settings' ) .
			'">' . __('Settings') . '</a>';
		return $links;
	}


	/**
	 * Add upgrade notice text to plugin list
	 */
	function show_upgrade_notification($existing_metadata, $new_metadata = NULL){
		if (isset($new_metadata->upgrade_notice) && strlen(trim($new_metadata->upgrade_notice)) > 0){
			echo '<br><br><strong>Upgrade Notice:</strong> ';
			echo esc_html($new_metadata->upgrade_notice);
		}
	}

	/**
	 * Set upgrade transient value used to trigger admin notice
	 */
	function set_upgrade_transient($upgrader_object, $options){
		$basename = plugin_basename( __FILE__ );
		if( $options['action'] == 'update' && $options['type'] == 'plugin' && isset( $options['plugins'] ) ) {
			foreach( $options['plugins'] as $plugin ) {
				if( $plugin == $basename ) {
					set_transient( 'quotable_updated', 1 );
				}
			}
		}
	}

	/**
	 * Show a notice when the plugin has been updated
	 */
	function display_update_notice() {
		if( get_transient( 'quotable_updated' ) ) {
			$link = '<a href="' . esc_url( 'https://www.patreon.com/localjo' ) . '">' 
			. __( 'please consider becoming a Patron.', 'quotable' )
			. '</a>';
			echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Thank you for updating Quotable. If you\'ve found my plugin useful,', 'quotable' ) . ' ' . $link . '</p></div>';
			delete_transient( 'quotable_updated' );
		}
	 }

	/**
	 * Show a notice when the plugin has been updated
	 */
	 function display_install_notice() {
		if( get_transient( 'quotable_activated' ) ) {
			$link = '<a href="' . esc_url( 'https://www.patreon.com/localjo' ) . '">' 
			. __( 'become a Patron.', 'quotable' )
			. '</a>';
			echo '<div id="message" class="updated notice is-dismissible"><p>' . __( 'Thank you for installing Quotable. For exclusive updates,', 'quotable' ) . ' ' . $link . '</p></div>';
			delete_transient( 'quotable_activated' );
		}
	 }

	/**
	 * Register Quotable meta fields
	 */
	function quotable_register_post_meta() {
		$screens = array( 'post', 'page' );
		foreach ( $screens as $screen ) {
			register_post_meta( $screen, '_quotable_text_disable', array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'boolean',
					'auth_callback' => function() {
						return current_user_can( 'edit_posts' );
					}
			) );
			register_post_meta( $screen, '_quotable_blockquote_disable', array(
					'show_in_rest' => true,
					'single' => true,
					'type' => 'boolean',
					'auth_callback' => function() {
						return current_user_can( 'edit_posts' );
					}
			) );
		}
	}

	/**
	 * Add Quotable metabox (for classic editor)
	 */
	public function quotable_add_meta_box() {
		$screens = array( 'post', 'page' );
		foreach ( $screens as $screen ) {
			add_meta_box(
				'quotable_sectionid',
				__( 'Quotable', 'quotable' ),
				array( $this, 'quotable_meta_box_callback' ),
				$screen, 
				'normal', 
				'default',
				array('__back_compat_meta_box' => true)
			);
		}
	}

	/**
	 * Set up quotable metabox contents for a post
	 *
	 * @param WP_POST $post A post object.
	 */
	function quotable_meta_box_callback( $post ) {
		wp_nonce_field( 'quotable_meta_box', 'quotable_meta_box_nonce' );
		$post_id             = $post->ID;
		$blockquote_value    = get_post_meta(
			$post_id,
			'_quotable_blockquote_disable',
			true
		);
		$textselection_value = get_post_meta(
			$post_id,
			'_quotable_text_disable',
			true
		);
		include( plugin_dir_path( __FILE__ ) . 'partials/' . $this->plugin_name . '-metabox.php' );
	}

	/**
	 * Save metabox data
	 *
	 * @param int $post_id The post id to save the metabox data to.
	 */
	public function quotable_save_meta_box_data( $post_id ) {
		if (
			! isset( $_POST['quotable_meta_box_nonce'] ) || // Input var okay.
			! wp_verify_nonce(
				sanitize_key( $_POST['quotable_meta_box_nonce'] ), // Input var okay.
				'quotable_meta_box'
			) ||
			! ( current_user_can( 'edit_post', $post_id ) ||
			current_user_can( 'edit_page', $post_id ) ) ||
			( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		) {
			return $post_id;
		}

		if ( isset( $_POST['quotable_blockquote_disable'] ) ) { // Input var okay.
			$quotable_blockquote_disable_value = sanitize_text_field(
				wp_unslash( $_POST['quotable_blockquote_disable'] ) // Input var okay.
			);
			update_post_meta(
				$post_id,
				'_quotable_blockquote_disable',
				$quotable_blockquote_disable_value
			);
		} else {
			update_post_meta( $post_id, '_quotable_blockquote_disable', false );
		}

		if ( isset( $_POST['quotable_text_disable'] ) ) { // Input var okay.
			$quotable_text_disable_value = sanitize_text_field(
				wp_unslash( $_POST['quotable_text_disable'] ) // Input var okay.
			);
			update_post_meta(
				$post_id,
				'_quotable_text_disable',
				$quotable_text_disable_value
			);
		} else {
			update_post_meta( $post_id, '_quotable_text_disable', false );
		}

	}

	/**
	 * Add quotable status classes to admin body
	 * Used for editor styles
	 *
	 * @since    2.0.0
	 */
	public function add_quotable_status_classes($classes) {
		$post_meta = get_post_meta(get_the_ID());
		$is_post_blockquote_disabled = $post_meta['_quotable_blockquote_disable'][0];
		$activation = get_option( 'quotable_activation' );
		$is_blockquote_enabled = isset( $activation['blockquotes'] ) ;
		$is_active = $is_blockquote_enabled && !$is_post_blockquote_disabled;
		if ($is_active) {
			$classes = $classes . ' quotable-active';
		}
		return $classes;
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$admin_bundle = include( plugin_dir_path( __FILE__ ) . 'bundle.asset.php');
		wp_register_script(
				'quotable-admin',
				plugins_url( 'bundle.js', __FILE__ ),
				$admin_bundle['dependencies'],
				$admin_bundle['version']
		);
		wp_enqueue_script( 'quotable-admin' );
	}

	/**
	 * Register the styles for the block editor
	 *
	 * @since    2.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/quotable-editor.css', array(), $this->version, 'all' );
	}

}
