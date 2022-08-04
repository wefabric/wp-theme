@php
    if($block->get('show_all') === true) {
        $args = [
            'posts_per_page'   => 8,
            'post_type'        => 'post',
        ];
        $query = new WP_Query( $args );
        $postList = $query->posts;
    } else {
	    $postList = $block->get('news'); //preselected list
    }
@endphp

<div class="container mx-auto w-full lg:{{ $block->get('width') }}">
    @include('components.headings.normal', [
	    'type' => '2',
	    'class' => 'mb-12 text-center',
	    'heading' => $block->get('title'),
    ])

    @if(false)
        @include('components.slider.smart-slider', [
            'items' => $postList,
            'card_type' => 'newsitem',
        ])
    @else
        @include('components.slider.grid', [
            'items' => $postList,
            'card_type' => 'newsitem',
        ])
    @endif

</div>
