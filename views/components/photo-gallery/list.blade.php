@php
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    // Use a deterministic unique identifier per block instance to avoid collisions when multiple galleries are on the same page
    $galleryUnique = $block['id'] ?? uniqid('pg-');
    $randomNumber = $galleryUnique; // keep backward compatibility for existing class references
    $swiperTopRandomId = 'photoGallerySwiper-' . $galleryUnique;
    $swiperThumbsRandomId = 'photoGallerySwiperThumbs-' . $galleryUnique;

    $dynamicImageCount = $block['data']['dynamic_image_count'] ?? false;

    if ($dynamicImageCount) {
        $mobileLayout = count($images);
        $tabletLayout = count($images);
        $desktopLayout = count($images);
    } else {
        $mobileLayout = $block['data']['layout_mobile'] ?? 3;
        $tabletLayout = $block['data']['layout_tablet'] ?? 3;
        $desktopLayout = $block['data']['layout_desktop'] ?? 4;
    }

    $spaceBetween = $block['data']['space_between'] ?? 20;
@endphp

<div class="block relative">
    <div class="flex flex-col">

        <!-- Top Slider -->
        <div class="swiper {{ $swiperTopRandomId }}">
            <div class="swiper-wrapper gallery-top" style="margin-bottom: {{$spaceBetween}}px">
                @foreach ($images as $imageID)
                    <div class="swiper-slide h-auto">
                        <div class="image h-full">
                            @include('components.image', [
                                'image_id' => $imageID,
                                'size' => 'full',
                                'object_fit' => 'cover',
                                'img_class' => 'w-full h-full max-h-[500px] object-cover rounded-' . $borderRadius . ' ' . $imageHeightClass,
                                'alt' => get_post_meta($imageID, '_wp_attachment_image_alt', true)
                            ])
                        </div>
                    </div>
                @endforeach
            </div>

{{--            Todo: paginatie toevoegen voor thumbslider?--}}
{{--            <!-- Pagination -->--}}
{{--            <div class="lg:hidden swiper-pagination"></div>--}}
{{--            <!-- Navigation Buttons -->--}}
{{--            <div class="swiper-button-next photogallery-button-next-{{ $randomNumber }}"></div>--}}
{{--            <div class="swiper-button-prev photogallery-button-prev-{{ $randomNumber }}"></div>--}}
        </div>

        <!-- Thumbs Slider -->
        <div class="swiper {{ $swiperThumbsRandomId }}">
            <div class="swiper-wrapper gallery-thumbs">
                @foreach ($images as $imageID)
                    <div class="swiper-slide h-auto">
                        <div class="thumb">
                            @include('components.image', [
                                'image_id' => $imageID,
                                'size' => 'full',
                                'object_fit' => 'cover',
                                'img_class' => 'w-full aspect-square object-cover rounded-' . $borderRadius,
                                'alt' => get_post_meta($imageID, '_wp_attachment_image_alt', true)
                            ])
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        // Thumbs Slider (init first to avoid double-initialization and ensure correct linkage)
        var thumbsSwiper = new Swiper(".{{ $swiperThumbsRandomId }}", {
            spaceBetween: {{ $spaceBetween }},
            freeMode: true,
            watchSlidesProgress: true,
            slideToClickedSlide: true,
            observer: true,
            observeParents: true,
            breakpoints: {
                0: {
                    loop: false,
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: false,
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: false,
                    slidesPerView: {{ $desktopLayout }},
                },
            }
        });

        // Top Slider
        var topSwiper = new Swiper(".{{ $swiperTopRandomId }}", {
            spaceBetween: {{ $spaceBetween }},
            slidesPerView: 1,
            observer: true,
            observeParents: true,
            @if ($swiperAutoplay)
            autoplay: {
                delay: {{ $swiperAutoplaySpeed }},
                disableOnInteraction: true,
            },
            @endif

            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: ".photogallery-button-next-{{ $randomNumber }}",
                prevEl: ".photogallery-button-prev-{{ $randomNumber }}",
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
        });

        // Ensure initial sync of Top with current Thumb active index
        if (typeof thumbsSwiper.activeIndex !== 'undefined') {
            topSwiper.slideTo(thumbsSwiper.activeIndex, 0);
        }
        // Extra safety: react on click when slideToClickedSlide is not enough in some Swiper versions
        thumbsSwiper.on('click', function(swiper){
            if (typeof swiper.clickedIndex !== 'undefined' && swiper.clickedIndex !== null) {
                topSwiper.slideTo(swiper.clickedIndex);
            }
        });
    });
</script>

<style>
    .gallery-thumbs .swiper-slide {
        height: 100%;
        opacity: 0.4;
        cursor: pointer;
        transition: opacity 0.3s ease-in-out;
    }

    .gallery-thumbs .swiper-slide:hover {
        opacity: 1;
        transition: opacity 0.3s ease-in-out;
    }

    .gallery-thumbs .swiper-slide-thumb-active {
        opacity: 1;
        transition: opacity 0.3s ease-in-out;
    }
</style>