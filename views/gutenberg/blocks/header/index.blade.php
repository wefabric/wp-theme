@php
    // Header style
    $headerStyle = $block['data']['header_style'] ?? 'fixed_height';

    if ($headerStyle == 'fixed_height') {
        $headerHeight = $block['data']['header_height'] ?? '';
        $heightClasses = [
            1 => 'h-[400px] sm:h-[500px] md:h-[500px] lg:h-[500px] xl:h-[500px] 2xl:h-[800px]',
            2 => 'h-[200px] md:h-[400px] 2xl:h-[500px]',
            3 => 'h-[120px] md:h-[200px]',
        ];
        $headerClass = $heightClasses[$headerHeight] ?? '';
    }

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
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $showTitle = $block['data']['show_title'] ?? true;
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $contentImageId = $block['data']['content_image'] ?? '';
    $contentImageAlt = get_post_meta($contentImageId, '_wp_attachment_image_alt', true);
    $fullHeightContentImage = $block['data']['full_height_image'] ?? false;
    $title2 = $block['data']['title_2'] ?? '';
    $text2 = $block['data']['text_2'] ?? '';

        // Buttons
        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';
        $button1Download = $block['data']['button_button_1_download'] ?? false;
        $button1Icon = $block['data']['button_button_1_icon'] ?? '';
        if (!empty($button1Icon)) {
            $iconData = json_decode($button1Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button1Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }
        $button2Text = $block['data']['button_button_2']['title'] ?? '';
        $button2Link = $block['data']['button_button_2']['url'] ?? '';
        $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
        $button2Color = $block['data']['button_button_2_color'] ?? '';
        $button2Style = $block['data']['button_button_2_style'] ?? '';
        $button2Download = $block['data']['button_button_2_download'] ?? false;
        $button2Icon = $block['data']['button_button_2_icon'] ?? '';
        if (!empty($button2Icon)) {
            $iconData = json_decode($button2Icon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $button2Icon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }

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
    $breadcrumbsLocation = $block['data']['breadcrumbs_location'] ?? 'underneath';


    // Blokinstellingen
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $showFeaturedImage = $block['data']['show_featured_image'] ?? false;
    $featuredImage = $showFeaturedImage ? get_the_post_thumbnail_url(get_the_ID(), 'full') : '';
    $featuredImageId = $featuredImage ? attachment_url_to_postid($featuredImage) : '';
    $backgroundVideoID = $block['data']['background_video'] ?? '';
    $backgroundVideoURL = $backgroundVideoID ? wp_get_attachment_url($backgroundVideoID) : '';

    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $headerBackgroundColor = $block['data']['background_color'] ?? '';
    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';


    // Paddings & margins
    $randomNumber = rand(0, 1000);

    $mobilePaddingTop = $block['data']['padding_mobile_padding_top'] ?? '';
    $mobilePaddingRight = $block['data']['padding_mobile_padding_right'] ?? '';
    $mobilePaddingBottom = $block['data']['padding_mobile_padding_bottom'] ?? '';
    $mobilePaddingLeft = $block['data']['padding_mobile_padding_left'] ?? '';
    $tabletPaddingTop = $block['data']['padding_tablet_padding_top'] ?? '';
    $tabletPaddingRight = $block['data']['padding_tablet_padding_right'] ?? '';
    $tabletPaddingBottom = $block['data']['padding_tablet_padding_bottom'] ?? '';
    $tabletPaddingLeft = $block['data']['padding_tablet_padding_left'] ?? '';
    $desktopPaddingTop = $block['data']['padding_desktop_padding_top'] ?? '';
    $desktopPaddingRight = $block['data']['padding_desktop_padding_right'] ?? '';
    $desktopPaddingBottom = $block['data']['padding_desktop_padding_bottom'] ?? '';
    $desktopPaddingLeft = $block['data']['padding_desktop_padding_left'] ?? '';

    $mobileMarginTop = $block['data']['margin_mobile_margin_top'] ?? '';
    $mobileMarginRight = $block['data']['margin_mobile_margin_right'] ?? '';
    $mobileMarginBottom = $block['data']['margin_mobile_margin_bottom'] ?? '';
    $mobileMarginLeft = $block['data']['margin_mobile_margin_left'] ?? '';
    $tabletMarginTop = $block['data']['margin_tablet_margin_top'] ?? '';
    $tabletMarginRight = $block['data']['margin_tablet_margin_right'] ?? '';
    $tabletMarginBottom = $block['data']['margin_tablet_margin_bottom'] ?? '';
    $tabletMarginLeft = $block['data']['margin_tablet_margin_left'] ?? '';
    $desktopMarginTop = $block['data']['margin_desktop_margin_top'] ?? '';
    $desktopMarginRight = $block['data']['margin_desktop_margin_right'] ?? '';
    $desktopMarginBottom = $block['data']['margin_desktop_margin_bottom'] ?? '';
    $desktopMarginLeft = $block['data']['margin_desktop_margin_left'] ?? '';


    // Animaties
    $showReadingProgress = $block['data']['show_reading_progress'] ?? false;
    $showScrollIndicator = $block['data']['show_scroll_indicator'] ?? false;
@endphp


@if ($customBlockClasses && $breadcrumbsEnabled && $breadcrumbsLocation === 'above' && !is_front_page() && get_the_ID())
    <div class="breadcrumbs-{{ $customBlockClasses }}"> @endif
        @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'above' && !is_front_page())
            @include('components.breadcrumbs.index')
        @endif
        @if ($customBlockClasses && $breadcrumbsEnabled && $breadcrumbsLocation === 'above' && !is_front_page() && get_the_ID()) </div>
@endif
<section id="@if($customBlockId){{ $customBlockId }}@else header @endif"
         class="block-header relative header-{{ $randomNumber }}-custom-padding header-{{ $randomNumber }}-custom-margin bg-{{ $headerBackgroundColor }} {{ $headerName }} @if($headerStyle == 'fixed_height') fixed-header @elseif($headerStyle == 'scalable_height') scaled-header @endif {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }} max-w-[2800px] mx-auto">
    <div class="custom-styling bg-cover bg-center {{ $headerClass }}"
         style="@if($backgroundImageParallax) background-attachment: fixed; @endif background-image: url('{{ $backgroundImageId ? wp_get_attachment_image_url($backgroundImageId, 'full') : ($featuredImage ? $featuredImage : '') }}'); {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId ?: $featuredImageId) }}">
        @if ($backgroundVideoURL)
            <video autoplay muted loop playsinline class="video-background absolute inset-0 w-full h-full object-cover">
                <source src="{{ esc_url($backgroundVideoURL) }}" type="video/mp4">
            </video>
        @endif
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="custom-width @if (!$fullHeightContentImage) relative @endif container mx-auto px-8 h-full flex items-center z-30 {{ $textPositionClass }} @if ($contentImageId) gap-x-8 @endif @if ($fullHeightContentImage && $textPosition === 'right') justify-end @endif">
            <div class="header-info z-30 flex flex-col @if ($headerStyle == 'scalable_height') py-20 @endif {{ $textWidthClass }} @if ($contentImageId) w-full md:w-1/2 @if ($textPosition === 'left') order-1 @elseif ($textPosition === 'right') order-2 pl-8 @endif @endif">
                @if ($showTitle)
                    @if ($subTitle)
                        <span class="subtitle block mb-2 text-{{ $subTitleColor }}">{!! $subTitle !!}</span>
                    @endif
                    <h1 class="title text-{{ $titleColor }}">{!! $title !!}</h1>
                @endif
                @if ($text)
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 text-lg mb-4 text-' . $textColor])
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="buttons w-full flex flex-wrap gap-y-2 gap-x-4 mt-4 @if ($textPosition === 'center') justify-center items-center @endif">
                        @include('components.buttons.default', [
                            'text' => $button1Text,
                            'href' => $button1Link,
                            'alt' => $button1Text,
                            'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                            'class' => 'rounded-lg',
                            'target' => $button1Target,
                            'icon' => $button1Icon,
                            'download' => $button1Download,
                        ])
                        @if (($button2Text) && ($button2Link))
                            @include('components.buttons.default', [
                                'text' => $button2Text,
                                'href' => $button2Link,
                                'alt' => $button2Text,
                                'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                                'class' => 'rounded-lg',
                                'target' => $button2Target,
                                'icon' => $button2Icon,
                                'download' => $button2Download,
                            ])
                        @endif
                    </div>
                @endif

                @if ($showScrollIndicator)
                    <div class="scroll-indicator-icon absolute left-1/2 bottom-[30px] transform -translate-x-1/2">
                        <a href="#" class="block scroll-to-next">
                            <div class="w-12 h-12 rounded-full border-2 border-white flex items-center justify-center text-white hover:bg-white hover:text-black transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                @endif

                @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'inside' &&!is_front_page())
                    @include('components.breadcrumbs.index')
                @endif
            </div>
            @if ($contentImageId)
                <div class="content-image w-full md:w-1/2
                @if ($textPosition === 'left') order-2 @elseif ($textPosition === 'right') order-1 @endif
                @if ($fullHeightContentImage) absolute h-full
                    @if ($textPosition === 'left') left-0 md:left-[50%] custom-image-width { @endif
                    @if ($textPosition === 'right') right-0 md:right-[50%] custom-image-width @endif
                @endif">
                    @include('components.image', [
                        'image_id' => $contentImageId,
                        'size' => 'full',
                        'object_fit' => 'cover',
                        'img_class' => 'w-full h-full object-cover rounded-' . $borderRadius,
                        'alt' => $contentImageAlt
                    ])
                    <div class="z-30 text-white absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 hidden md:block">
                        @if ($title2)
                            <h2 class="">{!! $title2 !!}</h2>
                        @endif
                        @if ($text2)
                            @include('components.content', ['content' => apply_filters('the_content', $text2), 'class' => 'mt-4 text-lg mb-4 text-' . $textColor])
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@if ($customBlockClasses) <div class="breadcrumbs-{{ $customBlockClasses }}"> @endif
    @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'underneath' && !is_front_page())
        @include('components.breadcrumbs.index')
    @endif
