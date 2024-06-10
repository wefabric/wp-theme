@php
//    $imageCaption = $image['caption'] ?? '';
//    $imageUrl = $image['url'] ?? '';

    $linkImage = $link['image'] ?? '';
    $linkImageAlt = $image['alt'] ?? '';
@endphp

@if ($linkImage)
    @include('components.image', [
        'image_id' => $linkImage,
        'size' => 'full',
        'object_fit' => 'cover',
        'img_class' => 'w-full h-[400px] h-[600px] object-cover rounded-' . $borderRadius,
        'alt' => $linkImageAlt
    ])
@endif