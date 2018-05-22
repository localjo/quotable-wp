<?php
/**
 * Quotable
 *
 * @package     Quotable
 * @author      Jo Sprague
 * @copyright   2018 Jo Sprague
 * @license     MIT
 *
 * @wordpress-plugin
 * Plugin Name: Quotable
 * Plugin URI: https://github.com/localjo/quotable-wp
 * Description: A plugin that helps people share your content via powerful quotes.
 * Version: 1.0.6
 * Author: Jo Sprague
 * Author URI: https://josiahsprague.com/
 * Text Domain: quotable
 * License: MIT
 **/

defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

/**
 * Set up an object with Quotable's data
 *
 * @return quotable_data An object with Quotable's data
 */
function quotable_setup() {
	$host        = isset( $_SERVER['HTTP_HOST'] ) // Input var okay.
		? sanitize_text_field( wp_unslash(
			$_SERVER['HTTP_HOST'] // Input var okay.
		) ) : '';
	$request_uri = isset( $_SERVER['REQUEST_URI'] ) // Input var okay.
		? sanitize_text_field( wp_unslash(
			$_SERVER['REQUEST_URI'] // Input var okay.
		) ) : '';
	$linktext    = ' tweet';
	$pageurl     = esc_url_raw(
		( is_ssl() ? 'https://' : 'http://' ) . $host . $request_uri
	);
	$theauthor   = get_the_author_meta( 'twitter' );
	$social      = get_option( 'wpseo_social' );
	$related     = $social['twitter_site']; // Site's Twitter name from Yoast SEO.
	$posttags    = '';
	$tagarray    = get_the_tags();
	if ( ! empty( $tagarray ) ) {
		foreach ( $tagarray as $tag ) {
			$posttags = $posttags . $tag->name . ',';
		}
	}
	$quotable_data = (object) array(
		'linktext'  => $linktext,
		'permalink' => $pageurl,
		'author'    => $theauthor,
		'related'   => $related,
		'hashtags'  => $posttags,
	);
	return $quotable_data;
}

/**
 * Add Twitter contact method to WP user profiles if it doesn't already exist.
 * Yoast's WP SEO also adds this.
 *
 * @param array $user_contact an array of user contact methods.
 * @return user_contact
 */
function add_twitter_contactmethod( $user_contact ) {
	if ( ! isset( $user_contact['twitter'] ) ) {
		$user_contact['twitter'] = 'Twitter';
	}
	return $user_contact;
}
add_filter( 'user_contactmethods', 'add_twitter_contactmethod', 10, 1 );

/**
 * Add Quotable's CSS and JS to the page
 */
function quotable_scripts() {
	$protocol     = is_ssl() ? 'https://' : 'http://';
	$is_activated = get_option( 'quotable_activation' );
	wp_enqueue_style(
		'quotable',
		plugins_url( '/includes/quotable.css', __FILE__ )
	);
	wp_enqueue_script(
		'twitter-widgets',
		$protocol . '//platform.twitter.com/widgets.js',
		false,
		false,
		true
	);
	if ( $is_activated['textselection'] ) {
		$is_disabled = get_post_meta(
			get_the_ID(),
			'_quotable_text_disable',
			true
		);
		if ( ! $is_disabled ) {
			wp_enqueue_script(
				'quotable',
				plugins_url( '/includes/quotable.js', __FILE__ ),
				array( 'twitter-widgets' ),
				false,
				true
			);
		}
	}
}
add_action( 'wp_enqueue_scripts', 'quotable_scripts' );

/**
 * Print Quotable Toolbar Markup
 */
function quotable_toolbar() {
	if ( is_singular() ) {
		$qd        = quotable_setup();
		$permalink = $qd->permalink;
		$author    = $qd->author;
		$related   = $qd->related;
		$hashtags  = $qd->hashtags;
		$linktext  = $qd->linktext;
		echo '<a
			target="_blank"
			style="visibility: hidden; top: 0; left: 0;"
			href=""
			id="quotable-toolbar"
			data-permalink="' . esc_attr( $permalink ) . '"
			data-author="' . esc_attr( $author ) . '"
			data-related="' . esc_attr( $related ) . '"
			data-hashtags="' . esc_attr( $hashtags ) . '"
				>' . esc_html( $linktext ) . '</a>';
	}
}
add_action( 'wp_footer', 'quotable_toolbar' );

/**
 * Add Quotable button to blockquotes
 *
 * @param str $content the post content passed in by the_content filter.
 */
function quotable_blockquotes( $content ) {
	if ( is_singular() && is_main_query() ) {
		// Wrap the content in a div to use for mouse event listener.
		$content = '<div id="quotablecontent">' . $content . '</div>';

		$is_activated = get_option( 'quotable_activation' );
		if ( isset( $is_activated['blockquotes'] ) ) {

			$is_disabled = get_post_meta(
				get_the_ID(),
				'_quotable_blockquote_disable',
				true
			);
			if ( ! $is_disabled ) {
				// Convert encoding to avoid mis-encoded characters.
				if ( function_exists( 'mb_convert_encoding' ) ) {
					$content = mb_convert_encoding( $content, 'html-entities', 'utf-8' );
				}
				libxml_use_internal_errors( true ); // Hide mal-formed html errors.

				$content_dom = new DomDocument();
				$content_dom->loadHtml( $content );

				$quotable_data = quotable_setup();

				// Get all the blockquotes in the content and loop through them.
				$blockquotes = $content_dom->getElementsByTagName( 'blockquote' );
				foreach ( $blockquotes as $blockquote ) {
					$paragraphs     = $blockquote->getElementsByTagName( 'p' );
					$paragraphcount = $paragraphs->length;
					if ( $paragraphcount > 0 ) {
						foreach ( $paragraphs as $paragraph ) {
							quotable_add_link( $content_dom, $paragraph, $quotable_data );
						}
					} else {
						quotable_add_link( $content_dom, $blockquote, $quotable_data );
					}
				}

				// Remove doctype and parent nodes added by DomDocument.
				// @codingStandardsIgnoreStart
				$content_dom->removeChild( $content_dom->firstChild );
				$content_dom->replaceChild(
					$content_dom->firstChild->firstChild->firstChild,
					$content_dom->firstChild
				);
				$content = $content_dom->saveHtml();
				// @codingStandardsIgnoreEnd
			}
		}
	}
	return $content;
}
add_filter( 'the_content', 'quotable_blockquotes' );

