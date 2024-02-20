@php
    $title = $usp['uspTitle'];
    $text = $usp['uspText'];
    $icon = $usp['uspIcon'];
    $iconColor = $usp['uspIconColor'];
    $imageID = $usp['uspImage'];
    $uspTitleColor = $block['data']['usp_title_color'] ?? '';
    $uspTextColor = $block['data']['usp_text_color'] ?? '';
    $altText = get_post_meta($imageID, '_wp_attachment_image_alt', true) ?: 'usp-image';
@endphp

<div class="USP-item h-full">
    <div class="item-styling h-full text-center">
        @if ($icon)
            <i class="fa-{{ $icon['style'] }} fa-{{ $icon['id'] }} text-{{ $iconColor }} text-[70px] mb-3 inline-block"
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
        @if ($title || $text)
            <div class="usp-data">
                @if ($title)
                    <p class="usp-title text-{{ $uspTitleColor }} font-bold h4">{!! $title !!}</p>
                @endif
                @if ($text)
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 text-' . $uspTextColor])
                @endif
            </div>
        @endif
    </div>
</div>