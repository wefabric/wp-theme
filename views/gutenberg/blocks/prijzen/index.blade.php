@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';

    $showTables = $block['data']['show_price_tables'] ?? false;

    // Show prices
    $displayType = $block['data']['display_type'];
    $packages = [];
    $tables = [];

   if ($displayType == 'show_all') {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'prices',
        ];
        $query = new WP_Query($args);
        foreach ($query->posts as $post) {
            $packages[] = get_field('packages', $post->ID);
            $tables[] = get_field('tables', $post->ID);
        }
        $packages = array_merge(...array_filter($packages));
        $tables = array_merge(...array_filter($tables));

    } elseif ($displayType == 'show_specific') {
        $postIds = $block['data']['show_specific_price'] ?? [];

        if (!is_array($postIds)) {
            $postIds = [$postIds];
        }

        foreach ($postIds as $postId) {
            $packages[] = get_field('packages', $postId);
            $tables[] = get_field('tables', $postId);
        }
        $packages = array_merge(...array_filter($packages));
        $tables = array_merge(...array_filter($tables));
    }


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = ($block['data']['background_image']) ?? '';
    $overlayEnabled = ($block['data']['overlay_image']) ?? false;
    $overlayColor = ($block['data']['overlay_color']) ?? '';
    $overlayOpacity = ($block['data']['overlay_opacity']) ?? '';

    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strenght']??'': 'rounded-none';
@endphp

<section id="prijs-pakketten" class="relative py-16 lg:py-0 bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover;">
    @if ($overlayEnabled)
        <div class="absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <h2 class="text-{{ $titleColor }} container mx-auto mb-8 lg:mb-20 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{{ $title }}</h2>
            @endif
            @include('components.prices.packages-list', ['packages' => $packages])

            @if ($showTables)
                <div class="container w-full @if(($blockWidth == '50') || ($blockWidth == '66')) w-full @else md:w-2/3 @endif mx-auto">
                    @include('components.prices.tables-list', ['tables' => $tables])
                </div>
            @endif
        </div>
    </div>
</section>