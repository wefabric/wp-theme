<x-wefabric:section block-type="afbeelding-en-tekst" :block="$block">
    @php
        // Image / video data
        $imageId = $block['data']['image'] ?? 0;
        $imageAlt = $imageId ? get_post_meta($imageId, '_wp_attachment_image_alt', true) : '';
        $imageParallax = $block['data']['image_parallax'] ?? false;
        $stickyImage = $block['data']['sticky_image'] ?? false;
        $imageSize = (string)($block['data']['image_size'] ?? '50');
        $verticalCentered = $block['data']['vertical_centered'] ?? false;

        // Order text/image
        $textPosition = $textPosition ?? ($block['data']['text_position'] ?? '');
        $textOrderClass = $textPosition === 'left' ? 'lg:order-1 left' : 'lg:order-2 right';
        $imageOrderClass = $textPosition === 'left' ? 'lg:order-2 right' : 'lg:order-1 left';

        // Width map
        $sizes = [
            '33' => ['lg:w-1/3', 'lg:w-2/3'],
            '40' => ['lg:w-2/5', 'lg:w-3/5'],
            '50' => ['lg:w-1/2', 'lg:w-1/2'],
            '60' => ['lg:w-3/5', 'lg:w-2/5'],
            '66' => ['lg:w-2/3', 'lg:w-1/3'],
        ];
        [$imageWidthClass, $textWidthClass] = $sizes[$imageSize] ?? ['lg:w-1/2', 'lg:w-1/2'];


        // Links
        $linksCount = $block['data']['links'] ?? 0;
        $links = [];

            for ($i = 0; $i < $linksCount; $i++) {
            $linkKey = "links_{$i}_link";
            $linkText = $block['data'][$linkKey]['title'] ?? '';
            $linkUrl = $block['data'][$linkKey]['url'] ?? '';
            $linkTarget = $block['data'][$linkKey]['target'] ?? '_self';

            $linkIcon = $block['data']["links_{$i}_link_icon"] ?? '';
            $buttonIcon = '';
            if (!empty($linkIcon)) {
                $iconData = json_decode($linkIcon, true);
                if (isset($iconData['id'], $iconData['style'])) {
                    $buttonIcon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
                }
            }

            $links[] = [
                'linkText' => $linkText,
                'linkUrl' => $linkUrl,
                'linkTarget' => $linkTarget,
                'buttonIcon' => $buttonIcon,
                'linkIcon' => $linkIcon,
            ];
        }


        // USP
        $uspCount = $block['data']['usps'] ?? 0;
        $usp = [];

            for ($i = 0; $i < $uspCount; $i++) {
            $uspText = $block['data']["usps_{$i}_usp_text"] ?? '';

            $uspIcon = $block['data']["usps_{$i}_usp_icon"] ?? '';
            $buttonIcon = '';

            $usps[] = [
                'uspText' => $uspText,
                'uspIcon' => $uspIcon,
            ];
        }


        // Video
        $video = $block['data']['video_file'] ?? '';
        $fileId = is_numeric($video) ? intval($video) : 0;
        $mime = $fileId ? get_post_mime_type($fileId) : '';
        $url = $fileId ? wp_get_attachment_url($fileId) : '';
        $isVideo = $mime && (strpos($mime, 'video') === 0 || $mime === 'video/quicktime');

        // Text and buttons (already provided by component class)
        // $text, $textColor, $buttons, $textClass are available

        // Optional effects
        $flyinEffect = $block['data']['flyin_effect'] ?? false;
        $imageMaxHeight = $block['data']['image_max_height'] ?? '';
        $videoSetting = $block['data']['video_setting'] ?? 'automatic';
        $stickyText = !empty($block['data']['sticky_text']);
    @endphp

    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            <div class="text-image flex flex-col lg:flex-row gap-8 xl:gap-20 @if ($verticalCentered) lg:items-center @endif">
                <div class="text {{ $textWidthClass }} order-2 {{ $textOrderClass }} {{ $textClass }} @if($stickyText) h-fit sticky-text sticky top-[150px] @endif">
                    <x-wefabric:title :block="$block"/>

                    @if ($text)
                        <x-wefabric:content :content="$text"
                                            :class="'mb-8 text-' . $textColor . ($flyInAnimation ? ' flyin-animation' : '')"></x-wefabric:content>
                    @endif


                    @if ($links)
                        <div class="links-list flex flex-col gap-y-4">
                            @foreach($links as $link)
                                @if($link['linkText'] && $link['linkUrl'])
                                    <div class="link-item">
                                        <a href="{{ $link['linkUrl'] }}"
                                           aria-label="Ga naar {{ $link['linkText'] }} pagina"
                                           target="{{ $link['linkTarget'] }}" class="flex items-center gap-x-4 group">
                                            @if($link['linkIcon'])
                                                @php
                                                    $iconData = json_decode($link['linkIcon'], true);
                                                    $iconClass = 'fa-' . ($iconData['style'] ?? 'solid') . ' fa-' . ($iconData['id'] ?? '');
                                                @endphp
                                                <i class="fa {{ $iconClass }} text-[20px] w-[24px] h-[24px] flex justify-center items-center transition-transform duration-300 ease-in-out"
                                                   aria-hidden="true"></i>
                                            @endif
                                            <span class="link-text text-cta font-semibold group-hover:underline">{!! $link['linkText'] !!}</span>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                    @if ($usps)
                        <div class="usp-list flex flex-col gap-y-4">
                            @foreach($usps as $usp)
                                @if($usp['uspText'])
                                    <div class="usp-item flex items-center gap-x-4">
                                        @if($usp['uspIcon'])
                                            @php
                                                $iconData = json_decode($usp['uspIcon'], true);
                                                $iconClass = 'fa-' . ($iconData['style'] ?? 'solid') . ' fa-' . ($iconData['id'] ?? '');
                                            @endphp
                                            <i class="fa {{ $iconClass }} text-[20px] w-[24px] h-[24px] flex justify-center items-center"
                                               aria-hidden="true"></i>
                                        @endif
                                        <div class="usp-text text-{{ $textColor }} font-medium">{!! $usp['uspText'] !!}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif

                    @if ($buttons && $buttons->count() >= 1)
                        <div class="buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 @if($textPosition === 'center') justify-center @endif @if ($flyInAnimation) flyin-animation @endif">
                            @foreach ($buttons as $button)
                                {!! $button->render()->render(); !!}
                            @endforeach
                        </div>
                    @endif
                </div>

                @if ($isVideo && $url)
                    <div class="image {{ $imageWidthClass }} order-1 {{ $imageOrderClass }} @if ($imageParallax) parallax-image @endif @if($videoSetting === 'standard') relative @endif">
                        <video class="image-item w-full object-cover @if($stickyImage) sticky-image sticky top-[150px] @endif @if($flyinEffect) text-image-hidden @endif"
                               @if($videoSetting === 'automatic') autoplay muted loop playsinline @endif
                               @if($videoSetting === 'on_hover') muted loop playsinline @endif
                               preload="metadata"
                               @if($imageMaxHeight) style="max-height: {{ $imageMaxHeight }}px;" @endif>
                            <source src="{{ esc_url($url) }}" type="{{ esc_attr($mime) }}">
                            <source src="{{ esc_url($url) }}">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                @elseif ($imageId)
                    <div class="image {{ $imageWidthClass }} order-1 {{ $imageOrderClass }} @if ($imageParallax) parallax-image @endif">
                        @include('components.image', [
                            'image_id' => $imageId,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'image-item w-full object-cover' . ($stickyImage ? ' sticky-image sticky top-[150px]' : '') . ($flyinEffect ? ' text-image-hidden' : ''),
                            'alt' => $imageAlt,
                            'style' => $imageMaxHeight ? 'max-height: ' . $imageMaxHeight . 'px;' : ''
                        ])
                    </div>
                @endif
            </div>
        </div>
    </div>

