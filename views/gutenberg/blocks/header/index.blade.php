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

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = ($block['data']['button_button_1']['url']) ?? '';
    $button1Target = ($block['data']['button_button_1']['target']) ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';
    $button2Text = $block['data']['button_button_2']['title'] ?? '';
    $button2Link = ($block['data']['button_button_2']['url']) ?? '';
    $button2Target = ($block['data']['button_button_2']['target']) ?? '_self';
    $button2Color = $block['data']['button_button_2_color'] ?? '';
    $button2Style = $block['data']['button_button_2_style'] ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $textPositionClass = '';
    $textWidthClass = '';

    if ($textPosition === 'left') {
        $textPositionClass = 'justify-start text-left';
        $textWidthClass = ($headerHeight == 3) ? 'w-full' : 'w-full md:w-1/2 xl:w-1/3';
    } elseif ($textPosition === 'center') {
        $textPositionClass = 'justify-center text-center';
           $textWidthClass = ($headerHeight == 3) ? 'w-full' : 'w-full xl:w-3/4';
    } elseif ($textPosition === 'right') {
        $textPositionClass = 'justify-end text-left text-right';
           $textWidthClass = ($headerHeight == 3) ? 'w-full md:w-2/3' : 'w-full md:w-1/2 xl:w-1/3';
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

<section id="header" class="relative bg-{{ $headerBackgroundColor }}">
    <div class="bg-cover bg-center {{ $headerClass }}"
         style="background-image: url('{{ $imageId ? wp_get_attachment_image_url($imageId, 'full') : ($featuredImage ? $featuredImage : '') }}')">
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="relative container mx-auto px-8 h-full flex items-center z-30 {{ $textPositionClass }}">
            <div class="text-{{ $textColor }} {{ $textWidthClass }}">
                <h1 class="text-shadow-lg">{{ $title }}</h1>
                @if ($subTitle)
                    @include('components.content', ['content' => apply_filters('the_content', $subTitle), 'class' => 'mt-4 text-lg mb-4 text-shadow-lg'])
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="{{ $textPositionClass }} w-full flex sm:flex-row gap-4 mt-4 md:mt-8">
                        @include('components.buttons.default', [
                           'text' => $button1Text,
                           'href' => $button1Link,
                           'alt' => $button1Text,
                           'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style . '',
                           'class' => 'rounded-lg',
                           'target' => $button1Target,
                       ])
                        @if (($button2Text) && ($button2Link))
                            @include('components.buttons.default', [
                               'text' => $button2Text,
                               'href' => $button2Link,
                               'alt' => $button2Text,
                               'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style . '',
                               'class' => 'rounded-lg',
                               'target' => $button2Target,
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