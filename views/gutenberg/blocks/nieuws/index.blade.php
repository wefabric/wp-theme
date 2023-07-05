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

    $blockWidth = $block['data']['block_width'] ?? 25;
    $blockClass = '';
    if ($blockWidth == 50) {
        $blockClass = 'container mx-auto w-full lg:w-1/2';
    }
    elseif ($blockWidth == 100) {
        $blockClass = 'container mx-auto w-full';
    }
    elseif ($blockWidth == 'fullscreen') {
        $blockClass = ' w-full';
    }

@endphp

<section id="nieuws-block" class="bg-{{ $backgroundColor}}">
    <div class="{{ $blockClass }} px-8 lg:py-20">
        <div class="container mx-auto">
            <h2 class="mb-20 {{ $titleClass }}">{{ $title }}</h2>
        </div>
        @include('components.news.list', ['posts' => $posts])
    </div>
</section>