</x-wefabric:section>

@if ($titleAnimation)
    <script>
        (function () {
            const findPrevSection = (el) => {
                let node = el ? el.previousElementSibling : null;
                while (node && node.tagName !== 'SECTION') {
                    node = node.previousElementSibling;
                }
                return node || document;
            };
            const __script_ta = document.currentScript;
            const __root_ta = findPrevSection(__script_ta);
            window.addEventListener("DOMContentLoaded", () => {
                gsap.registerPlugin(ScrollTrigger);

                const root = __root_ta || document;
                root.querySelectorAll('.title-animation').forEach(element => {
                    let typeSplit = new SplitType(element, {
                        types: 'lines, words, chars',
                        tagName: 'span'
                    });

                    const tl = gsap.timeline({
                        scrollTrigger: {
                            trigger: element, // The current element that triggers the animation
                            start: 'top 70%', // When the trigger element is 70% from the top of the viewport
                            end: 'top 50%', // Animation end point
                            scrub: true, // Synchronize with the scrollbar
                            once: false, // Ensures the animation can play multiple times with scroll
                            markers: false // Disable markers for production
                        }
                    });

                    const icon = element.querySelector('.subtitle-icon');

                    if (icon) {
                        tl.from(icon, {
                            y: '100%',
                            opacity: 0,
                            rotate: -10,
                            duration: 0.3,
                            ease: 'back.out(1.7)'
                        });
                    }

                    tl.from(element.querySelectorAll('.word'), {
                        y: '100%',
                        opacity: 0,
                        duration: 0.5,
                        ease: 'back',
                        stagger: 0.1
                    }, icon ? '>-0.05' : 0);
                });
            });
        })();
    </script>
