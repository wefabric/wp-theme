@php
    $title = $block['data']['title'];
    $uspsCount = $block['data']['usps'];

    $textPosition = $block['data']['title_position'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';

    $backgroundColor = $block['data']['background_color'];

    if ($textPosition === 'left') {
        $textClass = 'text-left';
    } elseif ($textPosition === 'center') {
        $textClass = 'mx-auto text-center';
    } elseif ($textPosition === 'right') {
        $textClass = 'text-right';
    } else {
        $textClass = '';
    }

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

    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClass = '';
    if ($blockWidth == 50) {
        $blockClass = 'w-full lg:w-1/2';
    }
    elseif ($blockWidth == 66) {
        $blockClass = 'w-full lg:w-2/3';
    }
    elseif ($blockWidth == 100) {
        $blockClass = ' w-full';
    }
    elseif ($blockWidth == 'fullscreen') {
        $blockClass = 'w-full';
    }

    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';
@endphp

<section id="USP-block" class="relative bg-{{ $backgroundColor }}">
    <div class="{{ $fullScreenClass }} px-8 py-8 lg:py-20">
        <div class="{{ $blockClass }} mx-auto">
            @if (!empty($title))
                <h2 class="container mx-auto mb-8 lg:mb-20 {{ $textClass }}">{{ $title }}</h2>
            @endif
            @include('components.usps.list', ['usps' => $usps])
        </div>
    </div>
</section>