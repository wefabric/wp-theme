@php
    $imageCaption = $image['caption'] ?? '';
    $imageUrl = ($image['url']) ?? '';
    $imageAlt = ($image['alt']) ?? '';
@endphp

<img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" height="500" width="500"
     class="h-[300px] lg:h-[500px] w-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-{{ $borderRadius }}">
@if($imageCaption)
    <p class="mt-2">{{ $imageCaption }}</p>
@endif