@php
    // Content
    $title = $block['data']['title'] ?? '';

    $titlePosition = $block['data']['title_position'] ?? '';
    $titleClassMap = ['left' => 'text-left', 'center' => 'text-center', 'right' => 'text-right',];
    $titleClass = $titleClassMap[$titlePosition] ?? '';


    // Show news
    $displayType = $block['data']['display_type'];

    if ($displayType == 'show_all') {
        $args = [
        'posts_per_page' => -1,
        'post_type' => 'post',
        ];
        $query = new WP_Query($args);
        $posts = wp_list_pluck($query->posts, 'ID');
    }

    elseif ($displayType == 'show_specific') {
        $posts = $block['data']['show_specific_news'];
        if (!is_array($posts) || empty($posts)) {
            $posts = [];
        }
    }


    // Blokinstellingen
    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClassMap = [50 => 'w-full lg:w-1/2', 66 => 'w-full lg:w-2/3', 100 => 'w-full', 'fullscreen' => 'w-full'];
    $blockClass = $blockClassMap[$blockWidth] ?? '';
    $fullScreenClass = $blockWidth !== 'fullscreen' ? 'container mx-auto' : '';

    $backgroundColor = $block['data']['background_color'] ?? 'none';
@endphp

<section id="nieuws-block" class="relative bg-{{ $backgroundColor}}">
    <div class="{{ $fullScreenClass }} px-8 py-8 lg:py-20">
        <div class="{{ $blockClass }} mx-auto">
            <h2 class="container mx-auto mb-8 lg:mb-20 @if($blockWidth == 'fullscreen') px-8 @endif {{ $titleClass }}">{{ $title }}</h2>
            @include('components.news.list', ['posts' => $posts])
        </div>
    </div>
</section>