=== Quotable ===
Contributors: josiahsprague
Donate link: http://josiahsprague.com/support
Tags: social, quotes, sharing, twitter
Requires at least: 3.0.1
Tested up to: 3.9
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Quotable enables your readers to share your notable quotes quickly and easily on Twitter.

== Description ==

Make your content easy to tweet with Quotable. Quotable enables your readers to share your notable quotes quickly and easily on Twitter by automatically adding a "Tweet this!" button to blockquotes and selected text in your existing content. Retina ready and automatically matches your site's theme. No configuration required.

Tweets include the post or page permalink and WordPress tags are converted to hashtags. Also integrates with Twitter accounts configured via Yoast's WordPress SEO to include Twitter mentions for post authors and suggest following the website's Twitter account.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

After that the plugin should just work. Try highlighting text on a page to see the quotable toolbar popup, and look for the quotable toolbar added to the end of the `<blockquote>` elements in all of your posts. See the FAQ for more information about configuration.

== Frequently Asked Questions ==

= Can you add the option to share quotes on more social networks? =

I may add integration with certain websites or services as time goes on, but my main goal is to make sharing content simple and quick. Too many options could work counter to that goal.

= How do I add an author who gets credit the the shared content? =

You can use Yoast's WordPress SEO plugin to set a site-wide Twitter account and a Twitter account for each author. When a tweet is created with the plugin, those values will be used to give credit where credit is due.

= How do I add hashtags to the shared content? =

Hashtags are generated based on the WordPress tags that were used on the post.

== Screenshots ==
1. The plugin will add a quotable button to the end of all blockquotes. When the button is clicked, a new Twitter window is created with the quoted or selected text.
2. When text is highlighted, the quotable toolbar will show up.


== Changelog ==

= 0.5 =
* Hides errors caused by mal-formed HTML
= 0.4 =
* Added check for mb_convert_encoding for servers that don't support it
= 0.3 =
* Blockquote text is now highlighted on hover of the Tweet link to give a visual cue for the functionality
* Now uses wp_enqueue_scripts to add scripts
* Custom font CSS has been moved out of PHP into CSS
* Quotable toolbar is no longer added to pages where it is not used
= 0.2 =
* Updated readme and added screenshots.
= 0.1 =
* Initial version
