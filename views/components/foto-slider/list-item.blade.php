@php
    $caption = $image['caption'] ?? '';
    $imageUrl = ($image['url']) ?? '';
@endphp

<img src="{{ $imageUrl }}" alt="{{ $imageUrl }}"
     class="h-[300px] lg:h-[500px] w-full object-cover object-center transform ease-in-out duration-300 group-hover:scale-110 rounded-{{ $borderRadius }}">
@if($caption)
    <p class="mt-2">{{ $caption }}</p>
@endif