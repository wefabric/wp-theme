import Alpine from 'alpinejs'
// core version + navigation, pagination modules:
import Swiper, { Navigation, Pagination } from 'swiper';
// import Swiper and modules styles


// Import dependencies
window.$ = window.jQuery = require('jquery');

// Import custom JS files
import './outOfOffice';
import './forms';

window.Alpine = Alpine
window.Swiper = Swiper;
window.SwiperPagination = Pagination;
window.SwiperNavigation = Navigation;
Alpine.start()


// Hamburger Init
$(document).ready(function(){
  $(".hamburger").click(function(){
    $(this).toggleClass("is-active");
  });
});

$(document).ready(function(){
  $(".hamburger").click(function(){
      $("html").toggleClass("mobile-is-active");
  });
});

// Sticky Header
var activeSticky = $("body"),
  winDow = $(window);
winDow.on("scroll", function () {
  var scroll = $(window).scrollTop(),
    isSticky = activeSticky;
  if (scroll < 1) {
    isSticky.removeClass("header-is-sticky");
  } else {
    isSticky.addClass("header-is-sticky");
  }
});
