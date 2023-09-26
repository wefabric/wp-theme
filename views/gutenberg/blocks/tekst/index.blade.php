@php
    // content
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


    // blokinstellingen
    $backgroundColor = $block['data']['background_color'];

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
     $backgroundImageUrl = '';
    if (isset($block['data']['background_image'])) {
        $backgroundImageUrl = wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '';
    }

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

<section id="tekst-block" class="py-16 lg:py-0 bg-{{ $backgroundColor}}"
         style="background-image: url('{{ wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '' }}'); background-repeat: no-repeat; background-size: cover;">

    <div class="{{ $fullScreenClass }} px-8 py-8 lg:py-20 text-{{ $textColor }}">
        <div class="{{ $blockClass }} {{ $textClass }}">
            <h2 class="mb-4">{{ $title }}</h2>
            <p>{{ $text }}</p>
            @if (!empty($buttonText) && !empty($buttonLink))
                <a href="{{ $buttonLink }}" class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $buttonText }}</a>
            @endif
        </div>
    </div>
</section>