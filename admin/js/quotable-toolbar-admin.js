import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ToggleControl } from '@wordpress/components';
import { registerPlugin } from '@wordpress/plugins';
import { withSelect, dispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

let QuotableMetaBox = ({ isBlockquotesEnabled, isTextSelectionEnabled }) => {
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
        onChange={() =>
          dispatch('core/editor').editPost({
            meta: { _quotable_blockquote_disable: isBlockquotesEnabled },
          })
        }
      />
      <ToggleControl
        label="Text Selection Enabled"
        help={
          isTextSelectionEnabled
            ? 'Quotable toolbar will appear when text is selected.'
            : 'Quotable toolbar is disabled.'
        }
        checked={isTextSelectionEnabled}
        onChange={() =>
          dispatch('core/editor').editPost({
            meta: { _quotable_text_disable: isTextSelectionEnabled },
          })
        }
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

registerPlugin('plugin-quotable', {
  icon: 'format-quote',
  render: QuotableMetaBox,
});
