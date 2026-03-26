@if ($customBlockClasses && $breadcrumbsEnabled && $breadcrumbsLocation === 'above' && !is_front_page() && get_the_ID())
    <div class="breadcrumbs-{{ $customBlockClasses }}">
@endif
        @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'above' && !is_front_page())
            @include('components.breadcrumbs.index')
        @endif
@if ($customBlockClasses && $breadcrumbsEnabled && $breadcrumbsLocation === 'above' && !is_front_page() && get_the_ID())
    </div>
@endif

<section id="{{ $customBlockId ?: 'header' }}"
         class="block-header relative header-{{ $randomNumber }}-custom-padding header-{{ $randomNumber }}-custom-margin bg-{{ $headerBackgroundColor }} {{ $headerName }} @if($headerStyle === 'fixed_height') fixed-header @elseif($headerStyle === 'scalable_height') scaled-header @endif {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }} max-w-[2800px] mx-auto">

    <div class="custom-styling bg-cover bg-center {{ $headerClass }}"
         style="@if($backgroundImageParallax) background-attachment: fixed; @endif background-image: url('{{ $backgroundImageId ? wp_get_attachment_image_url($backgroundImageId, 'full') : ($featuredImage ?: '') }}'); {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId ?: $featuredImageId) }}">

        @if ($backgroundVideoURL)
            <video autoplay muted loop playsinline class="video-background absolute inset-0 w-full h-full object-cover">
                <source src="{{ esc_url($backgroundVideoURL) }}" type="video/mp4">
            </video>
        @endif

        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif

        <div class="custom-width @if (!$fullHeightContentImage) relative @endif container mx-auto px-8 h-full flex items-center z-30 {{ $textPositionClass }} @if ($contentImageId) gap-x-8 @endif @if ($fullHeightContentImage && $textPosition === 'right') justify-end @endif">

            <div class="header-info z-30 flex flex-col @if ($headerStyle === 'scalable_height') py-20 @endif {{ $textWidthClass }} @if ($contentImageId) w-full md:w-1/2 @if ($textPosition === 'left') order-1 @elseif ($textPosition === 'right') order-2 pl-8 @endif @endif">

                @if ($showTitle)
                    @if ($subTitle)
                        <span class="subtitle block mb-2 text-{{ $subTitleColor }}">{!! $subTitle !!}</span>
                    @endif
                    <h1 class="title text-{{ $titleColor }}">{!! $title !!}</h1>
                @endif

                @if ($text)
                    @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 text-lg mb-4 text-' . $textColor])
                @endif

                @if ($buttons && $buttons->isNotEmpty())
                    <div class="buttons w-full flex flex-wrap gap-y-2 gap-x-4 mt-4 @if ($textPosition === 'center') justify-center items-center @endif">
                        @foreach ($buttons as $button)
                            @if ($button->text && $button->href)
                                @include('components.buttons.default', [
                                    'text'     => $button->text,
                                    'href'     => $button->href,
                                    'alt'      => $button->text,
                                    'colors'   => 'btn-' . $button->color . ' btn-' . $button->style,
                                    'class'    => 'rounded-lg',
                                    'target'   => $button->target,
                                    'icon'     => $button->icon,
                                    'download' => $button->download,
                                ])
                            @endif
                        @endforeach
                    </div>
                @endif

                @if (!empty($tags))
                    <div class="header-tags flex flex-wrap gap-2 mt-4">
                        @foreach ($tags as $tag)
                            <div class="header-tag px-3 py-1 rounded-full">
                                {!! $tag['text'] !!}
                            </div>
                        @endforeach
                    </div>
                @endif

                @if ($showScrollIndicator)
                    <div class="scroll-indicator-icon absolute left-1/2 bottom-[30px] transform -translate-x-1/2">
                        <a href="#" class="block scroll-to-next">
                            <div class="w-12 h-12 rounded-full border-2 border-white flex items-center justify-center text-white hover:bg-white hover:text-black transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                @endif

                @if ($breadcrumbsEnabled && $breadcrumbsLocation === 'inside' && !is_front_page())
                    @include('components.breadcrumbs.index')
                @endif

            </div>

            @if ($contentImageId)
                <div class="content-image w-full md:w-1/2
                    @if ($textPosition === 'left') order-2 @elseif ($textPosition === 'right') order-1 @endif
                    @if ($fullHeightContentImage) absolute h-full
                        @if ($textPosition === 'left') left-0 md:left-[50%] custom-image-width @endif
                        @if ($textPosition === 'right') right-0 md:right-[50%] custom-image-width @endif
                    @endif">
                    @include('components.image', [
                        'image_id'   => $contentImageId,
                        'size'       => 'full',
                        'object_fit' => 'cover',
                        'img_class'  => 'w-full h-full object-cover rounded-' . $borderRadius,
                        'alt'        => $contentImageAlt,
                    ])
                    <div class="z-30 text-white absolute top-1/2 -translate-y-1/2 left-1/2 -translate-x-1/2 hidden md:block">
                        @if ($title2)
                            <h2>{!! $title2 !!}</h2>
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

