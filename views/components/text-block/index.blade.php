<x-wefabric:section block-type="tekst" :block="$block">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="content-background {{ $blockClass }} mx-auto {{ $textClass }}">

            <x-wefabric:title :block="$block" />

            @if ($text)
                <x-wefabric:content :content="$text" :class="'mb-8 text-' . $textColor . ($flyInAnimation ? ' flyin-animation' : '')"></x-wefabric:content>
            @endif

            @if ($buttons->count() >= 1)
                <div class="{{ $textClass }} buttons w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 @if ($flyInAnimation) flyin-animation @endif">
                   @foreach ($buttons as $button)
                       {!! $button->render()->render(); !!}
                   @endforeach
                </div>
            @endif
        </div>
    </div>

</x-wefabric:section>

@if ($titleAnimation)
    <script>
        (function(){
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
        (function(){
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