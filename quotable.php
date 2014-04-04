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

function quotable_header() {
  if (is_singular()) {
    $output="<link rel='stylesheet' type='text/css' href='" . plugins_url( "/includes/quotable.css", __FILE__ ) . "'>
    <script type='text/javascript' src='" . plugins_url( "/includes/quotable.js", __FILE__ ) . "'></script>";
    echo $output;
  }
}
add_action('wp_head', 'quotable_header');

function quotable_toolbar() {
      $quotableToolbar = "<a style='display: block; top: 0; left: 0;' href='' id='quotable-toolbar'>(toolbar)</a>";
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

      //setup the variables for the twitter links

      $linktext = "(tweet this)"; //update to pull from plugin settings in database
      $pageurl = get_permalink();
      $theauthor = "jrswp"; //update this to pull from database info about post author
      $related = "jrswp"; //update to pull from database setting for site's main twitter account?
      $posthashtags = "quotable"; //update to pull from custom field on post

        //Get all the blockquotes in the content and loop through them
        $blockquotes = $contentDOM->getElementsByTagName('blockquote');
        foreach ($blockquotes as $blockquote) {

            $paragraphs = $blockquote->getElementsByTagName('p');

            //If there are paragraphs, append the link individually.
            $paragraphcount = $paragraphs->length;
            if ($paragraphcount > 0) {

                foreach($paragraphs as $paragraph) {
                    //Create the share button
                    $tweettext = $paragraph->nodeValue;
                    //$tweettext = (strlen($tweettext) > 140) ? substr($tweettext,0,120).'...' : $tweettext;
                    $twitterhref = "http://twitter.com/intent/tweet?url=".$pageurl."&text=".$tweettext."&via=".$theauthor."&related=".$related."&hashtags=".$posthashtags;
                    $quotelink = $contentDOM->createElement('a', $linktext);
                    $quotelink->setAttribute("href", $twitterhref);
                    $quotelink->setAttribute("target", "_blank");

                    $paragraph->appendChild($quotelink);
                }
            } else {

                //Create the share button
                $tweettext = $blockquote->nodeValue;
                //$tweettext = (strlen($tweettext) > 140) ? substr($tweettext,0,120).'...' : $tweettext;
                $twitterhref = "http://twitter.com/intent/tweet?url=".$pageurl."&text=".$tweettext."&via=".$theauthor."&related=".$related."&hashtags=".$posthashtags;
                $quotelink = $contentDOM->createElement('a', $linktext);
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
