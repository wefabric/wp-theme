@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

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
    $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
    $textClass = $textClassMap[$textPosition] ?? '';


    // Quote
    $showQuoteIcon = $block['data']['show_quote_icon'] ?? false;
    $quote = $block['data']['quote'] ?? '';
    $quoteTextColor = $block['data']['quote_text_color'] ?? '';
    $avatarId = $block['data']['avatar'] ?? '';
    $name = $block['data']['name'] ?? '';
    $function = $block['data']['function'] ?? '';
    $personTextColor = $block['data']['person_text_color'] ?? '';
    $quoteBackgroundColor = $block['data']['quote_background_color'] ?? '';
    $quoteBackgroundImageId = $block['data']['quote_background_image'] ?? '';


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


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
    $flyinEffect = $block['data']['flyin_effect'] ?? false;
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'quote' }}@endif" class="block-quote relative quote-{{ $randomNumber }}-custom-padding quote-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">

    <div class="overflow-class">

        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="whitespace-class relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
            <div class="quote-{{ $randomNumber }}-flyin {{ $blockClass }} {{ $textClass }} mx-auto @if ($flyinEffect) quote-hidden @endif">

                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $subTitleColor }}">{!! $subTitle !!}</span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                @endif
                @if ($text)
                    @include('components.content', [
                        'content' => apply_filters('the_content', $text),
                        'class' => 'mb-8 text-' . $textColor . ' ' . $textClass . ($blockWidth == 'fullscreen' ? ' ' : '')
                    ])
                @endif

                @if ($quoteBackgroundColor || $quoteBackgroundImageId)
                    <div class="quote-background relative block bg-{{ $quoteBackgroundColor }} p-8"
                         @if ($quoteBackgroundImageId)
                         style="background-image: url('{{ wp_get_attachment_image_url($quoteBackgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($quoteBackgroundImageId) }}"
                         @endif
                    >
                @endif
                    @if ($showQuoteIcon)
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                             class="quote-icon inline-block w-8 h-8 mb-2 md:mb-6 text-{{ $quoteTextColor }}"
                             viewBox="0 0 975.036 975.036">
                            <path d="M925.036 57.197h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.399 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l36 76c11.6 24.399 40.3 35.1 65.1 24.399 66.2-28.6 122.101-64.8 167.7-108.8 55.601-53.7 93.7-114.3 114.3-181.9 20.601-67.6 30.9-159.8 30.9-276.8v-239c0-27.599-22.401-50-50-50zM106.036 913.497c65.4-28.5 121-64.699 166.9-108.6 56.1-53.7 94.4-114.1 115-181.2 20.6-67.1 30.899-159.6 30.899-277.5v-239c0-27.6-22.399-50-50-50h-304c-27.6 0-50 22.4-50 50v304c0 27.601 22.4 50 50 50h145.5c-1.9 79.601-20.4 143.3-55.4 191.2-27.6 37.8-69.4 69.1-125.3 93.8-25.7 11.3-36.8 41.7-24.8 67.101l35.9 75.8c11.601 24.399 40.501 35.2 65.301 24.399z"></path>
                        </svg>
                    @endif
                    @if ($quote)
                        @include('components.content', ['content' => apply_filters('the_content', $quote), 'class' => 'quote-text text-[24px] md:text-[36px] text-' . $quoteTextColor])
                    @endif
                    @if ($avatarId || $name || $function)
                        <div class="avatar-section flex items-center gap-x-4 mt-5 {{ $textClass }}">
                            @if ($avatarId)
                                <div class="avatar-image-section flex-shrink-0">
                                    @include('components.image', [
                                        'image_id' => $avatarId,
                                        'size' => 'full',
                                        'object_fit' => 'cover',
                                        'img_class' => 'avatar-image w-14 h-14 aspect-square rounded-full object-cover object-center',
                                        'alt' => $name,
                                    ])
                                </div>
                            @endif
                            @if ($name || $function)
                                <div class="avatar-details @if ($avatarId) text-left @endif">
                                    @if ($name)
                                        <div class="name-text h6 text-{{ $personTextColor }}">{{ $name }}</div>
                                    @endif
                                    @if ($function)
                                        <div class="function-text mt-1 text-{{ $personTextColor }}">{{ $function }}</div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                @if ($quoteBackgroundColor || $quoteBackgroundImageId)
                    </div>
                @endif

                @if (($button1Text) && ($button1Link))
                    <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif">
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
            </div>
        </div>
    </div>
</section>

<style>
    .quote-{{ $randomNumber }}-custom-padding {
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

    .quote-{{ $randomNumber }}-custom-margin {
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

    .quote-hidden {
        opacity: 0;
    }

    .quote-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>

@if ($flyinEffect)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const quoteItem = document.querySelector('.quote-{{ $randomNumber }}-flyin');

            if (!quoteItem) {
                return;
            }

            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach((entry) => {
                    if (!entry.isIntersecting) {
                        return;
                    }

                    if (entry.target.classList.contains('quote-hidden')) {
                        entry.target.classList.add('quote-animated');
                        entry.target.classList.remove('quote-hidden');
                    }

                    obs.unobserve(entry.target);
                });
            }, {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.035
            });

            observer.observe(quoteItem);
        });
    </script>
@endif