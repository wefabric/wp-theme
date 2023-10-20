@php
    // Content
    $title = $block['data']['title'];
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // Show usps
    $uspsCount = $block['data']['usps'];
    $usps = [];

    for ($i = 0; $i < $uspsCount; $i++) {
        $uspTitle = $block['data']["usps_{$i}_usp_title"];
        $uspText = $block['data']["usps_{$i}_usp_text"];

        $uspImage = isset($block['data']["usps_{$i}_image"]) ? $block['data']["usps_{$i}_image"] : null;

        $uspIcon = isset($block['data']["usps_{$i}_icon"]) ? $block['data']["usps_{$i}_icon"] : null;
        $uspIconColor = isset($block['data']["usps_{$i}_icon_color"]) ? str_replace('-color', '', $block['data']["usps_{$i}_icon_color"]) : '';

        $iconClass = '';
        if ($uspIcon !== null) {
            $iconData = json_decode($uspIcon);
            $iconClass = $iconData->style . ' fa-' . $iconData->id;
        }

        $usps[] = [
            'uspTitle' => $uspTitle,
            'uspText' => $uspText,
            'uspImage' => $uspImage,
            'uspIcon' => $iconClass,
            'uspIconColor' => $uspIconColor,
        ];
    }

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';
@endphp

<section id="usps" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="container mx-auto mb-8 lg:mb-20 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }} text-{{ $titleColor }}">{{ $title }}</h2>
            @endif
            @include('components.usps.list', ['usps' => $usps])
        </div>
    </div>
</section>