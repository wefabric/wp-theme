import Alpine from 'alpinejs'
// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination, Autoplay } from 'swiper';
// import Swiper and modules styles


// Import dependencies
window.$ = window.jQuery = require('jquery');

// Import custom JS files
import './outOfOffice';
import './forms';
import './wc-search';
import './wc-single-product';
import './offer-dynamic-url';
import './dynamic-content';
import './custom-cart';
import './cad-download-toggle';

Swiper.use([Navigation, Pagination, Autoplay]);

window.Alpine = Alpine
window.Swiper = Swiper;
window.SwiperPagination = Pagination;
window.SwiperNavigation = Navigation;
Alpine.start()