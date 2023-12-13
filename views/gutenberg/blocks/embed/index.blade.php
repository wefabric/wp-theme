@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $titleClassMap = ['left' => 'text-left justify-start', 'center' => 'text-center justify-center', 'right' => 'text-right justify-end',];
    $textClass = $titleClassMap[$textPosition] ?? '';

    $embedSource = $block['data']['embed'] ?? '';
    $embedHeight = $block['data']['embed_height'] ?? 600;

    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'default-color';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
@endphp

<section id="embed" class="relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 pt-8 lg:pt-16 xl:pt-20 {{ $fullScreenClass }}">
        <div class="mx-auto {{ $blockClass }}">
            @if ($title)
                <h2 class="mb-4 text-{{ $titleColor }} container mx-auto px-8 {{ $titleColor }}">{!! $title !!}</h2>
            @endif
            @if ($text)
                @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'mb-4 container mx-auto px-8 text-' . $textColor])
            @endif
            @if ($embedSource)
                    <iframe width="100%" height="{{ $embedHeight }}" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="{!! $embedSource !!}"></iframe>
            @endif
        </div>
    </div>
</section>

