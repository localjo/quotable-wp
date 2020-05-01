import Quotable from 'quotable-toolbar';

window.addEventListener('DOMContentLoaded', () => {
  const {
    containerId,
    pageUrl,
    authorTwitter,
    siteSocial,
    tags,
    isActive,
  } = wpQuotable;
  const quotableToolbar = new Quotable({
    selector: `#${containerId}`,
    isActive: {
      ...isActive,
      include: [
        '.quotable-quote-enabled',
        '.quotable-quote-enabled blockquote',
      ],
      exclude: [
        '.quotable-quote-disabled',
        '.quotable-quote-disabled blockquote',
      ],
    },
    url: pageUrl,
    twitter: {
      via: authorTwitter,
      related: siteSocial && siteSocial.twitter_site,
      hashtags: [...tags, 'quotable'],
    },
  });
  quotableToolbar.activate();
});
