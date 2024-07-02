@php
    $uspTitle = $usp['uspTitle'];
    $uspText = $usp['uspText'];
    $icon = $usp['uspIcon'];
    $iconColor = $usp['uspIconColor'];
    $imageID = $usp['uspImage'];
    $uspTitleColor = $block['data']['usp_title_color'] ?? '';
    $uspTextColor = $block['data']['usp_text_color'] ?? '';
    $altText = get_post_meta($imageID, '_wp_attachment_image_alt', true) ?: 'usp-image';
    $numberAnimation = $block['data']['number_animation'] ?? false;

    // Extract numeric part from $uspTitle
    preg_match('/(\d+)/', $uspTitle, $matches);
    $numericPart = $matches[0] ?? '';
    $isNumber = !empty($numericPart);
@endphp

<div class="USP-item h-full usp-{{ $uspLayout }} ">
    <div class="item-styling h-full @if( $uspLayout == 'horizontal') flex flex-row gap-x-6 items-center text-left justify-center @elseif( $uspLayout == 'vertical') flex flex-col gap-y-4 text-center @endif">
        @if ($icon)
            <i class="fa-{{ $icon['style'] }} fa-{{ $icon['id'] }} text-{{ $iconColor }} text-[70px] inline-block"
               aria-hidden="true"></i>
        @endif
        @if ($imageID)
            @include('components.image', [
                'image_id' => $imageID,
                'size' => 'full',
                'object_fit' => 'cover',
                'img_class' => 'mx-auto w-auto h-auto max-w-full max-h-20',
                'alt' => $altText,
            ])
        @endif
        @if ($uspTitle || $uspText)
            <div class="usp-data">
                @if ($uspTitle)
                    <p class="usp-title text-{{ $uspTitleColor }} font-bold h4">
                        @if ($isNumber && $numberAnimation)
                            <span class="counter" data-target="{{ $numericPart }}">0</span>{{ str_replace($numericPart, '', $uspTitle) }}
                        @else
                            {!! $uspTitle !!}
                        @endif
                    </p>
                @endif
                @if ($uspText)
                    @include('components.content', ['content' => apply_filters('the_content', $uspText), 'class' => 'usp-text mt-2 text-' . $uspTextColor])
                @endif
            </div>
        @endif
    </div>
</div>

@if ($isNumber && $numberAnimation)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');
            const observerOptions = {
                root: null, // Use the viewport as the root
                rootMargin: '0px',
                threshold: 0.1 // Trigger when at least 10% of the element is in the viewport
            };

            const observerCallback = (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = +counter.getAttribute('data-target');
                        const duration = 1000; // Total duration in milliseconds (5 seconds)
                        const frameRate = 60; // 60 updates per second
                        const updateInterval = 1000 / frameRate; // Interval between updates in milliseconds
                        const totalSteps = duration / updateInterval; // Total number of steps
                        const increment = target / totalSteps; // Increment per step

                        let count = 0;

                        const updateCounter = () => {
                            count += increment;
                            if (count < target) {
                                counter.innerText = Math.ceil(count);
                                setTimeout(updateCounter, updateInterval);
                            } else {
                                counter.innerText = target;
                            }
                        };

                        updateCounter();
                        observer.unobserve(counter); // Stop observing once the animation starts
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);

            counters.forEach(counter => {
                observer.observe(counter);
            });
        });
    </script>
@endif