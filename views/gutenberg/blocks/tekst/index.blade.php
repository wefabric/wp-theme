@php
    // Content
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';

    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = ($block['data']['button_link']['url']) ?? '';

    $textColor = $block['data']['text_color'] ?? '';
    $textPosition = $block['data']['text_position'] ?? '';

    if ($textPosition === 'left') {
        $textClass = 'mr-auto';
    } elseif ($textPosition === 'center') {
        $textClass = 'mx-auto text-center';
    } elseif ($textPosition === 'right') {
        $textClass = 'ml-auto';
    } else {
        $textClass = '';
    }


    // Blokinstellingen
    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';

    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClass = '';
    if ($blockWidth == 50) {
        $blockClass = 'w-full lg:w-1/2';
    }
    elseif ($blockWidth == 66) {
        $blockClass = 'w-full lg:w-2/3';
    }
    elseif ($blockWidth == 100) {
        $blockClass = ' w-full';
    }
    elseif ($blockWidth == 'fullscreen') {
        $blockClass = 'w-full';
    }
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';
@endphp

<section id="tekst-block" class="relative py-16 lg:py-0 bg-{{ $backgroundColor}}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{$overlayColor}} opacity-{{$overlayOpacity}}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }} text-{{ $textColor }}">
        <div class="{{ $blockClass }} {{ $textClass }}">
            <h2 class="mb-4">{{ $title }}</h2>
            <p>{!! $text !!} </p>
            @if (!empty($buttonText) && !empty($buttonLink))
                <a href="{{ $buttonLink }}" class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $buttonText }}</a>
            @endif
        </div>
    </div>
</section>