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

    <div class="grid md:grid-cols-2 lg:grid-cols-3">
        @foreach($postList as $employeeId)
            @include('components.cards.employee', [
                'employeeId' => $employeeId,
            ])
        @endforeach
    </div>
</div>

@if(false)
    @if($block->get('display_type') === 'image_view')
        <div class="container mx-auto my-16 text-center">
            <h2 class="uppercase">{{ $block->get('title') }}</h2>

            @include('components.employees.employee-list', ['postList' => $postList])
        </div>
    @elseif($block->get('display_type') === 'block_view')
        <div class="container mx-auto">
            <h2 class="uppercase ml-4">{{ $block->get('title') }}</h2>

            @include('components.employees.employee-list-blocks', ['postList' => $postList])
        </div>
    @endif
@endif