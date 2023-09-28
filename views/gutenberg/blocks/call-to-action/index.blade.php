@php
    // Content
    $title = $block['data']['title'] ?? '';
    $text = $block['data']['text'] ?? '';

    $textColor = $block['data']['text_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';

    $buttonText = $block['data']['button_text'] ?? '';
    $buttonLink = ($block['data']['button_link']['url']) ?? '';

    // Blokinstellingen
    $backgroundColor = $block['data']['background_color'] ?? 'default-color';

    $backgroundImageUrl = '';
    if (isset($block['data']['background_image'])) {
        $backgroundImageUrl = wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '';
    }
@endphp

<section id="call-to-action">
    <div class="container mx-auto px-8 py-8 lg:py-20">
        <div class="py-16 px-8 bg-{{ $backgroundColor}}"
             style="background-image: url('{{ wp_get_attachment_image_src($block['data']['background_image'])[0] ?? '' }}'); background-repeat: no-repeat; background-size: cover;">
            <div class="flex flex-col md:flex-row md:items-center w-full xl:w-2/3 mx-auto gap-y-4 md:gap-y-0">
                <div class="w-full md:w-2/3 text-center md:text-left">
                    <h2 class="text-{{$textColor}}">{{ $title }}</h2>
                    @if (!empty($text))
                        <p class="mt-4 md:mt-8 text-{{$textColor}}">{{ $text }}</p>
                    @endif
                </div>
                @if (!empty($buttonText) && !empty($buttonLink))
                    <div class="w-full md:w-1/3 md:justify-center text-center">
                        <a href="{{ $buttonLink }}" class="btn button-secondary bg-secondary-color hover:bg-secondary-dark text-base">{{ $buttonText }}</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>