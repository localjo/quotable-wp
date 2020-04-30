<?php

/**
 * Markup for the Quotable metabox
 *
 * @link       http://iamlocaljo.com
 * @since      2.0.0
 *
 * @package    Quotable
 * @subpackage Quotable/admin/partials
 */

?>
<label for="quotable_blockquote_disable">
	<input
		type="checkbox"
		id="quotable_blockquote_disable"
		name="quotable_blockquote_disable"
		value="1"
		<?php checked( 1, $blockquote_value ) ?>
	/>
  <?php esc_html_e( 'Disable Quotable for blockquotes on this page.', 'quotable' ) ?>
</label>
<br>
<label for="quotable_text_disable">
	<input
		type="checkbox"
		id="quotable_text_disable"
		name="quotable_text_disable"
		value="1" ' .
		<?php checked( 1, $textselection_value ) ?>
	/>
	<?php esc_html_e( 'Disable Quotable for text selection on this page.', 'quotable' ) ?>
</label>