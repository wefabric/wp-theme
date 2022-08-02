<div>

    @include('components.image', [
        'image_id' => $item->get('image'),
        'class' => $card_classes ?? '',
    ])

    <div>{{ $item->get('title') }}</div>

    <div>{{ $item->get('button_text') }}</div>

</div>
