@php
    // Content
    $title = $block['data']['title'];
    $subTitle  = $block['data']['subtitle'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';

        $titlePosition = $block['data']['title_position'] ?? '';
        $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
        $titleClass = $titleClassMap[$titlePosition] ?? '';

    $imageID = $block['data']['image'] ?? '';
    $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);

        // Buttons
        $button2Text = $block['data']['button_2_button_2']['title'] ?? '';
        $button2Link = $block['data']['button_2_button_2']['url'] ?? '';
        $button2Target = $block['data']['button_2_button_2']['target'] ?? '_self';
        $button2Color = $block['data']['button_2_button_2_color'] ?? '';
        $button2Style = $block['data']['button_2_button_2_style'] ?? '';

        $button1Text = $block['data']['button_button_1']['title'] ?? '';
        $button1Link = $block['data']['button_button_1']['url'] ?? '';
        $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
        $button1Color = $block['data']['button_button_1_color'] ?? '';
        $button1Style = $block['data']['button_button_1_style'] ?? '';


    // Show steps
    $workflowVariant = $block['data']['layout_steps'] ?? '';

    $steps = $block['data']['steps'];
    $showStepNumber = $block['data']['show_step_number'];
    $stepTitleColor = $block['data']['step_title_color'] ?? '';
    $stepTextColor = $block['data']['step_text_color'] ?? '';


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

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
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
@endphp

<section id="werkwijze" class="block-werkwijze relative werkwijze-{{ $randomNumber }}-custom-padding werkwijze-{{ $randomNumber }}-custom-margin bg-{{ $backgroundColor }} {{ $customBlockClasses }} {{ $hideBlock ? 'hidden' : '' }}"
         style="background-image: url('{{ wp_get_attachment_image_url($backgroundImageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($backgroundImageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto layout">

            <div class="content-data mb-4">
                @if ($subTitle)
                    <span class="subtitle block mb-2 text-{{ $titleColor }} {{ $titleClass }}">{!! $subTitle !!}</span>
                @endif
                @if ($title)
                    <h2 class="title mb-4 text-{{ $titleColor }} {{ $titleClass }}">{!! $title !!}</h2>
                @endif
                @if (($button2Text) && ($button2Link))
                    <div class="w-full flex flex-wrap gap-4 mt-4 md:mt-8">
                        @include('components.buttons.default', [
                           'text' => $button2Text,
                           'href' => $button2Link,
                           'alt' => $button2Text,
                           'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                           'class' => 'rounded-lg text-left',
                           'target' => $button2Target,
                       ])
                    </div>
                @endif
            </div>

            <div class="steps-content flex flex-col lg:flex-row gap-x-8">
                @if ($imageID)
                    <div class="workflow-image w-full lg:w-1/2">
                        @include('components.image', [
                            'image_id' => $imageID,
                            'size' => 'full',
                            'object_fit' => 'contain',
                            'img_class' => 'object-contain',
                            'alt' => $imageAlt,
                        ])
                    </div>
                @endif


{{--            Todo: List component en slider van kunnen maken --}}

                <div class="custom-layout @if($imageID) w-full lg:w-1/2 @else w-full @endif">
                    @if ($workflowVariant == 'horizontal')
                        @include('components.workflow.workflow-horizontal')
                    @elseif ($workflowVariant == 'vertical')
                        @include('components.workflow.workflow-vertical')
                    @endif

                    @if (($button1Text) && ($button1Link))
                        <div class="w-full flex flex-wrap gap-4 mt-4 md:mt-8 pl-6 sm:pl-12 md:pl-14">
                            @include('components.buttons.default', [
                               'text' => $button1Text,
                               'href' => $button1Link,
                               'alt' => $button1Text,
                               'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                               'class' => 'rounded-lg text-left',
                               'target' => $button1Target,
                           ])
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
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
</style>

