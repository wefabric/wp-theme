@php
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textPosition = $block['data']['text_position'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';
    $backgroundColor = $block['data']['background_color'];

    if ($textPosition === 'left') {
        $textClass = 'mr-auto';
    } elseif ($textPosition === 'center') {
        $textClass = 'mx-auto text-center';
    } elseif ($textPosition === 'right') {
        $textClass = 'ml-auto';
    } else {
        $textClass = '';
    }

    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = $block['data']['button_link'] ?? '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
     $backgroundImageUrl = '';
    if (isset($block['data']['background_image'])) {
        $backgroundImageUrl = wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '';
    }
@endphp

<section id="tekst-block" class="py-16 lg:py-0 bg-{{ $backgroundColor}}"
         style="background-image: url('{{ wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '' }}'); background-repeat: no-repeat; background-size: cover;">
    <div class="container mx-auto px-8 lg:py-20 text-{{ $textColor }}">
        <div class="lg:w-2/3 {{ $textClass }}">
            <h2 class="mb-4">{{ $title }}</h2>
            <p>{{ $text }}</p>
            @if (!empty($buttonText) && !empty($buttonLink))
                <a href="{{ $buttonLink }}" class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $buttonText }}</a>
            @endif
        </div>
    </div>
</section>
