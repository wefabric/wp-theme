@php
    if($block->get('show_all') === true) {
        $args = [
            'posts_per_page'   => 8,
            'post_type'        => 'employees',
        ];
        $query = new WP_Query( $args );
        $postList = $query->posts;
    } else {
	    $postList = $block->get('employees'); //preselected list
    }
@endphp

<div class="container mx-auto w-full lg:{{ $block->get('width') }}">
    @include('components.headings.normal', [
	    'type' => '2',
	    'class' => 'mb-12 text-center',
	    'heading' => $block->get('title'),
    ])

    @include('components.content', [
	    'content' => $block->get('subtitle'),
	    'class' => 'text-center mb-12'
    ])

    @if($block->get('display_type') === 'slider')
        @include('components.slider.smart-slider', [
            'items' => $postList,
            'card_type' => 'employee',
        ])
    @elseif($block->get('display_type') === 'grid')
        @include('components.slider.grid', [
            'items' => $postList,
            'card_type' => 'employee',
        ])
    @endif
</div>

