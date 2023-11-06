@php
    // Variant
    $headerHeight = $block['data']['header_height'] ?? '';

    $headerClass = '';
    if ($headerHeight == 1) {
        $headerClass = 'h-[400px] sm:h-[500px] md:h-[600px] lg:h-[800px] xl:h-[1000px]';
    } elseif ($headerHeight == 2) {
        $headerClass = 'h-[200px] md:h-[500px]';
    } elseif ($headerHeight == 3) {
        $headerClass = 'h-[180px] md:h-[200px]';
    }

    // Content
    $title = !empty($block['data']['title']) ? $block['data']['title'] : get_the_title();
    $subTitle = ($block['data']['subtitle']) ?? '';
    $textColor = ($block['data']['text_color']) ?? '';

    $buttonOneText = ($block['data']['button_1_text']) ?? '';
    $buttonOneLink = ($block['data']['button_1_link']['url']) ?? '';
    $buttonTwoText = ($block['data']['button_2_text']) ?? '';
    $buttonTwoLink = ($block['data']['button_2_link']['url']) ?? '';

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

    $featuredImage = get_the_post_thumbnail_url(get_the_ID(), 'full');

    $headerBackgroundColor = ($block['data']['background_color']) ?? '';
@endphp

<section id="header" class="relative">
    <div class="bg-cover bg-center bg-{{ $headerBackgroundColor }} {{ $headerClass }}"
         style="background-image: url('{{ $imageId ? wp_get_attachment_image_url($imageId, 'full') : ($featuredImage ? $featuredImage : '') }}')">
        @if ($overlayEnabled)
            <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="relative container mx-auto px-8 h-full flex items-center z-30 {{ $textPositionClass }}">
            <div class="text-{{ $textColor }} {{ $textWidthClass }}">
                <h1 class="text-shadow-lg">{{ $title }}</h1>
                @if ($subTitle)
                    <div class="mt-4 text-lg mb-4 text-shadow-lg">{{ $subTitle }}</div>
                @endif
                @if ($buttonOneText && $buttonOneLink)
                    <div class="mt-8 flex gap-4 @if($textPosition == 'center') justify-center @endif">
                        @include('components.buttons.default', [
                            'text' => $buttonOneText,
                            'href' => $buttonOneLink,
                            'alt' => $buttonOneText,
                            'colors' => 'btn btn-primary btn-filled',
                            'class' => 'rounded-lg',
                        ])
                        @if ($buttonTwoText && $buttonTwoLink)
                            @include('components.buttons.default', [
                               'text' => $buttonTwoText,
                               'href' => $buttonTwoLink,
                               'alt' => $buttonTwoText,
                               'colors' => 'btn btn-white btn-outline',
                               'class' => 'rounded-lg',
                           ])
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
@if ($breadcrumbsEnabled && !is_front_page() && get_the_ID() !== wc_get_page_id( 'cart' ))
    @include('components.breadcrumbs.index')
@endif