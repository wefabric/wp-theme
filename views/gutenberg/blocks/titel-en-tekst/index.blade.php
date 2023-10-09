@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';

    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = ($block['data']['button_link']['url']) ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $textAlignment = ($textPosition === 'left') ? 'left' : 'right';
    $textOrder = ($textPosition === 'left') ? 'lg:order-1' : 'lg:order-2';
    $titleOrder = ($textPosition === 'left') ? 'lg:order-2' : 'lg:order-1';


    // Blokinstellingen
    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';
@endphp

<section id="titel-tekst" class="relative bg-{{ $backgroundColor }} py-16 lg:py-0"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 container mx-auto px-8 lg:py-20">
        <div class="w-full lg:w-2/3 mx-auto flex flex-col lg:flex-row gap-x-8">
            <div class="w-full lg:w-3/5 order-2 {{ $textOrder }}">
                <p class="text-{{ $textColor }}">{!! $text !!}</p>
                @if (!empty($buttonText) && !empty($buttonLink))
                    <a href="{{ $buttonLink }}" class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $buttonText }}</a>
                @endif
            </div>
            <div class="w-full lg:w-2/5 order-1 {{ $titleOrder }}">
                <h2 class="mb-4 text-{{ $titleColor }} lg:text-{{ $textAlignment }}">{{ $title }}</h2>
            </div>
        </div>
    </div>
</section>
