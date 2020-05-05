=== Quotable ===
Contributors: josiahsprague
Donate link: https://www.patreon.com/localjo
Tags: social media, share buttons, quotes, twitter, medium
Requires at least: 3.0.1
Tested up to: 5.4
Stable tag: 2.1.0
Requires PHP: 5.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds buttons to quotes and text selection that make it quick and easy for your readers to share quotes from your website.

== Description ==

Quotable adds buttons to quotes and text selection that make it quick and easy for your readers to share quotes from your website.

Simply install the plugin, there is no setup required. Icons that match your site's theme will be added to quotes and appear in a contextual menu when readers select text on your website, allowing them to quickly and easily share the quotes to Twitter.

This plugin adds a page link, hashtags and mentions to shared quotes. WordPress tags are used as hashtags and, if you use Yoast's WordPress SEO plugin, the post author's and site's Twitter accounts are added as mentions to Tweets.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress

After installing the plugin, there is no setup required. Visit a page and highlight some text in the main content and you should see the Quotable toolbar pop up. Visit a page or post with quote blocks, and you should see the Quotable icon added at the end of the quote. See the FAQ for more information about available options and settings.

== Frequently Asked Questions ==

= Can I turn off the functionality just for blockquotes or just for text selection? =

Yes. Go to Settings > Discussion > Quotable to enable or disable plugin features site-wide. You can enable or disable features for individual pages and posts from the Quotable section in the Document tab of the post editor. If you want to enable or disable the icon for individual quotes, you can do so from the Quotable section in the Block settings tab when editing the quote block.

= Can you add the option to share quotes on more social networks? =

If you're interested in having the option to share quotes via Facebook, Reddit, Hacker News or email, I am developing these features in a separate plugin exclusively for sponsors. If you would like to receive exclusive updates and features, please [sponsor me on Patreon](https://www.patreon.com/localjo).

= How do I make shared quotes mention the author's Twitter account? =

You can use Yoast's WordPress SEO plugin to set a site-wide Twitter account and a Twitter account for each author. When a tweet is created with Quotable, the post author's Twitter account will be mentioned in the tweet, and Twitter will recommend that people follow the site-wide Twitter account after they share the tweet.

= How do I add hashtags to the shared content? =

Hashtags are generated based on the WordPress tags that were used on the post. If you want more control over which hashtags are generated, I am developing these features in a separate plugin exclusively for sponsors. If you would like to receive exclusive updates and features, please [sponsor me on Patreon](https://www.patreon.com/localjo).

== Screenshots ==
1. This plugin adds a sharing button at the end of all quote blocks. The quote text will is highlighted on hover.
2. When text is selected, a sharing button will appear above the selected text.
3. The sharing button opens a popup for readers to share the quote on social media.

== Upgrade Notice ==
= 2.1.0 =
This update adds German and Hungarian translations.
= 2.0.0 =
This update adds support for the Gutenberg blocks editor.

== Changelog ==
= 2.1.0 =
* Adds Hungarian translation
* Adds German translation
= 2.0.0 =
* Adds support for Gutenberg block editor
* Adds the ability to enable/disable buttons on individual quotes in the block editor
* Moves page and post settings to the Gutenberg document settings sidebar
* Hides Quotable settings on posts and pages if disabled site-wide
* Completely rewritten codebase using  WordPress coding standards and modern JavaScript
* Removes a call to platform.twitter.com
* Adds Spanish translation for the plugin
* Improves the user expereince when installing and updating
* Adds settings shortcut in plugin list
* Various bug fixes and tests
* Released under GPL license, previous version was MIT

= 1.0.6 =
* Update code formatting and style to match WordPress standards.
* Remove underlines, shadows and borders from Twitter icon at the end of blockquotes.

= 1.0.2 =
* Fetch Twitter script via https

= 1.0.1 =
* Fixed minor console errors on pages with no quotable content

= 1.0.0 =
* Updated plugin meta information
* Prepared the plugin for future updates (coming soon!)

= 0.85 =
* Fixed bug where tweets were occasionaly generated with a link to the wrong post.

= 0.8 =
* Added settings to WP Dashboard which allow plugin functionality to be selectively disabled site-wide.
* Added post options which allow plugin functionality to be selectively disabled per post.
* Cleaned up whitespace in code.
* Changed license from GPL to MIT

= 0.7 =
* Fixed issue where plugin was stripping out HTML inside of blockquotes.
* Refactored some code

= 0.6 =
* Fixed positioning for the text selection button in Firefox when the page is scrolled.
* Defers loading of JS by placing it in the footer instead of the head.

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

== Sponsorship ==
I am software engineer and I love to create free and open source software for nomads, bloggers and language learners. In order to afford to spend time creating, maintaining and updating my free software, I rely on financial support from donors. In return, I provide my donors with access to exclusive updates, support and features. If you find this plugin useful, please consider [supporting me for just $1/month on Patreon](https://www.patreon.com/localjo).
