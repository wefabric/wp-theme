@php
    $imageCaption = $image['caption'] ?? '';
    $imageUrl = $image['url'] ?? '';
    $imageAlt = $image['alt'] ?? '';
    $imageID = $image['id'] ?? '';
@endphp

@if($imageID)
    @include('components.image', [
        'image_id' => $imageID,
        'size' => 'full',
        'object_fit' => 'cover',
        'img_class' => 'w-full h-[400px] h-[600px] object-cover rounded-' . $borderRadius,
        'alt' => $imageAlt
    ])
@endif
@if($imageCaption)
    <p class="mt-2">{{ $imageCaption }}</p>
@endif