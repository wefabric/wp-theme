@php
    $mobileLayout = $block['data']['layout_mobile'] ?? 1;
    $tabletLayout = $block['data']['layout_tablet'] ?? 1;
    $desktopLayout = $block['data']['layout_desktop'] ?? 1;
    $desktopXlLayout = $block['data']['layout_desktop_xl'] ?? 1;

    $layoutClasses = [
        'mobile' => 'grid-cols-' . $mobileLayout,
        'tablet' => 'sm:grid-cols-' . $tabletLayout,
        'desktop' => 'xl:grid-cols-' . $desktopLayout,
        'desktop-xl' => '2xl:grid-cols-' . $desktopXlLayout,
    ];

    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;
    $swiperAutoplay = $block['data']['autoplay'] ?? false;
    $swiperAutoplaySpeed = max((int)($block['data']['autoplay_speed'] ?? 0) * 1000, 5000);
    $swiperLoop = $block['data']['loop_slides'] ?? true;
    $swiperCenteredSlides = $block['data']['centered_slides'] ?? false;
    $randomNumber = rand(0, 1000);
    $paginationStyle = $block['data']['pagination_style'] ?? 'bullets';
    $randomId = 'videoSliderSwiper-' . $randomNumber;

    $spaceBetween = $block['data']['space_between'] ?? 20;
@endphp

@if($block['data']['show_slider'])
    <div class="slider video-swiper block relative">
        <div class="swiper {{ $randomId }} py-8">
            <div class="swiper-wrapper items-center">
                @foreach ($videosData as $video)
                    <div class="swiper-slide h-auto">
                        @include('components.video-slider.list-item')
                    </div>
                @endforeach
            </div>
            @if ($paginationStyle != 'none')
                <div class="swiper-pagination"></div>
            @endif
        </div>
        <div class="swiper-navigation">
            <div class="swiper-button-next videoslider-button-next-{{ $randomNumber }}"></div>
            <div class="swiper-button-prev videoslider-button-prev-{{ $randomNumber }}"></div>
        </div>
    </div>
@else
    <div class="grid {{ $layoutClasses['mobile'] }} {{ $layoutClasses['tablet'] }} {{ $layoutClasses['desktop'] }} {{ $layoutClasses['desktop-xl'] }} gap-y-4 gap-x-4 lg:gap-x-8 lg:gap-y-8 py-8">
        @foreach ($videosData as $video)
            @include('components.video-slider.list-item')
        @endforeach
    </div>
@endif

@if ($swiperOutContainer)
    <style>
        .videoSliderSwiper-{{ $randomNumber }} {
            overflow: unset !important;
        }
    </style>
@endif

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var videoSliderSwiper = new Swiper(".{{ $randomId }}", {
            touchStartPreventDefault: false,
            spaceBetween: {{ $spaceBetween }},
            @if ($swiperCenteredSlides)
                centeredSlides: true,
            @endif
            @if ($swiperAutoplay)
                autoplay: {
                    delay: {{ $swiperAutoplaySpeed }},
                    disableOnInteraction: true,
                },
            @endif
            pagination: {
                el: '.swiper-pagination',
                @if ($paginationStyle == 'progress_bar')
                    type: 'progressbar',
                @elseif ($paginationStyle == 'bullets')
                    clickable: true,
                @endif
            },
            navigation: {
                nextEl: ".videoslider-button-next-{{ $randomNumber }}",
                prevEl: ".videoslider-button-prev-{{ $randomNumber }}",
            },
            breakpoints: {
                0: {
                    loop: {{ $swiperLoop && count($videosData) > $mobileLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $mobileLayout }},
                },
                640: {
                    loop: {{ $swiperLoop && count($videosData) > $tabletLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $tabletLayout }},
                },
                1280: {
                    loop: {{ $swiperLoop && count($videosData) > $desktopLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopLayout }},
                },
                1536: {
                    loop: {{ $swiperLoop && count($videosData) > $desktopXlLayout ? 'true' : 'false' }},
                    slidesPerView: {{ $desktopXlLayout }},
                },
            }
        });

        // Overlay blijft altijd actief: swipes gaan naar Swiper, taps via postMessage naar de player
        var swiperContainerEl = document.querySelector('.{{ $randomId }}');
        if (swiperContainerEl) {
            function sendVideoCommand(iframe, playing) {
                if (!iframe || !iframe.contentWindow) return;
                var src = iframe.src || '';
                if (src.indexOf('youtube.com') !== -1) {
                    iframe.contentWindow.postMessage(JSON.stringify({
                        event: 'command',
                        func: playing ? 'pauseVideo' : 'playVideo',
                        args: []
                    }), 'https://www.youtube.com');
                } else if (src.indexOf('vimeo.com') !== -1) {
                    iframe.contentWindow.postMessage(JSON.stringify({
                        method: playing ? 'pause' : 'play'
                    }), 'https://player.vimeo.com');
                }
            }

            function pauseAllVideos() {
                swiperContainerEl.querySelectorAll('[data-iframe-guard]').forEach(function(g) {
                    if (g._playing) {
                        sendVideoCommand(g.closest('.video-container').querySelector('iframe'), true);
                        g._playing = false;
                    }
                });
            }

            function addIframeGuards() {
                swiperContainerEl.querySelectorAll('.video-container').forEach(function(container) {
                    if (!container.querySelector('iframe') || container.querySelector('[data-iframe-guard]')) return;

                    var guard = document.createElement('div');
                    guard.setAttribute('data-iframe-guard', '');
                    guard.style.cssText = 'position:absolute;inset:0;z-index:2;cursor:pointer;';
                    guard._playing = false;
                    container.appendChild(guard);

                    var startX = 0, startY = 0, moved = false;

                    guard.addEventListener('touchstart', function(e) {
                        startX = e.touches[0].clientX;
                        startY = e.touches[0].clientY;
                        moved = false;
                    }, {passive: true});

                    guard.addEventListener('touchmove', function(e) {
                        if (Math.abs(e.touches[0].clientX - startX) > 8 ||
                            Math.abs(e.touches[0].clientY - startY) > 8) {
                            moved = true;
                        }
                    }, {passive: true});

                    function toggleVideo() {
                        sendVideoCommand(container.querySelector('iframe'), guard._playing);
                        guard._playing = !guard._playing;
                    }

                    guard.addEventListener('touchend', function() {
                        if (!moved) toggleVideo();
                    }, {passive: true});

                    guard.addEventListener('click', toggleVideo);
                });
            }

            addIframeGuards();

            videoSliderSwiper.on('slideChange', function() {
                pauseAllVideos();
                addIframeGuards();
            });
        }
    });
</script>