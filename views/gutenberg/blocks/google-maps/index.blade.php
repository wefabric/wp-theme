@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';

    $textPosition = $block['data']['text_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$textPosition] ?? '';

    $location = $block['data']['location']['adress']  ?? '';


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

<section id="google-maps" class="relative py-16 lg:py-0 bg-{{ $backgroundColor}}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{$overlayColor}} opacity-{{$overlayOpacity}}"></div>
    @endif
    <div class="relative z-10 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="mx-auto {{ $blockClass }}">
            <h2 class="text-{{ $titleColor }} container mx-auto mb-4 px-8 {{ $titleClass }}">{{ $title }}</h2>
            <iframe width="100%" height="600"
                    class="h-[300px] lg:h-[600px] @if($blockWidth !== 'fullscreen') px-8 @endif"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                    src="https://maps.google.com/maps?width=100%25&amp;height=600&amp;hl=en&amp;q={{ $location }}&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed">
            </iframe>
        </div>
    </div>
</section>