/**
 * Add quotable link to a content DOM
 *
 * @param DOMDocument $content_dom A DOM representation of content to modify.
 * @param DOMNode     $paragraph The paragraph element to modify.
 * @param arr         $qd An array of Quotable's data.
 */
function quotable_add_link( $content_dom, $paragraph, $qd ) {
	// This span is used to highlight text on mouseover.
	$quote_wrap = $content_dom->createElement( 'span', '' );
	$quote_wrap->setAttribute( 'class', 'quotable-text' );
	// @codingStandardsIgnoreStart
	$tweettext   = $paragraph->nodeValue;
	// @codingStandardsIgnoreEnd
	$permalink   = $qd->permalink;
	$author      = $qd->author;
	$related     = $qd->related;
	$hashtags    = $qd->hashtags;
	$linktext    = $qd->linktext;
	$twitterhref = 'http://twitter.com/intent/tweet?url=' . $permalink .
		'&text=' . $tweettext .
		'&related=' . $related .
		'&hashtags=' . $hashtags;
	if ( ! empty( $author ) ) {
		$twitterhref = $twitterhref . '&via=' . $author;
	}
	$quotelink = $content_dom->createElement( 'a', $linktext );
	$quotelink->setAttribute( 'href', $twitterhref );
	$quotelink->setAttribute( 'class', 'quotable-link' );
	$quotelink->setAttribute( 'target', '_blank' );
	$quotelink->setAttribute( 'title', 'Tweet this!' );

	// DOMElement doesn't have a method to get the innerHTML of an element without
	// stripping out HTML, so this is a workaround.
	// @codingStandardsIgnoreStart
	while ( $paragraph->childNodes->length > 0 ) {
		$child = $paragraph->childNodes->item( 0 );
		// @codingStandardsIgnoreEnd
		$paragraph->removeChild( $child );
		$quote_wrap->appendChild( $child );
	}

	$quote_wrap->appendChild( $quotelink );
	// @codingStandardsIgnoreStart
	$paragraph->nodeValue = '';
	// @codingStandardsIgnoreEnd
	$paragraph->appendChild( $quote_wrap );
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
function quotable_settings_init() {
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
		'quotable_settings_section_setup',
		'discussion'
	);

	add_settings_field(
		'quotable_activation',
		'Activate Quotable',
		'quotable_activation_setting_setup',
		'discussion',
		'quotable_settings'
	);

	register_setting( 'discussion', 'quotable_activation' );
}
add_action( 'admin_init', 'quotable_settings_init' );

/**
 * Add settings description
 */
function quotable_settings_section_setup() {
	echo '<p>If you want to selectively deactivate Quotable functionality ' .
	'site-wide, you can uncheck the boxes below.</p>';
}

/**
 * Set up Quotable's activation settings
 */
function quotable_activation_setting_setup() {
	$is_activated = (array) get_option( 'quotable_activation' );
	echo '<input
		name="quotable_activation[blockquotes]"
		id="quotableActivationBlockquotes"
		type="checkbox"
		value="1"
		class="code" ' .
		checked( 1, $is_activated['blockquotes'], false ) .
	' /> Activate Quotable on blockquotes<br>
	<input
		name="quotable_activation[textselection]"
		id="quotableActivationText"
		type="checkbox"
		value="1"
		class="code" ' .
		checked( 1, $is_activated['textselection'], false ) .
	' /> Activate Quotable on text selection.';
}

/**
 * Add Quotable metabox
 */
function quotable_add_meta_box() {
	$screens = array( 'post', 'page' );
	foreach ( $screens as $screen ) {
		add_meta_box(
			'quotable_sectionid',
			__( 'Quotable', 'quotable' ),
			'quotable_meta_box_callback',
			$screen
		);
	}
}
add_action( 'add_meta_boxes', 'quotable_add_meta_box' );

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

	echo '<label for="quotable_blockquote_disable">
		<input
			type="checkbox"
			id="quotable_blockquote_disable"
			name="quotable_blockquote_disable"
			value="1" ' .
			checked( 1, $blockquote_value, false ) .
		' />';
	esc_html_e( 'Disable Quotable for blockquotes on this page.', 'quotable' );
	echo '</label> <br>';
	echo '<label for="quotable_text_disable">
		<input
			type="checkbox"
			id="quotable_text_disable"
			name="quotable_text_disable"
			value="1" ' .
			checked( 1, $textselection_value, false ) .
		' />';
	esc_html_e( 'Disable Quotable for text selection on this page.', 'quotable' );
	echo '</label> ';
}

/**
 * Save metabox data
 *
 * @param int $post_id The post id to save the metabox data to.
 */
function quotable_save_meta_box_data( $post_id ) {
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
add_action( 'save_post', 'quotable_save_meta_box_data' );

/**
 * Plugin Localization
 */
function quotable_load_translation_file() {
	$plugin_path = plugin_basename( dirname( __FILE__ ) . '/translations' );
	load_plugin_textdomain( 'quotable', false, $plugin_path );
}
add_action( 'init', 'quotable_load_translation_file' );
