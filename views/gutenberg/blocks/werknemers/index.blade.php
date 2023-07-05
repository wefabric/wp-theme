@php
    $title = $block['data']['title'] ?? '';
    $textPosition = $block['data']['title_position'] ?? '';
    $backgroundColor = $block['data']['background_color'] ?? 'none';

    $textClass = '';
    if ($textPosition === 'left') {
        $textClass = 'text-left';
    } elseif ($textPosition === 'center') {
        $textClass = 'text-center';
    } elseif ($textPosition === 'right') {
        $textClass = 'text-right';
    }


    $displayType = $block['data']['display_type'];

    if ($displayType == 'show_all') {
        $args = [
        'posts_per_page' => -1,
        'post_type' => 'employees',
        ];

        $query = new WP_Query($args);
        $employees = wp_list_pluck($query->posts, 'ID');
    }

    elseif ($displayType == 'show_specific') {
        $employees = $block['data']['show_specific_employees'];
            if (!is_array($employees) || empty($employees)) {
                $employees = [];
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

<section id="werknemers-block" class="bg-{{ $backgroundColor}}">
    <div class="{{ $blockClass }} px-8 lg:py-20">
        <div class="container mx-auto">
            <h2 class="mb-20 {{ $textClass }}">{{ $title }}</h2>
        </div>
        @include('components.employees.list', ['employees' => $employees])
    </div>
</section>