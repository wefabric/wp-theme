@php
    $mobileLayout = $options['logo_layout']['mobile'] ?? 2;
    $tabletLayout = $options['logo_layout']['tablet'] ?? 3;
    $desktopLayout = $options['logo_layout']['desktop']?? 4;
    $desktopXlLayout = $options['logo_layout']['desktop_xl'] ?? 5;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'xl:grid-cols-' . $desktopLayout,
        'desktop-xl' => '2xl:grid-cols-' . $desktopXlLayout,
    ];

    $swiperOutContainer = $options['logo_slider_outside_container'] ?? false;
    $swiperAutoplay = $options['logo_autoplay'] ?? false;
    $swiperAutoplaySpeed = max((int)($options['logo_autoplay_speed'] ?? 0) * 1000, 5000);
    $swiperLoop = $options['logo_loop_slides'] ?? true;
    $swiperCenteredSlides = $options['logo_centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $randomId = 'footerLogoSwiper-' . $randomNumber;
@endphp

@if($options['logo_show_slider'])
    <div class="slider block relative">
        <div class="swiper {{ $randomId }} py-4">
            <div class="swiper-wrapper items-center">
                @foreach ($option['logos']['logos'] ?? [] as $logo)
                    @php
                        $logoImage = $logo['image'] ?? null;
                        $logoName = !empty($logo['name']) ? $logo['name'] : 'Logo';
                    @endphp

                    @if($logoImage)
                        <div class="swiper-slide flex items-center justify-center w-full ">
                            @include('components.image', [
                                'image_id' => $logoImage,
                                'size' => 'full',
                                'object_fit' => 'contain',
                                'img_class' => 'max-w-[130px] max-h-[60px] transition ease-in-out duration-300',
                                'alt' => $logoName,
                            ])
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="footer-logo-list grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-4 gap-x-4 lg:gap-x-8 py-2">
        @foreach ($option['logos']['logos'] ?? [] as $logo)
            @php
                $logoImage = $logo['image'] ?? null;
                $logoName = !empty($logo['name']) ? $logo['name'] : 'Logo';
            @endphp

            @if($logoImage)
                <div class="swiper-slide flex items-center justify-center w-full">
                    @include('components.image', [
                        'image_id' => $logoImage,
                        'size' => 'full',
                        'object_fit' => 'contain',
                        'img_class' => 'max-w-[130px] max-h-[60px] transition ease-in-out duration-300',
                        'alt' => $logoName,
                    ])
                </div>
            @endif
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .footerLogoSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var footerLogoSwiper = new Swiper(".{{ $randomId }}", {
            spaceBetween: 20,
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperAutoplay)
            autoplay: {
                    delay: {{ $swiperAutoplaySpeed }},
                    disableOnInteraction: false,
                },
            @endif
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($option['logos']['logos'] ?? []) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ $swiperLoop && count($option['logos']['logos'] ?? []) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($option['logos']['logos'] ?? []) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($option['logos']['logos'] ?? []) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });
        @if ($swiperAutoplay)
            // Swiper's own pause/resume bookkeeping can get orphaned when a click or
            // drag interrupts a transition, leaving autoplay stuck forever. This
            // watchdog force-restarts it whenever it stalls for longer than a normal
            // tick, regardless of what interaction caused the stall.
            (function () {
                var stallThreshold = {{ $swiperAutoplaySpeed }} + 2000;
                var lastTranslate = null;
                var lastChange = Date.now();

                setInterval(function () {
                    if (!footerLogoSwiper || footerLogoSwiper.destroyed || !footerLogoSwiper.autoplay) return;

                    var currentTranslate = footerLogoSwiper.translate;
                    if (currentTranslate !== lastTranslate) {
                        lastTranslate = currentTranslate;
                        lastChange = Date.now();
                        return;
                    }

                    if (footerLogoSwiper.autoplay.running && (Date.now() - lastChange) > stallThreshold) {
                        footerLogoSwiper.autoplay.paused = false;
                        footerLogoSwiper.autoplay.stop();
                        footerLogoSwiper.autoplay.start();
                        lastChange = Date.now();
                    }
                }, 1000);
            })();
        @endif
    });
</script>