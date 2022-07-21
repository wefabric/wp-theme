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

<div class="container mx-auto">
    @include('components.headings.normal', [
	    'type' => '2',
	    'class' => 'mb-12 text-center',
	    'heading' => $block->get('title'),
    ])

    @if(false)
        <div class="">
            @include('components.slider.slider', [
	            'items' => $postList,
	            'card_type' => 'newsitem',
	            'card_classes' => 'w-full md:w-1/2 lg:w-1/3'
            ])
        </div>
    @else
        <div class="grid md:grid-cols-2 lg:grid-cols-3">
            @foreach($postList as $postId)
                @include('components.cards.newsitem', [
                    'postId' => $postId,
                ])
            @endforeach
        </div>
    @endif

</div>
