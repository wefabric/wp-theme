@php
    // Variant
    $headerVariant = $block['data']['header_version'] ?? '';

    $headerClass = '';
    if ($headerVariant == 1) {
        $headerClass = 'h-[400px] sm:h-[500px] md:h-[600px] lg:h-[600px] xl:h-[800px]';
    } elseif ($headerVariant == 2) {
        $headerClass = 'h-[300px]';
    }

    // Content
    $title = !empty($block['data']['title']) ? $block['data']['title'] : get_the_title();
    $subTitle = ($block['data']['subtitle']) ?? '';
    $textColor = ($block['data']['text_color']) ?? '';

    $buttonOneText = ($block['data']['button_1_text']) ?? '';
    $buttonOneLink = ($block['data']['button_1_link']['url']) ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $textPositionClass = '';
    $textWidthClass = '';

    if ($textPosition === 'left') {
        $textPositionClass = 'justify-start text-left';
        $textWidthClass = 'w-full md:w-1/2 xl:w-1/3';
    } elseif ($textPosition === 'center') {
        $textPositionClass = 'justify-center text-center';
           $textWidthClass = 'w-full xl:w-3/4';
    } elseif ($textPosition === 'right') {
        $textPositionClass = 'justify-end text-left';
           $textWidthClass = 'w-full md:w-1/2 xl:w-1/3';
    }

    // Breadcrumbs
    $breadcrumbsEnabled = ($block['data']['show_breadcrumbs']) ?? false;
    $breadcrumbsBackgroundColor = ($block['data']['breadcrumbs_background_color']) ?? '';
    $breadcrumbsTextColor = ($block['data']['breadcrumbs_text_color']) ?? '';

    // Image
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';
@endphp

<section id="header" class="relative">
    <div class="bg-cover bg-center {{ $headerClass }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}')">
        @if ($overlayEnabled)
            <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="relative container mx-auto px-8 h-full flex items-center z-30 {{ $textPositionClass }}">
            <div class="text-shadow-lg text-{{ $textColor }} {{ $textWidthClass }}">
                <h1 class="mb-4">{{ $title }}</h1>
                @if ($subTitle)
                    <p class="text-lg mb-4">{{ $subTitle }}</p>
                @endif
                @if (!empty($buttonOneText) && !empty($buttonOneLink))
                    <a href="{{ $buttonOneLink }}" class="btn bg-primary">{{ $buttonOneText }}</a>
                @endif
            </div>
        </div>
    </div>
</section>
@if ($breadcrumbsEnabled && !is_front_page() && get_the_ID() !== wc_get_page_id( 'cart' ))
    @include('components.breadcrumbs.index')
@endif