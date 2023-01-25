/**
 * Support Plugin
 *
 * @version 2.3.4
 * @author Vivid Planet Software GmbH
 * @author Artus Kolanowski
 * @author David Deutsch
 * @license The MIT License (MIT)
 */
!function($,n,i,t){var o=$("<support>").get(0).style,r="Webkit Moz O ms".split(" "),a={transition:{end:{WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd",transition:"transitionend"}},animation:{end:{WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd",animation:"animationend"}}},e=function(){return!!p("transform")},s=function(){return!!p("perspective")},u=function(){return!!p("animation")};function p(n,i){var t=!1,a=n.charAt(0).toUpperCase()+n.slice(1);return $.each((n+" "+r.join(a+" ")+a).split(" "),(function(n,r){if(undefined!==o[r])return t=!i||r,!1})),t}function d(n){return p(n,!0)}(function(){return!!p("transition")})()&&($.support.transition=new String(d("transition")),$.support.transition.end=a.transition.end[$.support.transition]),u()&&($.support.animation=new String(d("animation")),$.support.animation.end=a.animation.end[$.support.animation]),e()&&($.support.transform=new String(d("transform")),$.support.transform3d=s())}(window.Zepto||window.jQuery,window,document);