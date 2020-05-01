<?php

/**
 * Markup for the Quotable settings checkboxes
 *
 * @link       http://iamlocaljo.com
 * @since      2.0.0
 *
 * @package    Quotable
 * @subpackage Quotable/admin/partials
 */

?>
<div id="quotable-settings">
  <input
    name="quotable_activation[blockquotes]"
    id="quotableActivationBlockquotes"
    type="checkbox"
    value="1"
    class="code"
    <?php checked( 1, $is_activated['blockquotes'] ) ?>
  /> <?php esc_html_e( 'Add sharing links to blockquotes', 'quotable' ) ?><br><br>
  <input
    name="quotable_activation[textselection]"
    id="quotableActivationText"
    type="checkbox"
    value="1"
    class="code"
    <?php checked( 1, $is_activated['textselection'] ) ?>
  /> <?php esc_html_e( 'Enable popup toolbar on text selection', 'quotable' ) ?>
</div>