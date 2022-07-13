<div class="{{ $class ?? '' }}"> {{--
    - On mobile (default to lg), if count(items) <= 1 shows grid, else slider.
    - On desktop (lg and up), if count(items) <= 3 shows grid, else slider
--}}

    @php
        $count = count($items);
        $card_classes = 'w-full';
    @endphp

    <div class="block lg:hidden"> {{-- This is the mobile block --}}
        @if($count > 0 && $count <= 1)
            @include('components.slider.grid', [
                'items' => $items,
                'card_type' => $card_type,
            ])
        @elseif($count > 1)
            @include('components.slider.slider', [
                'items' => $items,
                'card_type' => $card_type,
                'card_classes' => $card_classes,
            ])
        @endif
    </div>

    <div class="hidden lg:block"> {{-- This is the desktop block --}}
        @if($count > 0 && $count <= 3)
            @include('components.slider.grid', [
                'items' => $items,
                'card_type' => $card_type,
            ])
        @elseif($count > 3)
            @include('components.slider.slider', [
                'items' => $items,
                'card_type' => $card_type,
                'card_classes' => $card_classes,
            ])
        @endif
    </div>

</div>