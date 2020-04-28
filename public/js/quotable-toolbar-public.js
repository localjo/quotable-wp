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
    isActive,
    url: pageUrl,
    twitter: {
      via: authorTwitter,
      related: siteSocial && siteSocial.twitter_site,
      hashtags: tags,
    },
  });
  quotableToolbar.activate();
});
