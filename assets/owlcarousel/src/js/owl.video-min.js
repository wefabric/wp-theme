/**
 * Video Plugin
 * @version 2.3.4
 * @author Bartosz Wojciechowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
!function($,e,t,i){var o=function(e){this._core=e,this._videos={},this._playing=null,this._handlers={"initialized.owl.carousel":$.proxy((function(e){e.namespace&&this._core.register({type:"state",name:"playing",tags:["interacting"]})}),this),"resize.owl.carousel":$.proxy((function(e){e.namespace&&this._core.settings.video&&this.isInFullScreen()&&e.preventDefault()}),this),"refreshed.owl.carousel":$.proxy((function(e){e.namespace&&this._core.is("resizing")&&this._core.$stage.find(".cloned .owl-video-frame").remove()}),this),"changed.owl.carousel":$.proxy((function(e){e.namespace&&"position"===e.property.name&&this._playing&&this.stop()}),this),"prepared.owl.carousel":$.proxy((function(e){if(e.namespace){var t=$(e.content).find(".owl-video");t.length&&(t.css("display","none"),this.fetch(t,$(e.content)))}}),this)},this._core.options=$.extend({},o.Defaults,this._core.options),this._core.$element.on(this._handlers),this._core.$element.on("click.owl.video",".owl-video-play-icon",$.proxy((function(e){this.play(e)}),this))};o.Defaults={video:!1,videoHeight:!1,videoWidth:!1},o.prototype.fetch=function(e,t){var i=e.attr("data-vimeo-id")?"vimeo":e.attr("data-vzaar-id")?"vzaar":"youtube",o=e.attr("data-vimeo-id")||e.attr("data-youtube-id")||e.attr("data-vzaar-id"),a=e.attr("data-width")||this._core.settings.videoWidth,r=e.attr("data-height")||this._core.settings.videoHeight,s=e.attr("href");if(!s)throw new Error("Missing video URL.");if((o=s.match(/(http:|https:|)\/\/(player.|www.|app.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com|be\-nocookie\.com)|vzaar\.com)\/(video\/|videos\/|embed\/|channels\/.+\/|groups\/.+\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/))[3].indexOf("youtu")>-1)i="youtube";else if(o[3].indexOf("vimeo")>-1)i="vimeo";else{if(!(o[3].indexOf("vzaar")>-1))throw new Error("Video URL not supported.");i="vzaar"}o=o[6],this._videos[s]={type:i,id:o,width:a,height:r},t.attr("data-video",s),this.thumbnail(e,this._videos[s])},o.prototype.thumbnail=function(e,t){var i,o,a=t.width&&t.height?"width:"+t.width+"px;height:"+t.height+"px;":"",r=e.find("img"),s="src",n="",l=this._core.settings,d=function(t){'<div class="owl-video-play-icon"></div>',i=l.lazyLoad?$("<div/>",{class:"owl-video-tn "+n,srcType:t}):$("<div/>",{class:"owl-video-tn",style:"opacity:1;background-image:url("+t+")"}),e.after(i),e.after('<div class="owl-video-play-icon"></div>')};if(e.wrap($("<div/>",{class:"owl-video-wrapper",style:a})),this._core.settings.lazyLoad&&(s="data-src",n="owl-lazy"),r.length)return d(r.attr(s)),r.remove(),!1;"youtube"===t.type?(o="//img.youtube.com/vi/"+t.id+"/hqdefault.jpg",d(o)):"vimeo"===t.type?$.ajax({type:"GET",url:"//vimeo.com/api/v2/video/"+t.id+".json",jsonp:"callback",dataType:"jsonp",success:function(e){o=e[0].thumbnail_large,d(o)}}):"vzaar"===t.type&&$.ajax({type:"GET",url:"//vzaar.com/api/videos/"+t.id+".json",jsonp:"callback",dataType:"jsonp",success:function(e){o=e.framegrab_url,d(o)}})},o.prototype.stop=function(){this._core.trigger("stop",null,"video"),this._playing.find(".owl-video-frame").remove(),this._playing.removeClass("owl-video-playing"),this._playing=null,this._core.leave("playing"),this._core.trigger("stopped",null,"video")},o.prototype.play=function(e){var t,i=$(e.target).closest("."+this._core.settings.itemClass),o=this._videos[i.attr("data-video")],a=o.width||"100%",r=o.height||this._core.$stage.height();this._playing||(this._core.enter("playing"),this._core.trigger("play",null,"video"),i=this._core.items(this._core.relative(i.index())),this._core.reset(i.index()),(t=$('<iframe frameborder="0" allowfullscreen mozallowfullscreen webkitAllowFullScreen ></iframe>')).attr("height",r),t.attr("width",a),"youtube"===o.type?t.attr("src","//www.youtube.com/embed/"+o.id+"?autoplay=1&rel=0&v="+o.id):"vimeo"===o.type?t.attr("src","//player.vimeo.com/video/"+o.id+"?autoplay=1"):"vzaar"===o.type&&t.attr("src","//view.vzaar.com/"+o.id+"/player?autoplay=true"),$(t).wrap('<div class="owl-video-frame" />').insertAfter(i.find(".owl-video")),this._playing=i.addClass("owl-video-playing"))},o.prototype.isInFullScreen=function(){var e=t.fullscreenElement||t.mozFullScreenElement||t.webkitFullscreenElement;return e&&$(e).parent().hasClass("owl-video-frame")},o.prototype.destroy=function(){var e,t;for(e in this._core.$element.off("click.owl.video"),this._handlers)this._core.$element.off(e,this._handlers[e]);for(t in Object.getOwnPropertyNames(this))"function"!=typeof this[t]&&(this[t]=null)},$.fn.owlCarousel.Constructor.Plugins.Video=o}(window.Zepto||window.jQuery,window,document);