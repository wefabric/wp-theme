@php
    // Content
    $title = $block['data']['title'] ?? '';
    $titleColor = $block['data']['title_color'] ?? '';
    $text = $block['data']['text'] ?? '';
    $textColor = $block['data']['text_color'] ?? '';
    $textPosition = $block['data']['text_position'] ?? '';
    $textClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $textClass = $textClassMap[$textPosition] ?? '';
    $bottomText = $block['data']['bottom_text'] ?? '';

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
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength']??'': 'rounded-none';
@endphp

<section id="prijs-pakketten" class="relative bg-{{ $backgroundColor }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \App\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <div class="container mx-auto lg:mb-12 @if($blockWidth == 'fullscreen') px-8 @endif">
                    <h2 class="text-{{ $titleColor }} {{ $textClass }} mb-4">{{ $title }}</h2>
                    @if ($text)
                        @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'text-' . $textColor])
                    @endif
                </div>
            @endif
            @include('components.prices.packages-list', ['packages' => $packages])
            @if ($showTables)
                <div class="container w-full @if(($blockWidth == '50') || ($blockWidth == '66')) w-full @else md:w-2/3 @endif mx-auto">
                    @include('components.prices.tables-list', ['tables' => $tables])
                </div>
            @endif
            @if($bottomText)
                @include('components.content', [
                    'content' => apply_filters('the_content', $bottomText),
                    'class' => 'mt-4 container mx-auto ' . (($blockWidth == '50' || $blockWidth == '66') ? 'w-full' : 'md:w-2/3')
                ])
            @endif
        </div>
    </div>
</section>