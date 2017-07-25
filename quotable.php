<?php
/*
Plugin Name: Quotable
Plugin URI: https://github.com/localjo/quotable-wp
Description: A plugin that helps people share your content via powerful quotes.
Version: 1.0.2
Author: Jo Sprague
Author URI: http://josiahsprague.com/
Text Domain: quotable
License: MIT

Copyright 2014 Josiah Sprague (email : josiah.sprague@gmail.com)

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/

function quotable_setup() {
  $linktext = " tweet";
  $pageurl = esc_url_raw(( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
  $theauthor = get_the_author_meta('twitter');
  $wpseosocialoptions = get_option("wpseo_social");
  $related = $wpseosocialoptions["twitter_site"]; //Gets site twitter username if Yoast's WP SEO is installed
  $posttags = "";
  $tagarray = get_the_tags();
  if ($tagarray != "") { //Check that there are actually post tags before trying to use them
    foreach($tagarray as $tag) {
      $posttags = $posttags . $tag->name . ",";
    }
  }
  $quotableData = (object) array('linktext' => $linktext, 'permalink' => $pageurl, 'author' => $theauthor, 'related' => $related, 'hashtags' => $posttags);
  return $quotableData;
}

//Add Twitter contact method to WP user profiles if it doesn't already exist. (Yoast's WP SEO also adds this).
function add_twitter_contactmethod( $contactmethods ) {
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = 'Twitter';
  return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_twitter_contactmethod', 10, 1 );

function quotable_scripts() {
  $activation = get_option( 'quotable_activation');
  $textActivation = isset($activation['textselection']) ? $activation['textselection'] : false;

  wp_enqueue_style( 'quotable', plugins_url( "/includes/quotable.css", __FILE__ ) );
  wp_enqueue_script( 'twitter-widgets', ( is_ssl() ? 'https://' : 'http://' ) . '//platformz.twitter.com/widgets.js', false, false, true );
  if( true == $textActivation ) {
    $textdisable = get_post_meta( get_the_ID(), '_quotable_text_disable', true );
    if ( ! $textdisable ) {
      wp_enqueue_script( 'quotable', plugins_url( "/includes/quotable.js", __FILE__ ), array('twitter-widgets'), false, true);
    }
  }
}
add_action( 'wp_enqueue_scripts', 'quotable_scripts' );

function quotable_toolbar() {
  if( is_singular()) {
    $quotableData = quotable_setup();
    $quotableToolbar = "<a target='_blank' style='visibility: hidden; top: 0; left: 0;' href='' id='quotable-toolbar' data-permalink='".$quotableData->permalink."' data-author='".$quotableData->author."' data-related='".$quotableData->related."' data-hashtags='".$quotableData->hashtags."'>".$quotableData->linktext."</a>";
    echo $quotableToolbar;
  }
}
add_action('wp_footer', 'quotable_toolbar'); //This may be theme dependent (some themes may not call wp_footer)

function quotable_blockquotes($content) {
  if( is_singular() && is_main_query() ) {
    //Wrap the content in a div to use for mouse event listener
    $content = "<div id='quotablecontent'>" . $content . "</div>";

    $activation = get_option( 'quotable_activation');
    $blockquoteActivation = isset($activation['blockquotes']) ? $activation['blockquotes'] : false;
    if( true == $blockquoteActivation ) {

      $disable = get_post_meta( get_the_ID(), '_quotable_blockquote_disable', true );
      if ( ! $disable ) {
        //Encoding has to be converted or we'll end up with all kinds of weird characters
        if (function_exists('mb_convert_encoding')){
          $content = mb_convert_encoding($content, 'html-entities', 'utf-8');
        }
        libxml_use_internal_errors(true); //Keep errors from displaying for mal-formed html

        $contentDOM = new DomDocument();
        $contentDOM->loadHtml($content);

        $quotableData = quotable_setup();

        //Get all the blockquotes in the content and loop through them
        $blockquotes = $contentDOM->getElementsByTagName('blockquote');
        foreach ($blockquotes as $blockquote) {
          $paragraphs = $blockquote->getElementsByTagName('p');
          $paragraphcount = $paragraphs->length;
          if ($paragraphcount > 0) {
            foreach($paragraphs as $paragraph) {
              quotable_add_link($contentDOM, $paragraph, $quotableData);
            }
          } else {
            quotable_add_link($contentDOM, $blockquote, $quotableData);
          }
        }

        // remove doctype and parent nodes added by DomDocument
        $contentDOM->removeChild($contentDOM->firstChild);
        $contentDOM->replaceChild($contentDOM->firstChild->firstChild->firstChild, $contentDOM->firstChild);
        $content = $contentDOM->saveHtml();
      }
    }
  }
  return $content;
}
add_filter( 'the_content', 'quotable_blockquotes' );

function quotable_add_link($contentDOM, $paragraph, $quotableData) {
  $quoteWrap = $contentDOM->createElement('span', "");
  $quoteWrap->setAttribute("class", "quotable-text"); //This span is used to highlight text on mouseover

  $tweettext = $paragraph->nodeValue;
  $twitterhref = "http://twitter.com/intent/tweet?url=".$quotableData->permalink."&text=".$tweettext."&via=".$quotableData->author."&related=".$quotableData->related."&hashtags=".$quotableData->hashtags;
  $quotelink = $contentDOM->createElement('a', $quotableData->linktext);
  $quotelink->setAttribute("href", $twitterhref);
  $quotelink->setAttribute("class", "quotable-link");
  $quotelink->setAttribute("target", "_blank");
  $quotelink->setAttribute("title", "Tweet this!");

  //DOMElement doesn't have a method to get the innerHTML of an element without stripping out HTML, so this is a workaround
  while ($paragraph->childNodes->length > 0) {
    $child = $paragraph->childNodes->item(0);
    $paragraph->removeChild($child);
    $quoteWrap->appendChild($child);
  }

  $quoteWrap->appendChild($quotelink);
  $paragraph->nodeValue = "";
  $paragraph->appendChild($quoteWrap);
}

function quotable_default_settings() {
  $defaults = array(
    'blockquotes'   =>  true,
    'textselection'    =>  true,
    );
  return apply_filters( 'quotable_default_settings', $defaults );
}

function quotable_settings_init() {
  // Check if settings exist before adding the defaults
  if( false == get_option( 'quotable_activation' ) ) {
    add_option( 'quotable_activation', apply_filters( 'quotable_default_settings', quotable_default_settings() ) );
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

function quotable_settings_section_setup() {
  echo '<p>If you want to selectively deactivate Quotable functionality site-wide, you can uncheck the boxes below.</p>';
}

function quotable_activation_setting_setup($args) {
  $activation = (array) get_option('quotable_activation');
  $blockquoteActivation = isset($activation['blockquotes']) ? $activation['blockquotes'] : false;
  $textActivation = isset($activation['textselection']) ? $activation['textselection'] : false;
  echo '<input name="quotable_activation[blockquotes]" id="quotableActivationBlockquotes" type="checkbox" value="1" class="code" ' . checked( 1, $blockquoteActivation, false ) . ' /> Activate Quotable on blockquotes<br>';
  echo '<input name="quotable_activation[textselection]" id="quotableActivationText" type="checkbox" value="1" class="code" ' . checked( 1, $textActivation, false ) . ' /> Activate Quotable on text selection.';
}

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

function quotable_meta_box_callback( $post ) {
  wp_nonce_field( 'quotable_meta_box', 'quotable_meta_box_nonce' );
  $blockquoteValue = get_post_meta( $post->ID, '_quotable_blockquote_disable', true );
  $textselectionValue = get_post_meta( $post->ID, '_quotable_text_disable', true );

  echo '<label for="quotable_blockquote_disable">';
  echo '<input type="checkbox" id="quotable_blockquote_disable" name="quotable_blockquote_disable" value="1" ' . checked( 1, $blockquoteValue, false ) . ' />';
  _e( 'Disable Quotable for blockquotes on this page.', 'quotable' );
  echo '</label> <br>';

  echo '<label for="quotable_text_disable">';
  echo '<input type="checkbox" id="quotable_text_disable" name="quotable_text_disable" value="1" ' . checked( 1, $textselectionValue, false ) . ' />';
  _e( 'Disable Quotable for text selection on this page.', 'quotable' );
  echo '</label> ';
}

function quotable_save_meta_box_data( $post_id ) {
  if ( ! isset( $_POST['quotable_meta_box_nonce'] ) ) {
    return;
  }
  if ( ! wp_verify_nonce( $_POST['quotable_meta_box_nonce'], 'quotable_meta_box' ) ) {
    return;
  }
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return;
  }
  if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {
    if ( ! current_user_can( 'edit_page', $post_id ) ) {
      return;
    }
  } else {
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
      return;
    }
  }

  $my_data = sanitize_text_field( $_POST['quotable_blockquote_disable'] );
  update_post_meta( $post_id, '_quotable_blockquote_disable', $my_data );

  $my_data2 = sanitize_text_field( $_POST['quotable_text_disable'] );
  update_post_meta( $post_id, '_quotable_text_disable', $my_data2 );

}
add_action( 'save_post', 'quotable_save_meta_box_data' );

// Plugin Localization
function quotable_load_translation_file() {
  $plugin_path = plugin_basename( dirname( __FILE__ ) .'/translations' );
  load_plugin_textdomain( 'quotable', '', $plugin_path );
}
add_action('init', 'quotable_load_translation_file');
