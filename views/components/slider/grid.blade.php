@php
    if(!isset($count)) {
        $count = count($items);
    }
@endphp
<div class="grid grid-cols-{{ $count }}">
    @foreach($items as $item)
        @include('components.slider.cards.'. $card_type, [
            'item' => $item
        ])
    @endforeach
</div>