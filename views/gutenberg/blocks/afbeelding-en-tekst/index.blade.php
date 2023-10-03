@php
    // Content
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $buttonOneText = $block['data']['button_1_text'] ?? '';
    $buttonOneLink = ($block['data']['button_1_link']['url']) ?? '';

    $buttonTwoText = $block['data']['button_2_text'] ?? '';
    $buttonTwoLink = ($block['data']['button_2_link']['url']) ?? '';

    $textOrder = ($textPosition === 'left') ? 'lg:order-1' : 'lg:order-2';
    $imageOrder = ($textPosition === 'left') ? 'lg:order-2' : 'lg:order-1';

    $imageSize = $block['data']['image_size'] ?? '';
    $imageClass = '';
    $textClass = '';

    if ($imageSize === '33') {
        $imageClass = 'lg:w-1/3';
        $textClass = 'lg:w-2/3';
    } elseif ($imageSize === '50') {
        $imageClass = 'lg:w-1/2';
        $textClass = 'lg:w-1/2';
    } elseif ($imageSize === '66') {
        $imageClass = 'lg:w-2/3';
        $textClass = 'lg:w-1/3';
    }

    $imageHeightClass = $block['data']['full_height'] ? 'h-full' : '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? ($options['border_radius_strength'] ?? '') : 'rounded-none';
@endphp

<section id="afbeelding-tekst-block" class="relative bg-{{ $backgroundColor}} py-16 lg:py-0"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{$overlayColor}} opacity-{{$overlayOpacity}}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            <div class="flex flex-col lg:flex-row gap-8 xl:gap-20">
                <div class="{{ $textClass }} order-2 {{ $textOrder }} text-{{ $textColor }}">
                    <h2 class="mb-4">{{ $title }}</h2>
                    <p>{{ $text }}</p>
                    @if (!empty($buttonOneText) && !empty($buttonOneLink))
                        <a href="{{ $buttonOneLink }}"
                           class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $buttonOneText }}</a>
                    @endif
                    @if (!empty($buttonTwoText) && !empty($buttonTwoLink))
                        <a href="{{ $buttonTwoLink }}"
                           class="ml-4 text-black font-medium hover:text-primary underline mt-4 text-base">{{ $buttonTwoText }}</a>
                    @endif
                </div>
                <div class="{{ $imageClass }} order-1 {{ $imageOrder }}">
                    {!! wp_get_attachment_image($block['data']['image'], 'full', false, ['class' => 'w-full object-cover rounded-' . $borderRadius . ' ' . $imageHeightClass ]) !!}
                </div>
            </div>
        </div>
    </div>
</section>