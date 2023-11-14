@php
    $title = $usp['uspTitle'];
    $text = $usp['uspText'];
    $icon = $usp['uspIcon'];
    $iconColor = $usp['uspIconColor'];
    $imageID = $usp['uspImage'];
    $textColor = $block['data']['text_color'] ?? '';
    $altText = get_post_meta($imageID, '_wp_attachment_image_alt', true) ?: 'usp-image';
@endphp

<div class="USP-item">
    <div class="h-full text-center">
        @if ($icon)
            <i class="fa {{ $icon }} text-{{ $iconColor }} text-[70px] mb-3 inline-block"
               aria-hidden="true"></i>
        @endif
        @if ($imageID)
            @include('components.image', [
                'image_id' => $imageID,
                'size' => 'full',
                'object_fit' => 'cover',
                'img_class' => 'mx-auto w-auto h-auto max-w-full max-h-20 mb-8',
                'alt' => $altText,
            ])
        @endif
        @if ($title)
            <p class="text-{{$textColor}} font-bold h4">{{ $title }}</p>
        @endif
        @if ($text)
            <p class="mt-4 text-{{$textColor}}">{{ $text }}</p>
        @endif
    </div>
</div>