@php
    if (!isset($randomNumber)) { \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter; }
    $randomId = 'specialStepSliderSwiper-' . $randomNumber;
@endphp

<div class="werkwijze-sticky block sticky top-0">
    <div class="swiper {{ $randomId }} pb-8 md:pb-0">
        <div class="swiper-wrapper">
            @foreach ($steps as $index => $step)
                @php
                    $stepImage = $step['stepImage'] ?? null;
                    $itemImageAlt = $stepImage ? get_post_meta($stepImage, '_wp_attachment_image_alt', true) : $step['stepTitle'] ?? 'Stap afeelding';
                @endphp

                @if ($stepImage)
                    <div class="swiper-slide step-slide h-auto">
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
    window.addEventListener("DOMContentLoaded", () => {

        const swiperEl = document.querySelector('.{{ $randomId }}');
        if (!swiperEl) return;

        const werkwijze = swiperEl.closest('.block-werkwijze');
        if (!werkwijze) return;

        var specialStepSliderSwiper = new Swiper(swiperEl, {
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

        const steps = werkwijze.querySelectorAll('.step');
        if (!steps.length) return;

        function updateActiveStep(index) {
            steps.forEach(step => step.classList.remove('active-step'));
            if (steps[index]) {
                steps[index].classList.add('active-step');
            }
        }

        steps.forEach((step, index) => {
            step.addEventListener('mouseover', () => {
                specialStepSliderSwiper.slideToLoop(index);
                updateActiveStep(index);
            });
        });

        specialStepSliderSwiper.on('slideChange', () => {
            updateActiveStep(specialStepSliderSwiper.realIndex);
        });

        updateActiveStep(0);
    });
</script>


<style>
    .step-slide .image {
        transform: scale(0.95);
        transition: transform 0.5s ease;
    }

    .step-slide.swiper-slide-active .image {
        display: block;
        transform: scale(1);
    }
</style>