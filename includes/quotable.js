function getSelectedText() {
  "use strict";
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
  "use strict";
  var url, via, related, hashtags;
  toolbar.href = "http://twitter.com/intent/tweet";
  url = toolbar.getAttribute("data-permalink");
  via = toolbar.getAttribute("data-author");
  related = toolbar.getAttribute("data-related");
  hashtags = toolbar.getAttribute("data-hashtags");

  if (selection.text) {
    toolbar.href = toolbar.href + "?text=" + encodeURIComponent(selection.text);
  }
  if (url) {
    toolbar.href = toolbar.href + "&url=" + encodeURIComponent(url);
  }
  if (via) {
    toolbar.href = toolbar.href + "&via=" + encodeURIComponent(via);
  }
  if (related) {
    toolbar.href = toolbar.href + "&related=" + encodeURIComponent(related);
  }
  if (hashtags) {
    toolbar.href = toolbar.href + "&hashtags=" + encodeURIComponent(hashtags);
  }

  toolbar.style.top = ((selection.top + document.body.scrollTop) - toolbar.offsetHeight - 10) + "px";
  toolbar.style.left = (selection.left + ((selection.right - selection.left - toolbar.offsetWidth) / 2)) + "px";
  toolbar.style.visibility = "visible";
}

function clearQuotableToolbar(toolbar) {
  "use strict";
  toolbar.style.visibility = "hidden";
  toolbar.href = "";
}

window.onload = function () {
  "use strict";
  var quotableToolbar, quotableContent;
  quotableToolbar = document.getElementById("quotable-toolbar");
  if (quotableToolbar !== null) { //Don't do anything if the quotable-toolbar element isn't on the page

    // Only listen for text selection on content that is quotable to avoid toolbar
    // popping up for content people don't want to share
    quotableContent = document.getElementById("quotablecontent");

    quotableContent.addEventListener("mouseup", function () {
      var selection = getSelectedText();
      //Only update the toolbar if there is actually text selected
      if (selection.text !== "") {
        updateQuotableToolbar(quotableToolbar, selection);
      }
    }, false);

    // Clicking anywhere on the document, other than the toolbar, when the toolbar
    // is displayed should clear it.
    document.body.addEventListener("mousedown", function (e) {
      if ((e.target.id !== "quotable-toolbar") && (quotableToolbar.style.visibility === "visible")) {
        clearQuotableToolbar(quotableToolbar);
      }
    }, false);
  }
};
