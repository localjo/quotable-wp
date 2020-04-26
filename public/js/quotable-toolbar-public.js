import Quotable from './quotable-plugin';
window.addEventListener('DOMContentLoaded', (event) => {
  const settings = wpQuotable;
  const quotable = new Quotable(settings);
  quotable.init();
});
