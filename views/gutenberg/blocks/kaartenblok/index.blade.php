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

        $buttonCardText = $block['data']['card_button_button_text'] ?? '';
        $buttonCardColor = $block['data']['card_button_button_color'] ?? '';
        $buttonCardStyle = $block['data']['card_button_button_style'] ?? '';
        $buttonCardIcon = $block['data']['card_button_button_icon'] ?? '';
        if (!empty($buttonCardIcon)) {
            $iconData = json_decode($buttonCardIcon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $buttonCardIcon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }

        $textPosition = $block['data']['text_position'] ?? '';
        $textClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
        $textClass = $textClassMap[$textPosition] ?? '';


    // Kaarten
    $cardVariant = $block['data']['cardblock_version'] ?? '';
    $pagesData = [];
    $numPages = isset($block['data']['pages']) ? intval($block['data']['pages']) : 0;

    $cardBackgroundColor = $block['data']['card_background_color'] ?? '';
    $cardTitleColor = $block['data']['card_title_color'] ?? '';
    $cardTextColor = $block['data']['card_text_color'] ?? '';
    $cardIconColor = $block['data']['card_icon_color'] ?? '';
    $cardOverlayColor = $block['data']['card_overlay_color'] ?? '';
    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;

    $selectedPostType = $block['data']['cardblock_post_type'] ?? '';
    $cardVisual = $block['data']['block_visual'] ?? 'featured_image';

    // Als er een post type is geselecteerd, haal dan alle berichten van deze post type op
    if (!empty($selectedPostType)) {
        $cardVisual = 'featured_image';
        $args = [
            'post_type' => $selectedPostType,
            'posts_per_page' => -1,
            'post_status' => 'publish',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == $selectedPostType) {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);

        if ($query->have_posts()) {
            foreach ($query->posts as $post) {
                $pagesData[] = [
                    'id' => $post->ID,
                    'title' => $post->post_title,
                    'custom_title' => '',
                    'url' => get_permalink($post->ID),
                    'content' => $post->post_content,
                    'icon' => '', // You can add icon logic based on post meta if needed
                    'image_id' => has_post_thumbnail($post->ID) ? get_post_thumbnail_id($post->ID) : 0,
                    'featured_image_id' => has_post_thumbnail($post->ID) ? get_post_thumbnail_id($post->ID) : 0,
                ];
            }
        }
        wp_reset_postdata();
    } else {
        // Use manually selected pages
        for ($i = 0; $i < $numPages; $i++) {
            $pageId = $block['data']["pages_{$i}_page"] ?? 0;
            $imageId = $block['data']["pages_{$i}_image"] ?? 0;

            if ($pageId) {
                $page = get_post($pageId);

                if ($page) {
                    $pagesData[] = [
                        'id' => $page->ID,
                        'title' => $page->post_title,
                        'custom_title' => $block['data']["pages_{$i}_custom_page_title"] ?? '',
                        'url' => get_permalink($page->ID),
                        'content' => $page->post_content,
                        'icon' => $block['data']["pages_{$i}_icon"] ?? '',
                        'image_id' => $imageId,
                        'featured_image_id' => $imageId ?: (has_post_thumbnail($page->ID) ? get_post_thumbnail_id($page->ID) : 0),
                    ];
                }
            }
        }
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
    $hoverEffect = $block['data']['hover_effect'] ?? '';
    $hoverEffectClasses = [
        'lift-up' => 'group-hover:-translate-y-2 group-hover:md:-translate-y-4',
        'scale-up' => 'group-hover:scale-105',
        'scale-down' => 'group-hover:scale-95',
        'none' => ''
    ];
    $hoverEffectClass = $hoverEffectClasses[$hoverEffect] ?? '';

    $flyinEffect = $block['data']['flyin_effect'] ?? false;
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'kaarten' }}@endif" class="block-kaarten kaarten-{{ $randomNumber }}-custom-padding kaarten-{{ $randomNumber }}-custom-margin relative bg-{{ $backgroundColor }} {{ $customBlockClasses }} @if ($cardVariant == 'variant1') content-in-card @elseif ($cardVariant == 'variant2') content-under-card @endif {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat;  @if($backgroundImageParallax) background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if($swiperOutContainer)
        <div class="overflow-hidden">
    @endif
        @if ($overlayEnabled)
            <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
        @endif
        <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
            <div class="block-content {{ $blockClass }} mx-auto">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $subTitleColor }} @if($blockWidth == 'fullscreen') px-8 @endif {{ $textClass }}">{!! $subTitle !!}</span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }} @if($blockWidth == 'fullscreen') px-8 @endif {{ $textClass }}">{!! $title !!}</h2>
                @endif
                @if ($text)
                    @include('components.content', [
                       'content' => apply_filters('the_content', $text),
                       'class' => 'mt-4 text-' . $textColor . ' ' . $textClass,
                    ])
                @endif
                @if ($pagesData)
                    @include('components.cardblock.list')
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="buttons bottom-button w-full flex flex-wrap gap-x-4 gap-y-2 mt-4 md:mt-8 {{ $textClass }}">
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
    @if($swiperOutContainer)
        </div>
    @endif
</section>

<style>
    .kaarten-{{ $randomNumber }}-custom-padding {
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

    .kaarten-{{ $randomNumber }}-custom-margin {
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

    .card-hidden {
        opacity: 0;
    }

    .swiper-slide-duplicate .card-hidden {
        animation: flyIn 0.6s ease-out forwards !important;
    }

    .card-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>

@if ($flyinEffect)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const cardItems = document.querySelectorAll('.card-item');
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.035
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const cardItem = entry.target;

                        setTimeout(() => {
                            if (cardItem.classList.contains('card-hidden')) {
                                cardItem.classList.add('card-animated');
                                cardItem.classList.remove('card-hidden');
                            }
                        }, index * 200);

                        observer.unobserve(cardItem);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            cardItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endif