@endif

@if ($flyInAnimation)
    <script>
        (function () {
            const findPrevSection = (el) => {
                let node = el ? el.previousElementSibling : null;
                while (node && node.tagName !== 'SECTION') {
                    node = node.previousElementSibling;
                }
                return node || document;
            };
            const __script_fi = document.currentScript;
            const __root_fi = findPrevSection(__script_fi);
            window.addEventListener('DOMContentLoaded', function () {
                gsap.registerPlugin(ScrollTrigger);

                const root = __root_fi || document;
                root.querySelectorAll('.flyin-animation').forEach(element => {
                    let typeSplit = new SplitType(element, {
                        types: 'lines',
                        tagName: 'span'
                    });

                    var fadeDirection = @json($textFadeDirection);
                    let xValue, yValue;

                    if (fadeDirection === "left") {
                        xValue = '-20%';
                    } else if (fadeDirection === "right") {
                        xValue = '20%';
                    } else {
                        xValue = '0%';
                    }

                    if (fadeDirection === "top") {
                        yValue = '-20%';
                    } else if (fadeDirection === "bottom") {
                        yValue = '20%';
                    } else {
                        yValue = '0%';
                    }

                    const tl = gsap.timeline({
                        scrollTrigger: {
                            trigger: element, // The current element that triggers the animation
                            start: 'top 65%', // When the trigger element is 60% from the top of the viewport
                            end: 'top 50%', // Animation end point
                            scrub: false, // If set to false, the animation will not synchronize with the scrollbar
                            once: true, // Ensures the animation triggers only once
                            markers: false // Disable markers for production
                        }
                    });

                    const icon = element.querySelector('.subtitle-icon');
                    if (icon) {
                        tl.from(icon, {
                            x: xValue,
                            y: yValue,
                            opacity: 0,
                            duration: 0.6,
                            ease: 'power3.out'
                        });
                    }

                    tl.from(element.querySelectorAll('.line'), {
                        x: xValue,
                        y: yValue,
                        opacity: 0,
                        duration: 1.5,
                        ease: 'power4.out',
                        stagger: 0
                    }, icon ? '>-0.1' : 0);
                });
            });
        })();
    </script>
@endif

<style>
    .text-image-hidden {
        opacity: 0;
    }

    .text-image-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>

{{-- Parallax effect (scoped to this section) --}}
@if ($imageParallax)
    <script>
        (function () {
            const findPrevSection = (el) => {
                let node = el ? el.previousElementSibling : null;
                while (node && node.tagName !== 'SECTION') {
                    node = node.previousElementSibling;
                }
                return node || document;
            };
            const __script_px = document.currentScript;
            const root = findPrevSection(__script_px);
            window.addEventListener('DOMContentLoaded', function () {
                const parallaxImage = root.querySelector('.parallax-image');
                if (!parallaxImage) return;
                const applyParallaxEffect = () => {
                    const scrollPosition = window.scrollY;
                    const blockRect = root.getBoundingClientRect();
                    const blockTop = blockRect.top + window.scrollY;
                    const blockHeight = blockRect.height;
                    const viewportCenter = scrollPosition + window.innerHeight / 2;
                    const blockCenter = blockTop + blockHeight / 2;
                    const distanceFromCenter = viewportCenter - blockCenter;
                    let parallaxFactor = -0.4;
                    if (window.innerWidth <= 1024) parallaxFactor = -0.1;
                    const translateY = distanceFromCenter * parallaxFactor;
                    parallaxImage.style.transform = `translateY(${translateY}px)`;
                };
                window.addEventListener('scroll', applyParallaxEffect);
                applyParallaxEffect();
            });
        })();
    </script>
@endif

