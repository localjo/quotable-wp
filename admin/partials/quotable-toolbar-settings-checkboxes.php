<?php

/**
 * Markup for the Quotable settings checkboxes
 *
 * @link       http://iamlocaljo.com
 * @since      2.0.0
 *
 * @package    Quotable_Toolbar
 * @subpackage Quotable_Toolbar/admin/partials
 */

?>
<input
  name="quotable_activation[blockquotes]"
  id="quotableActivationBlockquotes"
  type="checkbox"
  value="1"
  class="code"
  <?php checked( 1, $is_activated['blockquotes'] ) ?>
/> Activate Quotable on blockquotes<br>
<input
  name="quotable_activation[textselection]"
  id="quotableActivationText"
  type="checkbox"
  value="1"
  class="code"
  <?php checked( 1, $is_activated['textselection'] ) ?>
/> Activate Quotable on text selection.