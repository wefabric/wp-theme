@php
    // Content
   $title = $block['data']['title'] ?? '';
   $titleColor = $block['data']['title_color'] ?? '';
   $text = $block['data']['text'] ?? '';
   $textColor = $block['data']['text_color'] ?? '';
//    $textPosition = $block['data']['text_position'] ?? '';
//    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
//    $textClass = $titleClassMap[$textPosition] ?? '';

   $ctaForm = ($block['data']['form']) ?? '';
   $sideImage = ($block['data']['side_image']) ?? '';
   $topImage = ($block['data']['top_image']) ?? '';
   $blockBackgroundColor = $block['data']['block_background_color'] ?? '';
   $blockBackgroundImage = ($block['data']['block_background_image']) ?? '';
   $blockOverlayEnabled = ($block['data']['block_overlay_image']) ?? false;
   $blockOverlayColor = ($block['data']['block_overlay_color']) ?? '';
   $blockOverlayOpacity = ($block['data']['block_overlay_opacity']) ?? '';

   // Buttons
   $button1Text = $block['data']['button_button_1']['title'] ?? '';
   $button1Link = ($block['data']['button_button_1']['url']) ?? '';
   $button1Target = ($block['data']['button_button_1']['target']) ?? '_self';
   $button1Color = $block['data']['button_button_1_color'] ?? '';
   $button1Style = $block['data']['button_button_1_style'] ?? '';
   $button2Text = $block['data']['button_button_2']['title'] ?? '';
   $button2Link = ($block['data']['button_button_2']['url']) ?? '';
   $button2Target = ($block['data']['button_button_2']['target']) ?? '_self';
   $button2Color = $block['data']['button_button_2_color'] ?? '';
   $button2Style = $block['data']['button_button_2_style'] ?? '';

   // Blokinstellingen
   $blockWidth = $block['data']['block_width'] ?? 100;
   $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
   $blockClass = $blockClassMap[$blockWidth] ?? '';
   $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

   $backgroundColor = $block['data']['background_color'] ?? 'default-color';
   $imageId = ($block['data']['background_image']) ?? '';
   $overlayEnabled = ($block['data']['overlay_image']) ?? false;
   $overlayColor = ($block['data']['overlay_color']) ?? '';
   $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';

   // Theme settings
   $options = get_fields('option');
   $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="cta-whitepaper" class="relative bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="cta-custom {{ $fullScreenClass }} @if ($topImage) pt-36 lg:pt-52 @else pt-8 lg:pt-16 xl:pt-20 @endif">

        <div class="custom-width background-container absolute top-0 right-0 h-full pt-8 lg:pt-16 xl:pt-20">
            <div class="bg-{{ $blockBackgroundColor }} w-full h-full"></div>
        </div>

        @if ($topImage)
            <div class="overlay absolute z-30 left-1/2 -translate-x-1/2 -translate-y-1/2">
                @include('components.image', [
                    'image_id' => $topImage,
                    'size' => 'full',
                    'object_fit' => 'cover',
                    'img_class' => 'w-[200px] h-[200px] aspect-square object-cover rounded-full',
                    'alt' => get_post_meta($topImage, '_wp_attachment_image_alt', true) ?: 'Top image',
                ])
            </div>
        @endif

        <div class="cta-block mx-auto relative {{ $blockClass }} @if($blockWidth !== 'fullscreen') md:px-8 @endif">
            <div class="px-8 py-16 bg-{{ $blockBackgroundColor }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif"
                 style="background-image: url('{{ wp_get_attachment_image_url($blockBackgroundImage, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($blockBackgroundImage) }}">
                @if ($blockOverlayEnabled)
                    <div class="absolute inset-0 @if($blockWidth !== 'fullscreen') md:mx-8 @endif bg-{{ $blockOverlayColor }} opacity-{{ $blockOverlayOpacity }}"></div>
                @endif

                <div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
                    <div class="flex flex-col md:flex-row md:items-center gap-y-4 md:gap-y-0 @if($topImage) mt-16 md:mt-20 @endif">
                        <div class="w-full text-center @if($sideImage) md:w-2/3 @else md:w-full @endif">
                            @if ($title)
                                <h2 class="text-{{ $titleColor }}">{!! $title !!}</h2>
                            @endif
                            @if ($text)
                                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 md:mt-4 text-' . $textColor])
                            @endif
                        </div>
                        @if ($sideImage)
                            <div class="w-full md:w-1/3 md:justify-center text-center md:mt-[-100px]">
                                @include('components.image', [
                                   'image_id' => $sideImage,
                                   'size' => 'full',
                                   'object_fit' => 'cover',
                                   'img_class' => 'w-full object-cover',
                                   'alt' => get_post_meta($sideImage, '_wp_attachment_image_alt', true) ?: 'Whitepaper',
                               ])
                            </div>
                        @endif
                    </div>
                    @if ($ctaForm)
                        <div class="w-full mt-10 text-left text-white">
                            {!! gravity_form($ctaForm, false) ; !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>