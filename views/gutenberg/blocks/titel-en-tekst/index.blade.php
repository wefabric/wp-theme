@php
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textPosition = $block['data']['text_position'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';



    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $backgroundImageUrl = '';
    if (isset($block['data']['background_image'])) {
        $backgroundImageUrl = wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '';
    }

    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = $block['data']['button_link'] ?? '';

    $textOrder = ($textPosition === 'left') ? 'lg:order-1' : 'lg:order-2';
    $titleOrder = ($textPosition === 'left') ? 'lg:order-2' : 'lg:order-1';
@endphp

<section id="titel-tekst-block" class="bg-{{ $backgroundColor}} py-16 lg:py-0"
         style="background-image: url('{{ $backgroundImageUrl }}'); background-repeat: no-repeat; background-size: cover;">
    <div class="container mx-auto px-8 lg:py-20">
        <div class="w-full lg:w-2/3 mx-auto flex flex-col lg:flex-row gap-x-8 text-{{ $textColor }}">
            <div class="w-full lg:w-3/4 order-2 {{ $textOrder }}">
                <p>{{ $text }}</p>
                @if (!empty($buttonText) && !empty($buttonLink))
                    <a href="{{ $buttonLink }}" class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $buttonText }}</a>
                @endif
            </div>
            <div class="w-full lg:w-1/4 order-1 {{ $titleOrder }}">
                <h2 class="mb-4">{{ $title }}</h2>
            </div>
        </div>
    </div>
</section>
