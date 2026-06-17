@php
    $uspUrl = $usp->link['url'] ?? '';
    $altText = get_post_meta($usp->image, '_wp_attachment_image_alt', true) ?: 'usp-image';

    // Extract numeric part from title for optional counter animation
    preg_match('/(\d+)/', $usp->title, $matches);
    $numericPart = $matches[0] ?? '';
    $isNumber = !empty($numericPart);
@endphp

<div class="USP-item h-full usp-{{ $uspBlock->uspLayout }} @if ($uspBlock->flyinEffect) usp-hidden @endif @if($uspBlock->uspBackgroundColor) bg-{{ $uspBlock->uspBackgroundColor }} p-4 lg:p-8 @endif">

    @if ($uspUrl)
        <a href="{{ $uspUrl }}" class="usp-url" aria-label="Ga naar {{ $usp->title }} pagina">
    @endif

    <div class="item-styling h-full @if($uspBlock->uspLayout == 'horizontal') flex flex-row gap-x-6 items-center text-left justify-start @elseif($uspBlock->uspLayout == 'vertical') flex flex-col gap-y-4 text-center @endif">
        @if ($uspBlock->visualType === 'icons' && $usp->iconData)
            <i class="fa-{{ $usp->iconData['style'] }} fa-{{ $usp->iconData['id'] }} text-{{ $uspBlock->uspIconColor }} text-[70px] inline-block"
               aria-hidden="true"></i>
        @endif
        @if ($uspBlock->visualType === 'images' && $usp->image)
            @include('components.image', [
                'image_id' => $usp->image,
                'size' => 'full',
                'object_fit' => 'cover',
                'img_class' => 'mx-auto w-auto h-auto max-w-full max-h-20',
                'alt' => $altText,
            ])
        @endif
        @if ($usp->title || $usp->text)
            <div class="usp-data">
                @if ($usp->title)
                    <div class="usp-title text-{{ $uspBlock->uspTitleColor }} font-bold h4">
                        @if ($isNumber && $uspBlock->numberAnimation)
                            <span class="counter" data-target="{{ $numericPart }}">0</span>{{ str_replace($numericPart, '', $usp->title) }}
                        @else
                            @include('components.content', ['content' => $usp->title])
                        @endif
                    </div>
                @endif
                @if ($usp->text)
                    @include('components.content', ['content' => $usp->text, 'class' => 'usp-text mt-2 text-' . $uspBlock->uspTextColor])
                @endif
            </div>
        @endif
    </div>

    @if ($uspUrl)
        </a>
    @endif

</div>

@if ($isNumber && $uspBlock->numberAnimation)
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
