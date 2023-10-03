@php
    // Content
    $imageID = $block['data']['image'];
    $imageAlt = get_post_meta($imageID, '_wp_attachment_image_alt', true);
    $imagePosition = $block['data']['image_position'] ?? '';
    $fullScreen = $block['data']['full_screen_image'] ?? false;
    $imageSize = $block['data']['image_size'] ?? '';

    $positionClass = '';
    if ($imagePosition === 'left') {
        $positionClass = 'mr-auto';
    } elseif ($imagePosition === 'right') {
        $positionClass = 'ml-auto';
    } elseif ($imagePosition === 'center') {
        $positionClass = 'mx-auto';
    }

    $imageClass = '';
    if ($imageSize === '33') {
        $imageClass = 'lg:w-1/3';
    } elseif ($imageSize === '50') {
        $imageClass = 'lg:w-1/2';
    } elseif ($imageSize === '66') {
        $imageClass = 'lg:w-2/3';
    } elseif ($imageSize === '100') {
        $imageClass = '';
    }

    // Blokinstellingen
    $backgroundColor = $block['data']['background_color'] ?? 'none';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strenght']??'': 'rounded-none';
@endphp

<section id="afbeelding-block" class="relative bg-{{ $backgroundColor}}">
    <div class="{{ $fullScreen ? 'w-full' : 'container mx-auto px-8 lg:py-20' }}">
        @if($block['data']['image'])
            {!! wp_get_attachment_image($imageID, 'full', false, [
                'class' => $imageClass . ' ' . $positionClass . ' w-full object-cover rounded-' . $borderRadius,
                'alt' => $imageAlt
            ]) !!}
        @endif
    </div>
</section>