import Alpine from 'alpinejs'
// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination, Autoplay, Zoom, Thumbs } from 'swiper';
// import Swiper and modules styles



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
import './../../../theme-child/assets/js/app'; // Child theme js

Swiper.use([Navigation, Pagination, Autoplay , Zoom, Thumbs]);

window.Alpine = Alpine
window.Swiper = Swiper;
window.SwiperPagination = Pagination;
window.SwiperNavigation = Navigation;
Alpine.start()