<div class="grid md:grid-cols-2 lg:grid-cols-3">
    @foreach($items as $item)
        @include('components.cards.'. $card_type, [
            'item' => $item
        ])
    @endforeach
</div>