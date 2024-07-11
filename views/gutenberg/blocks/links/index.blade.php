@php
    // Content
    $title = $block['data']['title'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

         $textPosition = $block['data']['text_position'] ?? '';
         $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
         $textClass = $titleClassMap[$textPosition] ?? '';


    // Show links
    $linkDisplay = $block['data']['link_display'] ?? 'button';
    $linksCount = $block['data']['links'] ?? 0;
    $links = [];

    for ($i = 0; $i < $linksCount; $i++) {
        $linkKey = "links_{$i}_link";
        $linkText = $block['data'][$linkKey]['title'] ?? '';
        $linkUrl = $block['data'][$linkKey]['url'] ?? '';
        $linkTarget = $block['data'][$linkKey]['target'] ?? '_self';

        $buttonColor = $block['data']["links_{$i}_button_color"] ?? '';
        $linkImage = $block['data']["links_{$i}_link_image"] ?? '';
        $linkIcon = $block['data']["links_{$i}_link_icon"] ?? '';

        $links[] = [
            'linkText' => $linkText,
            'linkUrl' => $linkUrl,
            'linkTarget' => $linkTarget,
            'buttonColor' => $buttonColor,
            'linkImage' => $linkImage,
            'linkIcon' => $linkIcon,
        ];
    }

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

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
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
@endphp

<section id="links" class="block-links relative links-{{ $randomNumber }}-custom-padding links-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto {{ $textClass }} layout">
            <div class="content-data mb-4">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $titleColor }}">{!! $subTitle !!}</span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
                @endif
                @if ($text)
                    @include('components.content', [
                        'content' => apply_filters('the_content', $text),
                        'class' => 'mb-8 text-' . $textColor . ($blockWidth == 'fullscreen' ? ' ' : '')
                    ])
                @endif
            </div>

            @if ($links)
                @if ($linkDisplay == 'icon')
                    <div class="links-list flex flex-wrap gap-x-12 gap-y-8 {{ $textClass }}">
                        @foreach($links as $link)
                            @if($link['linkText'] && $link['linkUrl'])
                                <div class="link-item w-full">
                                    <a href="{{ $link['linkUrl'] }}" aria-label="Ga naar {{ $link['linkText'] }} pagina"
                                       target="{{ $link['linkTarget'] }}" class="flex items-center gap-x-4 group w-fit">
                                        @if($link['linkIcon'])
                                            @php
                                                $iconData = json_decode($link['linkIcon'], true);
                                                $iconClass = 'fa-' . ($iconData['style'] ?? 'solid') . ' fa-' . ($iconData['id'] ?? '');
                                            @endphp
                                            <i class="fa {{ $iconClass }} text-[50px] group-hover:scale-105 transition-transform duration-300 ease-in-out" aria-hidden="true"></i>
                                        @endif
                                        <span class="link-text text-cta font-semibold group-hover:underline">{{ $link['linkText'] }}</span>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @elseif ($linkDisplay == 'image')
                    <div class="links-list flex flex-wrap gap-x-12 gap-y-8 {{ $textClass }}">
                        @foreach($links as $link)
                            @if($link['linkText'] && $link['linkUrl'])
                                <div class="link-item w-full">
                                    <a href="{{ $link['linkUrl'] }}" aria-label="Ga naar {{ $link['linkText'] }} pagina"
                                       target="{{ $link['linkTarget'] }}" class="flex items-center gap-x-4 group w-fit">
                                        @if($link['linkImage'])
                                            @include('components.image', [
                                                'image_id' => $link['linkImage'],
                                                'size' => '',
                                                'object_fit' => 'contain',
                                                'img_class' => 'h-[50px] w-[50px] group-hover:scale-105 transition-transform duration-300 ease-in-out',
                                                'alt' => $link['linkText']
                                            ])
                                        @endif
                                        <span class="link-text text-cta font-semibold group-hover:underline">{{ $link['linkText'] }}</span>
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @elseif ($linkDisplay == 'button')
                    <div class="links-list flex flex-wrap gap-2 {{ $textClass }}">
                        @foreach($links as $link)
                            @if($link['linkText'] && $link['linkUrl'])
                                <a href="{{ $link['linkUrl'] }}" aria-label="Ga naar {{ $link['linkText'] }} pagina"
                                   target="{{ $link['linkTarget'] }}" class="link-text btn btn-{{ $link['buttonColor'] }} btn-filled">{{ $link['linkText'] }}</a>
                            @endif
                        @endforeach
                    </div>
                @endif
            @endif
        </div>
    </div>
</section>

<style>
    .links-{{ $randomNumber }}-custom-padding {
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

    .links-{{ $randomNumber }}-custom-margin {
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
</style>