@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $subTitle = $block['data']['subtitle'] ?? '';
    $subTitleColor = $block['data']['subtitle_color'] ?? '';
    $subtitleIcon = $block['data']['subtitle_icon'] ?? '';
    $subtitleIcon = $subtitleIcon ? json_decode($subtitleIcon, true) : null;
    $subtitleIconColor = $block['data']['subtitle_icon_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';


    // Show links
    $linkColor = $block['data']['link_color'] ?? '';
    $stickyMenu = $block['data']['sticky_submenu'] ?? true;

    $linksCount = $block['data']['links'] ?? 0;
    $links = [];

    for ($i = 0; $i < $linksCount; $i++) {

     $linkKey = "links_{$i}_link";
     $linkUrl = $block['data'][$linkKey]['url'] ?? '';
     $linkText = $block['data'][$linkKey]['title'] ?? '';
     $linkTarget = $block['data'][$linkKey]['target'] ?? '';

     $links[] = [
         'text' => $linkText,
         'link' => $linkUrl,
         'target' => $linkTarget,
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
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Paddings & margins
    \Theme\Views\Components\BlockComponent::$blockCounter++; $randomNumber = \Theme\Views\Components\BlockComponent::$blockCounter;

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

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'submenu' }}@endif" class="block-submenu @if($stickyMenu) sticky-submenu sticky z-40 @else relative @endif submenu-{{ $randomNumber }}-custom-padding submenu-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 @if($stickyMenu) py-8 @else py-8 2xl:py-16 @endif {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $subTitleColor }} {{ $textClass }}">
                    @if ($subtitleIcon)
                        <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                    @endif
                    {!! $subTitle !!}
                </span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} {{ $textClass }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'mb-8 text-' . $textColor . ' ' .  $textClass . ($blockWidth == 'fullscreen' ? ' ' : '')
                ])
            @endif
            <div class="links-list flex flex-wrap gap-1 text-{{ $linkColor }}">
                @foreach($links as $index => $link)
                    @if ($link['text'] && $link['link'])
                        <a href="{{ $link['link'] }}" class="link-item underline hover:text-primary" target="{{ $link['target'] }}" aria-label="Ga naar {{ $link['text'] }}">{{ $link['text'] }}</a>
                        @if ($index < count($links) - 1)
                            <span class="separator">|</span>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>

@if ($stickyMenu)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const masthead = document.getElementById('masthead');
            const submenu = document.querySelector('.sticky-submenu');

            if (!masthead || !submenu) return;

            const mastheadHeight = masthead.offsetHeight;
            const submenuHeight = submenu.offsetHeight;
            const combinedHeight = mastheadHeight + submenuHeight;

            // Set scroll-margin via a <style> tag
            const style = document.createElement('style');
            style.textContent = `* { scroll-margin: ${combinedHeight}px !important; }`;
            document.head.appendChild(style);

            // Set initial top position
            submenu.style.top = mastheadHeight + 'px';

            // Scroll event for shadow toggle
            window.addEventListener('scroll', () => {
                if (window.scrollY > mastheadHeight) {
                    submenu.classList.add('shadow-xl');
                } else {
                    submenu.classList.remove('shadow-xl');
                }
            });
        });
    </script>
@endif

<style>
    .submenu-{{ $randomNumber }}-custom-padding {
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

    .submenu-{{ $randomNumber }}-custom-margin {
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