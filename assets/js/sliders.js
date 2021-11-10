jQuery('.slick-carousel.usp-slider').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    mobileFirst: true,
    responsive: [
        {
            breakpoint: 768,
            settings: 'unslick'
        }
    ]
});