@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

    // Show pages
    $pagesData = [];
    $numPages = intval($block['data']['pages']);

    for ($i = 0; $i < $numPages; $i++) {
        $pageKey = "pages_{$i}_page";  // Adjust the key to the one you are using
        $pageId = $block['data'][$pageKey] ?? 0; // Assuming you store the page ID in the ACF field

        if ($pageId) {
            // Retrieve information about the page
            $page = get_post($pageId);

            if ($page) {
                $pagesData[] = [
                    'id' => $page->ID,
                    'title' => $page->post_title,
                    'url' => get_permalink($page->ID),
                    'content' => $page->post_content,

                ];
            }
        }

    }
//            @dd($pagesData);

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

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strenght'] ?? '' : 'rounded-none';
@endphp

<section id="kaarten" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} {{ $titleClass }}">
            <h2 class="text-{{ $titleColor }} mb-4">{{ $title }}</h2>
            @include('components.cardblock.list')
        </div>
    </div>
</section>