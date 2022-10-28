<div class="mx-auto {{ $grid_class ?? 'grid md:grid-cols-2 lg:grid-cols-3' }} {{ $grid_spacing ?? 'md:gap-4' }}">
    @foreach($items as $item)
        @include('components.cards.'. $card_type, [
            'item' => $item,
            'class' => $grid_items_class ?? '',
            'lg_hidden' => isset($mobile_loop_max) && $loop->iteration > $mobile_loop_max, //if 1 allowed and iteration = 1, lg_hidden = false. next is true.
        ])
    @endforeach
</div>