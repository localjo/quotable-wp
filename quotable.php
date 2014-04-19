<?php
/*
Plugin Name: Quotable
Plugin URI: http://josiahsprague.com/quotable
Description: A plugin that helps people share your content via powerful quotes.
Version: 0.3
Author: Josiah Sprague
Author URI: http://josiahsprague.com
Text Domain: quotable
License: GPL2

Copyright 2014 Josiah Sprague (email : info@josiahsprague.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

function quotable_setup() {
  $linktext = " tweet";
  $pageurl = get_permalink();
  $theauthor = get_the_author_meta('twitter');
  $wpseosocialoptions = get_option("wpseo_social");
  $related = $wpseosocialoptions["twitter_site"]; //Gets site twitter username if Yoast's WP SEO is installed
  $posttags = "";
  $tagarray = get_the_tags();
  if ($tagarray != "") { //Check that there are actually post tage before trying to use them
    foreach($tagarray as $tag) {
      $posttags = $posttags . $tag->name . ",";
    }
  }
  $quotableData = (object) array('linktext' => $linktext, 'permalink' => $pageurl, 'author' => $theauthor, 'related' => $related, 'hashtags' => $posttags);
  return $quotableData;
}

//Add Twitter contact method to WP user profiles if it doesn't already exist
function add_twitter_contactmethod( $contactmethods ) {
  if ( !isset( $contactmethods['twitter'] ) )
    $contactmethods['twitter'] = 'Twitter';
  return $contactmethods;
}
add_filter( 'user_contactmethods', 'add_twitter_contactmethod', 10, 1 );

function quotable_scripts() {
	wp_enqueue_style( 'quotable', plugins_url( "/includes/quotable.css", __FILE__ ) );
  wp_enqueue_script( 'twitter-widgets', 'http://platform.twitter.com/widgets.js' );
	wp_enqueue_script( 'quotable', plugins_url( "/includes/quotable.js", __FILE__ ), array('twitter-widgets'));
}

add_action( 'wp_enqueue_scripts', 'quotable_scripts' );

function quotable_toolbar() {
  if( is_singular()) {
      $quotableData = quotable_setup();
      $quotableToolbar = "<a target='_blank' style='visibility: hidden; top: 0; left: 0;' href='' id='quotable-toolbar' data-permalink='".$quotableData->permalink."' data-author='".$quotableData->author."' data-related='".$quotableData->related."' data-hashtags='".$quotableData->hashtags."'>".$quotableData->linktext."</a>";
      echo $quotableToolbar;
    }
}
//This may be theme dependent (some themes may not call wp_footer)
add_action('wp_footer', 'quotable_toolbar');

function quotable_blockquotes($content) {
  if( is_singular() && is_main_query() ) {

      //Wrap the content in a div to give it an easy ID handle for selection sharing
      $content = "<div id='quotablecontent'>" . $content . "</div>";
      //Encoding has to be converted or we'll end up with all kinds of jank
      if (function_exists('mb_convert_encoding')){
        $content = mb_convert_encoding($content, 'html-entities', 'utf-8');
      }

      // Add twitter icon button to end of blockquotes

      $contentDOM = new DomDocument();
      $contentDOM->loadHtml($content);

      $quotableData = quotable_setup();

        //Get all the blockquotes in the content and loop through them
        $blockquotes = $contentDOM->getElementsByTagName('blockquote');
        foreach ($blockquotes as $blockquote) {

            $paragraphs = $blockquote->getElementsByTagName('p');

            //If there are paragraphs, append the link individually.
            $paragraphcount = $paragraphs->length;
            if ($paragraphcount > 0) {

                foreach($paragraphs as $paragraph) {

                    $paragraph->setAttribute("class", "quotable-p");
                    $quoteWrap = $contentDOM->createElement('span', $paragraph->nodeValue);
                    $quoteWrap->setAttribute("class", "quotable-span");
                    $paragraph->nodeValue = "";
                    $paragraph->appendChild($quoteWrap);

                    $tweettext = $paragraph->nodeValue;
                    //$tweettext = (strlen($tweettext) > 140) ? substr($tweettext,0,120).'...' : $tweettext;
                    $twitterhref = "http://twitter.com/intent/tweet?url=".$quotableData->permalink."&text=".$tweettext."&via=".$quotableData->author."&related=".$quotableData->related."&hashtags=".$quotableData->hashtags;
                    $quotelink = $contentDOM->createElement('a', $quotableData->linktext);
                    $quotelink->setAttribute("href", $twitterhref);
                    $quotelink->setAttribute("class", "quotable-link");
                    $quotelink->setAttribute("target", "_blank");
                    $quotelink->setAttribute("title", "Tweet this!");

                    $paragraph->appendChild($quotelink);
                }
            } else {

              $blockquote->setAttribute("class", "quotable-p");
              $quoteWrap = $contentDOM->createElement('span', $blockquote->nodeValue);
              $quoteWrap->setAttribute("class", "quotable-span");
              $blockquote->nodeValue = "";
              $blockquote->appendChild($quoteWrap);

                //Create the share button
                $tweettext = $blockquote->nodeValue;
                //$tweettext = (strlen($tweettext) > 140) ? substr($tweettext,0,120).'...' : $tweettext;
                $twitterhref = "http://twitter.com/intent/tweet?url=".$quotableData->permalink."&text=".$tweettext."&via=".$quotableData->author."&related=".$quotableData->related."&hashtags=".$quotableData->hashtags;
                $quotelink = $contentDOM->createElement('a', $quotableData->linktext);
                $quotelink->setAttribute("href", $twitterhref);
                $quotelink->setAttribute("class", "quotable-link");
                $quotelink->setAttribute("target", "_blank");
                $quotelink->setAttribute("title", "Tweet this!");

                $blockquote->appendChild($quotelink);
            }
        }

    // remove doctype and parent nodes added my DomDocument
    $contentDOM->removeChild($contentDOM->firstChild);
    $contentDOM->replaceChild($contentDOM->firstChild->firstChild->firstChild, $contentDOM->firstChild);

    $content = $contentDOM->saveHtml();

  }
  return $content;
}
add_filter( 'the_content', 'quotable_blockquotes' );

// Plugin Localization
function quotable_load_translation_file() {
    $plugin_path = plugin_basename( dirname( __FILE__ ) .'/translations' );
    load_plugin_textdomain( 'quotable', '', $plugin_path );
}
add_action('init', 'quotable_load_translation_file');
