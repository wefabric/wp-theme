@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    // Show links
    $linksCount = $block['data']['links'] ?? 0;
    $links = [];

    for ($i = 0; $i < $linksCount; $i++) {
        $buttonTextKey = "links_{$i}_button_text";
        $buttonLinkKey = "links_{$i}_button_link";
        $buttonText = $block['data'][$buttonTextKey] ?? '';
        $buttonLink = $block['data'][$buttonLinkKey]['url'] ?? '';

        $links[] = [
            'buttonText' => $buttonText,
            'buttonLink' => $buttonLink,
        ];
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
@endphp

<section id="links" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="mb-4 text-{{ $titleColor }}">{{ $title }}</h2>
            @endif
            @if ($text)
                <p class="text-{{ $textColor }}">{!! $text !!} </p>
            @endif
            @foreach($links as $link)
                @if($link['buttonText'] && $link['buttonLink'])
                    <a href="{{ $link['buttonLink'] }}"
                       class="btn button-primary bg-primary hover:bg-primary-dark mt-4 text-base">{{ $link['buttonText'] }}</a>
                @endif
            @endforeach
        </div>
    </div>
</section>