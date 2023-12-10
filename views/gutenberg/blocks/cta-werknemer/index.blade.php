@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';
//    $textPosition = $block['data']['text_position'] ?? '';
//    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
//    $textClass = $titleClassMap[$textPosition] ?? '';

    $ctaForm = $block['data']['form'] ?? '';
    $blockBackgroundColor = $block['data']['block_background_color'] ?? '';
    $blockBackgroundImage = $block['data']['block_background_image'] ?? '';
    $blockOverlayEnabled = $block['data']['block_overlay_image'] ?? false;
    $blockOverlayColor = $block['data']['block_overlay_color'] ?? '';
    $blockOverlayOpacity = $block['data']['block_overlay_opacity'] ?? '';

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = $block['data']['button_button_1']['url'] ?? '';
    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';
    $button2Text = $block['data']['button_button_2']['title'] ?? '';
    $button2Link = $block['data']['button_button_2']['url'] ?? '';
    $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
    $button2Color = $block['data']['button_button_2_color'] ?? '';
    $button2Style = $block['data']['button_button_2_style'] ?? '';

    // Employee
    $ctaEmployee = $block['data']['employee'] ?? '';
    $employeeImageId = $ctaEmployee ? get_field('image', $ctaEmployee) : '';
    $employeeImage = $employeeImageId ? wp_get_attachment_image_url($employeeImageId, 'full') : '';
    $employeeTitle = $ctaEmployee ? get_the_title($ctaEmployee) : '';

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="cta-werknemer" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif

    <div class="cta-custom {{ $fullScreenClass }} @if ($employeeImage) pt-24 lg:pt-28 @else pt-8 lg:pt-16 xl:pt-20 @endif">
        {{--Voor het uitlijnen naar rechts--}}
        <div class="custom-width background-container absolute top-0 right-0 h-full @if ($employeeImage) pt-24 lg:pt-28 @else pt-8 lg:pt-16 xl:pt-20 @endif">
            <div class="bg-{{ $blockBackgroundColor }} w-full h-full"></div>
        </div>

        @if ($employeeImage)
            <div class="overlay absolute z-30 left-1/2 -translate-x-1/2 -translate-y-1/2">
                @include('components.image', [
                 'image_id' => $employeeImageId,
                 'size' => 'full',
                 'object_fit' => 'cover',
                 'img_class' => 'w-[200px] lg:w-[300px] lg:h-[300px] aspect-square object-cover rounded-full',
                 'alt' => $employeeTitle,
             ])
            </div>
        @endif
        <div class="cta-block relative z-10 mx-auto {{ $blockClass }} relative @if($blockWidth !== 'fullscreen') md:px-8 @endif">
            <div class="px-8 py-16 bg-{{ $blockBackgroundColor }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif"
                 style="background-image: url('{{ wp_get_attachment_image_url($blockBackgroundImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($blockBackgroundImage) }}">
                @if ($blockOverlayEnabled)
                    <div class="absolute inset-0 @if($blockWidth !== 'fullscreen') md:mx-8 @endif bg-{{ $blockOverlayColor }} opacity-{{ $blockOverlayOpacity }}"></div>
                @endif

                <div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
                    <div class="w-full text-center mx-auto @if($employeeImage) mt-16 md:mt-32 @endif">
                        @if ($title)
                            <h2 class="text-{{ $titleColor }}">{!! $title !!}</h2>
                        @endif
                        @if ($text)
                            @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 md:mt-4 text-' . $textColor])
                        @endif
                        @if (($button1Text) && ($button1Link))
                            <div class="flex gap-4 w-full justify-center mt-4 md:mt-8">
                                @include('components.buttons.default', [
                                   'text' => $button1Text,
                                   'href' => $button1Link,
                                   'alt' => $button1Text,
                                   'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                                   'class' => 'rounded-lg',
                                   'target' => $button1Target,
                               ])
                                @if (($button2Text) && ($button2Link))
                                    @include('components.buttons.default', [
                                       'text' => $button2Text,
                                       'href' => $button2Link,
                                       'alt' => $button2Text,
                                       'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                                       'class' => 'rounded-lg',
                                       'target' => $button2Target,
                                   ])
                                @endif
                            </div>
                        @endif
                        @if ($ctaForm)
                            <div class="w-full mt-10 text-left text-white">
                                {!! gravity_form($ctaForm, false) ; !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>