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


<div class="container mx-auto">
    <h2 class="mb-12 text-center">{{ $block->get('title') }}</h2>

    @include('components.content', [
	    'content' => $block->get('subtitle'),
	    'class' => 'text-center text-base mb-12'
    ])

    @if($block->get('display_type') === 'slider')
        <div class="">
            @include('components.slider.slider', [
                'items' => $postList,
                'card_type' => 'employee',
                'card_classes' => 'w-1/3',
            ])
        </div>
    @elseif($block->get('display_type') === 'grid')
        <div class="grid md:grid-cols-2 lg:grid-cols-3">
            @foreach($postList as $employeeId)
                @include('components.cards.employee', [
                    'employeeId' => $employeeId,
                ])
            @endforeach
        </div>
    @endif
</div>

