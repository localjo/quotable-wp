"use strict";

function getSelectedText() {
  var range;
  if (window.getSelection) {
    range = window.getSelection();
    return range.toString();
  }
  range = document.selection.createRange();
  return range.text;
}

function updateQuotableToolbar(text, e) {
  quotableToolbar.href = "http://twitter.com/intent/tweet";

  if (pagePermalink) {
    quotableToolbar.href = quotableToolbar.href + "?url=" + escape(pagePermalink);
  }
  if (text) {
    quotableToolbar.href = quotableToolbar.href + "&text=" + escape(text);
  }
  if (authorTwitter) {
    quotableToolbar.href = quotableToolbar.href + "&via=" + escape(authorTwitter);
  }
  if (relatedAccounts) {
    quotableToolbar.href = quotableToolbar.href + "&related=" + escape(relatedAccounts);
  }
  if (postHashtags) {
    quotableToolbar.href = quotableToolbar.href + "&hashtags=" + escape(postHashtags);
  }
  // This should be updated to get the position relative to the text selection
  // rather than mouse coordinates
  quotableToolbar.style.top = (e.pageY - 10) + "px";
  quotableToolbar.style.left = (e.pageX + 5) + "px";
  quotableToolbar.style.display = "block";
}

function clearQuotableToolbar() {
  quotableToolbar.style.display = "none";
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

  quotableContent.addEventListener("mouseup", function (e) {
    window.selectedText = getSelectedText();
    //Only update the toolbar if there is actually text selected
    if (selectedText !== "") {
      updateQuotableToolbar(getSelectedText(), e);
    }
  }, false);

  quotableContent.addEventListener("mousedown", function () {
    //Only clear the toolbar if it is displayed
    if (quotableToolbar.style.display === "block") {
      clearQuotableToolbar();
    }
  }, false);
}
