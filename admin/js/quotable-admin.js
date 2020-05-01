import { PluginDocumentSettingPanel } from '@wordpress/edit-post';
import { ToggleControl, PanelBody, SelectControl } from '@wordpress/components';
import { registerPlugin } from '@wordpress/plugins';
import { addFilter } from '@wordpress/hooks';
import { InspectorControls } from '@wordpress/editor';
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

const quoteBlocks = ['core/quote', 'core/pullquote'];

const quotableEnabledOptions = [
  {
    label: __('Default'),
    value: '',
  },
  {
    label: __('Enabled'),
    value: 'enabled',
  },
  {
    label: __('Disabled'),
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

const withQuotableControl = createHigherOrderComponent((BlockEdit) => {
  return (props) => {
    if (!quoteBlocks.includes(props.name)) return <BlockEdit {...props} />;
    const { quotableEnabled } = props.attributes;
    if (quotableEnabled && quotableEnabled.length > 0) {
      props.attributes.className = `quotable-quote-${quotableEnabled}`;
    }
    return (
      <Fragment>
        <BlockEdit {...props} />
        <InspectorControls>
          <PanelBody title={__('Quotable')} initialOpen={true}>
            <SelectControl
              label={__('Enable/Disable')}
              value={quotableEnabled}
              options={quotableEnabledOptions}
              onChange={(selectedOption) => {
                props.setAttributes({
                  quotableEnabled: selectedOption,
                });
              }}
            />
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

const addQuotableProps = (saveElementProps, blockType, attributes) => {
  if (!quoteBlocks.includes(blockType.name)) return saveElementProps;
  const { quotableEnabled } = attributes;
  if (quotableEnabled.length < 1) return saveElementProps;
  const { className } = saveElementProps;
  const newClassName = `quotable-quote-${quotableEnabled}`;
  if (className.includes(newClassName)) return saveElementProps;
  return {
    ...saveElementProps,
    className: `${className} ${newClassName}`,
  };
};

addFilter(
  'blocks.getSaveContent.extraProps',
  'quotable/add-extra-props',
  addQuotableProps
);
