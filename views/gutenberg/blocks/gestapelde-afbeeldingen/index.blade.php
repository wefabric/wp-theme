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


    // Afbeeldingen
    $groupCount  = $block['data']['image_group'] ?? 0;
    $imagesCount = $block['data']['images_count'] ?? 0;

    $mobileImagesWrapperHeight = $block['data']['mobile_image_wrapper_height'] ?? 400;
    $tabletImagesWrapperHeight = $block['data']['tablet_image_wrapper_height'] ?? 500;
    $desktopImagesWrapperHeight = $block['data']['desktop_image_wrapper_height'] ?? 600;
    $desktopXlImagesWrapperHeight = $block['data']['desktop_xl_image_wrapper_height'] ?? 600;

    $imageGroups = [];
    $imageIds = [];
    for ($g = 0; $g < $groupCount; $g++) {
        $images = [];
        for ($i = 1; $i <= $imagesCount; $i++) {
            $key = "image_group_{$g}_image_{$i}";
            if (!empty($block['data'][$key])) {
                $image_id = $block['data'][$key];
                $alt      = get_post_meta($image_id, '_wp_attachment_image_alt', true) ?: '';
                $images[] = [
                    'id'  => $image_id,
                    'alt' => $alt
                ];

                if (!isset($imageIds[$image_id])) {
                    $imageIds[$image_id] = [
                        'top'    => isset($block['data']["image_{$i}_top"]) ? $block['data']["image_{$i}_top"] . '%' : 'auto',
                        'bottom' => isset($block['data']["image_{$i}_bottom"]) ? $block['data']["image_{$i}_bottom"] . '%' : 'auto',
                        'left'   => isset($block['data']["image_{$i}_left"]) ? $block['data']["image_{$i}_left"] . '%' : 'auto',
                        'right'  => isset($block['data']["image_{$i}_right"]) ? $block['data']["image_{$i}_right"] . '%' : 'auto',
                    ];
                }
            }
        }
        if (!empty($images)) {
            $imageGroups[] = $images;
        }
    }


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [33 => 'w-full lg:w-1/3', 50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto px-8' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $backgroundImageId = $block['data']['background_image'] ?? '';
    $backgroundOverlayEnabled = $block['data']['overlay_background_image'] ?? false;
    $backgroundOverlayColor = $block['data']['background_overlay_color'] ?? '';
    $backgroundOverlayOpacity = $block['data']['background_overlay_opacity'] ?? '';
    $backgroundImageParallax = $block['data']['background_image_parallax'] ?? false;

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';
    $hideBlock = $block['data']['hide_block'] ?? false;


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';


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


    // Animaties
    $flyinEffect = $block['data']['flyin_effect'] ?? false;
    $switchGroups = $block['data']['switch_animation'] ?? false;
    $switchDuration = $block['data']['switch_duration'] ?? 5;
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'gestapelde-afbeeldingen' }}@endif"
         class="block-gestapelde-afbeeldingen block-{{ $randomNumber }} gestapelde-afbeeldingen-{{ $randomNumber }} gestapelde-afbeeldingen-{{ $randomNumber }}-custom-padding gestapelde-afbeeldingen-{{ $randomNumber }}-custom-margin relative bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($backgroundOverlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $backgroundOverlayColor }} opacity-{{ $backgroundOverlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} {{ $textClass }} mx-auto">
            @if ($subTitle)
                <span class="subtitle block mb-2 text-{{ $subTitleColor }} {{ $textClass }} @if ($blockWidth == 'fullscreen') container mx-auto px-8 @endif">
                    @if ($subtitleIcon)
                        <i class="subtitle-icon text-{{ $subtitleIconColor }} fa-{{ $subtitleIcon['style'] }} fa-{{ $subtitleIcon['id'] }} mr-1"></i>
                    @endif
                    {!! $subTitle !!}
                </span>
            @endif
            @if ($title)
                <h2 class="title mb-4 text-{{ $titleColor }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', [
                    'content' => apply_filters('the_content', $text),
                    'class' => 'container mx-auto mb-8 text-' . $textColor . ($blockWidth == 'fullscreen' ? ' px-8' : '')
                ])
            @endif

            <div class="images-wrapper relative mx-auto w-full">
                @foreach($imageGroups as $groupIndex => $images)
                    <div class="image-group absolute inset-0 transition-opacity duration-700 {{ $loop->first ? 'opacity-100 z-20' : 'opacity-0 z-10' }}"
                         data-group="{{ $loop->index }}">
                        @foreach($images as $index => $image)
                            @php $pos = $imageIds[$image['id']] ?? null; @endphp
                            @if($pos)
                                <div class="absolute z-30 shadow-lg image-item @if($flyinEffect) image-hidden @endif"
                                     style="
                                 top: {{ $pos['top'] }};
                                 bottom: {{ $pos['bottom'] }};
                                 left: {{ $pos['left'] }};
                                 right: {{ $pos['right'] }};
                                ">
                                    @include('components.image', [
                                        'image_id'  => $image['id'],
                                        'size'      => 'full',
                                        'object_fit'=> $imageStyle ?? 'cover',
                                        'img_class' => 'w-full h-full object-cover rounded-' . ($borderRadius ?? 'md'),
                                        'alt'       => $image['alt']
                                    ])
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<style>
    @media only screen and (min-width: 0px) {
        .images-wrapper {
            height: {{ $mobileImagesWrapperHeight }}px;
        }
    }
    @media only screen and (min-width: 768px) {
        .images-wrapper {
            height: {{ $tabletImagesWrapperHeight }}px;
        }
    }
    @media only screen and (min-width: 1024px) {
        .images-wrapper {
            height: {{ $desktopImagesWrapperHeight }}px;
        }
    }
    @media only screen and (min-width: 1536px) {
        .images-wrapper {
            height: {{ $desktopXlImagesWrapperHeight }}px;
        }
    }

    .gestapelde-afbeeldingen-{{ $randomNumber }}-custom-padding {
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

    .gestapelde-afbeeldingen-{{ $randomNumber }}-custom-margin {
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

    .image-hidden {
        opacity: 0;
    }

    .image-animated {
        animation: flyIn 0.6s ease-out forwards;
    }

    .image-group {
        transition: opacity 0.7s ease;
    }
</style>


@if ($flyinEffect || $switchGroups)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const wrapper = document.querySelector('.images-wrapper');
            const groups = wrapper.querySelectorAll('.image-group');
            const switchDelay = {{ $switchDuration }} * 1000;
            let current = 0;
            let intervalId = null;

            function animateGroup(index) {
                const items = groups[index].querySelectorAll('.image-item');
                items.forEach((item, i) => {
                    item.classList.remove('image-animated');
                    void item.offsetWidth;
                    setTimeout(() => item.classList.add('image-animated'), i * 250);
                });
            }

            function showGroup(next) {
                if (!groups[current] || !groups[next]) return;

                groups[current].classList.remove('opacity-100', 'z-20');
                groups[current].classList.add('opacity-0', 'z-10');

                groups[next].classList.remove('opacity-0', 'z-10');
                groups[next].classList.add('opacity-100', 'z-20');

                if ({{ $flyinEffect ? 'true' : 'false' }}) {
                    animateGroup(next);
                }

                current = next;
            }

            function startSwitchLoop() {
                if (!{{ $switchGroups ? 'true' : 'false' }}) return;

                intervalId = setInterval(() => {
                    const next = (current + 1) % groups.length;
                    showGroup(next);
                }, switchDelay);
            }

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {

                        groups.forEach((group, i) => {
                            if (i === 0) {
                                group.classList.remove('opacity-0', 'z-10');
                                group.classList.add('opacity-100', 'z-20');

                                if ({{ $flyinEffect ? 'true' : 'false' }}) {
                                    animateGroup(0);
                                }
                            } else {
                                group.classList.remove('opacity-100', 'z-20');
                                group.classList.add('opacity-0', 'z-10');
                            }
                        });

                        startSwitchLoop();

                        observer.unobserve(wrapper);
                    }
                });
            }, {rootMargin: '0px 0px -30px 0px', threshold: 0.1});

            observer.observe(wrapper);
        });
    </script>
@endif