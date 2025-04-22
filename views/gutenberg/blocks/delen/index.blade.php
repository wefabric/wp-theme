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

    $sharePlatforms = $block['data']['share_platforms'] ?? [];


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
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else delen @endif" class="block-delen relative delen-{{ $randomNumber }}-custom-padding delen-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }};">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-50 px-8 py-8 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto {{ $textClass }}">

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

            @if ($sharePlatforms)
                <div class="share-wrapper group relative z-50 w-fit">
                    <div class="share-button flex items-center gap-x-2 cursor-pointer"><i class="fas fa-share-alt"></i>Delen</div>
                    <div class="submenu hidden group-hover:flex flex-col absolute bg-background-color w-fit z-50">
                        @if (in_array('facebook', $sharePlatforms))
                            <div class="share-social facebook px-4 py-2">
                                <a href="#" class="share-btn facebook flex items-center gap-x-2" onclick="shareOnFacebook()" aria-label="Deel op Facebook">
                                    <i class="fab fa-facebook-f"></i>Facebook
                                </a>
                            </div>
                        @endif
                        @if (in_array('x', $sharePlatforms))
                            <div class="share-social x px-4 py-2">
                                <a href="#" class="share-btn twitter flex items-center gap-x-2" onclick="shareOnX()" aria-label="Deel op X">
                                    <i class="fa-brands fa-x-twitter"></i>X
                                </a>
                            </div>
                        @endif
                        @if (in_array('linkedin', $sharePlatforms))
                            <div class="share-social linkedin px-4 py-2">
                                <a href="#" class="share-btn linkedin flex items-center gap-x-2" onclick="shareOnLinkedIn()" aria-label="Deel op LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>LinkedIn
                                </a>
                            </div>
                        @endif
                        @if (in_array('whatsapp', $sharePlatforms))
                            <div class="share-social whatsapp px-4 py-2">
                                <a href="#" class="share-btn whatsapp flex items-center gap-x-2" onclick="shareOnWhatsApp()" aria-label="Deel op WhatsApp">
                                    <i class="fab fa-whatsapp"></i>WhatsApp
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>

<style>
    .delen-{{ $randomNumber }}-custom-padding {
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

    .delen-{{ $randomNumber }}-custom-margin {
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

<script>
      function getCurrentUrl() {
        return window.location.href;
    }
    function shareOnFacebook() {
        var url = getCurrentUrl();
        var shareUrl = 'https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(url);
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    function shareOnX() {
        var url = getCurrentUrl();
        var shareUrl = 'https://twitter.com/intent/tweet?url=' + encodeURIComponent(url);
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    function shareOnLinkedIn() {
        var url = getCurrentUrl();
        var shareUrl = 'https://www.linkedin.com/shareArticle?mini=true&url=' + encodeURIComponent(url);
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }

    function shareOnWhatsApp() {
        var url = getCurrentUrl();
        var shareUrl = 'https://api.whatsapp.com/send?text=' + encodeURIComponent(url);
        window.open(shareUrl, '_blank', 'width=600,height=400');
    }
</script>
