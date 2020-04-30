import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ToggleControl } from '@wordpress/components';
import { registerPlugin } from '@wordpress/plugins';
import { withSelect, withDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

let QuotableMetaBox = ({
  isBlockquotesEnabled,
  isTextSelectionEnabled,
  onBlockquotesChange,
  onTextSelectionChange,
}) => {
  return (
    <PluginDocumentSettingPanel name="quotable-panel" title="Quotable">
      <ToggleControl
        label="Blockquotes Enabled"
        help={
          isBlockquotesEnabled
            ? 'Quotable links will be added to blockquotes.'
            : 'Quotable links will not be added to blockquotes.'
        }
        checked={isBlockquotesEnabled}
        onChange={() => onBlockquotesChange(isBlockquotesEnabled)}
      />
      <ToggleControl
        label="Text Selection Enabled"
        help={
          isTextSelectionEnabled
            ? 'Quotable toolbar will appear when text is selected.'
            : 'Quotable toolbar is disabled.'
        }
        checked={isTextSelectionEnabled}
        onChange={() => onTextSelectionChange(isTextSelectionEnabled)}
      />
    </PluginDocumentSettingPanel>
  );
};

QuotableMetaBox = withSelect((select) => {
  const meta = select('core/editor').getEditedPostAttribute('meta');
  return {
    isBlockquotesEnabled: !meta._quotable_blockquote_disable,
    isTextSelectionEnabled: !meta._quotable_text_disable,
  };
})(QuotableMetaBox);

QuotableMetaBox = withDispatch((dispatch) => {
  return {
    onBlockquotesChange: (value) => {
      dispatch('core/editor').editPost({
        meta: { _quotable_blockquote_disable: value },
      });
    },
    onTextSelectionChange: (value) => {
      dispatch('core/editor').editPost({
        meta: { _quotable_text_disable: value },
      });
    },
  };
})(QuotableMetaBox);

registerPlugin('plugin-quotable', {
  icon: 'format-quote',
  render: QuotableMetaBox,
});

jQuery('document').ready(function($) {
  if (window.location.hash === '#quotable-settings') {
    $('#quotable-settings')
      .closest('table')
      .addClass('highlight');
  }
});
