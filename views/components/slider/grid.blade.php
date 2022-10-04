<div class="grid {{ $grid_class ?? 'md:grid-cols-2 lg:grid-cols-3' }} {{ $grid_spacing ?? '' }}">
    @foreach($items as $item)
        @include('components.cards.'. $card_type, [
            'item' => $item,
            'lg_hidden' => isset($mobile_loop_max) && $loop->iteration > $mobile_loop_max, //if 1 allowed and iteration = 1, lg_hidden = false. next is true.
        ])
    @endforeach
</div>