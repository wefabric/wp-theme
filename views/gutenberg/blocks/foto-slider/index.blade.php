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

    $imageID = $block['data'][$imageKey] ?? '';
    $caption = $block['data'][$captionKey] ?? '';

        if ($imageID) {
            $imageInfo = wp_get_attachment_image_src($imageID, 'full');
            if ($imageInfo) {
                $alt = get_post_meta($imageID, '_wp_attachment_image_alt', true);
                $alt = $alt ? $alt : "image_$i";

                $imagesData[] = [
                    'id' => $imageID, // Add the image ID to the array
                    'url' => $imageInfo[0],
                    'caption' => $caption,
                    'alt' => $alt,
                ];
            }
        }
    }

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

<section id="foto-slider" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="lg:mb-4 text-{{ $titleColor }} container mx-auto @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{{ $title }}</h2>
            @endif
            @include('components.photo-slider.list')
        </div>
    </div>
</section>