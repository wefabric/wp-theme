@php
    //    todo: Needs block update

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

    // Prices
    $displayType = $block['data']['display_type'];
    $packages = [];
    $tables = [];

    // Show all
    if ($displayType == 'show_all') {
        $args = [
            'posts_per_page' => -1,
            'post_type' => 'prijzen',
            'post_status' => 'publish',
        ];

        // Exclude current post
        if(!is_archive()){
            if(get_post()->post_type == 'prijzen') {
                $args['post__not_in'] = [get_post()->ID];
            }
        }

        $query = new WP_Query($args);
        foreach ($query->posts as $post) {
            $packages[] = get_field('packages', $post->ID);
            $tables[] = get_field('tables', $post->ID);
        }

        $packages = array_merge(...array_filter($packages));
        $tables = array_merge(...array_filter($tables));


    // Show specific
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
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 80 => 'w-full lg:w-4/5', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
    $imageId = $block['data']['background_image'] ?? '';
    $overlayEnabled = $block['data']['overlay_image'] ?? false;
    $overlayColor = $block['data']['overlay_color'] ?? '';
    $overlayOpacity = $block['data']['overlay_opacity'] ?? '';

    $customBlockClasses = $block['data']['custom_css_classes'] ?? '';
    $customBlockId = $block['data']['custom_block_id'] ?? '';


    // Theme settings
    $options = get_fields('option');
    $borderRadius = $options['rounded_design'] === true ? $options['border_radius_strength'] ?? '' : 'rounded-none';
@endphp

<section id="@if($customBlockId){{ $customBlockId }}@else{{ 'prijs-pakketten' }}@endif" class="block-prijs-pakketten relative bg-{{ $backgroundColor }} {{ $customBlockClasses }}"
         style="background-image: url('{{ wp_get_attachment_image_url($imageId, 'full') }}'); background-repeat: no-repeat; background-size: cover; {{ \Theme\Helpers\FocalPoint::getBackgroundPosition($imageId) }}">
    @if ($overlayEnabled)
        <div class="overlay absolute inset-0 bg-{{ $overlayColor }} opacity-{{ $overlayOpacity }}"></div>
    @endif
    <div id="{{ str_replace(' ', '-', strtolower($title)) }}" class="relative z-10 px-8 py-8 lg:py-16 xl:py-20 {{ $fullScreenClass }}">
        <div class="{{ $blockClass }} mx-auto">
            @if ($title)
                <div class="container mx-auto lg:mb-12 @if($blockWidth == 'fullscreen') px-8 @endif">
                    <h2 class="text-{{ $titleColor }} {{ $textClass }} mb-4">{!! $title !!}</h2>
                    @if ($text)
                        @include('components.content', ['content' => apply_filters('the_content', $text), 'class' => 'text-' . $textColor])
                    @endif
                </div>
            @endif
            @if ($packages)
                @include('components.prices.packages-list', ['packages' => $packages])
            @endif
            @if ($showTables)
                <div class="container w-full mx-auto @if(($blockWidth == '50') || ($blockWidth == '66') || ($blockWidth == '80')) w-full @else md:w-2/3 @endif">
                    @include('components.prices.tables-list', ['tables' => $tables])
                </div>
            @endif
            @if($bottomText)
                @include('components.content', [
                    'content' => apply_filters('the_content', $bottomText),
                    'class' => 'mt-4 container mx-auto ' . (($blockWidth == '50') || ($blockWidth == '66') || ($blockWidth == '80') ? 'w-full' : 'md:w-2/3')
                ])
            @endif
        </div>
    </div>
</section>