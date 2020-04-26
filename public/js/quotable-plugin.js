class Quotable {
  constructor(settings) {
    this.settings = settings;
    this.el = document.getElementById('quotablecontent');
  }

  init() {
    const { el, settings, makeLink, addLink, getSelectedText } = this;
    const { siteSocial, tags } = settings;

    if (window.__twitterIntentHandler) return;
    var intentRegex = /twitter\.com\/intent\/(\w+)/,
      windowOptions = 'scrollbars=yes,resizable=yes,toolbar=no,location=yes',
      width = 550,
      height = 420,
      winHeight = screen.height,
      winWidth = screen.width;

    function handleIntent(e) {
      e = e || window.event;
      var target = e.target || e.srcElement,
        m,
        left,
        top;

      while (target && target.nodeName.toLowerCase() !== 'a') {
        target = target.parentNode;
      }

      if (target && target.nodeName.toLowerCase() === 'a' && target.href) {
        m = target.href.match(intentRegex);
        if (m) {
          left = Math.round(winWidth / 2 - width / 2);
          top = 0;

          if (winHeight > height) {
            top = Math.round(winHeight / 2 - height / 2);
          }

          window.open(
            target.href,
            'intent',
            windowOptions +
              ',width=' +
              width +
              ',height=' +
              height +
              ',left=' +
              left +
              ',top=' +
              top
          );
          e.returnValue = false;
          e.preventDefault && e.preventDefault();
        }
      }
    }

    if (document.addEventListener) {
      document.addEventListener('click', handleIntent, false);
    } else if (document.attachEvent) {
      document.attachEvent('onclick', handleIntent);
    }
    window.__twitterIntentHandler = true;

    // Text selection
    el.addEventListener('mouseup', () => {
      const { text, top, left, right } = getSelectedText();
      if (text !== '') {
        const scrollTop =
          window.scrollY ||
          window.scrollTop ||
          document.getElementsByTagName('html')[0].scrollTop;
        const style = {
          top: top + scrollTop - 10,
          left: left + (right - left) / 2,
        };
        const link = makeLink({
          params: {
            text,
            ...(siteSocial ? { related: siteSocial } : {}),
            ...(tags.length > 0 ? { hashtags: tags.join(',') } : {}),
          },
          style,
        });
        addLink(link, el);
      }
    });
    document.body.addEventListener('mousedown', (e) => {
      const { classList } = e.target;
      if (!classList.contains('quotable-link')) {
        const existingLinks = document.querySelectorAll(
          '.quotable-link-floating'
        );
        if (existingLinks.length > 0) {
          existingLinks.forEach((link) => link.remove());
        }
      }
    });

    // Blockquote hover
    const blockquotes = el.querySelectorAll('blockquote');
    blockquotes.forEach((blockquote) => {
      const paragraphs = blockquote.querySelectorAll('p');
      if (paragraphs.length > 0) {
        paragraphs.forEach((paragraph) => {
          const link = makeLink({
            params: {
              text: paragraph.textContent,
              ...(siteSocial ? { related: siteSocial } : {}),
              ...(tags ? { hashtags: tags.join(',') } : {}),
            },
          });
          addLink(link, paragraph);
        });
      } else {
        const link = makeLink({
          params: {
            text: blockquote.textContent,
            ...(siteSocial ? { related: siteSocial } : {}),
            ...(tags ? { hashtags: tags.join(',') } : {}),
          },
        });
        addLink(link, blockquote);
      }
    });
  }

  getSelectedText() {
    let range, textSelection;
    if (window.getSelection) {
      range = window.getSelection();
      textSelection = window
        .getSelection()
        .getRangeAt(0)
        .getBoundingClientRect();
      textSelection.text = range.toString();
      return textSelection;
    }
    range = document.selection.createRange();
    return range.text;
  }

  makeLink({ params, style = {} }) {
    const { top, left } = style;
    const query = Object.keys(params)
      .map((c) => `${encodeURIComponent(c)}=${encodeURIComponent(params[c])}`)
      .join('&');
    const isFloating = top || left;
    return `
<a href="http://twitter.com/intent/tweet?${query}"
  ${
    isFloating
      ? `style="top: ${top}px; left: ${left}px; position: absolute"`
      : `onmouseover="event.target.parentNode.style.background = 'rgba(100,100,100,0.1)'"
         onmouseout="event.target.parentNode.style.background = null"`
  }
  class="quotable-link${isFloating ? ' quotable-link-floating' : null}"
>
  tweet
</a>`;
  }

  addLink(link, target) {
    target.insertAdjacentHTML('beforeend', link);
  }
}
export default Quotable;
