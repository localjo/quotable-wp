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
        label="Add sharing links to blockquotes"
        checked={isBlockquotesEnabled}
        onChange={() => onBlockquotesChange(isBlockquotesEnabled)}
      />
      <ToggleControl
        label="Enable popup toolbar on text selection"
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
