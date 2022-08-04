<script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.js"></script>
<div>
{{--
    BEWARE: This class isn't designed to be used directly.
    Preferably use smart-slider which shows a grid instead
    of a slider, when sliding functionality isn't required.
--}}

    <div x-data="{
        skip: 1,
        atBeginning: false,
        atEnd: false,
        next() {
            this.to((current, offset) => current + (offset * this.skip))
        },
        prev() {
            this.to((current, offset) => current - (offset * this.skip))
        },
        to(strategy) {
            let slider = this.$refs.slider
            let current = slider.scrollLeft
            let offset = slider.firstElementChild.getBoundingClientRect().width
            slider.scrollTo({ left: strategy(current, offset), behavior: 'smooth' })
        },
        focusableWhenVisible: {
            'x-intersect:enter'() {
                this.$el.removeAttribute('tabindex')
            },
            'x-intersect:leave'() {
                this.$el.setAttribute('tabindex', '-1')
            },
        },
        disableNextAndPreviousButtons: {
            'x-intersect:enter.threshold.05'() {
                let slideEls = this.$el.parentElement.children

                // If this is the first slide.
                if (slideEls[0] === this.$el) {
                    this.atBeginning = true
                // If this is the last slide.
                } else if (slideEls[slideEls.length-1] === this.$el) {
                    this.atEnd = true
                }
            },
            'x-intersect:leave.threshold.05'() {
                let slideEls = this.$el.parentElement.children

                // If this is the first slide.
                if (slideEls[0] === this.$el) {
                    this.atBeginning = false
                // If this is the last slide.
                } else if (slideEls[slideEls.length-1] === this.$el) {
                    this.atEnd = false
                }
            },
        },
    }" class="flex flex-col w-full"
    >
        <div
                x-on:keydown.right="next"
                x-on:keydown.left="prev"
                tabindex="0"
                role="region"
                aria-labelledby="carousel-label"
                class="flex space-x-6"
        >
            <h2 id="carousel-label" class="sr-only" hidden>Carousel</h2>

            <!-- Prev Button -->
            <button
                    x-on:click="prev"
                    class="text-6xl hidden lg:block"
                    :aria-disabled="atBeginning"
                    :tabindex="atEnd ? -1 : 0"
                    :class="{ 'opacity-50 cursor-not-allowed': atBeginning }"
            >
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                </span>
                <span class="sr-only">Skip to previous slide page</span>
            </button>

            <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>

            <ul
                    x-ref="slider"
                    tabindex="0"
                    role="listbox"
                    aria-labelledby="carousel-content-label"
                    class="flex w-full overflow-x-scroll snap-x snap-mandatory"
            >
                @foreach($items as $item)
                    <li class="snap-start {{ $card_classes ?? 'w-5/6 md:w-2/5 lg:w-1/4 2xl:w-1/5' }} shrink-0 flex flex-col items-center px-2 lg:px-4 pb-4" role="option">
                        @include('components.cards.'. $card_type, [
                            'item' => $item,
                        ])
                    </li>
                @endforeach
            </ul>

            <!-- Next Button -->
            <button
                    x-on:click="next"
                    class="text-6xl hidden lg:block"
                    :aria-disabled="atEnd"
                    :tabindex="atEnd ? -1 : 0"
                    :class="{ 'opacity-50 cursor-not-allowed': atEnd }"
            >
                <span aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </span>
                <span class="sr-only">Skip to next slide page</span>
            </button>

        </div>
    </div>
</div>
