"use strict";

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

function updateQuotableToolbar(selectedText) {
  quotableToolbar.href = "http://twitter.com/intent/tweet";

  if (pagePermalink) {
    quotableToolbar.href = quotableToolbar.href + "?url=" + encodeURIComponent(pagePermalink);
  }
  if (selectedText.text) {
    quotableToolbar.href = quotableToolbar.href + "&text=" + encodeURIComponent(selectedText.text);
  }
  if (authorTwitter) {
    quotableToolbar.href = quotableToolbar.href + "&via=" + encodeURIComponent(authorTwitter);
  }
  if (relatedAccounts) {
    quotableToolbar.href = quotableToolbar.href + "&related=" + encodeURIComponent(relatedAccounts);
  }
  if (postHashtags) {
    quotableToolbar.href = quotableToolbar.href + "&hashtags=" + encodeURIComponent(postHashtags);
  }
  quotableToolbar.style.top = ((selectedText.top + document.body.scrollTop) - quotableToolbar.offsetHeight - 10) + "px";
  quotableToolbar.style.left = (selectedText.left + ((selectedText.right - selectedText.left - quotableToolbar.offsetWidth) / 2)) + "px";
  quotableToolbar.style.visibility = "visible";
}

function clearQuotableToolbar() {
  quotableToolbar.style.visibility = "hidden";
  quotableToolbar.href = "";
}

window.onload = function () {
  window.quotableToolbar = document.getElementById("quotable-toolbar");
  window.pagePermalink = quotableToolbar.getAttribute("data-permalink");
  if (pagePermalink === "") {
    pagePermalink = document.URL;
  }
  window.authorTwitter = quotableToolbar.getAttribute("data-author");
  window.relatedAccounts = quotableToolbar.getAttribute("data-related");
  window.postHashtags = quotableToolbar.getAttribute("data-hashtags");

  // Only listen for text selection on content that is quotable to avoid toolbar
  // popping up for content people don't want to share
  window.quotableContent = document.getElementById("quotablecontent");

  quotableContent.addEventListener("mouseup", function () {
    window.selectedText = getSelectedText();
    //Only update the toolbar if there is actually text selected
    if (selectedText.text !== "") {
      updateQuotableToolbar(selectedText);
    }
  }, false);

  // Clicking anywhere on the document, other than the toolbar, when the toolbar
  // is displayed should clear it.
  document.getElementsByTagName('body')[0].addEventListener("mousedown", function (e) {
    if ((e.target.id !== "quotable-toolbar") && (quotableToolbar.style.visibility === "visible")) {
      clearQuotableToolbar();
    }
  }, false);
};
