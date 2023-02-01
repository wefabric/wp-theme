/**
 * Modernizr Support Plugin
 *
 * @version 2.3.4
 * @author Vivid Planet Software GmbH
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
!function($,n,i,t,o){var r={transition:{end:{WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd",transition:"transitionend"}},animation:{end:{WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd",animation:"animationend"}}};if(!n)throw new Error("Modernizr is not loaded.");$.each(["cssanimations","csstransitions","csstransforms","csstransforms3d","prefixed"],(function(i,t){if(void 0===n[t])throw new Error(['Modernizr "',t,'" is not loaded.'].join(""))})),n.csstransitions&&($.support.transition=new String(n.prefixed("transition")),$.support.transition.end=r.transition.end[$.support.transition],/Android 4\.[123]/.test(navigator.userAgent)&&($.support.transition.end="webkitTransitionEnd")),n.cssanimations&&($.support.animation=new String(n.prefixed("animation")),$.support.animation.end=r.animation.end[$.support.animation]),n.csstransforms&&($.support.transform=new String(n.prefixed("transform")),$.support.transform3d=n.csstransforms3d)}(window.Zepto||window.jQuery,window.Modernizr,window,document);