@if ($customBlockClasses) </div> @endif


<style>
    .header-{{ $randomNumber }}-custom-padding {
        @media only screen and (min-width: 0px) {
            @if($mobilePaddingTop) padding-top: {{ $mobilePaddingTop }}px; @endif
            @if($mobilePaddingRight) padding-right: {{ $mobilePaddingRight }}px; @endif
            @if($mobilePaddingBottom) padding-bottom: {{ $mobilePaddingBottom }}px; @endif
            @if($mobilePaddingLeft) padding-left: {{ $mobilePaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletPaddingTop) padding-top: {{ $tabletPaddingTop }}px; @endif
            @if($tabletPaddingRight) padding-right: {{ $tabletPaddingRight }}px; @endif
            @if($tabletPaddingBottom) padding-bottom: {{ $tabletPaddingBottom }}px; @endif
            @if($tabletPaddingLeft) padding-left: {{ $tabletPaddingLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopPaddingTop) padding-top: {{ $desktopPaddingTop }}px; @endif
            @if($desktopPaddingRight) padding-right: {{ $desktopPaddingRight }}px; @endif
            @if($desktopPaddingBottom) padding-bottom: {{ $desktopPaddingBottom }}px; @endif
            @if($desktopPaddingLeft) padding-left: {{ $desktopPaddingLeft }}px; @endif
        }
    }

    .header-{{ $randomNumber }}-custom-margin {
        @media only screen and (min-width: 0px) {
            @if($mobileMarginTop) margin-top: {{ $mobileMarginTop }}px; @endif
            @if($mobileMarginRight) margin-right: {{ $mobileMarginRight }}px; @endif
            @if($mobileMarginBottom) margin-bottom: {{ $mobileMarginBottom }}px; @endif
            @if($mobileMarginLeft) margin-left: {{ $mobileMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 768px) {
            @if($tabletMarginTop) margin-top: {{ $tabletMarginTop }}px; @endif
            @if($tabletMarginRight) margin-right: {{ $tabletMarginRight }}px; @endif
            @if($tabletMarginBottom) margin-bottom: {{ $tabletMarginBottom }}px; @endif
            @if($tabletMarginLeft) margin-left: {{ $tabletMarginLeft }}px; @endif
        }
        @media only screen and (min-width: 1024px) {
            @if($desktopMarginTop) margin-top: {{ $desktopMarginTop }}px; @endif
            @if($desktopMarginRight) margin-right: {{ $desktopMarginRight }}px; @endif
            @if($desktopMarginBottom) margin-bottom: {{ $desktopMarginBottom }}px; @endif
            @if($desktopMarginLeft) margin-left: {{ $desktopMarginLeft }}px; @endif
        }
    }

    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0);
        }
        40% {
            transform: translateY(10px);
        }
        60% {
            transform: translateY(5px);
        }
    }

    .scroll-indicator-icon {
        animation: bounce 2s infinite;
    }
</style>

@if ($showReadingProgress)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.querySelector('header');

            if (header) {
                const progressContainer = document.createElement('div');
                progressContainer.className = 'reading-progress';

                const progressFill = document.createElement('div');
                progressFill.className = 'reading-progress-fill';

                progressContainer.appendChild(progressFill);
                header.appendChild(progressContainer);

                document.addEventListener('scroll', function() {
                    const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                    const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                    const width = (scrollTop / scrollHeight) * 100;
                    progressFill.style.width = width + '%';
                });
            }
        });
    </script>
@endif

@if ($showScrollIndicator)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollBtn = document.querySelector('.scroll-to-next');

            scrollBtn.addEventListener('click', (e) => {
                e.preventDefault();

                // Get all <section> elements
                const sections = document.querySelectorAll('section');

                // Convert NodeList to Array, skip the one with ID "header" (trim in case of whitespace)
                const nextSection = Array.from(sections).find(
                    section => section.id.trim() !== 'header'
                );

                if (nextSection) {
                    nextSection.scrollIntoView({ behavior: 'smooth' });
                }
            });
        });
    </script>
@endif