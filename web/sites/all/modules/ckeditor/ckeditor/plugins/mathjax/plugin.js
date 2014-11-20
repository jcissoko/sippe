﻿/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
(function(){var h="http://cdn.mathjax.org/mathjax/2.2-latest/MathJax.js?config=TeX-AMS_HTML";CKEDITOR.plugins.add("mathjax",{lang:"ca,cs,cy,de,el,en,en-gb,es,fa,fi,hu,ja,km,nb,nl,no,pl,pt,ro,ru,sv,uk,zh,zh-cn",requires:"widget,dialog",icons:"mathjax",hidpi:!0,init:function(a){var c=a.config.mathJaxClass||"math-tex";a.widgets.add("mathjax",{inline:!0,dialog:"mathjax",button:a.lang.mathjax.button,mask:!0,allowedContent:"span(!"+c+")",pathName:a.lang.mathjax.pathName,template:'<span class="'+c+'" style="display:inline-block" data-cke-survive=1></span>',
parts:{span:"span"},defaults:{math:"\\(x = {-b \\pm \\sqrt{b^2-4ac} \\over 2a}\\)"},init:function(){var b=this.parts.span.getChild(0);if(!b||b.type!=CKEDITOR.NODE_ELEMENT||!b.is("iframe"))b=new CKEDITOR.dom.element("iframe"),b.setAttributes({style:"border:0;width:0;height:0",scrolling:"no",frameborder:0,allowTransparency:!0,src:CKEDITOR.plugins.mathjax.fixSrc}),this.parts.span.append(b);this.once("ready",function(){CKEDITOR.env.ie&&b.setAttribute("src",CKEDITOR.plugins.mathjax.fixSrc);this.frameWrapper=
new CKEDITOR.plugins.mathjax.frameWrapper(b,a);this.frameWrapper.setValue(this.data.math)})},data:function(){this.frameWrapper&&this.frameWrapper.setValue(this.data.math)},upcast:function(b,a){if("span"==b.name&&b.hasClass(c)&&!(1<b.children.length||b.children[0].type!=CKEDITOR.NODE_TEXT)){a.math=b.children[0].value;var d=b.attributes;d.style=d.style?d.style+";display:inline-block":"display:inline-block";d["data-cke-survive"]=1;b.children[0].remove();return b}},downcast:function(b){b.children[0].replaceWith(new CKEDITOR.htmlParser.text(this.data.math));
var a=b.attributes;a.style=a.style.replace(/display:\s?inline-block;?\s?/,"");""===a.style&&delete a.style;return b}});CKEDITOR.dialog.add("mathjax",this.path+"dialogs/mathjax.js");a.on("contentPreview",function(b){b.data.dataValue=b.data.dataValue.replace(/<\/head>/,'<script src="'+(a.config.mathJaxLib?CKEDITOR.getUrl(a.config.mathJaxLib):h)+'"><\/script></head>')});a.on("paste",function(a){a.data.dataValue=a.data.dataValue.replace(RegExp("<span[^>]*?"+c+".*?</span>","ig"),function(a){return a.replace(/(<iframe.*?\/iframe>)/i,
"")})})}});CKEDITOR.plugins.mathjax={};CKEDITOR.plugins.mathjax.fixSrc=CKEDITOR.env.gecko?"javascript:true":CKEDITOR.env.ie?"javascript:void((function(){"+encodeURIComponent("document.open();("+CKEDITOR.tools.fixDomain+")();document.close();")+"})())":"javascript:void(0)";CKEDITOR.plugins.mathjax.loadingIcon=CKEDITOR.plugins.get("mathjax").path+"images/loader.gif";CKEDITOR.plugins.mathjax.copyStyles=function(a,c){for(var b="color font-family font-style font-weight font-variant font-size".split(" "),
e=0;e<b.length;e++){var d=b[e],g=a.getComputedStyle(d);g&&c.setStyle(d,g)}};CKEDITOR.plugins.mathjax.trim=function(a){var c=a.indexOf("\\(")+2,b=a.lastIndexOf("\\)");return a.substring(c,b)};CKEDITOR.plugins.mathjax.frameWrapper=CKEDITOR.env.ie&&8==CKEDITOR.env.version?function(a,c){a.getFrameDocument().write('<!DOCTYPE html><html><head><meta charset="utf-8"></head><body style="padding:0;margin:0;background:transparent;overflow:hidden"><span style="white-space:nowrap;" id="tex"></span></body></html>');
return{setValue:function(b){var e=a.getFrameDocument(),d=e.getById("tex");d.setHtml(CKEDITOR.plugins.mathjax.trim(b));CKEDITOR.plugins.mathjax.copyStyles(a,d);c.fire("lockSnapshot");a.setStyles({width:Math.min(250,d.$.offsetWidth)+"px",height:e.$.body.offsetHeight+"px",display:"inline","vertical-align":"middle"});c.fire("unlockSnapshot")}}}:function(a,c){function b(){f=a.getFrameDocument();f.getById("preview")||(CKEDITOR.env.ie&&a.removeAttribute("src"),f.write('<!DOCTYPE html><html><head><meta charset="utf-8"><script type="text/x-mathjax-config">MathJax.Hub.Config( {showMathMenu: false,messageStyle: "none"} );function getCKE() {if ( typeof window.parent.CKEDITOR == \'object\' ) {return window.parent.CKEDITOR;} else {return window.parent.parent.CKEDITOR;}}function update() {MathJax.Hub.Queue([ \'Typeset\', MathJax.Hub, this.buffer ],function() {getCKE().tools.callFunction( '+
m+" );});}MathJax.Hub.Queue( function() {getCKE().tools.callFunction("+n+');} );<\/script><script src="'+(c.config.mathJaxLib||h)+'"><\/script></head><body style="padding:0;margin:0;background:transparent;overflow:hidden"><span id="preview"></span><span id="buffer" style="display:none"></span></body></html>'))}function e(){k=!0;i=j;c.fire("lockSnapshot");d.setHtml(i);g.setHtml("<img src="+CKEDITOR.plugins.mathjax.loadingIcon+" alt="+c.lang.mathjax.loading+">");a.setStyles({height:"16px",width:"16px",
display:"inline","vertical-align":"middle"});c.fire("unlockSnapshot");f.getWindow().$.update(i)}var d,g,i,j,f=a.getFrameDocument(),l=!1,k=!1,n=CKEDITOR.tools.addFunction(function(){g=f.getById("preview");d=f.getById("buffer");l=!0;j&&e();CKEDITOR.fire("mathJaxLoaded",a)}),m=CKEDITOR.tools.addFunction(function(){CKEDITOR.plugins.mathjax.copyStyles(a,g);g.setHtml(d.getHtml());c.fire("lockSnapshot");a.setStyles({height:0,width:0});var b=Math.max(f.$.body.offsetHeight,f.$.documentElement.offsetHeight),
h=Math.max(g.$.offsetWidth,f.$.body.scrollWidth);a.setStyles({height:b+"px",width:h+"px"});c.fire("unlockSnapshot");CKEDITOR.fire("mathJaxUpdateDone",a);i!=j?e():k=!1});a.on("load",b);b();return{setValue:function(a){j=a;l&&!k&&e()}}}})();