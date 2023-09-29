@php
    // CTA variant
    $ctaVariant = $block['data']['cta_version'] ?? '';

    // Content
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';

    $textColor = $block['data']['text_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';

    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = ($block['data']['button_link']['url']) ?? '';

        // CTA form fields
        $ctaImage = ($block['data']['image']) ?? '';
        $ctaForm = ($block['data']['form']) ?? '';

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
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto px-8' : '';


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strenght']??'': 'rounded-none';
@endphp

<section id="call-to-action" class="relative">
    <div class="{{ $fullScreenClass }} pt-8 lg:pt-20">
        <div class="mx-auto {{ $blockClass }} relative py-16 px-8 bg-{{ $backgroundColor }} @if($blockWidth !== 'fullscreen') rounded-{{ $borderRadius }} @endif"
             style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
            @if ($overlayEnabled)
                <div class="absolute inset-0 bg-{{$overlayColor}} opacity-{{$overlayOpacity}}"></div>
            @endif
            <div class="container mx-auto @if($blockWidth == 'fullscreen') px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
                <div class="flex flex-col md:flex-row md:items-center gap-y-4 md:gap-y-0">
                    <div class="w-full md:w-2/3 text-center md:text-left">
                        <h2 class="text-{{$textColor}}">{{ $title }}</h2>
                        @if (!empty($text))
                            <p class="mt-4 md:mt-8 text-{{$textColor}}">{{ $text }}</p>
                        @endif
                    </div>
                    @if ($ctaVariant == 'cta_button' && !empty($buttonText) && !empty($buttonLink))
                        <div class="w-full md:w-1/3 md:justify-center text-center">
                            <a href="{{ $buttonLink }}"
                               class="btn button-secondary bg-secondary-color hover:bg-secondary-dark text-base">{{ $buttonText }}</a>
                        </div>
                    @endif
                    @if ($ctaVariant == 'cta_whitepaper' && !empty($ctaImage))
                        <div class="w-full md:w-1/3 md:justify-center text-center md:mt-[-100px]">
                            {!! wp_get_attachment_image($block['data']['image'], 'full', false, ['class' => 'w-full object-cover', 'alt' => get_post_meta($block['data']['image'], '_wp_attachment_image_alt', true)]) !!}
                        </div>
                    @endif
                </div>
                <div>
                    @if ($ctaVariant == 'cta_whitepaper' && !empty($ctaForm))
                        <div class="w-full mt-10">
                            {!! gravity_form($ctaForm, false) ; !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>