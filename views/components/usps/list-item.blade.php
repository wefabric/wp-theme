@php
    $visualType = $block['data']['visual_type'] ?? 'icons';

    $uspTitle = $usp['uspTitle'];
    $uspText = $usp['uspText'];
    $uspLink = $usp['uspLink'];
    $uspUrl = $uspLink['url'] ?? '';
    $icon = $usp['uspIcon'];

    $imageId = $usp['uspImage'];
    $altText = get_post_meta($imageId, '_wp_attachment_image_alt', true) ?: 'usp-image';
    $numberAnimation = $block['data']['number_animation'] ?? false;

    // Extract numeric part from $uspTitle
    preg_match('/(\d+)/', $uspTitle, $matches);
    $numericPart = $matches[0] ?? '';
    $isNumber = !empty($numericPart);
@endphp


<div class="USP-item h-full usp-{{ $uspLayout }} @if ($flyinEffect) usp-hidden @endif @if($uspBackgroundColor) bg-{{ $uspBackgroundColor }} p-4 lg:p-8 @endif">

    @if (!empty($uspUrl) && $uspUrl)
        <a href="{{ $uspUrl }}" class="usp-url" aria-label="Ga naar {{ $uspTitle }} pagina">
    @endif


    <div class="item-styling h-full @if( $uspLayout == 'horizontal') flex flex-row gap-x-6 items-center text-left justify-start @elseif( $uspLayout == 'vertical') flex flex-col gap-y-4 text-center @endif">
        @if (($visualType == 'icons') && ($icon))
            <i class="fa-{{ $icon['style'] }} fa-{{ $icon['id'] }} text-{{ $uspIconColor }} text-[70px] inline-block"
               aria-hidden="true"></i>
        @endif
        @if (($visualType == 'images') && ($imageId))
            @include('components.image', [
                'image_id' => $imageId,
                'size' => 'full',
                'object_fit' => 'cover',
                'img_class' => 'mx-auto w-auto h-auto max-w-full max-h-20',
                'alt' => $altText,
            ])
        @endif
        @if ($uspTitle || $uspText)
            <div class="usp-data">
                @if ($uspTitle)
                    <div class="usp-title text-{{ $uspTitleColor }} font-bold h4">
                        @if ($isNumber && $numberAnimation)
                            <span class="counter" data-target="{{ $numericPart }}">0</span>{{ str_replace($numericPart, '', $uspTitle) }}
                        @else
                            @include('components.content', ['content' => $uspTitle])
                        @endif
                    </div>
                @endif
                @if ($uspText)
                    @include('components.content', ['content' => $uspText, 'class' => 'usp-text mt-2 text-' . $uspTextColor])
                @endif
            </div>
        @endif
    </div>

    @if (!empty($uspUrl) && $uspUrl)
        </a>
    @endif


</div>

@if ($isNumber && $numberAnimation)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const counters = document.querySelectorAll('.counter');
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observerCallback = (entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const counter = entry.target;
                        const target = +counter.getAttribute('data-target');
                        const duration = 1000;
                        const frameRate = 60;
                        const updateInterval = 1000 / frameRate;
                        const totalSteps = duration / updateInterval;
                        const increment = target / totalSteps;

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
                        observer.unobserve(counter);
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