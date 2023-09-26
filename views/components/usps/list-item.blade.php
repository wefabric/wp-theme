@php
    $title = $usp['uspTitle'];
    $text = $usp['uspText'];
    $icon = $usp['uspIcon'];
    $iconColor = $usp['uspIconColor'];
    $imageUrl = wp_get_attachment_url($usp['uspImage']) ?? '';
    $textColor = $block['data']['text_color'];
@endphp


<div class="USP-item">
    <div class="h-full p-6 rounded-lg text-center">
        @if ($icon)
            <i class="fa {{ $icon }} text-{{ $iconColor }} text-3xl mb-3 inline-block" aria-hidden="true"></i>
        @endif
        @if ($imageUrl)
            <img src="{{ $imageUrl }}" alt="usp-image" class="mx-auto w-auto h-auto max-w-full max-h-20 mb-8">
        @endif
        @if ($title)
            <p class="text-white font-bold text-xl lg:text-3xl mb-4">{{ $title }}</p>
        @endif
        @if ($text)
            <p class="text-{{$textColor}}">{{ $text }}</p>
        @endif
    </div>
</div>