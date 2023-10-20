@php
    // CTA variant
    $ctaVariant = $block['data']['cta_version'] ?? '';

    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';
    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = ($block['data']['button_link']['url']) ?? '';
    $textPosition = $block['data']['text_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $textClass = $titleClassMap[$textPosition] ?? '';

    $blockBackgroundColor = $block['data']['block_background_color'] ?? '';

    // CTA employee fields
    $ctaEmployee = $block['data']['employee'] ?? '';
    $employeeImageId = $ctaEmployee ? get_field('image', $ctaEmployee) : '';
    $employeeImage = $employeeImageId ? wp_get_attachment_image_url($employeeImageId, 'full') : '';
    $employeeTitle = $ctaEmployee ? get_the_title($ctaEmployee) : '';

    // CTA form fields
    $ctaImage = ($block['data']['image']) ?? '';
    $ctaForm = ($block['data']['form']) ?? '';

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="call-to-action" class="relative bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    <div class="{{ $fullScreenClass }} pt-8 lg:pt-20">
        @if (!empty($employeeImage))
            <div class="absolute z-10 left-1/2 -translate-x-1/2 -translate-y-1/2">
                <img src="{{ $employeeImage }}"
                     alt="{{ $employeeTitle }}"
                     class="w-[200px] h-[200px] md:w-[300px] md:h-[300px] aspect-square object-cover rounded-full">
            </div>
        @endif
        <div class="mx-auto {{ $blockClass }} relative py-16 px-8 bg-{{ $blockBackgroundColor }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif">
            @if ($overlayEnabled)
                <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
            @endif
            @if ($ctaVariant == 'cta_button')
                @include('components.cta.cta-button')
            @endif
            @if ($ctaVariant == 'cta_whitepaper')
                @include('components.cta.cta-whitepaper')
            @endif
            @if ($ctaVariant == 'cta_employee')
                @include('components.cta.cta-employee')
            @endif
        </div>
    </div>
</section>