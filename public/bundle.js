!function(e){var t={};function n(o){if(t[o])return t[o].exports;var r=t[o]={i:o,l:!1,exports:{}};return e[o].call(r.exports,r,r.exports,n),r.l=!0,r.exports}n.m=e,n.c=t,n.d=function(e,t,o){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:o})},n.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var o=Object.create(null);if(n.r(o),Object.defineProperty(o,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var r in e)n.d(o,r,function(t){return e[t]}.bind(null,r));return o},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=7)}([function(e,t){e.exports=function(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,o=new Array(t);n<t;n++)o[n]=e[n];return o}},function(e,t,n){var o=n(3),r=n(4),l=n(5),i=n(6);e.exports=function(e){return o(e)||r(e)||l(e)||i()}},function(e,t){e.exports=function(e,t,n){return t in e?Object.defineProperty(e,t,{value:n,enumerable:!0,configurable:!0,writable:!0}):e[t]=n,e}},function(e,t,n){var o=n(0);e.exports=function(e){if(Array.isArray(e))return o(e)}},function(e,t){e.exports=function(e){if("undefined"!=typeof Symbol&&Symbol.iterator in Object(e))return Array.from(e)}},function(e,t,n){var o=n(0);e.exports=function(e,t){if(e){if("string"==typeof e)return o(e,t);var n=Object.prototype.toString.call(e).slice(8,-1);return"Object"===n&&e.constructor&&(n=e.constructor.name),"Map"===n||"Set"===n?Array.from(n):"Arguments"===n||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)?o(e,t):void 0}}},function(e,t){e.exports=function(){throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}},function(e,t,n){"use strict";n.r(t);var o,r,l,i,u,a,c=n(1),s=n.n(c),_=n(2),p=n.n(_),d={},f=[],h=/acit|ex(?:s|g|n|p|$)|rph|grid|ows|mnc|ntw|ine[ch]|zoo|^ord/i;function v(e,t){for(var n in t)e[n]=t[n];return e}function b(e){var t=e.parentNode;t&&t.removeChild(e)}function y(e,t,n){var o,r=arguments,l={};for(o in t)"key"!==o&&"ref"!==o&&(l[o]=t[o]);if(arguments.length>3)for(n=[n],o=3;o<arguments.length;o++)n.push(r[o]);if(null!=n&&(l.children=n),"function"==typeof e&&null!=e.defaultProps)for(o in e.defaultProps)void 0===l[o]&&(l[o]=e.defaultProps[o]);return g(e,l,t&&t.key,t&&t.ref,null)}function g(e,t,n,r,l){var i={type:e,props:t,key:n,ref:r,__k:null,__:null,__b:0,__e:null,__d:void 0,__c:null,constructor:void 0,__v:l};return null==l&&(i.__v=i),o.vnode&&o.vnode(i),i}function m(e){return e.children}function w(e,t){this.props=e,this.context=t}function x(e,t){if(null==t)return e.__?x(e.__,e.__.__k.indexOf(e)+1):null;for(var n;t<e.__k.length;t++)if(null!=(n=e.__k[t])&&null!=n.__e)return n.__e;return"function"==typeof e.type?x(e):null}function k(e){var t,n;if(null!=(e=e.__)&&null!=e.__c){for(e.__e=e.__c.base=null,t=0;t<e.__k.length;t++)if(null!=(n=e.__k[t])&&null!=n.__e){e.__e=e.__c.base=n.__e;break}return k(e)}}function S(e){(!e.__d&&(e.__d=!0)&&r.push(e)&&!l++||u!==o.debounceRendering)&&((u=o.debounceRendering)||i)(T)}function T(){for(var e;l=r.length;)e=r.sort((function(e,t){return e.__v.__b-t.__v.__b})),r=[],e.some((function(e){var t,n,o,r,l,i,u;e.__d&&(i=(l=(t=e).__v).__e,(u=t.__P)&&(n=[],(o=v({},l)).__v=o,r=A(u,l,o,t.__n,void 0!==u.ownerSVGElement,null,n,null==i?x(l):i),E(n,l),r!=i&&k(l)))}))}function C(e,t,n,o,r,l,i,u,a){var c,s,_,p,h,v,y,g=n&&n.__k||f,m=g.length;if(u==d&&(u=null!=l?l[0]:m?x(n,0):null),c=0,t.__k=O(t.__k,(function(n){if(null!=n){if(n.__=t,n.__b=t.__b+1,null===(_=g[c])||_&&n.key==_.key&&n.type===_.type)g[c]=void 0;else for(s=0;s<m;s++){if((_=g[s])&&n.key==_.key&&n.type===_.type){g[s]=void 0;break}_=null}if(p=A(e,n,_=_||d,o,r,l,i,u,a),(s=n.ref)&&_.ref!=s&&(y||(y=[]),_.ref&&y.push(_.ref,null,n),y.push(s,n.__c||p,n)),null!=p){var f;if(null==v&&(v=p),void 0!==n.__d)f=n.__d,n.__d=void 0;else if(l==_||p!=u||null==p.parentNode){e:if(null==u||u.parentNode!==e)e.appendChild(p),f=null;else{for(h=u,s=0;(h=h.nextSibling)&&s<m;s+=2)if(h==p)break e;e.insertBefore(p,u),f=u}"option"==t.type&&(e.value="")}u=void 0!==f?f:p.nextSibling,"function"==typeof t.type&&(t.__d=u)}else u&&_.__e==u&&u.parentNode!=e&&(u=x(_))}return c++,n})),t.__e=v,null!=l&&"function"!=typeof t.type)for(c=l.length;c--;)null!=l[c]&&b(l[c]);for(c=m;c--;)null!=g[c]&&M(g[c],g[c]);if(y)for(c=0;c<y.length;c++)D(y[c],y[++c],y[++c])}function O(e,t,n){if(null==n&&(n=[]),null==e||"boolean"==typeof e)t&&n.push(t(null));else if(Array.isArray(e))for(var o=0;o<e.length;o++)O(e[o],t,n);else n.push(t?t("string"==typeof e||"number"==typeof e?g(null,e,null,null,e):null!=e.__e||null!=e.__c?g(e.type,e.props,e.key,null,e.__v):e):e);return n}function q(e,t,n){"-"===t[0]?e.setProperty(t,n):e[t]="number"==typeof n&&!1===h.test(t)?n+"px":null==n?"":n}function P(e,t,n,o,r){var l,i,u,a,c;if(r?"className"===t&&(t="class"):"class"===t&&(t="className"),"style"===t)if(l=e.style,"string"==typeof n)l.cssText=n;else{if("string"==typeof o&&(l.cssText="",o=null),o)for(a in o)n&&a in n||q(l,a,"");if(n)for(c in n)o&&n[c]===o[c]||q(l,c,n[c])}else"o"===t[0]&&"n"===t[1]?(i=t!==(t=t.replace(/Capture$/,"")),u=t.toLowerCase(),t=(u in e?u:t).slice(2),n?(o||e.addEventListener(t,j,i),(e.l||(e.l={}))[t]=n):e.removeEventListener(t,j,i)):"list"!==t&&"tagName"!==t&&"form"!==t&&"type"!==t&&"size"!==t&&!r&&t in e?e[t]=null==n?"":n:"function"!=typeof n&&"dangerouslySetInnerHTML"!==t&&(t!==(t=t.replace(/^xlink:?/,""))?null==n||!1===n?e.removeAttributeNS("http://www.w3.org/1999/xlink",t.toLowerCase()):e.setAttributeNS("http://www.w3.org/1999/xlink",t.toLowerCase(),n):null==n||!1===n&&!/^ar/.test(t)?e.removeAttribute(t):e.setAttribute(t,n))}function j(e){this.l[e.type](o.event?o.event(e):e)}function A(e,t,n,r,l,i,u,a,c){var s,_,p,d,f,h,b,y,g,x,k=t.type;if(void 0!==t.constructor)return null;(s=o.__b)&&s(t);try{e:if("function"==typeof k){if(y=t.props,g=(s=k.contextType)&&r[s.__c],x=s?g?g.props.value:s.__:r,n.__c?b=(_=t.__c=n.__c).__=_.__E:("prototype"in k&&k.prototype.render?t.__c=_=new k(y,x):(t.__c=_=new w(y,x),_.constructor=k,_.render=N),g&&g.sub(_),_.props=y,_.state||(_.state={}),_.context=x,_.__n=r,p=_.__d=!0,_.__h=[]),null==_.__s&&(_.__s=_.state),null!=k.getDerivedStateFromProps&&(_.__s==_.state&&(_.__s=v({},_.__s)),v(_.__s,k.getDerivedStateFromProps(y,_.__s))),d=_.props,f=_.state,p)null==k.getDerivedStateFromProps&&null!=_.componentWillMount&&_.componentWillMount(),null!=_.componentDidMount&&_.__h.push(_.componentDidMount);else{if(null==k.getDerivedStateFromProps&&y!==d&&null!=_.componentWillReceiveProps&&_.componentWillReceiveProps(y,x),!_.__e&&null!=_.shouldComponentUpdate&&!1===_.shouldComponentUpdate(y,_.__s,x)||t.__v===n.__v&&!_.__){for(_.props=y,_.state=_.__s,t.__v!==n.__v&&(_.__d=!1),_.__v=t,t.__e=n.__e,t.__k=n.__k,_.__h.length&&u.push(_),s=0;s<t.__k.length;s++)t.__k[s]&&(t.__k[s].__=t);break e}null!=_.componentWillUpdate&&_.componentWillUpdate(y,_.__s,x),null!=_.componentDidUpdate&&_.__h.push((function(){_.componentDidUpdate(d,f,h)}))}_.context=x,_.props=y,_.state=_.__s,(s=o.__r)&&s(t),_.__d=!1,_.__v=t,_.__P=e,s=_.render(_.props,_.state,_.context),t.__k=null!=s&&s.type==m&&null==s.key?s.props.children:Array.isArray(s)?s:[s],null!=_.getChildContext&&(r=v(v({},r),_.getChildContext())),p||null==_.getSnapshotBeforeUpdate||(h=_.getSnapshotBeforeUpdate(d,f)),C(e,t,n,r,l,i,u,a,c),_.base=t.__e,_.__h.length&&u.push(_),b&&(_.__E=_.__=null),_.__e=!1}else null==i&&t.__v===n.__v?(t.__k=n.__k,t.__e=n.__e):t.__e=L(n.__e,t,n,r,l,i,u,c);(s=o.diffed)&&s(t)}catch(e){t.__v=null,o.__e(e,t,n)}return t.__e}function E(e,t){o.__c&&o.__c(t,e),e.some((function(t){try{e=t.__h,t.__h=[],e.some((function(e){e.call(t)}))}catch(e){o.__e(e,t.__v)}}))}function L(e,t,n,o,r,l,i,u){var a,c,s,_,p,h=n.props,v=t.props;if(r="svg"===t.type||r,null!=l)for(a=0;a<l.length;a++)if(null!=(c=l[a])&&((null===t.type?3===c.nodeType:c.localName===t.type)||e==c)){e=c,l[a]=null;break}if(null==e){if(null===t.type)return document.createTextNode(v);e=r?document.createElementNS("http://www.w3.org/2000/svg",t.type):document.createElement(t.type,v.is&&{is:v.is}),l=null,u=!1}if(null===t.type)h!==v&&e.data!=v&&(e.data=v);else{if(null!=l&&(l=f.slice.call(e.childNodes)),s=(h=n.props||d).dangerouslySetInnerHTML,_=v.dangerouslySetInnerHTML,!u){if(h===d)for(h={},p=0;p<e.attributes.length;p++)h[e.attributes[p].name]=e.attributes[p].value;(_||s)&&(_&&s&&_.__html==s.__html||(e.innerHTML=_&&_.__html||""))}(function(e,t,n,o,r){var l;for(l in n)"children"===l||"key"===l||l in t||P(e,l,null,n[l],o);for(l in t)r&&"function"!=typeof t[l]||"children"===l||"key"===l||"value"===l||"checked"===l||n[l]===t[l]||P(e,l,t[l],n[l],o)})(e,v,h,r,u),_?t.__k=[]:(t.__k=t.props.children,C(e,t,n,o,"foreignObject"!==t.type&&r,l,i,d,u)),u||("value"in v&&void 0!==(a=v.value)&&a!==e.value&&P(e,"value",a,h.value,!1),"checked"in v&&void 0!==(a=v.checked)&&a!==e.checked&&P(e,"checked",a,h.checked,!1))}return e}function D(e,t,n){try{"function"==typeof e?e(t):e.current=t}catch(e){o.__e(e,n)}}function M(e,t,n){var r,l,i;if(o.unmount&&o.unmount(e),(r=e.ref)&&(r.current&&r.current!==e.__e||D(r,null,t)),n||"function"==typeof e.type||(n=null!=(l=e.__e)),e.__e=e.__d=void 0,null!=(r=e.__c)){if(r.componentWillUnmount)try{r.componentWillUnmount()}catch(e){o.__e(e,t)}r.base=r.__P=null}if(r=e.__k)for(i=0;i<r.length;i++)r[i]&&M(r[i],t,n);null!=l&&b(l)}function N(e,t,n){return this.constructor(e,n)}function I(e,t,n){var r,l,i;o.__&&o.__(e,t),l=(r=n===a)?null:n&&n.__k||t.__k,e=y(m,null,[e]),i=[],A(t,(r?t:n||t).__k=e,l||d,d,void 0!==t.ownerSVGElement,n&&!r?[n]:l?null:f.slice.call(t.childNodes),i,n||d,r),E(i,e)}o={__e:function(e,t){for(var n,o;t=t.__;)if((n=t.__c)&&!n.__)try{if(n.constructor&&null!=n.constructor.getDerivedStateFromError&&(o=!0,n.setState(n.constructor.getDerivedStateFromError(e))),null!=n.componentDidCatch&&(o=!0,n.componentDidCatch(e)),o)return S(n.__E=n)}catch(t){e=t}throw e}},w.prototype.setState=function(e,t){var n;n=this.__s!==this.state?this.__s:this.__s=v({},this.state),"function"==typeof e&&(e=e(n,this.props)),e&&v(n,e),null!=e&&this.__v&&(t&&this.__h.push(t),S(this))},w.prototype.forceUpdate=function(e){this.__v&&(this.__e=!0,e&&this.__h.push(e),S(this))},w.prototype.render=m,r=[],l=0,i="function"==typeof Promise?Promise.prototype.then.bind(Promise.resolve()):setTimeout,a=d;
/*! *****************************************************************************
Copyright (c) Microsoft Corporation. All rights reserved.
Licensed under the Apache License, Version 2.0 (the "License"); you may not use
this file except in compliance with the License. You may obtain a copy of the
License at http://www.apache.org/licenses/LICENSE-2.0

THIS CODE IS PROVIDED ON AN *AS IS* BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
KIND, EITHER EXPRESS OR IMPLIED, INCLUDING WITHOUT LIMITATION ANY IMPLIED
WARRANTIES OR CONDITIONS OF TITLE, FITNESS FOR A PARTICULAR PURPOSE,
MERCHANTABLITY OR NON-INFRINGEMENT.

See the Apache Version 2.0 License for specific language governing permissions
and limitations under the License.
***************************************************************************** */
var U=function(){return(U=Object.assign||function(e){for(var t,n=1,o=arguments.length;n<o;n++)for(var r in t=arguments[n])Object.prototype.hasOwnProperty.call(t,r)&&(e[r]=t[r]);return e}).apply(this,arguments)};!function(e,t){void 0===t&&(t={});var n=t.insertAt;if(e&&"undefined"!=typeof document){var o=document.head||document.getElementsByTagName("head")[0],r=document.createElement("style");r.type="text/css","top"===n&&o.firstChild?o.insertBefore(r,o.firstChild):o.appendChild(r),r.styleSheet?r.styleSheet.cssText=e:r.appendChild(document.createTextNode(e))}}('#quotable-toolbar, .quotable-link {\n  text-decoration: none;\n  height: 1em;\n}\n\n.quotable-link:hover {\n  text-decoration: none;\n}\n\n#quotable-toolbar {\n  display: block;\n  padding: 5px 10px;\n  line-height: 1.5em;\n  text-align: center;\n  text-decoration: none;\n  background: #eeeeee;\n  border: 1px solid rgba(0, 0, 0, 0.2);\n  border-radius: 5px;\n  box-sizing: content-box;\n  white-space: nowrap;\n}\n\n/* Caret */\n\n#quotable-toolbar:after, #quotable-toolbar:before {\n  top: 100%;\n  left: 50%;\n  border: solid transparent;\n  content: " ";\n  height: 0;\n  width: 0;\n  position: absolute;\n  pointer-events: none;\n}\n\n/* Caret background */\n\n#quotable-toolbar:after {\n  border-color: rgba(238, 238, 238, 0);\n  border-top-color: #eeeeee;\n  border-width: 6px;\n  margin-left: -6px;\n}\n\n/* Caret border */\n\n#quotable-toolbar:before {\n  border-color: rgba(0, 0, 0, 0);\n  border-top-color: rgba(0, 0, 0, 0.3);\n  border-width: 7px;\n  margin-left: -7px;\n}\n\n.quotable-link {\n  display: inline-block;\n  height: 1.2em;\n  text-decoration: none !important;\n  border: 0 !important;\n  -webkit-box-shadow: none !important;\n  box-shadow: none !important;\n}\n\n#quotable-toolbar .quotable-link {\n  background: none !important;\n}');var H=function(){function e(e){var t={twitter:{},url:window.location.href,isActive:{blockquotes:!0,textSelection:!0}};this.settings=U(U({},t),e),this.el=document.querySelector(e.selector),this.handleTextSelection=this.handleTextSelection.bind(this),this.handleTextDeselection=this.handleTextDeselection.bind(this),this.handleTwitterIntent=this.handleTwitterIntent.bind(this)}return e.prototype.activate=function(){var e=this,t=e.el,n=e.settings,o=e.setUpBlockquotes,r=e.handleTextSelection,l=e.handleTextDeselection,i=e.handleTwitterIntent,u=n.twitter,a=n.isActive,c=n.selector;if(o.bind(this)(),a.textSelection){var s=window.getComputedStyle(t).position,_=["relative","fixed","absolute"];_.includes(s)||(console.warn("Forcing element '"+c+"' to position: relative. The Quotable container element should have position set to one of: ["+_.join(",")+"] with CSS to avoid this warning."),t.style.position="relative"),t.addEventListener("mouseup",r),document.addEventListener("mousedown",l)}u&&!window.__twitterIntentHandler&&(document.addEventListener("click",i,!1),window.__twitterIntentHandler=!0)},e.prototype.deactivate=function(){var e=this,t=e.el,n=e.settings,o=e.handleTextSelection,r=e.handleTextDeselection,l=e.handleTwitterIntent,i=n.twitter;t.removeEventListener("mouseup",o),document.removeEventListener("mousedown",r),i&&window.__twitterIntentHandler&&document.removeEventListener("click",l)},e.prototype.setUpBlockquotes=function(){var e=this.el,t=this.settings,n=this.Toolbar,o=this.wrapContents,r=t.twitter,l=t.url,i=t.isActive,u=i.blockquotes,a=u?Array.from(e.querySelectorAll("blockquote")):[];!u&&i.include&&i.include.length>0&&i.include.forEach((function(t){var n=Array.from(e.querySelectorAll(t));a.push.apply(a,n)})),i.exclude&&i.exclude.length>0&&(a=a.filter((function(e){return!i.exclude.map((function(t){return e.matches(t)})).some((function(e){return!!e}))}))),a.forEach((function(e){var t=e.querySelectorAll("p");t.length>0?t.forEach((function(e){o(e,"span","quotable-text"),I(y(n,{text:e.textContent,url:l,twitter:r||null}),e,e)})):(o(e,"span","quotable-text"),I(y(n,{text:e.textContent,url:l,twitter:r||null}),e,e))}))},e.prototype.handleTextDeselection=function(e){var t=this.el;!!e.target.closest("#quotable-toolbar")||I(null,t,t)},e.prototype.handleTextSelection=function(){var e=this.el,t=this.settings,n=this.getSelectedText,o=this.Toolbar,r=t.twitter,l=t.url,i=n();if(i&&""!==i.text){var u=i.text,a=i.top,c=i.left,s=i.right,_=e.getBoundingClientRect();I(y(o,{text:u,url:l,style:{top:a-_.top-10,left:(c+s)/2-_.left,position:"absolute"},twitter:r||null}),e,e)}},e.prototype.handleTwitterIntent=function(e){for(var t=e.target;t&&"a"!==t.nodeName.toLowerCase();)t=t.parentNode;if(t&&"a"===t.nodeName.toLowerCase()&&t.href&&t.href.match(/twitter\.com\/intent\/(\w+)/)){var n=Math.round(screen.width/2-275),o=screen.height>420?Math.round(screen.height/2-210):0;window.open(t.href,"intent","scrollbars=yes,resizable=yes,toolbar=no,location=yes,width=550,height=420,left="+n+",top="+o),e.preventDefault()}},e.prototype.wrapContents=function(e,t,n){var o=document.createElement(t);o.classList.add(n),o.innerHTML=e.innerHTML,e.innerHTML=o.outerHTML},e.prototype.getSelectedText=function(){var e,t;return window.getSelection&&(e=window.getSelection()).rangeCount>0?{top:(t=e.getRangeAt(0).getBoundingClientRect()).top,left:t.left,right:t.right,text:e.toString()}:(e=document.selection.createRange()).text},e.prototype.Toolbar=function(e){var t=e.text,n=e.style,o=e.twitter,r=e.url,l=n&&(n.top||n.left),i=U(U(U({},n),{textDecoration:"none"}),l?{transform:"translate(-50%, -100%)"}:{}),u="";if(o){var a=o.hashtags,c=o.related,s=o.via,_=U(U(U({text:t,url:r},c?{related:c}:{}),s?{via:s}:{}),a&&a.length?{hashtags:a.join(",")}:{});u="http://twitter.com/intent/tweet?"+Object.keys(_).map((function(e){return encodeURIComponent(e)+"="+encodeURIComponent(_[e])})).join("&")}return y("span",{id:l?"quotable-toolbar":"",style:i},y("a",{class:"quotable-link",href:u,onMouseOver:l?function(){}:function(e){e.target.closest("blockquote, p").querySelector(".quotable-text").style.background="rgba(100,100,100,0.1)"},onMouseOut:l?function(){}:function(e){e.target.closest("blockquote, p").querySelector(".quotable-text").style.background=null}},y("div",{style:{display:"inline-block",width:"1em",height:"1em",lineHeight:"1em",fill:"currentColor",margin:l?"0":"0 0.2em",paddingTop:l?"0":"0.1em"},dangerouslySetInnerHTML:{__html:'<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -50 50 50"><path d="M49.998-40.494a20.542 20.542 0 01-5.892 1.614 10.28 10.28 0 004.511-5.671 20.53 20.53 0 01-6.514 2.488 10.246 10.246 0 00-7.488-3.237c-5.665 0-10.258 4.589-10.258 10.249 0 .804.091 1.586.266 2.337-8.526-.429-16.085-4.509-21.144-10.709a10.19 10.19 0 00-1.389 5.152c0 3.556 1.811 6.693 4.564 8.531a10.23 10.23 0 01-4.647-1.282l-.001.128c0 4.966 3.537 9.11 8.229 10.052a10.332 10.332 0 01-4.633.175 10.27 10.27 0 009.583 7.118 20.594 20.594 0 01-12.74 4.388 20.6 20.6 0 01-2.447-.145A29.048 29.048 0 0015.723-4.7c18.868 0 29.186-15.618 29.186-29.162 0-.445-.01-.887-.03-1.326a20.827 20.827 0 005.119-5.306z"/></svg>'}})))},e}();function B(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var o=Object.getOwnPropertySymbols(e);t&&(o=o.filter((function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable}))),n.push.apply(n,o)}return n}function R(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?B(Object(n),!0).forEach((function(t){p()(e,t,n[t])})):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):B(Object(n)).forEach((function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))}))}return e}window.addEventListener("DOMContentLoaded",(function(){var e=wpQuotable,t=e.containerId,n=e.pageUrl,o=e.authorTwitter,r=e.siteSocial,l=e.tags,i=e.isActive;new H({selector:"#".concat(t),isActive:R({},i,{include:[".quotable-quote-enabled"],exclude:[".quotable-quote-disabled"]}),url:n,twitter:{via:o,related:r&&r.twitter_site,hashtags:[].concat(s()(l),["quotable"])}}).activate()}))}]);