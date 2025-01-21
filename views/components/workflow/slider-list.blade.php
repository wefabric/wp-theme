@php
    $randomNumber = rand(0, 1000);
    $randomId = 'specialStepSliderSwiper-' . $randomNumber;
@endphp

<div class="block relative">
    <div class="swiper {{ $randomId }} pb-8 md:pb-0">
        <div class="swiper-wrapper">
            @foreach ($steps as $index => $step)
                @php
                    $stepImage = $step['stepImage'] ?? null;
                    $itemImageAlt = $stepImage ? get_post_meta($stepImage, '_wp_attachment_image_alt', true) : $step['stepTitle'] ?? 'Step Image';
                @endphp

                @if ($stepImage)
                    <div class="swiper-slide h-auto">
                        @include('components.image', [
                            'image_id' => $stepImage,
                            'size' => 'full',
                            'object_fit' => 'cover',
                            'img_class' => 'w-full h-[400px] md:h-[600px] object-cover rounded-' . $borderRadius,
                            'alt' => $itemImageAlt
                        ])
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<script>
    window.addEventListener("DOMContentLoaded", (event) => {
        var specialStepSliderSwiper = new Swiper(".{{ $randomId }}", {
            effect: 'fade',
            fadeEffect: {
                crossFade: true,
            },
            loop: true,
            slidesPerView: 1,
            allowTouchMove: false,
            simulateTouch: false,
            keyboard: false,
            mousewheel: false,
        });

        const steps = document.querySelectorAll('.step');
        steps.forEach((step, index) => {
            step.addEventListener('mouseover', () => {
                specialStepSliderSwiper.slideToLoop(index);
            });
        });
    });
</script>
