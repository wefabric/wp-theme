@php

if(empty($breakPoints)) {
    $breakPoints = [
        640 => [
          'slidesPerView' => 1,
          'spaceBetween' =>  0,
        ],
         768 => [
          'slidesPerView' => 2,
          'spaceBetween' =>  10,
        ],
         1024 => [
          'slidesPerView' => 3,
          'spaceBetween' =>  10,
        ],
    ];
}

@endphp
{{--
    BEWARE: This class isn't designed to be used directly.
    Preferably use smart-slider which shows a grid instead
    of a slider, when sliding functionality isn't required.
--}}
<div class="container">
    <div x-data="{swiper: null}"
         x-init="swiper = new Swiper($refs.container, {
         modules: [SwiperNavigation, SwiperPagination],
      loop: {{ ($loop ?? true) ? 1 : 0 }},
      slidesPerView: 1,
      spaceBetween: 0,
        pagination: {
              el: '.swiper-pagination',
              clickable: true
        },
      breakpoints: {{ json_encode($breakPoints) }},
    })"
         class="relative w-full mx-auto flex flex-row"
    >
        @if(($prevNext ?? true) === true)
            <div class="absolute inset-y-0 left-0 z-10 flex items-center">
                <button @click="swiper.slidePrev()"
                        class="bg-white -ml-2 lg:-ml-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-left w-6 h-6"><path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endif

        <div class="swiper" x-ref="container">
            <div class="swiper-wrapper">
                @foreach($items as $item)
                    <div class="swiper-slide  @if(($pagination ?? true)) pb-8  @else pb-4  @endif" role="option">
                            @include('components.cards.'. $card_type, [
                                'item' => $item,
                            ])
                        </div>
                @endforeach
            </div>
            <div class="swiper-pagination   @if(($pagination ?? true) === false) hidden @endif"></div>
        </div>

        @if(($prevNext ?? true) === true)
            <div class="absolute inset-y-0 right-0 z-10 flex items-center">
                <button @click="swiper.slideNext()"
                        class="bg-white -mr-2 lg:-mr-4 flex justify-center items-center w-10 h-10 rounded-full shadow focus:outline-none">
                    <svg viewBox="0 0 20 20" fill="currentColor" class="chevron-right w-6 h-6"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                </button>
            </div>
        @endif
    </div>
</div>