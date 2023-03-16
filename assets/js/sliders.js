var swiper = new Swiper(".relatedProductSwiper", {
    slidesPerView: 1,
    spaceBetween: 0,
    pagination: {
        el: ".swiper-pagination",
        clickable: true,
    },

    // Responsive breakpoints
    breakpoints: {
        // when window width is >= 6400px
        640: {
            slidesPerView: 1,
            spaceBetween: 0
        },
        // when window width is >= 768px
        768: {
            slidesPerView: 2,
            spaceBetween: 0
        },
        // when window width is >= 1024px
        1024: {
            slidesPerView: 3,
            spaceBetween: 0
        },
        // when window width is >= 1350px
        1350: {
            slidesPerView: 4,
            spaceBetween: 0
        }
    }
});