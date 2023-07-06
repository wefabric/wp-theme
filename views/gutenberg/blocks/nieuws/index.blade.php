@php
    $title = $block['data']['title'] ?? '';
    $titlePosition = $block['data']['title_position'] ?? '';
    $backgroundColor = $block['data']['background_color'] ?? 'none';

    $titleClass = '';
    if ($titlePosition === 'left') {
        $titleClass = 'text-left';
    } elseif ($titlePosition === 'center') {
        $titleClass = 'text-center';
    } elseif ($titlePosition === 'right') {
        $titleClass = 'text-right';
    }

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

    $blockWidth = $block['data']['block_width'] ?? 100;
    $blockClass = '';
    if ($blockWidth == 50) {
        $blockClass = 'w-full lg:w-1/2';
    }
    elseif ($blockWidth == 66) {
        $blockClass = 'w-full lg:w-2/3';
    }
    elseif ($blockWidth == 100) {
        $blockClass = ' w-full';
    }
    elseif ($blockWidth == 'fullscreen') {
        $blockClass = 'w-full';
    }

    $fullScreenClass = '';
    if ($blockWidth !== 'fullscreen') {
        $fullScreenClass = 'container mx-auto';
    }

@endphp

<section id="nieuws-block" class="bg-{{ $backgroundColor}}">
    <div class="{{ $fullScreenClass }} px-8 py-8 lg:py-20">
        <div class="{{ $blockClass }} mx-auto">
            <h2 class="container mx-auto mb-8 lg:mb-20 {{ $titleClass }}">{{ $title }}</h2>
            @include('components.news.list', ['posts' => $posts])
        </div>
    </div>
</section>