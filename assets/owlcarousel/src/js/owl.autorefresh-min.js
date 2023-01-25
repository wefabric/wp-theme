/**
 * AutoRefresh Plugin
 * @version 2.3.4
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
!function($,t,e,i){var s=function(t){this._core=t,this._interval=null,this._visible=null,this._handlers={"initialized.owl.carousel":$.proxy((function(t){t.namespace&&this._core.settings.autoRefresh&&this.watch()}),this)},this._core.options=$.extend({},s.Defaults,this._core.options),this._core.$element.on(this._handlers)};s.Defaults={autoRefresh:!0,autoRefreshInterval:500},s.prototype.watch=function(){this._interval||(this._visible=this._core.isVisible(),this._interval=t.setInterval($.proxy(this.refresh,this),this._core.settings.autoRefreshInterval))},s.prototype.refresh=function(){this._core.isVisible()!==this._visible&&(this._visible=!this._visible,this._core.$element.toggleClass("owl-hidden",!this._visible),this._visible&&this._core.invalidate("width")&&this._core.refresh())},s.prototype.destroy=function(){var e,i;for(e in t.clearInterval(this._interval),this._handlers)this._core.$element.off(e,this._handlers[e]);for(i in Object.getOwnPropertyNames(this))"function"!=typeof this[i]&&(this[i]=null)},$.fn.owlCarousel.Constructor.Plugins.AutoRefresh=s}(window.Zepto||window.jQuery,window,document);