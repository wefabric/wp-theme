@php
    // Content
   $title = $block['data']['title'] ?? '';
   $titleColor = $block['data']['title_color'] ?? '';
   $text = $block['data']['text'] ?? '';
   $textColor = $block['data']['text_color'] ?? '';
//    $textPosition = $block['data']['text_position'] ?? '';
//    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
//    $textClass = $titleClassMap[$textPosition] ?? '';
   $ctaImage = ($block['data']['image']) ?? '';
   $alt = get_post_meta($ctaImage, '_wp_attachment_image_alt', true) ?: 'whitepaper';
   $blockBackgroundColor = $block['data']['block_background_color'] ?? '';

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

   // Form field
   $ctaForm = ($block['data']['form']) ?? '';

   // Blokinstellingen
   $blockWidth = $block['data']['block_width'] ?? 100;
   $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
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
    <div class="cta-custom {{ $fullScreenClass }} pt-8 lg:pt-16 xl:pt-20">

        <div class="custom-width background-container absolute top-0 right-0 h-full pt-8 lg:pt-16 xl:pt-20">
            <div class="bg-{{ $blockBackgroundColor }} w-full h-full"></div>
        </div>

        <div class="cta-block mx-auto {{ $blockClass }} relative py-16 px-8 bg-{{ $blockBackgroundColor }} @if($blockWidth !== 'fullscreen') md:rounded-{{ $borderRadius }} @endif">
            @if ($overlayEnabled)
                <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
            @endif

            <div class="container mx-auto @if($blockWidth == 'fullscreen') md:px-8 @else w-full xl:w-2/3 @endif relative z-10 ">
                <div class="flex flex-col md:flex-row md:items-center gap-y-4 md:gap-y-0">
                    <div class="w-full @if($ctaImage) md:w-2/3 @else md:w-full @endif text-center">
                        @if ($title)
                            <h2 class="text-{{ $titleColor }}">{!! $title !!}</h2>
                        @endif
                        @if ($text)
                            @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mt-4 md:mt-4 text-' . $textColor])
                        @endif
                    </div>
                    @if ($ctaImage)
                        <div class="w-full md:w-1/3 md:justify-center text-center md:mt-[-100px]">
                            @include('components.image', [
                               'image_id' => $ctaImage,
                               'size' => 'full',
                               'object_fit' => 'cover',
                               'img_class' => 'w-full object-cover',
                               'alt' => $alt,
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
</section>