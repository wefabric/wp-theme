@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

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

    $textPosition = $block['data']['text_position'] ?? '';
    $textAlignment = ($textPosition === 'left') ? 'left' : 'right';
    $textOrder = ($textPosition === 'left') ? 'lg:order-1' : 'lg:order-2';
    $titleOrder = ($textPosition === 'left') ? 'lg:order-2' : 'lg:order-1';

    // Blokinstellingen
    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';
@endphp

<section id="titel-tekst" class="relative bg-{{ $backgroundColor }} py-16 lg:py-0"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="custom-margin relative z-10 container mx-auto px-8 lg:py-20">
        <div class="w-full xl:w-2/3 mx-auto flex flex-col lg:flex-row gap-x-8">
            <div class="w-full xl:w-3/5 order-2 {{ $textOrder }}">
                @if ($text)
                    <div class="text-{{ $textColor }}">{!! $text !!}</div>
                @endif
                @if (($button1Text) && ($button1Link))
                    <div class="flex gap-4 mt-4 md:mt-8">
                        @include('components.buttons.default', [
                           'text' => $button1Text,
                           'href' => $button1Link,
                           'alt' => $button1Text,
                           'colors' => 'btn btn-' . $button1Color . ' btn-' . $button1Style . '',
                           'class' => 'rounded-lg',
                           'target' => $button1Target,
                       ])
                        @if (($button2Text) && ($button2Link))
                            @include('components.buttons.default', [
                               'text' => $button2Text,
                               'href' => $button2Link,
                               'alt' => $button2Text,
                               'colors' => 'btn btn-' . $button2Color . ' btn-' . $button2Style . '',
                               'class' => 'rounded-lg',
                               'target' => $button2Target,
                           ])
                        @endif
                    </div>
                @endif
            </div>
            <div class="w-full xl:w-2/5 order-1 {{ $titleOrder }}">
                @if ($title)
                    <h2 class="mb-4 text-{{ $titleColor }} lg:text-{{ $textAlignment }}">{{ $title }}</h2>
                @endif
            </div>
        </div>
    </div>
</section>
