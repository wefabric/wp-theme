@php
    $linkImage = $link['image'] ?? '';

    $imageAlt = $linkImage ? get_post_meta($linkImage, '_wp_attachment_image_alt', true) : '';
    if (empty($imageAlt)) {
        $imageAlt = $link['title'] ?? '';
    }
@endphp

@if ($linkImage)
    @include('components.image', [
        'image_id' => $linkImage,
        'size' => 'full',
        'object_fit' => 'cover',
        'img_class' => 'w-full h-[400px] md:h-[600px] object-cover rounded-' . $borderRadius,
        'alt' => $imageAlt
    ])
@endif