<div>

    @include('components.image', [
        'image_id' => $item->get('image'),
        'class' => $card_classes ?? '',
        'size' => 'galery-thumbnail-1/'. $size,
    ])

    {{ $item->get('title') }}

    @include('components.buttons.default', [
        'button' => $item,
    ])

</div>
