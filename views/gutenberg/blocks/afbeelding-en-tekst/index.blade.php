@php
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textPosition = $block['data']['text_position'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $backgroundImageUrl = '';
    if (isset($block['data']['background_image'])) {
        $backgroundImageUrl = wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '';
    }

    $buttonOneText = $block['data']['button_one_text'] ?? '';
    $buttonOneLink = $block['data']['button_one_link'] ?? '';

    $buttonTwoText = $block['data']['button_two_text'] ?? '';
    $buttonTwoLink = $block['data']['button_two_link'] ?? '';

    $textOrder = ($textPosition === 'left') ? 'lg:order-1' : 'lg:order-2';
    $imageOrder = ($textPosition === 'left') ? 'lg:order-2' : 'lg:order-1';

    $imageSize = $block['data']['image_size'] ?? '';
    $imageClass = '';
    $textClass = '';

    if ($imageSize === '33') {
        $imageClass = 'lg:w-1/3';
        $textClass = 'lg:w-2/3';
    } elseif ($imageSize === '50') {
        $imageClass = 'lg:w-1/2';
        $textClass = 'lg:w-1/2';
    } elseif ($imageSize === '66') {
        $imageClass = 'lg:w-2/3';
        $textClass = 'lg:w-1/3';
    }

    $imageHeightClass = $block['data']['full_height'] ? 'h-full' : '';


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


<section id="afbeelding-tekst-block" class="bg-{{ $backgroundColor}} py-16 lg:py-0"
         style="background-image: url('{{ $backgroundImageUrl }}'); background-repeat: no-repeat; background-size: cover;">
    <div class="{{ $fullScreenClass }} px-8 py-8 lg:py-20">
        <div class="{{ $blockClass }} mx-auto">
            <div class="flex flex-col lg:flex-row gap-8">
                <div class="{{ $textClass }} order-2 {{ $textOrder }} text-{{ $textColor }}">
                    <h2 class="mb-4">{{ $title }}</h2>
                    <p>{{ $text }}</p>
                    @if (!empty($buttonOneText) && !empty($buttonOneLink))
                        <a href="{{ $buttonOneLink }}" class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $buttonOneText }}</a>
                    @endif
                    @if (!empty($buttonTwoText) && !empty($buttonTwoLink))
                        <a href="{{ $buttonTwoLink }}" class="ml-4 text-black font-medium hover:text-primary underline mt-4 text-base">{{ $buttonTwoText }}</a>
                    @endif
                </div>
                <div class="{{ $imageClass }} order-1 {{ $imageOrder }}">
                    {!! wp_get_attachment_image($block['data']['image'], 'full', false, ['class' => 'w-full  object-cover ' . $imageHeightClass ]) !!}
                </div>
            </div>
        </div>
    </div>
</section>