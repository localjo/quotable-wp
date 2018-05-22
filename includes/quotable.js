/* eslint-env browser */

'use strict';
function getSelectedText() {
  var range, textSelection;
  if (window.getSelection) {
    range = window.getSelection();
    textSelection = window.getSelection().getRangeAt(0).getBoundingClientRect();
    textSelection.text = range.toString();
    return textSelection;
  }
  range = document.selection.createRange();
  return range.text;
}

function updateQuotableToolbar(toolbar, selection) {
  var url, via, related, hashtags;
  toolbar.href = 'http://twitter.com/intent/tweet';
  url = toolbar.getAttribute('data-permalink');
  via = toolbar.getAttribute('data-author');
  related = toolbar.getAttribute('data-related');
  hashtags = toolbar.getAttribute('data-hashtags');

  if (selection.text) {
    toolbar.href = toolbar.href + '?text=' + encodeURIComponent(selection.text);
  }
  if (url) {
    toolbar.href = toolbar.href + '&url=' + encodeURIComponent(url);
  }
  if (via) {
    toolbar.href = toolbar.href + '&via=' + encodeURIComponent(via);
  }
  if (related) {
    toolbar.href = toolbar.href + '&related=' + encodeURIComponent(related);
  }
  if (hashtags) {
    toolbar.href = toolbar.href + '&hashtags=' + encodeURIComponent(hashtags);
  }

  // document.documentElement is for quirks mode
  var scrollTop = document.body.scrollTop || document.documentElement.scrollTop;
  var top = selection.top;
  var left = selection.left;
  var right = selection.right
  toolbar.style.top = top + scrollTop - toolbar.offsetHeight - 10 + 'px';
  toolbar.style.left = left + (right - left - toolbar.offsetWidth) / 2 + 'px';
  toolbar.style.visibility = 'visible';
}

function clearQuotableToolbar(toolbar) {
  toolbar.style.visibility = 'hidden';
  toolbar.href = '';
}

function quotableSetup() {
  var quotableToolbar, quotableContent, quotableLinks;

  quotableLinks = document.getElementsByClassName('quotable-link');

  for (var i = 0; i < quotableLinks.length; ++i) {
    quotableLinks[i].addEventListener(
      'mouseover',
      function(e) {
        e.target.parentNode.setAttribute('data-quotehover', 'true');
      },
      false
    );

    quotableLinks[i].addEventListener(
      'mouseout',
      function(e) {
        e.target.parentNode.setAttribute('data-quotehover', 'false');
      },
      false
    );
  }

  quotableToolbar = document.getElementById('quotable-toolbar');
  quotableContent = document.getElementById('quotablecontent');
  if (quotableToolbar !== null && quotableContent !== null) {
    //Don't do anything if quotable elements aren't on the page

    quotableContent.addEventListener(
      'mouseup',
      function() {
        var selection = getSelectedText();
        //Only update the toolbar if there is actually text selected
        if (selection.text !== '') {
          updateQuotableToolbar(quotableToolbar, selection);
        }
      },
      false
    );

    // Clicking anywhere on the document, other than the toolbar, when the toolbar
    // is displayed should clear it.
    document.body.addEventListener(
      'mousedown',
      function(e) {
        if (
          e.target.id !== 'quotable-toolbar' &&
          quotableToolbar.style.visibility === 'visible'
        ) {
          clearQuotableToolbar(quotableToolbar);
        }
      },
      false
    );
  }
}

window.addEventListener('load', quotableSetup, false);
