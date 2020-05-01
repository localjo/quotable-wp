import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ToggleControl, PanelBody, SelectControl } from '@wordpress/components';
import { registerPlugin } from '@wordpress/plugins';
import { addFilter } from '@wordpress/hooks';
import { InspectorControls } from '@wordpress/block-editor';
import { Fragment } from '@wordpress/element';
import { createHigherOrderComponent } from '@wordpress/compose';
import { withSelect, withDispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

let QuotableMetaBox = ({
  isBlockquotesEnabled,
  isTextSelectionEnabled,
  onBlockquotesChange,
  onTextSelectionChange,
}) => {
  const hasBlockquotes = !!quotableActive.blockquotes;
  const hasTextSelection = !!quotableActive.textSelection;
  return (
    <PluginDocumentSettingPanel name="quotable-panel" title="Quotable">
      {hasTextSelection && (
        <ToggleControl
          label={__('Enable popup toolbar on text selection', 'quotable')}
          checked={isTextSelectionEnabled}
          onChange={() => onTextSelectionChange(isTextSelectionEnabled)}
        />
      )}
      {hasBlockquotes && (
        <div>
          <ToggleControl
            label={__('Add sharing links to blockquotes', 'quotable')}
            checked={isBlockquotesEnabled}
            onChange={() => onBlockquotesChange(isBlockquotesEnabled)}
          />
          <p>
            {__(
              `Placeholders are shown in the editor in the places where
              Quotable links will be added to content on the front end.
              You must refresh the editor after changing this setting
              for placeholders to update.`,
              'quotable'
            )}
          </p>
        </div>
      )}
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

const quoteBlocks = ['core/quote', 'core/pullquote'];

const quotableEnabledOptions = [
  {
    label: __('Use Page Default', 'quotable'),
    value: '',
  },
  {
    label: __('Show', 'quotable'),
    value: 'enabled',
  },
  {
    label: __('Hide', 'quotable'),
    value: 'disabled',
  },
];

const addQuotableAttribute = (settings, name) => {
  if (!quoteBlocks.includes(name)) return settings;
  return {
    ...settings,
    attributes: {
      ...settings.attributes,
      quotableEnabled: {
        type: 'string',
        default: quotableEnabledOptions[0].value,
      },
    },
  };
};

addFilter(
  'blocks.registerBlockType',
  'quotable/add-attribute',
  addQuotableAttribute
);

const getQuotableClassNames = (quotableStatus = '', className = '') => {
  const cleanClassName = className.replace(
    /quotable-quote-(enabled|disabled)/g,
    ''
  );
  if (quotableStatus.length < 1) return cleanClassName;
  return `${cleanClassName} quotable-quote-${quotableStatus}`;
};

const withQuotableControl = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    if (!quoteBlocks.includes(props.name)) return <BlockEdit {...props} />;
    const { quotableEnabled, className } = props.attributes;
    props.attributes.className = getQuotableClassNames(
      quotableEnabled,
      className
    );
    return (
      <Fragment>
        <BlockEdit {...props} />
        <InspectorControls>
          <PanelBody title={__('Quotable', 'quotable')} initialOpen={true}>
            <SelectControl
              label={__('Show link on this quote', 'quotable')}
              value={quotableEnabled}
              options={quotableEnabledOptions}
              onChange={(selectedOption) => {
                props.setAttributes({
                  quotableEnabled: selectedOption,
                });
              }}
            />
            <p>
              {__(
                `Placeholders are shown in the editor in the places where
              Quotable links will be added to content on the front end.`,
                'quotable'
              )}
            </p>
          </PanelBody>
        </InspectorControls>
      </Fragment>
    );
  };
}, 'withQuotableControl');

addFilter(
  'editor.BlockEdit',
  'quotable/with-quotable-control',
  withQuotableControl
);
