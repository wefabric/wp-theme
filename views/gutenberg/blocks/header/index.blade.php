@php
    // Variant
    $headerHeight = $block['data']['header_height'] ?? '';

    $heightClasses = [
        1 => 'h-[400px] sm:h-[500px] md:h-[500px] lg:h-[500px] xl:h-[500px] 2xl:h-[800px]',
        2 => 'h-[200px] md:h-[400px] 2xl:h-[500px]',
        3 => 'h-[120px] md:h-[200px]',
    ];
    $headerClass = $heightClasses[$headerHeight] ?? '';

    $headerNames = [
        1 => 'big-header',
        2 => 'medium-header',
        3 => 'small-header',
    ];
    $headerName = $headerNames[$headerHeight] ?? '';

    // Content
    $title = !empty($block['data']['title']) ? $block['data']['title'] : get_the_title();
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';
    $showTitle = $block['data']['show_title'] ?? true;
    $contentImageId = $block['data']['content_image'] ?? '';
    $contentImageAlt = get_post_meta($contentImageId, '_wp_attachment_image_alt', true);

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = $block['data']['button_button_1']['url'] ?? '';
    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';
    $button2Text = $block['data']['button_button_2']['title'] ?? '';
    $button2Link = $block['data']['button_button_2']['url'] ?? '';
    $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
    $button2Color = $block['data']['button_button_2_color'] ?? '';
    $button2Style = $block['data']['button_button_2_style'] ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $textPositionClass = '';
    $textWidthClass = '';


    if (!$contentImageId) {
        if ($textPosition === 'left') {
            $textPositionClass = 'justify-start text-left';
            $textWidthClass = ($headerHeight == 3) ? 'w-full' : 'w-full md:w-2/3 xl:w-2/3';
        } elseif ($textPosition === 'center') {
            $textPositionClass = 'justify-center text-center items-center';
               $textWidthClass = ($headerHeight == 3) ? 'w-full' : 'w-full xl:w-3/4';
        } elseif ($textPosition === 'right') {
            $textPositionClass = 'justify-end text-left';
               $textWidthClass = ($headerHeight == 3) ? 'w-full md:w-2/3' : 'w-full md:w-1/2 xl:w-1/3';
        }
    }

    // Breadcrumbs
    $breadcrumbsEnabled = $block['data']['show_breadcrumbs'] ?? false;
    $breadcrumbsBackgroundColor = $block['data']['breadcrumbs_background_color'] ?? '';
    $breadcrumbsTextColor = $block['data']['breadcrumbs_text_color'] ?? '';

    // Background image
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $showFeaturedImage = $block['data']['show_featured_image'] ?? false;
    $featuredImage = $showFeaturedImage ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
    $featuredImageId = $featuredImage ? attachment_url_to_postid($featuredImage) : '';
    $headerBackgroundColor = $block['data']['background_color'] ?? '';

    $backgroundVideoID = $block['data']['background_video'] ?? '';
    $backgroundVideoURL = $backgroundVideoID ? wp_get_attachment_url($backgroundVideoID) : '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';
@endphp

<section id="header" class="block-header relative bg-{{ $headerBackgroundColor }} {{ $headerName }} {{ $customBlockClasses }}">
    <div class="custom-styling bg-cover bg-center {{ $headerClass }}"
         style="background-image: url('{{ $imageId ? wp_get_attachment_image_url($imageId, 'full') : ($featuredImage ? $featuredImage : '') }}'); {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId ?: $featuredImageId) }}">
        @if ($backgroundVideoURL)
            <video autoplay muted loop playsinline class="video-background absolute inset-0 w-full h-full object-cover" poster="one-does-not-simply.jpg">
                <source src="{{ esc_url($backgroundVideoURL) }}" type="video/mp4">
            </video>
        @endif
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="custom-width relative container mx-auto px-8 h-full flex items-center z-30 {{ $textPositionClass }} @if ($contentImageId) gap-x-8 @endif">
            <div class="header-info flex flex-col {{ $textWidthClass }} @if ($contentImageId) w-full md:w-1/2 @if ($textPosition === 'left') order-1 @elseif ($textPosition === 'right') order-2 @endif @endif">
                @if ($showTitle)
                    @if ($subTitle)
                        <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
                    @endif
                    <h1 class="title text-{{ $titleColor }}">{!! $title !!}</h1>
                @endif
                @if ($text)
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 text-lg mb-4 text-' . $textColor])
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="buttons w-full flex flex-wrap gap-y-2 gap-x-6 mt-4 @if ($textPosition === 'center') justify-center items-center @endif">
                        @include('components.buttons.default', [
                           'text' => $button1Text,
                           'href' => $button1Link,
                           'alt' => $button1Text,
                           'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                           'class' => 'rounded-lg w-fit',
                           'target' => $button1Target,
                       ])
                        @if (($button2Text) && ($button2Link))
                            @include('components.buttons.default', [
                               'text' => $button2Text,
                               'href' => $button2Link,
                               'alt' => $button2Text,
                               'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                               'class' => 'rounded-lg w-fit',
                               'target' => $button2Target,
                           ])
                        @endif
                    </div>
                @endif
            </div>
            @if ($contentImageId)
                <div class="hidden md:block content-image w-1/2 @if ($textPosition === 'left') order-2 @elseif ($textPosition === 'right') order-1 @endif">
                    @include('components.image', [
                        'image_id' => $contentImageId,
                        'size' => 'full',
                        'object_fit' => 'cover',
                        'img_class' => 'w-full max-h-[400px] md:max-h-[600px] object-cover rounded-' . $borderRadius,
                        'alt' => $contentImageAlt
                    ])
                </div>
            @endif
        </div>
    </div>
</section>

@if ($customBlockClasses) <div class="breadcrumbs-{{ $customBlockClasses }}"> @endif
    @if ($breadcrumbsEnabled && !is_front_page() && get_the_ID())
        @include('components.breadcrumbs.index')
    @endif
@if ($customBlockClasses) </div> @endif