@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

    // Show images
    $imagesData = [];
    $numImages = intval($block['data']['images']);

    for ($i = 0; $i < $numImages; $i++) {
    $imageKey = "images_{$i}_image";
    $captionKey = "images_{$i}_caption";
    $linkKey = "images_{$i}_link";

    $imageID = $block['data'][$imageKey] ?? '';
    $caption = $block['data'][$captionKey] ?? '';
    $imageLink = $block['data'][$linkKey] ?? '';

        if ($imageID) {
            $imageInfo = wp_get_attachment_image_src($imageID, 'full');
            if ($imageInfo) {
                $alt = get_post_meta($imageID, '_wp_attachment_image_alt', true);
                $alt = $alt ? $alt : "image_$i";

                $linkTitle = $imageLink['title'] ?? '';
                $linkUrl = $imageLink['url'] ?? '';
                $linkTarget = $imageLink['target'] ?? '';

                $imagesData[] = [
                    'id' => $imageID,
                    'url' => $imageInfo[0],
                    'caption' => $caption,
                    'alt' => $alt,
                    'link' => [
                        'title' => $linkTitle,
                        'url' => $linkUrl,
                        'target' => $linkTarget
                    ]
                ];
            }
        }
    }

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';

//    todo: dit kan weg
//    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    if ($blockWidth !== 'fullscreen') {
        $customContainer = $block['data']['custom_container'] ?? 'full-container';
        $containerClassMap = ['full-container' => 'container mx-auto', 'left-container' => 'left-container', 'right-container' => 'right-container'];
        $containerClass = $containerClassMap[$customContainer] ?? '';
    }
    else {
        $containerClass = '';
    }

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="foto-slider" class="block-foto-slider relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-styling relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $containerClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="lg:mb-4 text-{{ $titleColor }}  @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{!! $title !!}</h2>
            @endif
            @include('components.photo-slider.list')
        </div>
    </div>
</section>