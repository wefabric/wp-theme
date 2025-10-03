import Alpine from 'alpinejs'
// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination, Autoplay, Zoom, Thumbs, EffectFade } from 'swiper';
// import Swiper and modules styles
import SplitType from "split-type";
import gsap from "gsap";
import TelQr from '@wefabric/telqr';
import googleMaps from './google_maps';

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
import './indicator';
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

Alpine.data('google_maps', googleMaps);
Alpine.start();

// Initialize with default settings
document.addEventListener('DOMContentLoaded', () => {
    new TelQr({
        showToCallText: 'Klik om te bellen',
        scanToCallText: 'Scan om te bellen',
        buttonText: 'Bel op dit apparaat',
        qrCode: {
            width: 200,
            height: 200,
            correctLevel: 'L',
            colorDark: '#000000',
            colorLight: '#ffffff'
        },
        styling: {
            modal: {
                background: '#ffffff',
                borderRadius: '16px',
                padding: '32px',
                maxWidth: '350px'
            },
            button: {
                background: '#007cba',
                color: 'white',
                fontSize: '16px'
            }
        }
    });
});