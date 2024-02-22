@php
    // Content
   $title = $block['data']['title'] ?? '';
   $titleColor = $block['data']['title_color'] ?? '';
   $text = $block['data']['text'] ?? '';
   $textColor = $block['data']['text_color'] ?? '';

   $textPosition = $block['data']['text_position'] ?? '';
   $textClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
   $textClass = $textClassMap[$textPosition] ?? 'text-center';
   $flexClassMap = ['left' => 'items-start', 'center' => 'items-center', 'right' => 'items-end',];
   $flexClass = $flexClassMap[$textPosition] ?? 'items-center';
   $ctaLayout = $block['data']['cta_layout'] ?? '';
   $flexDirection = ($ctaLayout === 'vertical') ? 'flex-col' : (($ctaLayout === 'horizontal') ? 'flex-row' : '');


   $ctaForm = $block['data']['form'] ?? '';
   $sideImage = $block['data']['side_image'] ?? '';
   $topImage = $block['data']['top_image'] ?? '';
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

<section id="cta-whitepaper" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="cta-custom {{ $fullScreenClass }} @if($topImage && !$sideImage) pt-24 lg:pt-28 @elseif(!$topImage && $sideImage) pt-32 @else pt-8 lg:pt-16 xl:pt-20 @endif">

        <div class="custom-width background-container absolute top-0 right-0 h-full @if ($topImage) pt-24 lg:pt-28 @else pt-8 lg:pt-16 xl:pt-20 @endif">
            <div class="bg-{{ $blockBackgroundColor }} w-full h-full"></div>
        </div>

        @if ($topImage)
            <div class="top-image overlay absolute z-30 left-1/2 -translate-x-1/2 -translate-y-1/2">
                @include('components.image', [
                    'image_id' => $topImage,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'w-[200px] aspect-square object-cover rounded-full',
                    'alt' => get_post_meta($topImage, '_wp_attachment_image_alt', true) ?: 'Top image',
                ])
            </div>
        @endif

        <div class="cta-block relative z-10 mx-auto {{ $blockClass }} @if($blockWidth !== 'fullscreen') md:px-8 @endif">
            <div class="px-8 py-16 bg-{{ $blockBackgroundColor }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif"
                 style="background-image: url('{{ wp_get_attachment_image_url($blockBackgroundImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($blockBackgroundImage) }}">
                @if ($blockOverlayEnabled)
                    <div class="absolute inset-0 @if($blockWidth !== 'fullscreen') md:mx-8 @endif bg-{{ $blockOverlayColor }} opacity-{{ $blockOverlayOpacity }}"></div>
                @endif

                <div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full @endif relative z-10">
                    <div class="flex flex-col lg:{{ $flexDirection }} {{ $flexClass }} justify-center sm:px-8 lg:px-16 gap-y-4 gap-x-8 @if($topImage) mt-16 md:mt-20 @endif ">

                        <div class="flex flex-col gap-x-16 gap-y-4 @if ($ctaLayout == 'horizontal') order-2 lg:order-1 @else order-2 @endif @if($sideImage) w-full lg:w-4/5 text-center lg:{{$textClass}} @else w-full lg:w-full {{ $textClass }} @endif">
                            @if ($title)
                                <h2 class="text-{{ $titleColor }}">{!! $title !!}</h2>
                            @endif
                            @if ($text)
                                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 md:mt-4 text-' . $textColor])
                            @endif
                            @if ($ctaForm)
                                <div class="w-full @if($blockWidth == 'fullscreen') xl:w-1/2 @endif mx-auto mt-10 text-left text-white">
                                    {!! gravity_form($ctaForm, false) ; !!}
                                </div>
                            @endif
                            @if (($button1Text) && ($button1Link))
                                <div class="w-full flex flex-col sm:flex-row gap-x-4 w-fit justify-center lg:justify-start">
                                    @include('components.buttons.default', [
                                       'text' => $button1Text,
                                       'href' => $button1Link,
                                       'alt' => $button1Text,
                                       'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                                       'class' => 'rounded-lg text-left',
                                       'target' => $button1Target,
                                   ])
                                    @if (($button2Text) && ($button2Link))
                                        @include('components.buttons.default', [
                                           'text' => $button2Text,
                                           'href' => $button2Link,
                                           'alt' => $button2Text,
                                           'colors' => 'btn-' . $button2Color . ' btn-' . $button2Style,
                                           'class' => 'rounded-lg text-left',
                                           'target' => $button2Target,
                                       ])
                                    @endif
                                </div>
                            @endif
                        </div>
                        @if ($sideImage)
                            <div class="side-image @if($ctaLayout == 'horizontal') order-1 lg:order-2 @else order-1 @endif w-full lg:w-auto -mt-[150px]">
                                @include('components.image', [
                                   'image_id' => $sideImage,
                                   'size' => 'full',
                                   'object_fit' => 'contain',
                                   'img_class' => 'h-[300px] lg:h-auto w-auto lg:w-[380px]  object-contain  mx-auto',
                                   'alt' => get_post_meta($sideImage, '_wp_attachment_image_alt', true) ?: 'Whitepaper',
                               ])
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>