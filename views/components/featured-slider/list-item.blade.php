@php
    $itemImage = $item['image'] ?? '';

    $itemImageAlt = $itemImage ? get_post_meta($itemImage, '_wp_attachment_image_alt', true) : '';
    if (empty($itemImageAlt)) {
        $itemImageAlt = $item['title'] ?? '';
    }
@endphp

@if ($itemImage)
    @include('components.image', [
        'image_id' => $itemImage,
        'size' => 'full',
        'object_fit' => 'cover',
        'img_class' => 'w-full h-[400px] md:h-[600px] object-cover rounded-' . $borderRadius,
        'alt' => $itemImageAlt
    ])
@endif