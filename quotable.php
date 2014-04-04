<?php
/*
Plugin Name: Quotable
Plugin URI: http://josiahsprague.com/quotable
Description: A plugin that helps people share your content via powerful quotes.
Version: 0.1
Author: Josiah Sprague
Author URI: http://josiahsprague.com
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
  $linktext = "(tweet this)";
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

function quotable_header() {
  if (is_singular()) {
    $output="<link rel='stylesheet' type='text/css' href='" . plugins_url( "/includes/quotable.css", __FILE__ ) . "'>
    <script type='text/javascript' src='" . plugins_url( "/includes/quotable.js", __FILE__ ) . "'></script>
    <script type='text/javascript' src='http://platform.twitter.com/widgets.js'></script>";
    echo $output;
  }
}
add_action('wp_head', 'quotable_header');

function quotable_toolbar() {
      $quotableData = quotable_setup();
      $quotableToolbar = "<a target='_blank' style='display: none; top: 0; left: 0;' href='' id='quotable-toolbar' data-permalink='".$quotableData->permalink."' data-author='".$quotableData->author."' data-related='".$quotableData->related."' data-hashtags='".$quotableData->hashtags."'>".$quotableData->linktext."</a>";
      echo $quotableToolbar;
}
//This may be theme dependent (some themes may not call wp_footer)
add_action('wp_footer', 'quotable_toolbar');

function quotable_blockquotes($content) {
  if( is_singular() && is_main_query() ) {

      //Wrap the content in a div to give it an easy ID handle for selection sharing
      $content = "<div id='quotablecontent'>" . $content . "</div>";

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
                    $tweettext = $paragraph->nodeValue;
                    //$tweettext = (strlen($tweettext) > 140) ? substr($tweettext,0,120).'...' : $tweettext;
                    $twitterhref = "http://twitter.com/intent/tweet?url=".$quotableData->permalink."&text=".$tweettext."&via=".$quotableData->author."&related=".$quotableData->related."&hashtags=".$quotableData->hashtags;
                    $quotelink = $contentDOM->createElement('a', $quotableData->linktext);
                    $quotelink->setAttribute("href", $twitterhref);
                    $quotelink->setAttribute("target", "_blank");

                    $paragraph->appendChild($quotelink);
                }
            } else {

                //Create the share button
                $tweettext = $blockquote->nodeValue;
                //$tweettext = (strlen($tweettext) > 140) ? substr($tweettext,0,120).'...' : $tweettext;
                $twitterhref = "http://twitter.com/intent/tweet?url=".$quotableData->permalink."&text=".$tweettext."&via=".$quotableData->author."&related=".$quotableData->related."&hashtags=".$quotableData->hashtags;
                $quotelink = $contentDOM->createElement('a', $quotableData->linktext);
                $quotelink->setAttribute("href", $twitterhref);
                $quotelink->setAttribute("target", "_blank");

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
add_action('init', 'quotable_load_translation_file');

function quotable_load_translation_file() {
    // relative path to WP_PLUGIN_DIR where the translation files will sit:
    $plugin_path = plugin_basename( dirname( __FILE__ ) .'/translations' );
    load_plugin_textdomain( 'quotable', '', $plugin_path );
}
