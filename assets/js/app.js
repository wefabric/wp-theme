import Alpine from 'alpinejs'
// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination, Autoplay, Zoom, Thumbs, EffectFade } from 'swiper';
// import Swiper and modules styles
import SplitType from "split-type";
import gsap from "gsap";

// Import dependencies
window.$ = window.jQuery = require('jquery');

// Import custom JS files
import './outOfOffice';
import './theme-modal';
import './forms';
import './wc-search';
import './wc-single-product';
import './offer-dynamic-url';
import './dynamic-content';
import './custom-cart';
import './cad-download-toggle';
import './lazyload';
import ThemeChildApp from './../../../theme-child/assets/js/app';

// Use Swiper and the necessary modules
Swiper.use([Navigation, Pagination, Autoplay, Zoom, Thumbs, EffectFade]);

window.Alpine = Alpine
window.Swiper = Swiper;
window.SwiperPagination = Pagination;
window.SwiperNavigation = Navigation;
window.SplitType = SplitType;
window.gsap = gsap;
window.ScrollTrigger = require("gsap/ScrollTrigger");

// Initialize child theme integrations before Alpine starts so x-data components are available
if (ThemeChildApp !== undefined) {
    ThemeChildApp.init();
}

Alpine.start();
