<div class=" {{ $classes ?? 'mx-3 lg:mx-20' }}">
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

            <span id="carousel-content-label" class="sr-only" hidden>Carousel</span>

            <ul
                    x-ref="slider"
                    tabindex="0"
                    role="listbox"
                    aria-labelledby="carousel-content-label"
                    class="flex w-full overflow-x-scroll snap-x snap-mandatory hide-scrollbar"
            >
                @foreach($items as $item)
                    <li class="snap-start {{ $card_classes ?? 'w-5/6 md:w-2/5 lg:w-1/4 2xl:w-1/5' }} shrink-0 flex flex-col items-center justify-center p-4" role="option">
                        @include('components.cards.'. $card_type, [
                            'item' => $item,
                        ])
                    </li>
                @endforeach
            </ul>

        </div>

        <div class="mx-auto w-full p-4 grid lg:grid-cols-4 lg:gap-x-4 lg:pt-10">

        @if( $items->count() > 4 ) {{-- only show slider-buttons on lg: if there's anything to slide. --}}
        <!-- Prev Button -->
            <div class="col-start-2 hidden lg:flex justify-end">
                <button
                        x-on:click="prev"
                        class="btn btn-secondary-light rounded-full reversed-chevron-only h-8"
                        :aria-disabled="atBeginning"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'cursor-not-allowed': atBeginning }"
                >
                    <span class="sr-only">Skip to previous slide page</span>
                </button>
            </div>

            <!-- Next Button -->
            <div class="hidden lg:flex justify-start">
                <button
                        x-on:click="next"
                        class="btn btn-secondary-light rounded-full chevron-only h-8"
                        :aria-disabled="atEnd"
                        :tabindex="atEnd ? -1 : 0"
                        :class="{ 'cursor-not-allowed': atEnd }"
                >
                    <span class="sr-only">Skip to next slide page</span>
                </button>
            </div>
            @endif

            <div class="flex {{ ($items->count() <= 4 ? 'col-start-4' : '') }} justify-center lg:justify-end">
                <div class="btn rounded-full bg-secondary-light cursor-pointer" onclick="window.location.href='{{ $overview_link }}'">
                    <a href="{{ $overview_link }}">
                        {{ $overview_text }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>