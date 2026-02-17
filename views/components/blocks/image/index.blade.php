@if ($imageId)
<x-wefabric:section block-type="afbeelding" :block="$block" :random-number="$randomNumber">
    <div class="custom-styling relative z-10 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto relative @if ($imageParallax) parallax-image @endif @if($textPosition === 'center') text-center @elseif($textPosition === 'right') text-right @endif">
            @if ($imageId)
                @include('components.image', [
                   'image_id' => $imageId,
                   'size' => 'full',
                   'object_fit' => $imageStyle,
                   'img_class' => 'w-full h-auto',
                   'alt' => $imageAlt
               ])
                @if ($overlayEnabled)
                    <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
                @endif
            @endif
        </div>
    </div>
</x-wefabric:section>
@endif

<style>
    .block-{{ $randomNumber }} img {
        @if($maxHeight) max-height: {{ $maxHeight }}px; @endif
        @if($maxWidth) max-width: {{ $maxWidth }}px; @endif
    }
</style>

<!-- Parallax effect -->
<script>
    (function() {
        document.addEventListener('DOMContentLoaded', function () {
            const parallaxBlock = document.querySelector('.block-{{ $randomNumber }}');
            if (!parallaxBlock) return;
            const parallaxImage = parallaxBlock.querySelector('.parallax-image');

            if (!parallaxImage) return;

            // Get the parallax strength as a string from PHP
            const parallaxStrength = "{{ $parallaxStrength }}";

            // Set the parallax factor directly based on the strength
            let parallaxFactor = -0.4; // Default (normal)

            if (parallaxStrength === 'weak') {
                parallaxFactor = -0.2;
            } else if (parallaxStrength === 'strong') {
                parallaxFactor = -0.6;
            }

            function applyParallaxEffect() {
                const scrollPosition = window.scrollY;
                const blockRect = parallaxBlock.getBoundingClientRect();
                const blockTop = blockRect.top + window.scrollY;
                const blockHeight = blockRect.height;
                const viewportCenter = scrollPosition + window.innerHeight / 2;
                const blockCenter = blockTop + blockHeight / 2;
                const distanceFromCenter = viewportCenter - blockCenter;

                const translateY = distanceFromCenter * parallaxFactor;
                parallaxImage.style.transform = `translateY(${translateY}px)`;
            }

            window.addEventListener('scroll', applyParallaxEffect);
            applyParallaxEffect();
        });
    })();
</script>