{{-- Video behavior --}}
@if ($isVideo && $url)
    @if($videoSetting === 'automatic')
        <script>
            (function () {
                const findPrevSection = (el) => {
                    let n = el ? el.previousElementSibling : null;
                    while (n && n.tagName !== 'SECTION') {
                        n = n.previousElementSibling;
                    }
                    return n || document;
                };
                const __s = document.currentScript;
                const root = findPrevSection(__s);
                document.addEventListener('DOMContentLoaded', function () {
                    const vid = root.querySelector('video.image-item');
                    if (!vid) return;
                    const onChange = (entries) => {
                        entries.forEach(e => {
                            if (e.isIntersecting) {
                                vid.play().catch(() => {
                                });
                            } else {
                                vid.pause();
                            }
                        });
                    };
                    const io = new IntersectionObserver(onChange, {threshold: 0.2});
                    io.observe(vid);
                });
            })();
        </script>
    @elseif($videoSetting === 'on_hover')
        <script>
            (function () {
                const findPrevSection = (el) => {
                    let n = el ? el.previousElementSibling : null;
                    while (n && n.tagName !== 'SECTION') {
                        n = n.previousElementSibling;
                    }
                    return n || document;
                };
                const __s = document.currentScript;
                const root = findPrevSection(__s);
                document.addEventListener('DOMContentLoaded', function () {
                    const vid = root.querySelector('video.image-item');
                    if (!vid) return;
                    const startPlaying = () => {
                        if (vid.paused) {
                            vid.play().catch(() => {
                            });
                        }
                    };
                    vid.addEventListener('mouseenter', startPlaying);
                    let started = false;
                    vid.addEventListener('touchstart', function () {
                        if (!started) {
                            vid.play().catch(() => {
                            });
                            started = true;
                        }
                    }, {passive: true});
                });
            })();
        </script>
    @elseif($videoSetting === 'standard')
        <script>
            (function () {
                const findPrevSection = (el) => {
                    let n = el ? el.previousElementSibling : null;
                    while (n && n.tagName !== 'SECTION') {
                        n = n.previousElementSibling;
                    }
                    return n || document;
                };
                const __s = document.currentScript;
                const root = findPrevSection(__s);
                document.addEventListener('DOMContentLoaded', function () {
                    const wrap = root.querySelector('.image');
                    const vid = wrap ? wrap.querySelector('video.image-item') : null;
                    if (!vid || !wrap) return;
                    vid.removeAttribute('autoplay');
                    vid.pause();
                    // Overlay
                    const overlay = document.createElement('div');
                    overlay.className = 'video-overlay absolute inset-0 flex items-center justify-center pointer-events-none z-10';
                    const btn = document.createElement('button');
                    btn.setAttribute('aria-label', 'Play video');
                    btn.className = 'play-button pointer-events-auto w-20 h-20 rounded-full bg-white/70 text-black flex items-center justify-center shadow-lg';
                    btn.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>';
                    overlay.appendChild(btn);
                    wrap.style.position = 'relative';
                    wrap.appendChild(overlay);
                    btn.addEventListener('click', function () {
                        if (overlay && overlay.parentNode) {
                            overlay.parentNode.removeChild(overlay);
                        }
                        vid.muted = false;
                        vid.controls = true;
                        vid.removeAttribute('loop');
                        vid.play().catch(() => {
                        });
                        vid.addEventListener('ended', function () {
                            try {
                                vid.currentTime = 0;
                            } catch (e) {
                            }
                            vid.pause();
                        }, {once: true});
                    });
                });
            })();
        </script>
    @endif
@endif

{{-- Fly-in effect for images --}}
@if ($flyinEffect)
    <script>
        (function () {
            const findPrevSection = (el) => {
                let n = el ? el.previousElementSibling : null;
                while (n && n.tagName !== 'SECTION') {
                    n = n.previousElementSibling;
                }
                return n || document;
            };
            const __s = document.currentScript;
            const root = findPrevSection(__s);
            document.addEventListener('DOMContentLoaded', () => {
                const imageItems = root.querySelectorAll('.image-item');
                const observerOptions = {root: null, rootMargin: '0px 0px -30px 0px', threshold: 0.035};
                const observerCallback = (entries, observer) => {
                    entries.forEach((entry, index) => {
                        if (entry.isIntersecting) {
                            const imageItem = entry.target;
                            setTimeout(() => {
                                if (imageItem.classList.contains('text-image-hidden')) {
                                    imageItem.classList.add('text-image-animated');
                                    imageItem.classList.remove('text-image-hidden');
                                }
                            }, index * 200);
                            observer.unobserve(imageItem);
                        }
                    });
                };
                const observer = new IntersectionObserver(observerCallback, observerOptions);
                imageItems.forEach(item => observer.observe(item));
            });
        })();
    </script>
@endif