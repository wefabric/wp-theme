@php
    // Content
    $title = $block['data']['title'];
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // Buttons
    $button1Text = $block['data']['button_button_1']['title'] ?? '';
    $button1Link = $block['data']['button_button_1']['url'] ?? '';
    $button1Target = $block['data']['button_button_1']['target'] ?? '_self';
    $button1Color = $block['data']['button_button_1_color'] ?? '';
    $button1Style = $block['data']['button_button_1_style'] ?? '';

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
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
@endphp

<section id="usps" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto relative">
            @if ($title)
                <h2 class="container mx-auto lg:mb-8 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }} text-{{ $titleColor }}">{!! $title !!}</h2>
            @endif
            @include('components.usps.list', ['usps' => $usps])
            @if (($button1Text) && ($button1Link))
                <div class="w-full text-center mt-4 md:mt-8">
                    @include('components.buttons.default', [
                       'text' => $button1Text,
                       'href' => $button1Link,
                       'alt' => $button1Text,
                       'colors' => 'btn-' . $button1Color . ' btn-' . $button1Style,
                       'class' => 'rounded-lg',
                       'target' => $button1Target,
                   ])
                </div>
            @endif
        </div>
    </div>
</section>