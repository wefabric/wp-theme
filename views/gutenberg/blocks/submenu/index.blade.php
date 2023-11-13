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

        $linkKey = "links_{$i}_link";
        $linkUrl = $block['data'][$linkKey]['url'] ?? '';
        $linkText = $block['data'][$linkKey]['title'] ?? '';
        $linkTarget = $block['data'][$linkKey]['target'] ?? '';

        $links[] = [
            'text' => $linkText,
            'link' => $linkUrl,
            'target' => $linkTarget,
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

<section id="submenu" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="mb-4 text-{{ $titleColor }}">{{ $title }}</h2>
            @endif
            @if ($text)
                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mb-4 text-' . $textColor])
            @endif
            <div class="flex flex-wrap gap-1 text-{{ $textColor }}">
                @foreach($links as $index => $link)
                    @if($link['text'] && $link['link'])
                        <a href="{{ $link['link'] }}" class="underline hover:text-primary" target="{{ $link['target'] }}">{{ $link['text'] }}</a>
                        @if($index < count($links) - 1)
                            <span class="separator">|</span>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</section>