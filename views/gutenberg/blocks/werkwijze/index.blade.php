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


    // Show steps
    $workflowVariant = $block['data']['layout_steps'] ?? '';
    $showStepNumber = $block['data']['show_step_number'] ?? false;
    $stepTitleColor = $block['data']['step_title_color'] ?? '';
    $stepTextColor = $block['data']['step_text_color'] ?? '';
    $stepIconColor = $block['data']['step_icon_color'] ?? '';
    $swiperOutContainer = $block['data']['slider_outside_container'] ?? false;
    $visibleElements = $block['data']['show_element'] ?? [];

    $specialLayout = $block['data']['special_layout'] ?? false;
    $imageId = $block['data']['image'] ?? '';
    $imageAlt = get_post_meta($imageId, '_wp_attachment_image_alt', true);
    $stepsLocation = $block['data']['steps_location'] ?? 'left';


    $stepCount = $block['data']['steps'];
    $steps = [];

    for ($i = 0; $i < $stepCount; $i++) {
        $stepTitle = $block['data']["steps_{$i}_step_title"];
        $stepText = $block['data']["steps_{$i}_step_text"];
        $stepNumber = $i + 1;
        $stepImage = $block['data']["steps_{$i}_step_image"] ?? '';
        $stepIcon = $block['data']["steps_{$i}_step_icon"] ?? null;
        $stepLink = $block['data']["steps_{$i}_step_link"] ?? '';
        $stepButtonText = $block['data']["steps_{$i}_button_button"]['title'] ?? '';
        $stepButtonLink = $block['data']["steps_{$i}_button_button"]['url'] ?? '';
        $stepButtonTarget = $block['data']["steps_{$i}_button_button"]['target'] ?? '_self';
        $stepButtonColor = $block['data']["steps_{$i}_button_button_color"] ?? '';
        $stepButtonStyle = $block['data']["steps_{$i}_button_button_style"] ?? '';
        $stepButtonIcon = $block['data']["steps_{$i}_button_button_icon"] ?? '';
        if (!empty($stepButtonIcon)) {
            $iconData = json_decode($stepButtonIcon, true);
            if (isset($iconData['id'], $iconData['style'])) {
                $stepButtonIcon = 'fa-' . $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }

        $iconClass = '';
        if ($stepIcon !== null) {
            $iconData = json_decode($stepIcon, true);

            if ($iconData && isset($iconData['style']) && isset($iconData['id'])) {
                $iconClass = $iconData['style'] . ' fa-' . $iconData['id'];
            }
        }

        $steps[] = [
            'stepTitle' => $stepTitle,
            'stepText' => $stepText,
            'stepLink' => $stepLink,
            'stepImage' => $stepImage,
            'stepNumber' => $stepNumber,
            'stepIcon' => $iconData ?? null,
            'iconClass' => $iconClass,
            'stepButtonText' => $stepButtonText,
            'stepButtonLink' => $stepButtonLink,
            'stepButtonTarget' => $stepButtonTarget,
            'stepButtonColor' => $stepButtonColor,
            'stepButtonStyle' => $stepButtonStyle,
            'stepButtonIcon' => $stepButtonIcon,
        ];
    }


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
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
    $flyinEffect = $block['data']['flyin_effect'] ?? false;
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'werkwijze' }}@endif" class="block-werkwijze relative werkwijze-{{ $randomNumber }}-custom-padding werkwijze-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; @if($backgroundImageParallax)	background-attachment: fixed; @endif background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if($swiperOutContainer)
        <div class="overflow-hidden">
    @endif
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">

        <div class="layout relative z-10 {{ $fullScreenClass }} {{ $blockClass }}">
            <div class="content-data mx-auto">
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
                        'class' => 'mb-8 text-' . $textColor . ' ' . $textClass . ($blockWidth == 'fullscreen' ? ' ' : '')
                    ])
                @endif
            </div>

            <div class="steps-content flex flex-col lg:flex-row gap-x-8 gap-y-2 items-stretch">
                @if ($imageId && !$specialLayout)
                    <div class="workflow-image w-full lg:w-1/2 @if ($stepsLocation == 'right') order-1 lg:order-1 @else order-1 lg:order-2 @endif">
                        @include('components.image', [
                            'image_id' => $imageId,
                            'size' => 'full',
                            'object_fit' => 'contain',
                            'img_class' => 'object-contain',
                            'alt' => $imageAlt,
                        ])
                    </div>
                @endif

                @if ($specialLayout)
                    <div class="special-layout w-full lg:w-1/2 @if ($stepsLocation == 'right') order-1 lg:order-1 @else order-1 lg:order-2 @endif">
                        @include('components.workflow.slider-list')
                    </div>
                @endif

                <div class="custom-layout @if($imageId || $specialLayout) w-full lg:w-1/2 @else w-full @endif @if ($stepsLocation == 'right') order-2 lg:order-2 @else order-2 lg:order-1 @endif">
                    @if ($steps && $workflowVariant == 'horizontal')
                        @include('components.workflow.horizontal-list', ['steps' => $steps])
                    @elseif ($steps && $workflowVariant == 'vertical')
                        @include('components.workflow.vertical-list', ['steps' => $steps])
                    @endif
                </div>
            </div>

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
    @if($swiperOutContainer)
        </div>
    @endif
</section>

<style>
    .werkwijze-{{ $randomNumber }}-custom-padding {
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

    .werkwijze-{{ $randomNumber }}-custom-margin {
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

    .step-hidden {
        opacity: 0;
    }

    .swiper-slide-duplicate .step-hidden {
        animation: flyIn 0.6s ease-out forwards !important;
    }

    .step-animated {
        animation: flyIn 0.6s ease-out forwards;
    }
</style>

@if ($flyinEffect)
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const stepItems = document.querySelectorAll('.step-item');
            const observerOptions = {
                root: null,
                rootMargin: '0px 0px -30px 0px',
                threshold: 0.035
            };

            const observerCallback = (entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        const stepItem = entry.target;

                        setTimeout(() => {
                            if (stepItem.classList.contains('step-hidden')) {
                                stepItem.classList.add('step-animated');
                                stepItem.classList.remove('step-hidden');
                            }
                        }, index * 200);

                        observer.unobserve(stepItem);
                    }
                });
            };

            const observer = new IntersectionObserver(observerCallback, observerOptions);
            stepItems.forEach(item => {
                observer.observe(item);
            });
        });
    </script>
@endif