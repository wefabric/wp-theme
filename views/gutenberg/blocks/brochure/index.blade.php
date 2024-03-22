@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $brochureShortcode = $block['data']['shortcode'] ?? '';


//    // Buttons
//    $button1Text = $block['data']['button_button_1']['title'] ?? '';
//    $button1Link = $block['data']['button_button_1']['url'] ?? '';
//    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
//    $button1Color = $block['data']['button_button_1_color'] ?? '';
//    $button1Style = $block['data']['button_button_1_style'] ?? '';
//    $button2Text = $block['data']['button_button_2']['title'] ?? '';
//    $button2Link = $block['data']['button_button_2']['url'] ?? '';
//    $button2Target = $block['data']['button_button_2']['target'] ?? '_self';
//    $button2Color = $block['data']['button_button_2_color'] ?? '';
//    $button2Style = $block['data']['button_button_2_style'] ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
    $textClass = $titleClassMap[$textPosition] ?? '';

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
@endphp

<section id="brochure" class="block-brochure relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} {{ $textClass }} mx-auto">
            @if ($title)
                <h2 class="mb-4 text-{{ $titleColor }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mb-4 text-' . $textColor])
            @endif
            @if($brochureShortcode)
                {!! $brochureShortcode !!}
            @endif
        </div>
    </div>
</section>