@php
    // Inline CSS for paddings and margins
    $mobilePaddingTop      = $block['data']['padding_mobile_padding_top'] ?? '';
    $mobilePaddingRight    = $block['data']['padding_mobile_padding_right'] ?? '';
    $mobilePaddingBottom   = $block['data']['padding_mobile_padding_bottom'] ?? '';
    $mobilePaddingLeft     = $block['data']['padding_mobile_padding_left'] ?? '';
    $tabletPaddingTop      = $block['data']['padding_tablet_padding_top'] ?? '';
    $tabletPaddingRight    = $block['data']['padding_tablet_padding_right'] ?? '';
    $tabletPaddingBottom   = $block['data']['padding_tablet_padding_bottom'] ?? '';
    $tabletPaddingLeft     = $block['data']['padding_tablet_padding_left'] ?? '';
    $desktopPaddingTop     = $block['data']['padding_desktop_padding_top'] ?? '';
    $desktopPaddingRight   = $block['data']['padding_desktop_padding_right'] ?? '';
    $desktopPaddingBottom  = $block['data']['padding_desktop_padding_bottom'] ?? '';
    $desktopPaddingLeft    = $block['data']['padding_desktop_padding_left'] ?? '';

    $mobileMarginTop       = $block['data']['margin_mobile_margin_top'] ?? '';
    $mobileMarginRight     = $block['data']['margin_mobile_margin_right'] ?? '';
    $mobileMarginBottom    = $block['data']['margin_mobile_margin_bottom'] ?? '';
    $mobileMarginLeft      = $block['data']['margin_mobile_margin_left'] ?? '';
    $tabletMarginTop       = $block['data']['margin_tablet_margin_top'] ?? '';
    $tabletMarginRight     = $block['data']['margin_tablet_margin_right'] ?? '';
    $tabletMarginBottom    = $block['data']['margin_tablet_margin_bottom'] ?? '';
    $tabletMarginLeft      = $block['data']['margin_tablet_margin_left'] ?? '';
    $desktopMarginTop      = $block['data']['margin_desktop_margin_top'] ?? '';
    $desktopMarginRight    = $block['data']['margin_desktop_margin_right'] ?? '';
    $desktopMarginBottom   = $block['data']['margin_desktop_margin_bottom'] ?? '';
    $desktopMarginLeft     = $block['data']['margin_desktop_margin_left'] ?? '';
@endphp

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
        0%, 20%, 50%, 80%, 100% { transform: translateX(-50%) translateY(0); }
        40% { transform: translateX(-50%) translateY(10px); }
        60% { transform: translateX(-50%) translateY(5px); }
    }

    .scroll-indicator-icon {
        animation: bounce 2s infinite;
    }
</style>

@if ($showReadingProgress)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const progressContainer = document.createElement('div');
            progressContainer.className = 'reading-progress';

            const progressFill = document.createElement('div');
            progressFill.className = 'reading-progress-fill';

            progressContainer.appendChild(progressFill);
            document.body.appendChild(progressContainer);

            document.addEventListener('scroll', function () {
                const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
                const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                progressFill.style.width = ((scrollTop / scrollHeight) * 100) + '%';
            });
        });
    </script>
@endif

@if ($showScrollIndicator)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const scrollBtn = document.querySelector('.scroll-to-next');

            scrollBtn.addEventListener('click', (e) => {
                e.preventDefault();

                const sections = document.querySelectorAll('section');
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
