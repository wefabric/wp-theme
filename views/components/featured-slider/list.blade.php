@php
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'featuredSliderSwiper-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 20;
@endphp

<div class="block relative">
    <div class="swiper {{ $randomId }}">
        <div class="swiper-wrapper">
            @foreach ($links as $link)
                <div class="swiper-slide h-auto">
                    @include('components.featured-slider.list-item')
                </div>
            @endforeach
        </div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var featuredSliderSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: {{ $spaceBetween }},
            centeredSlides: false,
            slidesPerView: 1,
            @if ($swiperAutoplay)
            autoplay: {
                disableOnInteraction: false,
                delay: 5000, // autoplay delay of 5 seconds
            },
            @endif
        });

        const linkItems = document.querySelectorAll('.link-item');

        function updateActiveLinkItem() {
            linkItems.forEach((item) => {
                item.classList.remove('active-slider-item');
            });
            const activeIndex = featuredSliderSwiper.realIndex;
            const activeItem = linkItems[activeIndex];
            activeItem.classList.add('active-slider-item');
        }

        // Initialize the active class on page load
        updateActiveLinkItem();

        // Listen for slide change events
        featuredSliderSwiper.on('slideChange', function () {
            updateActiveLinkItem();
        });

        linkItems.forEach((item) => {
            item.addEventListener('click', function () {
                const slideIndex = this.getAttribute('data-slide');
                featuredSliderSwiper.slideToLoop(slideIndex); // Slide to the clicked slide
            });
        });
    });
</script>